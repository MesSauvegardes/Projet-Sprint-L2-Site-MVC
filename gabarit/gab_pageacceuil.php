<!DOCTYPE html>
<html lang="fr">
 		<head>
   			 <meta charset="utf-8">
   			 <link rel="stylesheet" href="style/style.css">
   			 <title>Acceuil du Site</title>
        </head>
    
 	    <body>
            <fieldset id="bloclogin">
                <form method="post" action="pageacceuil.php"> 
                    <p> 
                        <select id="categ" name="categorie" multiple>
                            <option class="choixcateg" value="directeur" selected>Directeur</option>
                            <option class="choixcateg" value="agent_acceuil">Agent d'Acceuil</option>
                            <option class="choixcateg" value="agent_administratif">Agent Administratif</option>
                        </select>
                    </p>
                    <p>
                        <label> Login </label>
                        <input type="text" name="login" required/>
                    </p>
                    <p>
                        <label> Mot de passe </label>
                        <input type="password" name="motdepasse" required/>
                    </p>
                    <p>
                        <input type="submit" value="valider" name="validerconnexion" />
                    </p>
                </form>
                <?php echo $errorbox; ?>
            </fieldset>
            
            <?php echo $hideBlocLogin; ?>
  	    </body>	
</html>