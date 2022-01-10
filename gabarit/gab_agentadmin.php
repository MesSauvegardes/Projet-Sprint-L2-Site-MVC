<!DOCTYPE html>
<html lang="fr">
 		<head>
   			 <meta charset="utf-8">
   			 <link rel="stylesheet" href="style/style.css">
   			 <title>Agent Administratif</title>
             <script>
                function hideshow($nom){
                    var x = document.getElementById($nom);
                    var fields=["planningsADM","gestionRDV","syntheseADM","formationADM"];
                    if (x.style.display === "block") {
                        x.style.display = "none";
                    }
                    else {
                        for (var i=0;i<fields.length;i++){
                        if (x != document.getElementById(fields[i])){
                            document.getElementById(fields[i]).style.display="none";
                        }
                        }
                        x.style.display = "block";
                    }
                    }
             </script>
        </head>
 	    <body>
            <div>
                <h6 id="titreADM"> - Agent Administratif - </h6>
            </div>
            
            <div id="menuboutons2">
                <form method="post" action=" interfaceagadm.php" >
                    <input type="submit" name="backhome" value="ACCEUIL" />
                </form>
                <p>
                <button onclick='hideshow("planningsADM")'> Plannings </button>
                </p>
                <p>
                <button onclick='hideshow("gestionRDV")'> Gestion des Rendez-Vous </button>
                </p>
                <p>
                <button onclick='hideshow("formationADM")'> Bloquer une Formation </button>
                </p>
                <p>
                <button onclick='hideshow("syntheseADM")'> Synthèse </button>
                </p>
                <form method="post" action="pageacceuil.php" >
                    <input type="submit" name="logout" value="DECONNEXION"/>
                </form>
            </div>
            
            <fieldset id="planningsADM">
                <form method="post" action=" interfaceagadm.php">
                <p>
                    <label> Nom de L'agent : </label>
                    <input type="text" name="nomadmplanningjour" required/>
                </p>
                <input type="submit" name="genererplanningjour" value="Afficher le Planning du Jour"/>
                <?php echo $todayPlanning ; ?>
                <p>
                    <label> Choisir une Date : </label>
                    <input type="date" name="datepouraffplanning" />
                </p>
                <input type="submit" name="genererplanningsomeday" value="Afficher le Planning"/>
                <?php echo $somedayPlanning ; ?>
            </form>
                
            </fieldset>
            
            <fieldset id="gestionRDV">
            <form method="post" action=" interfaceagadm.php">
                <p>
                    <label> Votre Nom : </label>
                    <input type="text" name="nomadmgestionrdv" required/>
                </p>
                <input type="submit" name="generergestion" value="Afficher les Rendez-Vous" />
            </form>
            <form method="post" action=" interfaceagadm.php">
                <?php echo $gestionConclusion ; ?>
            </form>
            </fieldset>
            
            <fieldset id="formationADM">
                <form method="post" action=" interfaceagadm.php">
                    <p>
                        <label> Votre Identifiant : </label>
                        <input type="number" name="idagentbloque" required/>
                    </p>
                    <p>
                        <label> Date de la Formation : </label>
                        <input type="date" name="datedelaformation" required/>
                        <label> Heure : </label>
                        <input type="number" name="heuredelaformation" min="7" max="19" required/>
                    </p>
                    <p>
                        <input type="submit" name="saveformation" value="Enregistrer"/>
                    </p>
                </form>
            </fieldset>
            
            <fieldset id="syntheseADM">
                <form method="post" action=" interfaceagadm.php">
                    <p>
                    <label> Synthèse de l'Etudiant n° </label>
                    <input type="number" name="idetudiantsynthese" required/>
                    <input type="submit" name="syntheseEtudiant" value="Visualiser"/>
                    </p>
                </form>
                <?php echo $syntheseEtudiant2; ?>
            </fieldset>
            
            <div id="errorzoneADM">
                <?php echo $errorbox ; ?>
            </div>
  	    </body>	
</html>