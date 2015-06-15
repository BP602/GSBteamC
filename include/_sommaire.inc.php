<?php
/** 
 * Contient la division pour le sommaire, sujet à des variations suivant la 
 * connexion ou non d'un utilisateur, et dans l'avenir, suivant le type de cet utilisateur 
 * @todo  RAS
 */

?>
    <!-- Division pour le sommaire -->
    <div id="menuGauche">
     <div id="infosUtil">
    <?php      
      if (estVisiteurConnecte() ) {
          $idUser = obtenirIdUserConnecte() ;
          $lgUser = obtenirDetailVisiteur($idConnexion, $idUser);
          $typeUser = obtenirTypeUtilisateur();
          $nom = $lgUser['nom'];
          $prenom = $lgUser['prenom'];
    ?>
        <h2><?php echo $nom . " " . $prenom ; ?></h2>
        <h3><?php if ($typeUser != 1) {echo "Visiteur Médical";}else{echo "Comptable";}?></h3>        
    <?php
       }
    ?>  
      </div>  
<?php      
  if (estVisiteurConnecte() ) {
?>
        <ul id="menuList">
           <li class="smenu">
              <a href="cAccueil.php" title="Page d'accueil">Accueil</a>
           </li>
           <li class="smenu">
              <a href="cSeDeconnecter.php" title="Se déconnecter">Se déconnecter</a>
           </li>
           <li class="smenu">
              <a href="cSaisieFicheFrais.php" title="Saisie fiche de frais du mois courant">Saisie fiche de frais</a>
           </li>
           <?php
           //si l'utilisateur est un comptable
           if($typeUser == 1){ ?>
           <li class="smenu">
              <a href="cModifForfait.php" title="Modification des forfaits">Modification des forfaits</a>
           </li>
           <li class="smenu">
              <a href="cModifUser.php" title="Modification des Utilisateurs">Modification des Utilisateurs</a>
           </li>
           <li class="smenu">
              <a href="cCreateUser.php" title="Création utilisateurs">Création utilisateurs</a>
           </li>
           <li class="smenu">
              <a href="cConsultFichesFrais.php" title="Validation de fiches de frais">Valider fiches de frais</a>
           </li>
           <?php } else {?>
            <li class="smenu">
              <a href="cConsultFichesFrais.php" title="Consultation de mes fiches de frais">Mes fiches de frais</a>
            </li>
           <?php }?>
         </ul>
        <?php
          // affichage des éventuelles erreurs déjà détectées
          if ( nbErreurs($tabErreurs) > 0 ) {
              echo toStringErreurs($tabErreurs) ;
          }
  }
        ?>
    </div>
    