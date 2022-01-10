<?php
    require_once('controleur/controleur.php');

    try {
        if (isset($_POST['validerconnexion'])){
            $categorie=$_POST['categorie'];
            $login=$_POST['login'];
            $pass=$_POST['motdepasse'];
            CtlSeConnecter($categorie,$login,$pass);
            }

            CtlAcceuilConnexion();
        }


catch(Exception $e) {
    $msg = $e->getMessage() ; 
    CtlErreurPA($msg);
 }