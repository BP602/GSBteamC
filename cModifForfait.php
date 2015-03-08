<?php
/** 
 * Script de contrôle et d'affichage du cas d'utilisation "Saisir fiche de frais"
 * @package default
 * @todo  RAS
 */
date_default_timezone_set('UTC');
  $repInclude = './include/';
  require($repInclude . "_init.inc.php");

  // page inaccessible si visiteur non connecté
  if (!estVisiteurConnecte()) {
      header("Location: cSeConnecter.php");  
  }
  require($repInclude . "_entete.inc.html");
  require($repInclude . "_sommaire.inc.php");
  // affectation du mois courant pour la saisie des fiches de frais
  $mois = sprintf("%04d%02d", date("Y"), date("m"));
  // vérification de l'existence de la fiche de frais pour ce mois courant
  $existeFicheFrais = existeFicheFrais($idConnexion, $mois, obtenirIdUserConnecte());
  // si elle n'existe pas, on la crée avec les élets frais forfaitisés à 0
  if ( !$existeFicheFrais ) {
      ajouterFicheFrais($idConnexion, $mois, obtenirIdUserConnecte());
  }
  // acquisition des données entrées
  // acquisition de l'étape du traitement 
  $etape=lireDonnee("etape","demanderSaisie");
  // acquisition des quantités des éléments forfaitisés 
  $tabQteEltsForfait=lireDonneePost("txtEltsForfait", "");
  // acquisition des données d'une nouvelle ligne hors forfait
  $idLigneHF = lireDonnee("idLigneHF", "");
  $dateHF = lireDonnee("txtDateHF", "");
  $libelleHF = lireDonnee("txtLibelleHF", "");
  $montantHF = lireDonnee("txtMontantHF", "");
 
  // structure de décision sur les différentes étapes du cas d'utilisation
  if ($etape == "validerSaisie") { 
      // l'utilisateur valide les éléments forfaitisés         
      // vérification des quantités des éléments forfaitisés
      $ok = verifierEntiersPositifs($tabQteEltsForfait);      
      if (!$ok) {
          ajouterErreur($tabErreurs, "Chaque quantité doit être renseignée et numérique positive.");
      }
      else { // mise à jour des quantités des éléments forfaitisés
          modifierEltsForfait($idConnexion, $mois, obtenirIdUserConnecte(),$tabQteEltsForfait);
      }
  }                                                       
  elseif ($etape == "validerSuppressionLigneHF") {
      supprimerLigneHF($idConnexion, $idLigneHF);
  }
  elseif ($etape == "validerAjoutLigneHF") {
      verifierLigneFraisHF($dateHF, $libelleHF, $montantHF, $tabErreurs);
      if ( nbErreurs($tabErreurs) == 0 ) {
          // la nouvelle ligne ligne doit être ajoutée dans la base de données
          ajouterLigneHF($idConnexion, $mois, obtenirIdUserConnecte(), $dateHF, $libelleHF, $montantHF);
      }
  }
  else { // on ne fait rien, étape non prévue 
  
  }                                  
?>
  <!-- Division principale -->
  <div id="contenu">
      <h2>Modifier les montant des forfaits</h2>
<?php
  if ($etape == "validerSaisie" || $etape == "validerAjoutLigneHF" || $etape == "validerSuppressionLigneHF") {
      if (nbErreurs($tabErreurs) > 0) {
          echo toStringErreurs($tabErreurs);
      } 
      else {
?>
      <p class="info">Les modifications de la fiche de frais ont bien été enregistrées</p>        
<?php
      }   
  }
      ?>            
      <form action="" method="post">
      <div class="corpsForm">
          <input type="hidden" name="etape" value="validerSaisie" />
          <fieldset>
            <legend>Forfaits
            </legend>
            <p>
              <label for="txtDateHF">* Date : </label>
              <input type="text" id="txtDateHF" name="txtDateHF" size="12" maxlength="10" 
                     title="Entrez la date d'engagement des frais au format JJ/MM/AAAA" 
                     value="<?php echo $dateHF; ?>" />
            </p>
            <p>
              <label for="txtLibelleHF">* Libellé : </label>
              <input type="text" id="txtLibelleHF" name="txtLibelleHF" size="70" maxlength="100" 
                    title="Entrez un bref descriptif des frais" 
                    value="<?php echo filtrerChainePourNavig($libelleHF); ?>" />
            </p>
            <p>
              <label for="txtMontantHF">* Montant : </label>
              <input type="text" id="txtMontantHF" name="txtMontantHF" size="12" maxlength="10" 
                     title="Entrez le montant des frais (le point est le séparateur décimal)" value="<?php echo $montantHF; ?>" />
            </p>
          </fieldset>
      </div>
      <div class="piedForm">
      <p>
        <input id="ok" type="submit" value="Valider" size="20" 
               title="Enregistrer les nouvelles valeurs des éléments forfaitisés" />
        <input id="annuler" type="reset" value="Effacer" size="20" />
      </p> 
      </div>
        
      </form>
  	
      <form action="" method="post">
      <div class="corpsForm">
          <input type="hidden" name="etape" value="validerAjoutLigneHF" />
          <fieldset>
            <legend>Nouvel élément hors forfait
            </legend>
            <p>
              <label for="txtDateHF">* Date : </label>
              <input type="text" id="txtDateHF" name="txtDateHF" size="12" maxlength="10" 
                     title="Entrez la date d'engagement des frais au format JJ/MM/AAAA" 
                     value="<?php echo $dateHF; ?>" />
            </p>
            <p>
              <label for="txtLibelleHF">* Libellé : </label>
              <input type="text" id="txtLibelleHF" name="txtLibelleHF" size="70" maxlength="100" 
                    title="Entrez un bref descriptif des frais" 
                    value="<?php echo filtrerChainePourNavig($libelleHF); ?>" />
            </p>
            <p>
              <label for="txtMontantHF">* Montant : </label>
              <input type="text" id="txtMontantHF" name="txtMontantHF" size="12" maxlength="10" 
                     title="Entrez le montant des frais (le point est le séparateur décimal)" value="<?php echo $montantHF; ?>" />
            </p>
          </fieldset>
      </div>
      <div class="piedForm">
      <p>
        <input id="ajouter" type="submit" value="Ajouter" size="20" 
               title="Ajouter la nouvelle ligne hors forfait" />
        <input id="effacer" type="reset" value="Effacer" size="20" />
      </p> 
      </div>
        
      </form>
  </div>
<?php        
  require($repInclude . "_pied.inc.html");
  require($repInclude . "_fin.inc.php");
?> 