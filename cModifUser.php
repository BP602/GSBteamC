<?php
/** 
 * Script de contrôle et d'affichage du cas d'utilisation "Saisir fiche de frais"
 * @package default
 * @todo  RAS
 */
  $repInclude = './include/';
  require($repInclude . "_init.inc.php");

  // page inaccessible si visiteur non connecté
  if ( ! estVisiteurConnecte() ) {
      header("Location: cSeConnecter.php");  
  }
  require($repInclude . "_entete.inc.html");
  require($repInclude . "_sommaire.inc.php");
  

  // acquisition des données entrées
  // acquisition de l'étape du traitement 
  $etape=lireDonneePost("etape","");
  // acquisition des quantités des éléments forfaitisés 
  // acquisition des données d'une nouvelle ligne hors forfait
  $libelleHF = lireDonneePost("txtLibelleHF","");
  $mdpHF = lireDonneePost("leMdpHF","");
  // structure de décision sur les différentes étapes du cas d'utilisation
  if ($etape != "demanderConsult" && $etape != "validerConsult"&& $etape != "validerConsult2") {
      $etape = "demanderConsult";        
  }                             
?>
  <!-- Division principale -->
  <div id="contenu">
      <h2>Modifier les données utilisateurs</h2>
<?php
    // Montre ou cache la page en fonction du type de l'utilisateur.

          ?>            
      <form action="" method="post">
      <div class="corpsForm">
          <input type="hidden" name="etape" value="validerConsult" />
            <fieldset>
              <legend>Modification de l'adresse utilisateur
              </legend>
              <p>
                  <?php 
                      $sql = " SELECT nom FROM visiteur"; 
                      $resultNom = mysql_query($sql) or die("Requête impossible"); 

                      ?> <label>* Visiteur : </label>
                      <select name='nom'> 
                      <?php while ($row=mysql_fetch_array($resultNom)){ ?>
                          <option><?php echo $row[0] ?></option>
                      <?php } ?>
                      </select>
              </p>
              <p>
                <label for="txtLibelleHF">* Adresse : </label>
                <input type="text" id="txtLibelleHF" name="txtLibelleHF" size="20" maxlength="100" />
              </p>
            </fieldset>
        </div>
      <div class="piedForm">
      <p>
        <input id="ok" type="submit" value="Valider" size="20" name ="valider"/>
        <input id="annuler" type="reset" value="Effacer" size="20" />
      </p> 
      </div>
        
      </form>

    <?php  
    if ( $etape == "validerConsult" ) {
        if ( nbErreurs($tabErreurs) > 0 ) {
            echo toStringErreurs($tabErreurs) ;
        }
        else {
                $nomChoisi= lireDonneePost("nom","");
                $sql="UPDATE visiteur SET adresse = '".$libelleHF."' WHERE nom = '".$nomChoisi."'";
                mysql_query($sql) or die(mysql_error()); 
        }
    }       
    ?>
      
      
      
      <form action="" method="post">
      <div class="corpsForm">
          <input type="hidden" name="etape" value="validerConsult2" />
            <fieldset>
                <legend>Modification du mot de passe
              </legend>
              <p>
                  <?php 
                      $sql = " SELECT nom FROM visiteur"; 
                      $resultNom = mysql_query($sql) or die("Requête impossible"); 

                      ?> <label>* Visiteur : </label>
                      <select name='nom2'> 
                      <?php while ($row=mysql_fetch_array($resultNom)){ ?>
                          <option><?php echo $row[0] ?></option>
                      <?php } ?>
                      </select>
              </p>
              <p>
                <label for="leMdpHF">* Mot de passe : </label>
                <input type="text" id="leMdpHF" name="leMdpHF" size="20" maxlength="100" />
              </p>
            </fieldset>
        </div>
      <div class="piedForm">
      <p>
        <input id="ok" type="submit" value="Valider" size="20" name ="valider2"/>
        <input id="annuler" type="reset" value="Effacer" size="20" />
      </p> 
      </div>
        
      </form>

    <?php  
    if ( $etape == "validerConsult2" ) {
        if ( nbErreurs($tabErreurs) > 0 ) {
            echo toStringErreurs($tabErreurs) ;
        }
        else {
                $nomChoisi= lireDonneePost("nom2","");
                $sql="UPDATE visiteur SET mdp = '".$mdpHF."' WHERE nom = '".$nomChoisi."'";
                mysql_query($sql) or die(mysql_error()); 
        }
    }  
    ?>
      
  </div>
<?php        
  require($repInclude . "_pied.inc.html");
  require($repInclude . "_fin.inc.php");
?> 