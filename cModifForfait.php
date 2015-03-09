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
  
if (estVisiteurConnecte() ) {
          $idUser = obtenirIdUserConnecte() ;
          
          }
if(obtenirTypeVisiteur($idUser)!=1){
                header("Location: cAccueil.php");
          }
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
      <h2>Modifier les montants des forfaits</h2>
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
          <input type="hidden" name="etape" value="" />
          <fieldset>
            <legend>Montants actuels des forfaits
            </legend>
            <p>
                <?php
                $requete = "SELECT libelle, montant FROM fraisforfait";
                $reponse = mysql_query($requete); 
                $nombrechamps = mysql_num_fields($reponse);
                for ($j=0;$j<$nombrechamps;$j++)
                {
                    $nomchamp[] = mysql_field_name($reponse,$j);
                }
                echo "<table border ='1' style='width:28%; line-height: 1.8'>";
                echo "<tr>";
                for ($i=0;$i<$nombrechamps;$i++)
                {
                    echo ('<td>');
                    echo ('<center>'.$nomchamp[$i].'</center>');
                    echo ('</td>');

                }
                echo "</tr>";
                while ($result = mysql_fetch_row($reponse))
                {
                    echo ('<tr>');
                    for ($i=0;$i<$nombrechamps;$i++)
                    {
                        echo ('<td>');
                        echo ('<center>'.$result[$i].'</center>');
                        echo ('</td>');
                    }
                    echo ('</tr>');
                }
                echo "</table>";
                ?>

            </p>
          </fieldset>
      </div>        
      </form>
      <form action="cModifForfait.php" method="post">
      <div class="corpsForm">
          <input type="hidden" name="etape" value="validerAjoutLigneHF" />
          <fieldset>
            <legend>Modification du montant du forfait
            </legend>
            <p>
                <?php 
                    $sql = " SELECT libelle FROM fraisforfait"; 
                    $result = mysql_query($sql) or die("Requête impossible"); 

                    echo "<label>* Forfait : </label>
                    <select name='bla'>"; 
                    while ($row=mysql_fetch_array($result)){ 
                        echo"<option>$row[0]</option>"; 
                    } 
                    echo"</select></form>"; ?> 
            </p>
            <p>
              <label for="txtLibelleHF">* Montant : </label>
              <input type="text" id="montant"  size="20" name="montant" maxlength="100"/>
              <center><table>
                <input id="ajouter" type="submit" name="submit"  value="Valider" size="20"/>
                <input id="effacer" type="reset" name="annuler" value="Annuler" size="20" />
              </table></center>
                <?php 
                
                if(isset($_POST["submit"])){
                $libelle=lireDonneePost("bla", "");
                $sql2 = " UPDATE fraisforfait SET montant=".$_POST['montant']." WHERE libelle='".$libelle."'"; 
                $result2 = mysql_query($sql2) or die(mysql_error()); 
                header("Refresh:0");
                } ?>
              
            </p>
          </fieldset>
      </div>
      </form>
  </div>
<?php        
  require($repInclude . "_pied.inc.html");
  require($repInclude . "_fin.inc.php");
?> 