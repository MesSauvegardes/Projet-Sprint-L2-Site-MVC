<!DOCTYPE html>
<html lang="fr">
 		<head>
   			 <meta charset="utf-8">
   			 <link rel="stylesheet" href="style/style.css">
   			 <title>Agent d'Acceuil</title>
             <script>
                function hideshow($nom) {
                    var x = document.getElementById($nom);
                    var fields=["enregistrer","modifier","gestion","recherche","rdv","syntheses","errorzoneAAC"];
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
                <h6 id="titreAAC"> - Agent d'Acceuil - </h6>
            </div>
            
            <div id="menuboutons">
                <form method="post" action="interfaceagacc.php" >
                    <input type="submit" name="backhome" value="ACCEUIL" />
                </form>
                <p>
                <button onclick='hideshow("enregistrer")'> Enregistrer un Etudiant </button>
                </p>
                <p>
                <button onclick='hideshow("modifier")'> Modifier une information </button>
                </p>
                <p>
                <button onclick='hideshow("gestion")'> Gestion Financière </button>
                </p>
                <p>
                <button onclick='hideshow("recherche")'> Rechercher Un Etudiant </button>
                </p>
                <p>
                <button onclick='hideshow("rdv")'> Prendre Un Rendez-Vous </button>
                </p>
                <p>
                <button onclick='hideshow("syntheses")'> Synthèses </button>
                </p>
                <form method="post" action="pageacceuil.php" >
                    <input type="submit" name="logout" value="DECONNEXION"/>
                </form>
            </div>
            
            <fieldset id="enregistrer">
                <legend> - Enregistrer un Etudiant - </legend>
                <form method="post" action=" interfaceagacc.php">
                    <p>
                    <label> Nom : </label>
                    <input type="text" name="nometudiant" required/>
                    </p>
                    <p>
                    <label> Prénom : </label>
                    <input type="text" name="prenom" required/>
                    </p>
                    <p>
                    <label> Date de naissance : </label>
                    <input type="date" name="birthdate" required/>
                    </p>
                    <p>
                    <label> Adresse : </label>
                    <input type="text" name="adresse" required/>
                    </p>
                    <p>
                    <label> Numéro de Téléphone : </label>
                    <input type="number" name="numero" required/>
                    </p>
                    <p>
                    <label> Adresse Mail : </label>
                    <input  type="email" name="emailetudiant" required/>
                    </p>
                    <p>
                    <label> Plafond total : </label>
                    <input  type="number" name="total" required/>
                    </p>
                    <p>
                    <input type="submit" name="enregistreretudiant" value="Valider" />
                    <input type="reset" value="Effacer le formulaire" />
                    </p>
                </form>
            </fieldset>
            
            
            <fieldset id="modifier">
                <legend> - Modifier une information - </legend>
                <form method="post" action=" interfaceagacc.php">
                    <p>
                    <label> Identifiant de l'Etudiant : </label>
                    <input type="number" name="modidetu" required/>
                    </p>
                    <p>
                    <label> ----------> Element(s) à Modifier : </label>
                    </p>
                    <p>
                    <label> Nom : </label>
                    <input type="text" name="nnometudiant" />
                    </p>
                    <p>
                    <label> Prénom : </label>
                    <input type="text" name="nprenom" />
                    </p>
                    <p>
                    <label> Date de naissance : </label>
                    <input type="date" name="nbirthdate" />
                    </p>
                    <p>
                    <label> Adresse : </label>
                    <input type="text" name="nadresse" />
                    </p>
                    <p>
                    <label> Numéro de Téléphone : </label>
                    <input type="number" name="nnumero" />
                    </p>
                    <p>
                    <label> Adresse Mail : </label>
                    <input  type="email" name="nemailetudiant"/>
                    </p>
                    <p>
                    <label> Plafond total : </label>
                    <input  type="number" name="ntotal"/>
                    </p>
                    <p>
                    <input type="submit" value="Valider" name="validerchoixelementamodifier" />
                    </p>
                </form>
            </fieldset>
            
            <fieldset id="gestion">
                <legend> - Gestion Financière - </legend>
                <form method="post" action=" interfaceagacc.php">
                    <p>
                        <label> Numéro de l'Etudiant : </label>
                        <input type="number" name="idetudiantgestion" />
                    </p>
                    <p>
                        <input type="submit" name="validergestionfinanciere" value="Valider"/>    
                    </p>
                    <?php echo $blocGestionFinanciere ; ?>
                </form>
            </fieldset>
            
            
            <fieldset id="recherche">
                <legend> - Rechercher un Numéro Etudiant - </legend>
                <form method="post" action=" interfaceagacc.php">
                <p>
                    <label> Nom de l'étudiant : </label>
                    <input type="text" name="nometudiantrecherche" required/>
                </p>
                <p>
                    <label> Date de naissance : </label>
                    <input type="date" name="birthdaterecherche" required/>
                </p>
                <p>
                    <input type="submit" name="validerrecherche" value="Rechercher" />
                </p>
                </form>
                <?php echo $blocResultatRecherche ; ?>
            </fieldset>
            
            <fieldset id="rdv">
            <fieldset>
                <legend> - Plages Horaires Disponibles - </legend>
                <form method="post" action=" interfaceagacc.php">
                    <p><label> Nom de l'Agent : </label>
                    <select name="nomagentadmin">
                        <?php echo $listenomsagentsadmin ;?>
                    </select>
                    </p>
                    <p>
                        <label> Semaine du : </label>
                        <input type="date" name="semainepourplanning" min="2020-12-07" step="7" required/>
                    </p>
                    <p>
                        <input type="submit" value="Valider" name="validernomagentrdv" />
                    </p>
                </form>
                <?php echo $blocPlanningSemaine ; ?>
            </fieldset>
            <fieldset>
                <legend> - Prendre un Rendez-Vous - </legend>
                <form method="post" action=" interfaceagacc.php">
                    <p>
                        <label> Etudiant numéro : </label>
                        <input type="number" name="numeturdv" required/>
                    </p>
                    <p> <label>Nom de l'Agent : </label>
                        <select name="nomagentadmin" required>
                            <?php echo $listenomsagentsadmin ;?>
                        </select>
                    </p>
                    <p>
                        <label> Date et Heure : </label>
                        <input type="date" name="datedurdv" min="2020-12-07" required />
                        à <input type="number" name="heuredurdv" min="7" max="19" required/> heures
                    </p>
                    <p>
                        <label> Objet du Rendez-vous : </label>
                        <?php echo $listeservices ; ?>
                    </p>
                    <p>
                        <input type="submit" name="savetherdv" value="Enregistrer le RDV" />
                    </p>
                </form>
                <?php echo $piecesPourRdv ; ?>
            </fieldset>
            </fieldset>
            
            <fieldset id="syntheses">
            <form method="post" action=" interfaceagacc.php">
                <p>
                <label> Payements En Attente </label>
                <input type="submit" name="synthesePayementsAttente" value="Visualiser"/>
                </p>
            </form>
            <form method="post" action=" interfaceagacc.php">
                <p>
                <label> Synthèse de l'Etudiant n° </label>
                <input type="number" name="idetudiantsynthese" required/>
                <input type="submit" name="syntheseEtudiant" value="Visualiser"/>
                </p>
            </form>
                <?php echo $synthesePaiements ; ?>
                <?php echo $syntheseEtudiant ; ?>
            </fieldset>
            
            <div id="errorzoneAAC">
                <?php echo $errorbox ; ?>
            </div>
  	    </body>	
</html>