<?php
    require_once("controleur/controleur.php");
    
    try {
        
        if (isset($_POST['backhome'])){
            CtlAcceuilAgentAcc();
        }
        
        if (isset($_POST['logout'])){
            CtlLogoutAAC();
        }
        
        if (isset($_POST['enregistreretudiant'])){
            $nom=$_POST['nometudiant'];
            $prenom=$_POST['prenom'];
            $adresse=$_POST['adresse'];
            $birthdate=$_POST['birthdate'];
            $numtel=$_POST['numero'];
            $email=$_POST['emailetudiant'];
            $total=$_POST['total'];
            CtlAjouterEtudiant($nom,$prenom,$birthdate,$adresse,$numtel,$email,$total);
        }
        
        /*modification d'informations*/
        
        if (isset($_POST['validerchoixelementamodifier'])){
            $idetu=$_POST['modidetu'];
            $nnom=$_POST['nnometudiant'];
            $nprenom=$_POST['nprenom'];
            $nadresse=$_POST['nadresse'];
            $nbirthdate=$_POST['nbirthdate'];
            $nnumtel=$_POST['nnumero'];
            $nemail=$_POST['nemailetudiant'];
            $ntotal=$_POST['ntotal'];
            CtlMofifierInfoEtudiant($idetu,$nnom,$nprenom,$nbirthdate,$nadresse,$nnumtel,$nemail,$ntotal);
        }
        
        /*gestion financière*/
        
        if (isset($_POST['validergestionfinanciere'])){
            $idetudiant=$_POST['idetudiantgestion'];
            CtlAfficherBlocGestionFinanciere($idetudiant);
        }
        
        if (isset($_POST['payerDernierService'])){
            $idetu=$_POST['selectedid'];
            CtlPayerDernierService($idetu);
        }
        
        if (isset($_POST['demanderDiffere'])){
            $idetu=$_POST['selectedid'];
            CtlMiseEnDiffere($idetu);
        }
        
        if (isset($_POST['remboursementDiffere'])){
            $idetu=$_POST['selectedid'];
            foreach($_POST['rdv'] as $value){
                $idrdv = intval($value);
                CtlRemboursementDiffere($idrdv,$idetu);
            } 
        }
        
        /*recherche d'étudiant*/
        
        if (isset($_POST['validerrecherche'])){
            $nom=$_POST['nometudiantrecherche'];
            $birthdate=$_POST['birthdaterecherche'];
            CtlAfficherResultatRecherche($nom,$birthdate);
        }
        
        /*prise de rendez-vous*/
        
        if (isset($_POST['validernomagentrdv'])){
            $semaine=$_POST['semainepourplanning'];
            $nomagent=$_POST['nomagentadmin'];
            CtlAfficherPlanningSemaineAgent($semaine,$nomagent);
        }
        
        
        if (isset($_POST['savetherdv'])){
            $idetu=$_POST['numeturdv'];
            $nomagent=$_POST['nomagentadmin'];
            $daterdv=$_POST['datedurdv'];
            $heurerdv=$_POST['heuredurdv'];
            $idobjet=$_POST['idduservice'];
            $idservice= intval($idobjet);
            CtlSaveNewRdv($idetu,$idservice,$nomagent,$daterdv,$heurerdv);
            
        }
        
        /*syntheses*/
        
        if (isset($_POST['synthesePayementsAttente'])){
            CtlAllNonPaye();
        }
        
        if (isset($_POST['syntheseEtudiant'])){
            $idetu=$_POST['idetudiantsynthese'];
            CtlStudentInfos($idetu);
        }
        
        /*par defaut*/
        
            CtlAcceuilAgentAcc();
        }


catch(Exception $e) {
    $msg = $e->getMessage() ; 
    CtlErreurAAC($msg);
 }