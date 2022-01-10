<!DOCTYPE html>
<html lang="fr">
 		<head>
   	        <meta charset="utf-8">
            <link rel="stylesheet" href="style/style.css">
            <title>Directeur</title>
            <script>
                function hideshow($nom) {
                    var x = document.getElementById($nom);
                    var fields=["userDR","serviceDR","statsDR"];
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
            <h6 id="titreDR"> - DIRECTEUR - </h6>
        </div>
            
        <div id="menuboutons3">
            <form method="post" action="interface_dr.php" >
                <input type="submit" name="backhome" value="ACCEUIL" />
            </form>
            <p>
                <button onclick='hideshow("userDR")'> Gestion des Employés </button>
            </p>
            <p>
                <button onclick='hideshow("serviceDR")'> Gestion des Services </button>
            </p>
            <p>
                <button onclick='hideshow("statsDR")'> Statistiques </button>
            </p>
            <form method="post" action="pageacceuil.php" >
                <input type="submit" name="logout" value="DECONNEXION"/>
            </form>
        </div>
            
        <fieldset id="userDR">
            <fieldset>
            <legend>Créer un utilisateur  </legend>
                <form method="post" action="interface_dr.php">
                    <p>
                        <label>Categorie :</label>
                        <select name="nomcategorie">
                            <option value="100">Directeur</option>
                            <option value="200">Agent d'Acceuil</option>
                            <option value="300">Agent Administratif</option>
                        </select>
                    </p>
                    <p>
                        <label>Nom : </label>
                        <input type="text" name="nomuser"/>
                    </p>
                    <p>
                        <label>Prénom : </label>
                        <input type="text" name="prenomuser"/>
                    </p>
                    <p>
                        <label>Login : </label>
                        <input type="text" name="loginuser"/>
                    </p>
                    <p>
                        <label>Mot de passe  : </label> 
                        <input type="password" name="mdpuser"/>
                    </p>
                    <p>
                        <input type="submit" value="Créer un utilisateur" name="creationuser"/>
                        <input type="reset" value="Annuler"/>
                    </p>
                </form>
            </fieldset>
            <fieldset>
                <legend>Modifier un utilisateur </legend>
                <form method="post" action="interface_dr.php">
                    <p>
                        <label>Id de l'utilisateur : </label>
                        <input type="number" name="iduser" />
                        <label> Nom : </label>
                        <input type="text" name="anciennom"/>
                    </p>
                    <p>
                        <label> Nouveau Nom : </label>
                        <input type="text" name="newnom"/>
                    </p>
                    <p>
                        <label> Nouveau Prénom : </label>
                        <input type="text" name="newprenom"/>
                    </p>
                    <p>
                        <label> Nouveau Login : </label>
                        <input type="text" name="newlogin"/>
                    </p>
                    <p>
                        <label> Nouveau Mot de Passe : </label>
                        <input type="password" name="newmdp"/>
                    </p>
                    <p>
                        <input type="submit" value="modifier un utilisateur" name="modifieruser"/>
                        <input type="reset" value="Annuler"/>
                    </p>
                </form>
            </fieldset>
            <fieldset>
                <legend> Supprimer un Employé </legend>
                <form method="post" action="interface_dr.php">
                    <p>
                        <label>Supprimer Employé n° </label>
                        <input type="text" name="idutilisateur"/>
                    </p>
                    <p>
                        <input type="submit" value="supprimer cet utilisateur " name="supputili"/>
                        <input type="reset" value="Annuler"/>
                    </p>
                </form>
            </fieldset>
        </fieldset>
            
        <fieldset id="serviceDR"> 
            <fieldset>
                <legend> Créer un service  </legend>
                <form method="post" action="interface_dr.php">
                    <p>
                        <label>Nom du Service : </label> 
                        <input type="text" name="Nomservice"/>
                    </p>
                    <p>
                        <label>Prix du Service : </label>
                        <input type="number" name="prixduservice"/>
                    </p>
                    <p>
                    <input type="submit" value="Créer un Service" name="creation"/>
                    <input type="reset" value="Annuler"/>
                    </p>
                </form>
            </fieldset>
            <fieldset>
                <legend> Modifier un service  </legend>
                <form method="post" action="interface_dr.php">
                    <p>
                        <input type="submit" value= "Nom des services" name="bouttonservice"/>
                        <?php echo $selectservice; ?>
                    </p>
                    <p>
                        <label> Nouveau Nom : </label>
                        <input type="text" name="nouveauservice"/>
                    </p>
                    <p>
                        <label> Nouveau Prix : </label>
                        <input type="number" name="newprice" />
                    </p>
                    <?php echo $blocModPieces; ?>
                    <p>
                        <input type="submit" value="modifier un service " name="modifierservice"/>
                        <input type="reset" value="Annuler"/>
                    </p>
                </form>
            </fieldset>
            <fieldset>
                <legend> Supprimer un service  </legend>
                <form method="post" action="interface_dr.php">
                    <p>
                    <label>Id du Service à supprimer :</label>
                        <input type="number" name="idservice"/>
                    </p>
                    <p>
                        <input type="submit" value="supprimer ce service " name="service"/>
                        <input type="reset" value="Annuler"/>
                    </p>
                </form>
            </fieldset>
        </fieldset>
            
        <fieldset id="statsDR">
            <legend> Visualisation des Statistiques </legend>
            <form method="post" action="interface_dr.php">
                <p>
                    <input type="submit" name="voirlesemployes" value="Afficher tous les Employés" />
                </p>
            </form>
            <form method="post" action="interface_dr.php">
                <p>
                    <label> Entre le </label>
                    <input type="date" name="statdebut" />
                    <label> et le </label>
                    <input type="date" name="statfin" />
                </p>
                <p>
                    <input type="submit" name="visualiserstats" value="Visualiser" />
                </p>
            </form>
            <?php echo $showEmployes; ?>
        </fieldset>    
            

  	    </body>
</html>


