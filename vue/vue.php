<?php

/////// PAGE D'ACCEUIL

function afficherAcceuilConnexion(){
    $hideBlocLogin='';
    $errorbox='';
    require_once('gabarit/gab_pageacceuil.php');
}

function makeBlocloginHidden(){
    $errorbox='';
    $hideBlocLogin='';
    $hideBlocLogin='<script> document.getElementById("bloclogin").style.display="none"; </script>';
    require_once('gabarit/gab_pageacceuil.php');
}

///// AGENT D'ACCEUIL

function afficherAcceuilAgentAcc(){
    $blocGestionFinanciere='';
    $blocResultatRecherche='';
    $listenomsagentsadmin='';
    $blocPlanningSemaine='';
    $errorbox='';
    $listeservices='';
    $piecesPourRdv='';
    $synthesePaiements='';
    $syntheseEtudiant='';
    require_once('gabarit/gab_agentacc.php');
}

function afficherBlocServicesPourPayement($liste,$idetu){
    $blocGestionFinanciere='';
    $blocResultatRecherche='';
    $listenomsagentsadmin='';
    $blocPlanningSemaine='';
    $errorbox='';
    $listeservices='';
    $piecesPourRdv='';
    $synthesePaiements='';
    $syntheseEtudiant='';
    $blocGestionFinanciere='<form>';
    $blocGestionFinanciere.='<script> document.getElementById("gestion").style.display="block";</script><input type="number" name="selectedid" value="'.$idetu.'" readonly/>';
    foreach($liste as $ligne){
        $blocGestionFinanciere.='<p><input type="checkbox" name="rdv[]" value="'.$ligne->ID_RDV.'"/> Rendez-vous du '.$ligne->DATE_RDV.' à '. $ligne->HEURE_RDV.' heures . Montant à payer : '.$ligne->PRIX_SERV.' Euros. Etat : '.$ligne->ETAT_PAIE.'</p>';
    }
    $blocGestionFinanciere.='<p><label> --- ACTIONS : </label><br><br><label> Dernier Service :</label>';
    $blocGestionFinanciere.='<input type="submit" name="payerDernierService" value="Payer" />';
    $blocGestionFinanciere.='<input type="submit" name="demanderDiffere" value="Mettre en Différé" /><br><br>';
    $blocGestionFinanciere.='<label> -- </label><input type="submit" name="remboursementDiffere" value="Rembourser les Différés sélectionnés"/>';
    $listeservices.='</form>';
    require_once('gabarit/gab_agentacc.php');
}

function afficherResRechercheId($residetudiant){
    $blocGestionFinanciere='';
    $blocResultatRecherche='';
    $listenomsagentsadmin='';
    $blocPlanningSemaine='';
    $errorbox='';
    $listeservices='';
    $piecesPourRdv='';
    $synthesePaiements='';
    $syntheseEtudiant='';
    $blocResultatRecherche = '<script> document.getElementById("recherche").style.display="block";</script><fieldset><legend> Résulat de la Recherche </legend>';
    foreach ($residetudiant as $ligne){
        $blocResultatRecherche.= '<p> Le numéro recherché est : '.$ligne->ID_ETU.'</p>';
    } $blocResultatRecherche.='</fieldset>';
    require_once('gabarit/gab_agentacc.php');
}

function afficherPlanningSemaine($dispo,$nomagent,$datedebut,$datefin,$listeA,$listeS){
    $blocGestionFinanciere='';
    $blocResultatRecherche='';
    $listenomsagentsadmin='';
    $blocPlanningSemaine='';
    $errorbox='';
    $listeservices='';
    $piecesPourRdv='';
    $synthesePaiements='';
    $syntheseEtudiant='';
    $blocPlanningSemaine='<script>document.getElementById("rdv").style.display="block";</script>';
    $blocPlanningSemaine.='<table><tr><th>Légende</th></tr><tr><td class="available">Disponible</td></tr><tr><td class="busytime">Occupé</td></tr></table><table id="planning"><br>';
    $blocPlanningSemaine.='<caption> Planning de la Semaine </caption>';
    $weekStart=new DateTime($datedebut);
    $intervalle = new DateInterval('P1D');
    $weekEnd = new DateTime($datefin); 
    $periode = new DatePeriod($weekStart,$intervalle,$weekEnd);
    foreach($periode as $day){
        $blocPlanningSemaine.='<tr><th>'.($day->format('d-m-Y')).'</th>';
        for($heure=7;$heure<20;$heure++){
            $bloc= '';
            foreach($dispo as $ligne){
                if(($ligne->DATE)==($day->format('Y-m-d')) && ($ligne->HEURE)==$heure){
                    $bloc='<td class="busytime">'.$heure.'h</td>';
                }
            } 
            if($bloc==''){
                $bloc= '<td class="available">'.$heure.'h</td>';
            }
            $blocPlanningSemaine.=$bloc;
        }  
        $blocPlanningSemaine.='</tr>';
    }
    $blocPlanningSemaine.='</table><br>';
    foreach ($listeA as $ligne){
        $listenomsagentsadmin.= '<option value="'.$ligne->NOM_EMP.'">'. $ligne->NOM_EMP .'</option>';
    }
    $listeservices.='<table id="menuservices"><caption> Services Proposés et Tarifs </caption><tr><th> Service </th><th> Prix (en euros) </th></tr>';
    foreach($listeS as $ligne){
        $listeservices.='<tr><td>'.$ligne->NOM_SERV.'</td><td>'.$ligne->PRIX_SERV.'</td></tr>';
    } 
    $listeservices.='</table><p><label> Choix du Service : </label><select name="idduservice">';
    foreach($listeS as $ligne){
        $listeservices.='<option value="'.$ligne->ID_SERV.'">'.$ligne->NOM_SERV.'</option>';
    }
    $listeservices.='</select>';
    require_once('gabarit/gab_agentacc.php');
}

function afficherPiecesPourRdv($pieces){
    $blocGestionFinanciere='';
    $blocResultatRecherche='';
    $listenomsagentsadmin='';
    $blocPlanningSemaine='';
    $errorbox='';
    $listeservices='';
    $piecesPourRdv='';
    $synthesePaiements='';
    $syntheseEtudiant='';
    $piecesPourRdv='<script>document.getElementById("rdv").style.display="block";</script><p>';
    $piecesPourRdv.='<br>Le Rendez vous a été enregistré. Veuillez apporter les documents suivants : <br>';
    $x=1;
    foreach($pieces as $ligne){
        $piecesPourRdv.='<br>'.$x.'. '.$ligne->NOM_PIECE;
        $x+=1;
    }$piecesPourRdv.='</p>';
    require_once('gabarit/gab_agentacc.php');
}

function afficherTousPayementsAttente($unpaid){
    $blocGestionFinanciere='';
    $blocResultatRecherche='';
    $listenomsagentsadmin='';
    $blocPlanningSemaine='';
    $errorbox='';
    $listeservices='';
    $piecesPourRdv='';
    $synthesePaiements='';
    $syntheseEtudiant='';
    $synthesePaiements='<script>document.getElementById("syntheses").style.display="block";</script><p>';
    $x=1;
    foreach($unpaid as $ligne){
        $synthesePaiements.='<br>'.$x.'. Rendez-vous de '.$ligne->NOM.' '.$ligne->PRENOM.' avec l\'Agent '.$ligne->NOM_AGENT.' le ';
        $synthesePaiements.=$ligne->DATE_RDV.' à '.$ligne->HEURE_RDV.' heures. Montant : '.$ligne->PRIX_SERV.' Euros. Etat : '.$ligne->ETAT_PAIE.'<br>';
        $x+=1;
    }
    $synthesePaiements.='</p>';
    require_once('gabarit/gab_agentacc.php');
}

function afficherSyntheseEtudiant($infos,$payStatus){
    $blocGestionFinanciere='';
    $blocResultatRecherche='';
    $listenomsagentsadmin='';
    $blocPlanningSemaine='';
    $errorbox='';
    $listeservices='';
    $piecesPourRdv='';
    $synthesePaiements='';
    $syntheseEtudiant='';
    $syntheseEtudiant.='<script>document.getElementById("syntheses").style.display="block";</script><p>';
    foreach($infos as $ligne){
        $syntheseEtudiant.='Nom et Prénom : ' . $ligne->NOM . ' ' . $ligne->PRENOM . '<br>';
        $syntheseEtudiant.='Date de Naissance : '. $ligne->DATEDENAISSANCE . '<br>Adresse : ' . $ligne->ADRESSE . '<br>';
        $syntheseEtudiant.='Numéro de téléphone : '. $ligne->NUM_TEL . '<br>Adresse mail : '. $ligne->MAIL . '<br>';
        $pD=$ligne->PLAFOND_DIFF;
        $pT=$ligne->PLAFOND_TOTAL;
        $syntheseEtudiant.='Montant de différé total autorisé : '.$pT.' Euros <br>';
        $syntheseEtudiant.='Montant de différé autorisé restant : '. ($pT-$pD) . ' Euros <br>';
    }
    $syntheseEtudiant.='</p><p>';
    $syntheseEtudiant.='<br> - Rendez-vous Enregistrés : <br>';
    $x=1;
    foreach($payStatus as $ligne){
        $syntheseEtudiant.='<br>'.$x.'. Rendez-Vous du ' .$ligne->DATE_RDV. ' à ' .$ligne->HEURE_RDV . ' heures, avec ' . $ligne->NOM_AGENT;
        $syntheseEtudiant.='<br> Motif : '.$ligne->NOM_SERV.'<br> Montant : '.$ligne->PRIX_SERV.' Euros';
        $syntheseEtudiant.='<br> Statut : '.$ligne->CONCLUSION.'<br> Etat du Paiement : '.$ligne->ETAT_PAIE.'<br>';
        $x+=1;
    }
    $syntheseEtudiant.='</p>';
    require_once('gabarit/gab_agentacc.php');
}

function genererListesDeroulantes($listeA,$listeS){
    $blocGestionFinanciere='';
    $blocResultatRecherche='';
    $listenomsagentsadmin='';
    $blocPlanningSemaine='';
    $errorbox='';
    $listeservices='';
    $piecesPourRdv='';
    $synthesePaiements='';
    $syntheseEtudiant='';
    foreach ($listeA as $ligne){
        $listenomsagentsadmin.= '<option value="'.$ligne->NOM_EMP.'">'. $ligne->NOM_EMP .'</option>';
    }
    $listeservices.='<table id="menuservices"><caption> Services Proposés et Tarifs </caption><tr><th id="caseserv"> Service </th><th> Prix (en euros) </th></tr>';
    foreach($listeS as $ligne){
        $listeservices.='<tr><td>'.$ligne->NOM_SERV.'</td><td>'.$ligne->PRIX_SERV.'</td></tr>';
    } 
    $listeservices.='</table><p> Choix du Service : <select name="idduservice">';
    foreach($listeS as $ligne){
        $listeservices.='<option value="'.$ligne->ID_SERV.'">'.$ligne->NOM_SERV.'</option>';
    }
    $listeservices.='</select>';
    require_once('gabarit/gab_agentacc.php');
}

/////  AGENT ADMINISTRATIF

function afficherAcceuilADM(){
    $errorbox='';
    $syntheseEtudiant2='';
    $todayPlanning='';
    $somedayPlanning='';
    $gestionConclusion='';
    require_once('gabarit/gab_agentadmin.php');        
}

/*plannings*/

function afficherPlanningToday($dates){
    $errorbox='';
    $syntheseEtudiant2='';
    $todayPlanning='';
    $somedayPlanning='';
    $gestionConclusion='';
    $todayPlanning='<script>document.getElementById("planningsADM").style.display="block";</script><p>';
    $todayPlanning.='<table>';
    $today = new DateTime('now');
    $todayPlanning.='<tr><th>'.($today->format('d-m-Y')).'</th>';
    for($heure=7;$heure<20;$heure++){
        $bloc= '';
        foreach($dates as $ligne){
            if(($ligne->DATE)==($today->format('Y-m-d')) && ($ligne->HEURE)==$heure){
                $bloc='<td class="busytime">'.$heure.'h</td>';
            }
        } 
        if($bloc==''){
            $bloc= '<td class="available">'.$heure.'h</td>';
        } $todayPlanning.=$bloc;
    }  
    $todayPlanning.='</tr></table><br>';
    require_once('gabarit/gab_agentadmin.php');
}

function afficherPlanningSomeday($dates,$someday){
    $errorbox='';
    $syntheseEtudiant2='';
    $todayPlanning='';
    $somedayPlanning='';
    $gestionConclusion='';
    $somedayPlanning='<script>document.getElementById("planningsADM").style.display="block";</script><p>';
    $somedayPlanning.='<table>';
    $jour = new DateTime($someday);
    $somedayPlanning.='<tr><th>'.($jour->format('d-m-Y')).'</th>';
    for($heure=7;$heure<20;$heure++){
        $bloc= '';
        foreach($dates as $ligne){
            if(($ligne->DATE)==($jour->format('Y-m-d')) && ($ligne->HEURE)==$heure){
                $bloc='<td class="busytime">'.$heure.'h</td>';
            }
        } 
        if($bloc==''){
            $bloc= '<td class="available">'.$heure.'h</td>';
        } $somedayPlanning.=$bloc;
    }  
    $somedayPlanning.='</tr></table><br>';
    require_once('gabarit/gab_agentadmin.php');
}

/*gestion conclusion*/

function genererBlocGestionConclusion($rdv){
    $errorbox='';
    $todayPlanning='';
    $syntheseEtudiant2='';
    $gestionConclusion='';
    $somedayPlanning='';
    $gestionConclusion.='<script>document.getElementById("gestionRDV").style.display="block";</script><p>';
    $gestionConclusion.='<select name="validerourefuser" id="rdvNV">';
    foreach($rdv as $ligne){
        $gestionConclusion.='<option value="'.$ligne->ID_RDV.'"> Rendez-Vous du '.$ligne->DATE_RDV.' à '.$ligne->HEURE_RDV.' heures avec l\'etudiant numéro '.$ligne->ID_ETU.' pour '.$ligne->NOM_SERV;
    }
    $gestionConclusion.='</select>';
    $gestionConclusion.='<p><label>Actions : </label><input type="submit" name="validerRDV" value="Valider"/><input type="submit" name="refuserRDV" value="Refuser" /></p>';
    require_once('gabarit/gab_agentadmin.php');
}

/*synthese*/

function afficherSyntheseEtudiantADM($infos,$payStatus){
    $errorbox='';
    $syntheseEtudiant2='';
    $gestionConclusion='';
    $todayPlanning='';
    $somedayPlanning='';
    $syntheseEtudiant2.='<script>document.getElementById("syntheseADM").style.display="block";</script><p>';
    foreach($infos as $ligne){
        $syntheseEtudiant2.='Nom et Prénom : ' . $ligne->NOM . ' ' . $ligne->PRENOM . '<br>';
        $syntheseEtudiant2.='Date de Naissance : '. $ligne->DATEDENAISSANCE . '<br>Adresse : ' . $ligne->ADRESSE . '<br>';
        $syntheseEtudiant2.='Numéro de téléphone : '. $ligne->NUM_TEL . '<br>Adresse mail : '. $ligne->MAIL . '<br>';
        $pD=$ligne->PLAFOND_DIFF;
        $pT=$ligne->PLAFOND_TOTAL;
        $syntheseEtudiant2.='Montant de différé total autorisé : '.$pT.' Euros <br>';
        $syntheseEtudiant2.='Montant de différé autorisé restant : '. ($pT-$pD) . ' Euros <br>';
    }
    $syntheseEtudiant2.='</p><p>';
    $syntheseEtudiant2.='<br> - Rendez-vous Enregistrés : <br>';
    $x=1;
    foreach($payStatus as $ligne){
        $syntheseEtudiant2.='<br>'.$x.'. Rendez-Vous du ' .$ligne->DATE_RDV. ' à ' .$ligne->HEURE_RDV . ' heures, avec ' . $ligne->NOM_AGENT;
        $syntheseEtudiant2.='<br> Motif : '.$ligne->NOM_SERV.'<br> Montant : '.$ligne->PRIX_SERV.' Euros';
        $syntheseEtudiant2.='<br> Statut : '.$ligne->CONCLUSION.'<br> Etat du Paiement : '.$ligne->ETAT_PAIE.'<br>';
        $x+=1;
    }
    $syntheseEtudiant2.='</p>';
    require_once('gabarit/gab_agentadmin.php');
}

////// DIRECTEUR

function afficheraccueildirecteur(){
    $selectservice = '';
    $errorbox='';
    $blocModPieces='';
    $showEmployes='';
    require_once ('gabarit/gab_directeur.php');
}
    
function afficherselect($serv,$pieces){
    $selectservice = '';
    $errorbox='';
    $blocModPieces='';
    $showEmployes='';
    $selectservice='<script>document.getElementById("serviceDR").style.display="block";</script><p>';
    $selectservice.= '<select name="lesnomsservices">';
    foreach ($serv as $ligne){
        $selectservice.='<option value = " '.$ligne->ID_SERV.'" >'.$ligne->NOM_SERV.'</option>';
    }
    $selectservice.='</select>';
    foreach($pieces as $ligne){
        $blocModPieces.='<p><input type="checkbox" name="piece[]" value="'.$ligne->ID_PIECE.'"/>'.$ligne->NOM_PIECE.'</p>';
    }
    require_once ('gabarit/gab_directeur.php');
}

function afficherTousLesEmployes($emp){
    $selectservice = '';
    $errorbox='';
    $blocModPieces='';
    $showEmployes='';
    $x=1;
    $showEmployes='<script>document.getElementById("statsDR").style.display="block";</script><p>';
    foreach($emp as $ligne){
        $showEmployes.='<br>'.$x.'. Nom et Prénom : '.$ligne->NOM_EMP.' '.$ligne->PRENOM_EMP.' - Id : '.$ligne->ID_EMP.'<br>';
        $x+=1;
    }
    require_once ('gabarit/gab_directeur.php');
}

/*functions pour erreurs*/

function afficherErreurPA($erreur){
    $hideBlocLogin='';
    $errorbox='<p>'. $erreur . '</p>';
    require_once('gabarit/gab_pageacceuil.php');
}

function afficherErreurDR($erreur){
    $selectservice = '';
    $errorbox='';
    $blocModPieces='';
    $showEmployes='';
    $errorbox='<script>document.getElementById("errorzoneDR").style.display="block";</script>';
    $errorbox.='<p>'. $erreur . '</p>';
    require_once ('gabarit/gab_directeur.php');
}

function afficherErreurAAC($erreur){
    $blocGestionFinanciere='';
    $blocResultatRecherche='';
    $listenomsagentsadmin='';
    $blocPlanningSemaine='';
    $errorbox='';
    $listeservices='';
    $piecesPourRdv='';
    $synthesePaiements='';
    $syntheseEtudiant='';
    $errorbox='<script>document.getElementById("errorzoneAAC").style.display="block";</script>';
    $errorbox.='<p>'. $erreur . '</p>';
    require_once('gabarit/gab_agentacc.php');
}

function afficherErreurADM($erreur){
    $gestionConclusion='';
    $todayPlanning='';
    $somedayPlanning='';
    $syntheseEtudiant2='';
    $errorbox='';
    $errorbox.='<script>document.getElementById("errorzoneADM").style.display="block";</script><p>';
    $errorbox.='<p>'. $erreur . '</p>';
    require_once('gabarit/gab_agentadmin.php');
}