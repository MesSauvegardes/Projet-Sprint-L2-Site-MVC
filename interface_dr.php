<?php
    require_once('controleur/controleur.php');

try {
    
    if(isset($_POST['creationuser'])){
        $categ=$_POST['nomcategorie'];
        $nom=$_POST['nomuser'];
        $prenom=$_POST['prenomuser'];
        $login=$_POST['loginuser'];
        $mdp=$_POST['mdpuser'];
        CtlAjouterEmploye($categ,$nom,$prenom,$login,$mdp);
        
    }
    
    if (isset($_POST['modifieruser'])){
        $iduser=$_POST['iduser'];
        $anom=$_POST['anciennom'];
        $nnom=$_POST['newnom'];
        $nprenom=$_POST['newprenom'];
        $nlogin=$_POST['newlogin'];
        $nmdp=$_POST['newmdp'];
        CtlModifierEmploye($iduser,$anom,$nnom,$nprenom,$nlogin,$nmdp);
        
    }
    
    if (isset($_POST['creation'])) {
        $nom = $_POST['Nomservice'];
        $prix = $_POST['prixduservice'];
        CtlAjouterService($nom, $prix);

    }
    
    if (isset($_POST['idservice'])) {
        $id = $_POST['idservice'];
        CtlSupprimerservice($id);

    }
    
    if (isset($_POST['modifierservice'])){
        $lesnoms= $_POST['lesnomsservices'];
        $nouvser= $_POST['nouveauservice'];
        Ctlmodifierservice($lesnoms,$nouvser);
        foreach($_POST['piece'] as $value){
            $idpiece = intval($value);
            CtlAttribuerPiece($idpiece,$lesnoms);
        } 


    }
    
    if (isset($_POST['voirlesemployes'])){
        CtlAfficherLesEmployes();
        
    }
    
    if (isset($_POST['bouttonservice'])) {
        Ctlafficherservice();
    }
    
    CtlAcceuilDirecteur();
} 

catch (Exception $e) {
    $msg = $e->getMessage();
    CtlErreurDR($msg);
}