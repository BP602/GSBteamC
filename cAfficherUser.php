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

  // structure de décision sur les différentes étapes du cas d'utilisation                        
?>
  <!-- Division principale -->
  <div id="contenu">
      <h2>Afficher les utilisateurs</h2>
          
        <?php
            $sql = "SELECT id, nom, prenom, Niveau FROM visiteur";

            // on lance la requête (mysql_query) et on impose un message d'erreur si la requête ne se passe pas bien (or die)
            $req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());

            // on va scanner tous les tuples un par un
            while ($data = mysql_fetch_array($req)) {
                    // on affiche les résultats
                    $id = $data['id'];
                    $nom = $data['nom'];
                    $prenom = $data['prenom'];
                    $niveau = $data['Niveau'];
                    if($niveau == 1){
                        $role = "comptable";
                    }
                    else{
                        $role = "visiteur";
                    }
                    
                    ?>
                         <?php echo $id ?>
                         <?php echo $nom ?>
                         <?php echo $prenom ?>
                         <?php echo $role ?>
                    <?php
            }
            mysql_free_result ($req);
            mysql_close (); 
        ?>
      
      
      
  </div>
<?php        
  require($repInclude . "_pied.inc.html");
  require($repInclude . "_fin.inc.php");
?> 