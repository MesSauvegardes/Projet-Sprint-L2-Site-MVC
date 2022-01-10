<?php 

require_once("modele/modele.php");
require_once("vue/vue.php") ;
require_once("controleur/controleur.php");

// CONTROLEUR PAGE ACCEUIL

function CtlAcceuilConnexion(){
    afficherAcceuilConnexion();
}

function CtlSeConnecter($categorie,$login,$mdp){
    if($categorie=="directeur"){
        $auth=checkUser(100,$login,$mdp); 
        if (!empty($auth)){
            makeBlocloginHidden();
            CtlAcceuilDirecteur();
            } else {
        throw new Exception("categorie, login ou mot de passe invalide");
        CtlAcceuilConnexion();
            }
    }
    if($categorie=="agent_acceuil"){
        $auth=checkUser(200,$login,$mdp); //en supposant que 200 = id de la catégorie agent_acceuil
        if (!empty($auth)){
            makeBlocloginHidden();
            CtlAcceuilAgentAcc();
            } else {
        throw new Exception("categorie, login ou mot de passe invalide");
        CtlAcceuilConnexion();
            }
    }
    if($categorie=="agent_administratif"){
        $auth=checkUser(300,$login,$mdp); 
        if (!empty($auth)){
            makeBlocloginHidden();
            CtlAcceuilAgentADM();
            } else {
        throw new Exception("categorie, login ou mot de passe invalide");
        CtlAcceuilConnexion();
            }
    }
}

// CONTROLEUR AGENT ACCEUIL

function CtlLogoutAAC(){
    CtlAcceuilConnexion();
    afficherAcceuilConnexion();
}

function CtlAcceuilAgentAcc(){
    $listenomsagents=getListeNomsAgentsAdmin();
    $listeservices=getListeServices();
    genererListesDeroulantes($listenomsagents,$listeservices);
    afficherAcceuilAgentAcc();
}

/* ajout nouvel etudiant */

function CtlAjouterEtudiant($nom,$prenom,$birthdate,$adresse,$numtel,$email,$total){
    if(empty($res)){
        ajouterNouvelEtudiant($nom,$prenom,$birthdate,$adresse,$numtel,$email,$total);
        throw new Exception(" Un nouvel Etudiant a été inscrit avec succès.");
    }
}

/* modification etudiant */

function CtlMofifierInfoEtudiant($idetu,$nnom,$nprenom,$nbirthdate,$nadresse,$nnumtel,$nemail,$ntotal){
    $res=checkStudent($idetu);
    if (!empty($res)){
        if(!empty($nnom)) {
            modifierNomEtudiant($idetu,$nnom);
            throw new Exception(" Le Nom a été modifié.");
        }
        if(!empty($nprenom)) {
            modifierPrenomEtudiant($idetu,$nprenom);
            throw new Exception(" Le Prénom a été modifié.");
        }
        if(!empty($nbirthdate)){
            modifierBirthdateEtudiant($idetu,$nbirthdate); 
            throw new Exception(" La date de naissance a été modifiée.");
        }
        if(!empty($nadresse)) {
            modifierAdresseEtudiant($idetu,$nadresse);
            throw new Exception(" L'adresse a été modifiée.");
        }
        if(!empty($nnumtel)) {
            modifierNumtelEtudiant($idetu,$nnumtel);
            throw new Exception(" Le numéro de téléphone a été modifié.");
        }
        if(!empty($nemail)){
            modifierMailEtudiant($idetu,$nemail);
            throw new Exception(" L'adresse mail a été modifiée.");
        } 
        if(!empty($ntotal)) {
            modifierTotalEtudiant($idetu,$ntotal);
            throw new Exception(" Le Plafond total autorisé a été modifié.");
        }
    } else {
        throw new Exception(" Etudiant inexistant dans la base de données.");
    }
    
}

/*gestion financiere*/

function CtlAfficherBlocGestionFinanciere($idetudiant){
    $res=getServicesPourPayement($idetudiant);
    if (!empty($res)){
        afficherBlocServicesPourPayement($res,$idetudiant);
    } else {
        throw new Exception("Erreur, aucune donnée n'a été trouvée.");
    }
    
}

function CtlPayerDernierService($idetu){
    setLastServiceAsPaid($idetu);
    throw new Exception(" Le dernier service a été Payé.");
}

function CtlMiseEnDiffere($idetu){
    $prixService=getPrixServiceEnAttente();
    $diff=getPlafondDiffEtTotal($idetu);
    foreach($diff as $ligne){
        foreach($prixService as $ligne2){
            $newDiff=($ligne->PLAFOND_DIFF)+($ligne2->PRIX_SERV);
            if ($newDiff < $ligne->PLAFOND_TOTAL){
                setServiceEnDiffere($idetu,$newDiff);
                throw new Exception(" Le dernier service a été mis en Différé.");
            } else {
                throw new Exception(" Risque de dépassement du plafond autorisé. Opération impossible.");
            }
        } 
    }   
}

function CtlRemboursementDiffere($idrdv,$idetu){
    $price=getPrixServiceRdv($idrdv);
    $montantDiff=getPlafondDiffEtTotal($idetu);
    foreach($price as $ligne1){
        foreach($montantDiff as $ligne2){
            $newDiff=($ligne2->PLAFOND_DIFF)-($ligne1->PRIX_SERV);
            setDiffereAsPaid($idrdv,$newDiff, $idetu);
            throw new Exception("Les services sélectionnés ont été remboursés");
        }
    }
}

/*recherche d'etudiant*/

function CtlAfficherResultatRecherche($nom,$birthdate){
    $res=getIdEtudiant($nom,$birthdate);
    if (!empty($res)) {
        afficherResRechercheId($res);
    }
    else {
        throw new Exception(" Etudiant inexistant dans la base de données."); 
    }
}

/*prise de rdv*/

function CtlAfficherPlanningSemaineAgent($semaine,$nomagent){
    $datedebut= new DateTime($semaine);
    $datefin = date_add($datedebut, new DateInterval('P5D'));
    $datefin = $datefin->format('Y-m-d');
    $listenomsagents=getListeNomsAgentsAdmin();
    $listeservices=getListeServices();
    $res=getPlanningSemaineAgent($nomagent,$semaine,$datefin);
    afficherPlanningSemaine($res,$nomagent,$semaine,$datefin,$listenomsagents,$listeservices);
    CtlAcceuilAgentAcc();
}

function CtlSaveNewRdv($idetu,$idserv,$nomagent,$daterdv,$heurerdv){
    $existant=checkStudent($idetu);
    if(!empty($existant)){
        $dispo=CtlAgentEstDisponible($nomagent,$daterdv,$heurerdv);
        if ($dispo==true){
            enregistrerNewRDV($idetu,$idserv,$nomagent,$daterdv,$heurerdv);
            CtlAfficherPieces($idserv);
        } else {
            throw new Exception("Le créneau horaire choisi est indisponible, veuillez recommencer");
        }
    } else {
        throw new Exception("Etudiant inexistant dans la base de données.");
    }
}

function CtlAfficherPieces($idserv){
    $pieces=getPiecesPourRdv($idserv);
    afficherPiecesPourRdv($pieces);
}

function CtlAgentEstDisponible($nomagent,$daterdv,$heurerdv){
    $res=agentOccupe($nomagent,$daterdv,$heurerdv);
    if(empty($res)){
        return true;
    } else {
        return false;
    }
}

/*syntheses*/

function CtlAllNonPaye(){
    $unpaid=getAllNonPaye();
    if (!empty($unpaid)){
        afficherTousPayementsAttente($unpaid);
    } else {
        throw new Exception("Aucun paiement en attente dans la base de données.");
    }
}

function CtlStudentInfos($idetu){
    $infos=getAllStudentInfo($idetu);
    $payStatus=getAllStudentPayStatus($idetu);
    if(!empty($infos)){
        afficherSyntheseEtudiant($infos,$payStatus);
    } else {
        throw new Exception("etudiant inexistant");
    }
}

//CONTROLEUR AGENT ADMINISTRATIF

function CtlAcceuilAgentADM(){
    afficherAcceuilADM();
}

/*plannings*/

function CtlTodayPlanning($nomagent){
    $today= new DateTime('now');
    $today = $today->format('Y-m-d');
    $dates=getPlanningOneDayAgent($nomagent,$today);
    afficherPlanningToday($dates);
}

function CtlSomedayPlanning($nomagent,$date){
    $dates=getPlanningOneDayAgent($nomagent,$date);
    afficherPlanningSomeday($dates,$date);
}

/*bloquer une formation*/

function CtlBloquerFormation($idagent,$date,$heure){
    creerFormation($date,$heure);
    $res=getIdFormation($date,$heure);
    foreach($res as $ligne){
        $idformation=$ligne->ID_FORMATION;
    }
    bloquerFormation($idagent,$idformation);
    throw new Exception("La formation a été enregistrée");
}

/*gestion conclusion rdv*/

function CtlAfficherBlocGestionConclusion($nomagent){
    $res=getRendezVousNonValides($nomagent);
    genererBlocGestionConclusion($res);
}

function CtlValiderRdv($idrdv){
    validerRdv($idrdv);
    throw new Exception("Le Service demandé a été validé.");
}

function CtlRefuserRdv($idrdv){
    refuserRdv($idrdv);
    throw new Exception("Le Service demandé a été refusé");
}

/*synthese*/

function CtlStudentInfos2($idetu){
    $infos=getAllStudentInfo($idetu);
    $payStatus=getAllStudentPayStatus($idetu);
    if(!empty($infos)){
        afficherSyntheseEtudiantADM($infos,$payStatus);
    } else {
        throw new Exception("etudiant inexistant");
    }
}


///////// CONTROLEUR DIRECTEUR 

function CtlAcceuilDirecteur(){
    afficheraccueildirecteur();
}

function CtlAjouterEmploye($idcateg,$nomemploye,$prenomemploye,$login,$mdp){
    if ($idcateg=="100"){
        creationEmploye(100,"directeur",$nomemploye,$prenomemploye,$login,$mdp);
    }
    if ($idcateg=="200"){
        creationEmploye(200,"agent_acceuil",$nomemploye,$prenomemploye,$login,$mdp);
        throw new Exception("Un agent d'acceuil a été créé");
    }
    if ($idcateg=="300"){
        creationEmploye(300,"agent_administratif",$nomemploye,$prenomemploye,$login,$mdp);
        throw new Exception("Un agent administratif a été créé");
    }        
}

function CtlModifierEmploye($iduser,$anom,$nnom,$nprenom,$nlogin,$nmdp){
    if(!empty($nnom)){
        modifierNomEmploye($iduser,$anom,$nnom);
    }
    if(!empty($nprenom)){
        modifierPrenomEmploye($iduser,$nprenom);
    }
    if(!empty($nlogin)){
        modifierLoginEmploye($iduser,$nlogin);
    }
    if(!empty($nmdp)){
        modifierPasswordEmploye($iduser,$nmdp);
    }
}

function CtlAjouterService($nom,$prix){
    if(!empty($nom) and !empty($prix)){
        getcreationservice($nom,$prix);
        throw new Exception("Le service a été créé");
    }
}

function Ctlafficherservice(){
    $res=recupereservice();
    $res2=recupererpieces();
    afficherselect($res,$res2);
}

function CtlAttribuerPiece($idpiece,$lesnoms){
    attribuerPiece($idpiece,$lesnoms);
}

function CtlSupprimerservice($id){
    if (ctype_digit($id)) {
        supprimerservice($id);
        throw new Exception("Le service a été supprimé");
    }
}

function Ctlmodifierservice($lesnoms,$nouvser){
    if(!empty($nouvser) and !empty($lesnoms)){
        modifierservice($nouvser,$lesnoms);
        throw new Exception("Le service a été modifié");
    }    
}

function CtlAfficherLesEmployes(){
    $res=getLesEmployes();
    afficherTousLesEmployes($res);
}


//////////////////////////////////////

/*gestion erreurs*/

function CtlErreurPA($erreur){
    afficherErreurPA($erreur);
}

function CtlErreurDR($msg){
    afficherErreurDR($msg);
}

function CtlErreurAAC($erreur){
    afficherErreurAAC($erreur);
}

function CtlErreurADM($erreur){
    afficherErreurADM($erreur);
}
