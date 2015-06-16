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
  $adresse = lireDonneePost("txtLibelleHF","");
  $cp = lireDonneePost("txtLibelleHF_CP","");
  $ville = lireDonneePost("txtLibelleHF_Ville","");
  $nomUser = lireDonneePost("nomUser","");
  $prenomUser = lireDonneePost("prenomUser","");
  $idUser = lireDonneePost("idUser","");
  $dateEmbauche = lireDonneePost("dateEmbauche","");
  $login = lireDonneePost("login","");
  $mdp = lireDonneePost("mdp","");
  foreach($_POST['niveau'] as $chkbx){
        $Niveau = $chkbx;						
    }
  // structure de décision sur les différentes étapes du cas d'utilisation
  if ($etape != "demanderConsult" && $etape != "validerConsult"&& $etape != "validerConsult2") {
      $etape = "demanderConsult";        
  }                             
?>
  <!-- Division principale -->
  <div id="contenu">
      <h2>Création utilisateur</h2>
<?php
    // Montre ou cache la page en fonction du type de l'utilisateur.

          ?>            
      <form action="" method="post">
      <div class="corpsForm">
          <input type="hidden" name="etape" value="validerConsult" />
            <fieldset>
              <legend>Création utilisateur
              </legend>
                <p>
                <label for="txtLibelleHF">* id : </label>
                <input type="text" id="idUser" name="idUser" size="20" maxlength="100" placeholder="ID"/>
              </p>
              <p>
                <label for="txtLibelleHF">* Nom : </label>
                <input type="text" id="nomUser" name="nomUser" size="20" maxlength="100" placeholder="Nom"/>
              </p>
              <p>
                <label for="txtLibelleHF">* Prenom : </label>
                <input type="text" id="prenomUser" name="prenomUser" size="20" maxlength="100" placeholder="Prenom"/>
              </p>
              <p>
                <label for="txtLibelleHF">* Adresse : </label>
                <input type="text" id="txtLibelleHF" name="txtLibelleHF" size="20" maxlength="100" placeholder="Adresse"/>
                <input type="text" id="txtLibelleHF_CP" name="txtLibelleHF_CP" size="20" maxlength="100" placeholder ="Code postal"/>
                <input type="text" id="txtLibelleHF_Ville" name="txtLibelleHF_Ville" size="20" maxlength="100" placeholder="Ville"/>
              </p>
              
              <p>
                <label for="txtLibelleHF">* Login : </label>
                <input type="text" id="login" name="login" size="20" maxlength="100" placeholder="Login"/>
              </p>
              <p>
                <label for="txtLibelleHF">* Mot de passe : </label>
                <input type="password" id="mdp" name="mdp" size="20" maxlength="100" placeholder="Mot de passe"/>
              </p>
              <p>
                <label for="txtLibelleHF">* Date d'embauche : </label>
                <input type="date" id="dateEmbauche" name="dateEmbauche" size="20" maxlength="100" placeholder="00/00/0000"/>
              </p>
              <INPUT type="checkbox" name="niveau[]" value="1"> Comptable
              <INPUT type="checkbox" name="niveau[]" value="0" checked> Visiteur
              
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
            if($idUser == "" || $nomUser=="" || $prenomUser=="" || $login== "" ||$mdp=="" || $adresse=="" || $cp== "" ||$ville=="" || $dateEmbauche==""){
                $message= "Toutes les zones de textes ne sont pas remplies";
            }
            else{
                $ok = true;
                $req = "SELECT `id` FROM visiteur";
                $idJeuVis = mysql_query($req, $idConnexion);
                $lgVis = mysql_fetch_assoc($idJeuVis);
                
                while ( is_array($lgVis) ) {
                    $idVis = $lgVis["id"];
                    if($idVis == $idUser){
                        $ok = false;
                    }
                    $lgVis = mysql_fetch_assoc($idJeuVis);
                }
                
                mysql_free_result($idJeuVis);
                if($ok == false){
                    $message=  "L'ID est déjà utilisé, veuillez en utiliser un autre";
                }
                else{
                    
                    $sql="INSERT INTO visiteur(id, nom, prenom, login, mdp, adresse, cp, ville, dateEmbauche, Niveau)
                        VALUES('".$idUser."', '".$nomUser."', '".$prenomUser."', '".$login."', '".$mdp."', '".$adresse."', '".$cp."', '".$ville."', '".$dateEmbauche."', '.$Niveau.')";
                    mysql_query($sql) or die(mysql_error()); 
                    $message= "Utilisateur crée";
                }
            }
        }
        echo $message;
    }       
    ?>
      
  </div>
<?php        
  require($repInclude . "_pied.inc.html");
  require($repInclude . "_fin.inc.php");
?> 