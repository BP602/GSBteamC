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
  $libelleHF_cp = lireDonneePost("txtLibelleHF_CP","");
  $libelleHF_ville = lireDonneePost("txtLibelleHF_Ville","");
  $modifNom = lireDonneePost("modifNom","");
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
              <legend>Modification des informations utilisateurs
              </legend>
              <p>
                  <?php 
                    $sql = " SELECT id, nom FROM visiteur"; 
                    $resultNom = mysql_query($sql) or die("Requête impossible"); 
                    
                    ?> <label>* Visiteur : </label>
                    <select name='nom'> 
                    <?php while ($row=mysql_fetch_array($resultNom)){ ?>
                        <option value="<?php echo $row[0]?>"><?php echo $row[1] ?></option>
                    <?php } ?>
                    </select>
              </p>
              <p>
                <label for="txtLibelleHF">* Nom : </label>
                <input type="text" id="modifNom" name="modifNom" size="20" maxlength="100" placeholder="Nom"/>
              </p>
              <p>
                <label for="txtLibelleHF">* Adresse : </label>
                <input type="text" id="txtLibelleHF" name="txtLibelleHF" size="20" maxlength="100" placeholder="Adresse"/>
                <input type="text" id="txtLibelleHF_CP" name="txtLibelleHF_CP" size="20" maxlength="100" placeholder ="Code postal"/>
                <input type="text" id="txtLibelleHF_Ville" name="txtLibelleHF_Ville" size="20" maxlength="100" placeholder="Ville"/>
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
            if($libelleHF_cp == "" || $libelleHF_ville=="" || $libelleHF=="" || $modifNom== ""){
                echo "Toutes les zones de textes ne sont pas remplies";
            }
            else{
                $nomChoisi= lireDonneePost("nom","");
                $sql="UPDATE visiteur SET adresse = '".$libelleHF."', cp = '".$libelleHF_cp."', ville = '".$libelleHF_ville."', nom = '".$modifNom."' WHERE nom = '".$nomChoisi."'" ;
                mysql_query($sql) or die(mysql_error()); 
                echo "Informations utilisateur modifié";
            }
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
                echo "Mot de passe utilisateur modifié";
        }
    }  
    ?>
      
  </div>
<?php        
  require($repInclude . "_pied.inc.html");
  require($repInclude . "_fin.inc.php");
?> 