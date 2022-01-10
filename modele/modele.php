<?php
require_once("connect.php");

function getConnect(){
    require_once("connect.php");
    $connexion = new PDO('mysql:host=' . SERVEUR . ';dbname=' . BDD, USER, PASSWORD);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connexion->query('SET NAMES UTF8');
    return $connexion;
}

// MODELE PAGE ACCEUIL

function checkUser($categorie,$login,$mdp){
    $connexion=getConnect();
    $requete="select * from categorie where ID_CAT='$categorie' and LOGIN='$login' and MDP='$mdp' ";
    $resultat=$connexion->query($requete);
    $resultat->setFetchMode(PDO::FETCH_OBJ);
    $authentification=$resultat->fetchall();
    $resultat->closeCursor();
    return $authentification;
}

// MODELE AGENT ACCEUIL

function ajouterNouvelEtudiant($nom,$prenom,$birthdate,$adresse,$numtel,$email,$total){
     $connexion=getConnect();
     $requete="insert into etudiants (ID_ETU , NOM , PRENOM , DATEDENAISSANCE, ADRESSE, NUM_TEL, MAIL, PLAFOND_DIFF, PLAFOND_TOTAL) values (0,'$nom', '$prenom', '$birthdate', '$adresse', '$numtel', '$email', '0', '$total')" ;
     $resultat=$connexion->query($requete);
     $resultat->closeCursor();
}

function checkStudent($idetu){
    $connexion=getConnect();
    $requete="select ID_ETU from etudiants where ID_ETU='$idetu'"; 
    $resultat=$connexion->query($requete);
    $resultat->setFetchMode(PDO::FETCH_OBJ);
    $student=$resultat->fetchall();
    $resultat->closeCursor();
    return $student;
}

/*modifications d'informations*/

function modifierNomEtudiant($idetu,$nnom){
    $connexion=getConnect();
    $requete="update etudiants set NOM='$nnom' where ID_ETU='$idetu' ";
    $resultat=$connexion->query($requete);
    $resultat->closeCursor();
}

function modifierPrenomEtudiant($idetu,$nprenom){
    $connexion=getConnect();
    $requete="update etudiants set PRENOM='$nprenom' where ID_ETU='$idetu' ";
    $resultat=$connexion->query($requete);
    $resultat->closeCursor();
}

function modifierBirthdateEtudiant($idetu,$nbirthdate){
    $connexion=getConnect();
    $requete="update etudiants set DATEDENAISSANCE='$nbirthdate' where ID_ETU='$idetu' ";
    $resultat=$connexion->query($requete);
    $resultat->closeCursor();
}

function modifierAdresseEtudiant($idetu,$nadresse){
    $connexion=getConnect();
    $requete="update etudiants set ADRESSE='$nadresse' where ID_ETU='$idetu' ";
    $resultat=$connexion->query($requete);
    $resultat->closeCursor();
}

function modifierNumtelEtudiant($idetu,$nnumtel){
    $connexion=getConnect();
    $requete="update etudiants set NUM_TEL='$nnumtel' where ID_ETU='$idetu' ";
    $resultat=$connexion->query($requete);
    $resultat->closeCursor();
}

function modifierMailEtudiant($idetu,$nemail){
    $connexion=getConnect();
    $requete="update etudiants set MAIL='$nemail' where ID_ETU='$idetu' ";
    $resultat=$connexion->query($requete);
    $resultat->closeCursor();
}

function modifierDiffereEtudiant($idetu,$ndiffere){
    $connexion=getConnect();
    $requete="update etudiants set PLAFOND_DIFF='$ndiffere' where ID_ETU='$idetu'";
    $resultat=$connexion->query($requete);
    $resultat->closeCursor();
}

function modifierTotalEtudiant($idetu,$ntotal){
    $connexion=getConnect();
    $requete="update etudiants set PLAFOND_TOTAL='$ntotal' where ID_ETU='$idetu' ";
    $resultat=$connexion->query($requete);
    $resultat->closeCursor();
}
    
/*gestion financière*/

function getServicesPourPayement($idetudiant){
    $connexion=getConnect();
    $requete="select * from rdv NATURAL JOIN services where ID_ETU='$idetudiant' and rdv.ETAT_PAIE!='PAYE' and rdv.CONCLUSION='VALIDE' "; 
    $resultat=$connexion->query($requete);
    $resultat->setFetchMode(PDO::FETCH_OBJ);
    $services=$resultat->fetchall();
    $resultat->closeCursor();
    return $services;
}

function getPrixServiceRdv($idrdv){
    $connexion=getConnect();
    $requete="select PRIX_SERV from services NATURAL JOIN rdv where rdv.ID_RDV='$idrdv'"; 
    $resultat=$connexion->query($requete);
    $resultat->setFetchMode(PDO::FETCH_OBJ);
    $prixService=$resultat->fetchall();
    $resultat->closeCursor();
    return $prixService;
}

function getPrixServiceEnAttente(){
    $connexion=getConnect();
    $requete="select PRIX_SERV from services NATURAL JOIN rdv where rdv.ETAT_PAIE='EN ATTENTE'"; 
    $resultat=$connexion->query($requete);
    $resultat->setFetchMode(PDO::FETCH_OBJ);
    $prixService=$resultat->fetchall();
    $resultat->closeCursor();
    return $prixService;
}

function setLastServiceAsPaid($idetu){
    $connexion=getConnect();
    $requete="update rdv set ETAT_PAIE='PAYE' where ETAT_PAIE='EN ATTENTE' and ID_ETU='$idetu' "; //en supp qu'il n'y ait qu'un seul en attente
    $resultat=$connexion->query($requete);
    $resultat->closeCursor();
}

function setDiffereAsPaid($idrdv,$newDiff,$idetu){
    $connexion=getConnect();
    $requete="update rdv set ETAT_PAIE='PAYE' where ID_RDV='$idrdv'";
    $resultat=$connexion->query($requete);
    $resultat->closeCursor();
    $requete2="update etudiants set PLAFOND_DIFF='$newDiff' where ID_ETU='$idetu'";
    $resultat=$connexion->query($requete2);
    $resultat->closeCursor();
}

function setServiceEnDiffere($idetu,$newDiff) {
    $connexion=getConnect();
    $requete="update rdv set ETAT_PAIE='EN DIFFERE' where ETAT_PAIE='EN ATTENTE' and ID_ETU='$idetu'";
    $resultat=$connexion->query($requete);
    $resultat->closeCursor();
    $requete2="update etudiants set PLAFOND_DIFF='$newDiff' where ID_ETU='$idetu'";
    $resultat=$connexion->query($requete2);
    $resultat->closeCursor();
}

function getPlafondDiffEtTotal($idetu) {
    $connexion=getConnect();
    $requete="select PLAFOND_DIFF , PLAFOND_TOTAL from etudiants where ID_ETU='$idetu'"; 
    $resultat=$connexion->query($requete);
    $resultat->setFetchMode(PDO::FETCH_OBJ);
    $plafond=$resultat->fetchall();
    $resultat->closeCursor();
    return $plafond;
}

/*recherche de l'id par nom et date de naissance */

function getIdEtudiant($nom,$birthdate){
    $connexion=getConnect();
    $requete="select ID_ETU from etudiants where NOM='$nom' and DATEDENAISSANCE='$birthdate'" ; 
    $resultat=$connexion->query($requete);
    $resultat->setFetchMode(PDO::FETCH_OBJ);
    $idetudiant=$resultat->fetchall();
    $resultat->closeCursor();
    return $idetudiant;
}

/*prise de rendez-vous*/

function getListeNomsAgentsAdmin(){
    $connexion=getConnect();
    $requete="select NOM_EMP from employe where ID_CAT=300" ;
    $resultat=$connexion->query($requete);
    $resultat->setFetchMode(PDO::FETCH_OBJ);
    $agentsadministratifs=$resultat->fetchall();
    $resultat->closeCursor();
    return $agentsadministratifs; 
}

function getPlanningSemaineAgent($nomagent,$semaine,$dateFin){
    $connexion=getConnect();
    $requete="select rdv.DATE_RDV as DATE, rdv.HEURE_RDV as HEURE from rdv where rdv.NOM_AGENT='$nomagent' and (rdv.DATE_RDV between '$semaine' and '$dateFin') union select formation.DATE_FORMATION as DATE, formation.HEURE_FORMATION as HEURE from formation NATURAL JOIN bloque NATURAL JOIN employe where employe.NOM_EMP='$nomagent' and (formation.DATE_FORMATION between '$semaine' and '$dateFin') ";
    $resultat=$connexion->query($requete);
    $resultat->setFetchMode(PDO::FETCH_OBJ);
    $planning=$resultat->fetchall();
    $resultat->closeCursor();
    return $planning;
}

function agentOccupe($nomagent,$daterdv,$heurerdv){
    $connexion=getConnect();
    $requete="select rdv.DATE_RDV as DATE, rdv.HEURE_RDV as HEURE from rdv where rdv.NOM_AGENT='$nomagent' and rdv.DATE_RDV='$daterdv' and rdv.HEURE_RDV='$heurerdv' union select formation.DATE_FORMATION as DATE, formation.HEURE_FORMATION as HEURE from formation NATURAL JOIN bloque NATURAL JOIN employe where employe.NOM_EMP='$nomagent' and formation.DATE_FORMATION='$daterdv' and formation.HEURE_FORMATION='$heurerdv'";
    $resultat=$connexion->query($requete);
    $resultat->setFetchMode(PDO::FETCH_OBJ);
    $occupe=$resultat->fetchall();
    $resultat->closeCursor();
    return $occupe;
}


function getListeServices(){
    $connexion=getConnect();
    $requete="select * from services";
    $resultat=$connexion->query($requete);
    $resultat->setFetchMode(PDO::FETCH_OBJ);
    $services=$resultat->fetchall();
    $resultat->closeCursor();
    return $services; 

}

function enregistrerNewRDV($idetu,$idserv,$nomagent,$daterdv,$heurerdv){
    $connexion=getConnect();
    $requete="insert into rdv (ID_RDV , ID_SERV , ID_ETU , NOM_AGENT , DATE_RDV , HEURE_RDV , CONCLUSION , ETAT_PAIE) values (0,'$idserv','$idetu', '$nomagent', '$daterdv', '$heurerdv', 'EN ATTENTE', 'NULL')" ;
    $resultat=$connexion->query($requete);
    $resultat->closeCursor();
}

function getPiecesPourRdv($idserv){
    $connexion=getConnect();
    $requete="select NOM_PIECE from pieces NATURAL JOIN necessite where necessite.ID_SERV='$idserv'"; 
    $resultat=$connexion->query($requete);
    $resultat->setFetchMode(PDO::FETCH_OBJ);
    $docs=$resultat->fetchall();
    $resultat->closeCursor();
    return $docs;
}


//SYNTHESES :

/* demander les paiements en attente/différé de tous les etudiants */

function getAllNonPaye(){
    $connexion=getConnect();
    $requete="select * from etudiants NATURAL JOIN rdv NATURAL JOIN services where rdv.ETAT_PAIE='EN DIFFERE' or rdv.ETAT_PAIE='EN ATTENTE' order by DATE_RDV desc "; 
    $resultat=$connexion->query($requete);
    $resultat->setFetchMode(PDO::FETCH_OBJ);
    $unpaid=$resultat->fetchall();
    $resultat->closeCursor();
    return $unpaid;
}

/* demander les infos d'un etudiant */

function getAllStudentInfo($idetu){
    $connexion=getConnect();
    $requete="select * from etudiants where ID_ETU='$idetu' "; 
    $resultat=$connexion->query($requete);
    $resultat->setFetchMode(PDO::FETCH_OBJ);
    $infos=$resultat->fetchall();
    $resultat->closeCursor();
    return $infos;

}

function getAllStudentPayStatus($idetu){
    $connexion=getConnect();
    $requete="select * from rdv NATURAL JOIN services where ID_ETU='$idetu' order by DATE_RDV "; 
    $resultat=$connexion->query($requete);
    $resultat->setFetchMode(PDO::FETCH_OBJ);
    $payStatus=$resultat->fetchall();
    $resultat->closeCursor();
    return $payStatus;
}

////
/////// AGENT ADMINISTRATIF
//////// 

/*plannings*/

function getPlanningOneDayAgent($nomagent,$date){
    $connexion=getConnect();
    $requete="select rdv.DATE_RDV as DATE, rdv.HEURE_RDV as HEURE from rdv where rdv.NOM_AGENT='$nomagent' and rdv.DATE_RDV='$date' union select formation.DATE_FORMATION as date, formation.HEURE_FORMATION as HEURE from formation NATURAL JOIN bloque NATURAL JOIN employe where employe.NOM_EMP='$nomagent' and formation.DATE_FORMATION='$date'";
    $resultat=$connexion->query($requete);
    $resultat->setFetchMode(PDO::FETCH_OBJ);
    $planning=$resultat->fetchall();
    $resultat->closeCursor();
    return $planning;
}

/* bloquer une formation */

function creerFormation($date,$heure){
    $connexion=getConnect();
    $requete="insert into formation (ID_FORMATION , DATE_FORMATION , HEURE_FORMATION) values (0,'$date','$heure')" ;
    $resultat=$connexion->query($requete);
    $resultat->closeCursor();
}

function getIdFormation($date,$heure){
    $connexion=getConnect();
    $requete="select ID_FORMATION from formation where DATE_FORMATION='$date' and HEURE_FORMATION='$heure'"; 
    $resultat=$connexion->query($requete);
    $resultat->setFetchMode(PDO::FETCH_OBJ);
    $idFormation=$resultat->fetchall();
    $resultat->closeCursor();
    return $idFormation;
}

function bloquerFormation($idagent,$idformation){
    $connexion=getConnect();
    $requete="insert into bloque (ID_EMP ,ID_FORMATION) values ('$idagent','$idformation')" ;
    $resultat=$connexion->query($requete);
    $resultat->closeCursor();
}

/*gestion conclusion rdv */

function getRendezVousNonValides($nomagent){
    $connexion=getConnect();
    $requete="select * from rdv NATURAL JOIN services where NOM_AGENT='$nomagent' and rdv.CONCLUSION='EN ATTENTE' "; 
    $resultat=$connexion->query($requete);
    $resultat->setFetchMode(PDO::FETCH_OBJ);
    $rdvNV=$resultat->fetchall();
    $resultat->closeCursor();
    return $rdvNV;
}

function validerRdv($idrdv){
    $connexion=getConnect();
    $requete="update rdv set ETAT_PAIE='EN ATTENTE' , CONCLUSION='VALIDE' where ID_RDV ='$idrdv' ";
    $resultat=$connexion->query($requete);
    $resultat->closeCursor();
}

function refuserRdv($idrdv){
    $connexion=getConnect();
    $requete="update rdv set CONCLUSION='REFUSE' where ID_RDV ='$idrdv' ";
    $resultat=$connexion->query($requete);
    $resultat->closeCursor();
}


////////
///////// DIRECTEUR
///////

function creationEmploye($idcateg,$categorie,$nomemploye,$prenomemploye,$login,$mdp){
    $connexion=getConnect();
    $requete1="insert into employe values (0,'$idcateg','$nomemploye','$prenomemploye')" ;
    $resultat=$connexion->query($requete1);
    $resultat->closeCursor();
    $requete2="insert into categorie values (0,'$idcateg','$login','$mdp','$categorie')" ;
    $resultat=$connexion->query($requete2);
    $resultat->closeCursor();
}

function modifierNomEmploye($idemp,$anom,$nnom){
    $connexion=getConnect();
    $requete1="update employe set NOM_EMP = '$nnom' where ID_EMP = '$idemp' " ;
    $resultat=$connexion->query($requete1);
    $resultat->closeCursor();
    $connexion=getConnect();
    $requete2="update rdv set NOM_AGENT = '$nnom' where NOM_AGENT = '$anom' " ;
    $resultat=$connexion->query($requete2);
    $resultat->closeCursor();
}

function modifierPrenomEmploye($idemp,$nprenom){
    $connexion=getConnect();
    $requete="update employe set PRENOM_EMP = '$nprenom' where ID_EMP = '$idemp' " ;
    $resultat=$connexion->query($requete);
    $resultat->closeCursor();
}

function modifierLoginEmploye($idemp,$nlogin){
    $connexion=getConnect();
    $requete="update categorie set LOGIN ='$nlogin' where ID_EMP='$idemp' " ;
    $resultat=$connexion->query($requete);
    $resultat->closeCursor();
}

function modifierPasswordEmploye($idemp,$nmdp){
    $connexion=getConnect();
    $requete="update categorie set MDP='$nmdp' where categorie.ID_EMP='$idemp' " ;
    $resultat=$connexion->query($requete);
    $resultat->closeCursor();
}

function getcreationservice($nom,$prix){
    $connexion=getConnect();
    $requete="insert into services values ('0','$nom','$prix')" ;
    $resultat=$connexion->query($requete);
    $resultat->closeCursor();
}

function supprimerservice($id){
    $connexion=getConnect();
    $requete1="delete from services where ID_SERV='$id'" ;
    $resultat=$connexion->query($requete1);
    $resultat->closeCursor();
    $requete2="delete from necessite where ID_SERV='$id'" ;
    $resultat=$connexion->query($requete2);
    $resultat->closeCursor();
    $requete3="delete from rdv where ID_SERV='$id'" ;
    $resultat=$connexion->query($requete3);
    $resultat->closeCursor();
}


function recupereservice(){
    $connexion=getConnect();
    $requete="select * from services" ;
    $resultat=$connexion->query($requete);
    $resultat->setFetchMode(PDO::FETCH_OBJ);
    $ser = $resultat->fetchall();
    $resultat->closeCursor();
    return $ser;
}

function recupererpieces(){
    $connexion=getConnect();
    $requete="select * from pieces" ;
    $resultat=$connexion->query($requete);
    $resultat->setFetchMode(PDO::FETCH_OBJ);
    $ser = $resultat->fetchall();
    $resultat->closeCursor();
    return $ser;
}


function modifierNomService($nomserv,$nnom){
    $connexion=getConnect();
    $requete="update services set NOM_SERV = '$nnom' where NOM_SERV = '$nomserv' " ;
    $resultat=$connexion->query($requete);
    $resultat->closeCursor();
}

function modifierPrixService($nomserv,$nprix){
    $connexion=getConnect();
    $requete="update services set PRIX_SERV = '$nprix' where NOM_SERV = '$nomserv' " ;
    $resultat=$connexion->query($requete);
    $resultat->closeCursor();
}

function attribuerPiece($lesnoms,$idpiece){
    $connexion=getConnect();
    $requete1="delete from necessite where ID_PIECE='$idpiece' and ID_SERV = '$lesnoms' " ;
    $resultat=$connexion->query($requete1);
    $resultat->closeCursor();
    $requete1="insert into necessite values ('$idpiece','$lesnoms')" ;
    $resultat=$connexion->query($requete1);
    $resultat->closeCursor();
}

function getLesEmployes(){
    $connexion=getConnect();
    $requete="select * from employe"; 
    $resultat=$connexion->query($requete);
    $resultat->setFetchMode(PDO::FETCH_OBJ);
    $emp=$resultat->fetchall();
    $resultat->closeCursor();
    return $emp;
}