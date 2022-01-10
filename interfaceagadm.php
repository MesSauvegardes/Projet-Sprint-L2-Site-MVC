<?php
    require_once('controleur/controleur.php');

    try {
        
        /*plannings*/
        
        if (isset($_POST['genererplanningjour'])){
            $nomagent=$_POST['nomadmplanningjour'];
            CtlTodayPlanning($nomagent);
        }
        
        if (isset($_POST['genererplanningsomeday'])){
            $nomagent=$_POST['nomadmplanningjour'];
            $date=$_POST['datepouraffplanning'];
            CtlSomedayPlanning($nomagent,$date);
        }
        
        /*bloquer une formation*/
        
        if (isset($_POST['saveformation'])){
            $idagent=$_POST['idagentbloque'];
            $date=$_POST['datedelaformation'];
            $heure=$_POST['heuredelaformation'];
            CtlBloquerFormation($idagent,$date,$heure);
        }
        
        /* synthese */ 
        
        if (isset($_POST['syntheseEtudiant'])){
            $idetu=$_POST['idetudiantsynthese'];
            CtlStudentInfos2($idetu);
        }
        
        /*gestion rdv*/
        
        if (isset($_POST['generergestion'])){
            $nomagent=$_POST['nomadmgestionrdv'];
            CtlAfficherBlocGestionConclusion($nomagent);
        }
        
        if (isset($_POST['validerRDV'])){
            $sidrdv=$_POST['validerourefuser'];
            $idrdv = intval($sidrdv);
            CtlValiderRdv($idrdv);
        }
        
        if (isset($_POST['refuserRDV'])){
            $sidrdv=$_POST['validerourefuser'];
            $idrdv = intval($sidrdv);
            CtlRefuserRdv($idrdv);
        }
        
            CtlAcceuilAgentADM();
        }


catch(Exception $e) {
    $msg = $e->getMessage() ; 
    CtlErreurADM($msg);
 }