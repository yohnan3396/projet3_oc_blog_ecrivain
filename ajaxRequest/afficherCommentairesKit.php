<?php if(isset($_POST['idKit']) AND is_numeric($_POST['idKit']) AND isset($_POST['type']) AND ($_POST['type'] == "kit" OR $_POST['type'] == "article" OR $_POST['type'] == "objet"))
{
require('../language/traduction.php');

$idKit = $_POST['idKit'];
?>

   <h4><?php echo $language[$langueAffichage]['Commentaires']; ?></h4>
                        <div class="content">
                            <ul class="comments">
<?php

require('connexionBDD.php');

if(isset($_SESSION['id']))
{
  $presenceSession = 1;

$membreCo = $db->prepare("SELECT * FROM user_temp WHERE email = ? ");
$membreCo->execute(array($_SESSION['id']));
while ($donneesMembreCo = $membreCo->fetch())
{
$idMembreCo = $donneesMembreCo['id'];
}
$membreCo->closeCursor(); 
}
else
{
  $presenceSession = 0;
}

$commentaires = $db->query("SELECT * FROM commentaire_kit WHERE id_kit='$idKit' AND type='$_POST[type]' ");
while ($commentaire = $commentaires->fetch())
{ 
$membreCommentaire = $db->prepare("SELECT * FROM user_temp WHERE id = ? ");
$membreCommentaire->execute(array($commentaire['id_membre']));
while ($donneesMembreCommentaire = $membreCommentaire->fetch())
{

if(strlen($donneesMembreCommentaire['picture']) < 3)
{
$urlAvatar = "https://leskits.com/assets/img/pas_image.jpg";
}
else
{
$urlAvatar = $donneesMembreCommentaire['picture'];
}

$nbReponse = $db->query("SELECT COUNT(*) FROM reponse_commentaire WHERE id_commentaire='$commentaire[id]' ")->fetchColumn(); 
$nbLike = $db->query("SELECT COUNT(*) FROM like_commentaire WHERE id_commentaire='$commentaire[id]' AND type='commentaire' ")->fetchColumn(); 
$nbLikeIdMembreCo = $db->query("SELECT COUNT(*) FROM like_commentaire WHERE id_commentaire='$commentaire[id]' AND type='commentaire' AND id_membre='$idMembreCo' ")->fetchColumn(); 
?>

    <li id="commentaire<?php echo $commentaire['id']; ?>">
  <div class="avatar"><a href="https://leskits.com/membre/<?php echo $donneesMembreCommentaire['id']; ?>"> <img src="<?php echo $urlAvatar; ?>" alt="<?php echo $donneesMembreCommentaire['login']; ?>"></a></div>
 <div class="content">
       <span class="details"><?php echo $donneesMembreCommentaire['login']; ?> le <?php echo date('d/m/Y - H:i:s', $commentaire['temps']); ?>, <?php if($presenceSession == 1) { ?> <a href="#" class="text-primary" data-toggle="modal" onclick="responseCommentaire(<?php echo $commentaire['id']; ?>)" data-target="#reponseCommentaire"><?php echo $language[$langueAffichage]['Repondre']; ?></a> - <?php } ?> <a href="#" data-toggle="modal" onclick="signalerCommentaire('commentaire', <?php echo $commentaire['id']; ?>)" data-target="#signalerLeCommentaire" class="text-primary"><?php echo $language[$langueAffichage]['Signaler']; ?></a> <?php if($idMembreCo == $commentaire['id_membre']) { ?> - <a href="#" class="text-primary" data-toggle="modal" onclick="supprimerCommentaire('commentaire', <?php echo $commentaire['id']; ?>, '<?php echo $_POST['type']; ?>')" data-target="#supprimerCommentaire"> <?php echo $language[$langueAffichage]['Supprimer']; ?> </a> <?php } ?></span>  
       <p><?php echo $commentaire['commentaire']; ?><?php if($presenceSession == 1) { ?><br><a href="javascript:void(0)" name="lienLike" onclick="likeCommentaire('commentaire', <?php echo $commentaire['id']; ?>)" class="text-primary">   <?php if($nbLikeIdMembreCo == 1) { echo $language[$langueAffichage]['Jaime_plus']; } else { echo $language[$langueAffichage]['Jaime']; } ?></a> - <i class="ti-thumb-up"></i> <span name="nbLike"><?php echo $nbLike; ?></span> <?php } ?></p>
       
         </div>
     


<?php if($nbReponse >= 1)
{

?>


        <ul>


<?php
$reponseCommentaire = $db->prepare("SELECT * FROM reponse_commentaire WHERE id_commentaire = ? ORDER by id ");
$reponseCommentaire->execute(array($commentaire['id']));
while ($donneesReponseCommentaire = $reponseCommentaire->fetch())
{


$membreCommentaireReponse = $db->prepare("SELECT * FROM user_temp WHERE id = ? ");
$membreCommentaireReponse->execute(array($commentaire['id_membre']));
while ($donneesMembreCommentaireReponse = $membreCommentaireReponse->fetch())
{

if(strlen($donneesMembreCommentaireReponse['picture']) < 3)
{
$urlAvatarReponse = "https://leskits.com/assets/img/pas_image.jpg";
}
else
{
$urlAvatarReponse = $donneesMembreCommentaireReponse['picture'];
}

$nbLikeReponse = $db->query("SELECT COUNT(*) FROM like_commentaire WHERE id_commentaire='$donneesReponseCommentaire[id]' AND type='reponse' ")->fetchColumn(); 
$nbLikeReponseIdMembreCo = $db->query("SELECT COUNT(*) FROM like_commentaire WHERE id_commentaire='$donneesReponseCommentaire[id]' AND type='reponse' AND id_membre='$idMembreCo' ")->fetchColumn(); 
?>




            <li id="reponse<?php echo $donneesReponseCommentaire['id']; ?>">
                <div class="avatar"><a href="https://leskits.com/membre/<?php echo $donneesReponseCommentaire['id']; ?>"> <img src="<?php echo $urlAvatarReponse; ?>" alt=""></a></div>
                             <div class="content">
                                <span class="details"><?php echo $donneesMembreCommentaireReponse['login']; ?> le <?php echo date('d/m/Y - H:i:s', $donneesReponseCommentaire['temps_reponse']); ?>, <a href="#" class="text-primary" onclick="signalerCommentaire('reponse', <?php echo $donneesReponseCommentaire['id']; ?>)" data-toggle="modal" data-target="#signalerLeCommentaire"><?php echo $language[$langueAffichage]['Signaler']; ?></a> <?php if($idMembreCo == $commentaire['id_membre']) { ?> - <a href="#" class="text-primary" data-toggle="modal" onclick="supprimerCommentaire('reponse', <?php echo $donneesReponseCommentaire['id']; ?>, '<?php echo $_POST['type']; ?>')" data-target="#supprimerCommentaire"> <?php echo $language[$langueAffichage]['Supprimer']; ?> </a> <?php } ?></span>
                                 <p><?php echo $donneesReponseCommentaire['commentaire_reponse']; ?><br><?php if($presenceSession == 1) { ?><a href="javascript:void(0)" name="lienLike"  onclick="likeCommentaire('reponse', <?php echo $donneesReponseCommentaire['id']; ?>)" class="text-primary"><?php if($nbLikeReponseIdMembreCo == 1) { echo $language[$langueAffichage]['Jaime_plus']; } else { echo $language[$langueAffichage]['Jaime']; } ?> </a> - <i class="ti-thumb-up"></i> <span name="nbLike"><?php echo $nbLikeReponse; ?></span> </p><?php } ?>
                                  
                         </div>
                   </li>
        


   

<?php
}
}
?>

     </ul>

<?php
} ?>




       </li>



<?php
}
}
?>


                  
                            
                            </ul>


                        </div>

<?php
} 
?>