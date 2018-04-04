
<?php ob_start(); ?>


<?php
while ($article = $articles->fetch())
{
$title = 'Blog Ecrivain - '.$article['titre'];


if(strlen($article['url_photo']) < 3)
{
$urlPhotoProfil = "https://leskits.com/assets/img/pas_image.jpg";
}
else
{
$urlPhotoProfil = $article['url_photo'];
}

$imageOG = $urlPhotoProfil;
?>


<!-- Modal / Demo -->
<DIV class="modal fade" id="reponseCommentaire" role="dialog">
    <DIV class="modal-dialog" role="document">
        <DIV class="modal-content">
            <DIV class="modal-header">
                <BUTTON type="button" class="close" data-dismiss="modal" aria-label="Close"><I class="ti-close"></I></BUTTON>
                <H4 class="modal-title" id="myModalLabel"><?php echo $language[$langueAffichage]['Reponse_a_un_commentaire']; ?> </H4>
            </DIV>
            <DIV class="modal-body">


    <DIV class="alert alert-success" id="successReponseCommentaire" style="display:none;" role="alert"><?php echo $language[$langueAffichage]['La_reponse_a_bien_ajoute']; ?></DIV>

<DIV class="alert alert-danger" id="errorReponseCommentaire"  style="display:none;" role="alert" ></DIV>


<center><img src="https://leskits.com/assets/img/loader.svg" id="loaderReponseCommentaire" style="display:none;"></center>


       <form action="https://leskits.com/ajaxRequest/ajoutReponseCommentaireKit.php" method="post" id="form-ajoutReponseCommentaire" class="validate-form">
                         <input type="hidden" name="idCommentaire" id="idCommentaire">

                                <div class="form-group">
                                    <textarea id="commentReponseKit" name="commentReponseKit" cols="30" rows="4" class="form-control" required></textarea>
                                </div>
                               
                            </form>

                     


            </DIV>
            <DIV class="modal-footer">
                <BUTTON type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $language[$langueAffichage]['Fermer']; ?></BUTTON>
                <BUTTON type="button"  onclick="submitReponseCommentaireKit();"  class="btn btn-primary"><?php echo $language[$langueAffichage]['Repondre']; ?></BUTTON>

            </DIV>
        </DIV>
    </DIV>
</DIV>

<!-- Modal / Demo -->
<DIV class="modal fade" id="signalerLeCommentaire" role="dialog">
    <DIV class="modal-dialog" role="document">
        <DIV class="modal-content">
            <DIV class="modal-header">
                <BUTTON type="button" class="close" data-dismiss="modal" aria-label="Close"><I class="ti-close"></I></BUTTON>
                <H4 class="modal-title" id="myModalLabel"><?php echo $language[$langueAffichage]['Signaler_ce_commentaire']; ?> </H4>
            </DIV>
            <DIV class="modal-body">
                      <input type="hidden" id="typeCommentaire">
                      <input type="hidden" id="idCommentaireSignalement"> 

  <DIV class="alert alert-success" id="successSignalement" style="display:none;" role="alert"><?php echo $language[$langueAffichage]['Le_commentaire_a_ete_signale']; ?></DIV>
<center><img src="https://leskits.com/assets/img/loader.svg" id="loaderSignalement" style="display:none;"></center>


                        <DIV class="alert alert-danger" id="commentaireVerifiee" role="alert" ><?php echo $language[$langueAffichage]['Le_commentaire_sera_verifie_par_notre_equipe']; ?></DIV>


            </DIV>
            <DIV class="modal-footer">
                <BUTTON type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $language[$langueAffichage]['Fermer']; ?></BUTTON>
                <BUTTON type="button" onclick="submitSignalement()"   class="btn btn-primary"><?php echo $language[$langueAffichage]['Signaler']; ?></BUTTON>

            </DIV>
        </DIV>
    </DIV>
</DIV>


<!-- Modal / Demo -->
<DIV class="modal fade" id="supprimerCommentaire" role="dialog">
    <DIV class="modal-dialog" role="document">
        <DIV class="modal-content">
            <DIV class="modal-header">
                <BUTTON type="button" class="close" data-dismiss="modal" aria-label="Close"><I class="ti-close"></I></BUTTON>
                <H4 class="modal-title" id="myModalLabel"><?php echo $language[$langueAffichage]['Supprimer_ce_commentaire']; ?> </H4>
            </DIV>
            <DIV class="modal-body">
                      <input type="hidden" id="typeCommentaireSupprimer">
                      <input type="hidden" id="idCommentaireSupprimer"> 

  <DIV class="alert alert-success" id="successCommentaire" style="display:none;" role="alert"><?php echo $language[$langueAffichage]['Le_commentaire_a_bien_ete_supprime']; ?></DIV>
<center><img src="https://leskits.com/assets/img/loader.svg" id="loaderSupprimerCommentaire" style="display:none;"></center>


                        <DIV class="alert alert-danger" id="commentaireSuprime" role="alert" ><?php echo $language[$langueAffichage]['Le_commentaire_sera_definitivement_supprime']; ?></DIV>


            </DIV>
            <DIV class="modal-footer">
                <BUTTON type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $language[$langueAffichage]['Fermer']; ?></BUTTON>
                <BUTTON type="button" onclick="submitSupprimerCommentaire('article')"   class="btn btn-primary"><?php echo $language[$langueAffichage]['Supprimer']; ?></BUTTON>

            </DIV>
        </DIV>
    </DIV>
</DIV>







    <!-- Section / Blog -->
    <section id="blog" class="section">

        <div class="container-fluid container-custom clearfix">
            <!-- Main -->
            <div class="main left">
                <!-- Post / Single -->
                <article class="post single">
              
                    <span class="date text-muted"><?php echo date('d/m/Y', $article['date_creation']); ?></span>
                    <h1 class="post-title"><?php echo $article['titre']; ?></h1>
                    <ul class="post-meta">
                        <li><i class="li-usb1"></i><a href="https://leskits.com/le-blog/?categ=<?php echo $article['categorie_id']; ?>"><?php echo $article['categorie']; ?></a></li>
                      
                    </ul>
                    <div class="post-image"><img src="<?php echo $urlPhotoProfil; ?>" alt="<?php echo $article['title_alt_photo']; ?>"></div>
                    <div class="post-content">
                      
                    <?php echo $article['contenu_html']; ?>

                    </div>
                <div class="post-comments post-module" style="margin-top: 50px;">

                    </div>
                    <div class="post-add-comment post-module" style="width:100%;">
                        <h4><?php echo $language[$langueAffichage]['Ajouter_un_commentaire']; ?></h4>
                        <div class="content">

    <DIV class="alert alert-success" id="successAjoutCommentaire" style="display:none;" role="alert"><?php echo $language[$langueAffichage]['Le_commentaire_a_bien_ete_ajoute']; ?></DIV>

<DIV class="alert alert-danger" id="errorAjoutCommentaire"  style="display:none;" role="alert" ></DIV>


<center><img src="https://leskits.com/assets/img/loader.svg" id="loaderAjoutCommentaire" style="display:none;"></center>


                            <form action="https://leskits.com/ajaxRequest/ajoutCommentaireKit.php" method="post" id="form-ajoutCommentaire" class="validate-form">
                         <input type="hidden" value="<?php echo $article['id']; ?>" id="idKit" name="idKit">
                         <input type="hidden" value="article" id="type" name="type">
                                <div class="form-group">
                                    <textarea id="commentKit" name="commentKit" cols="30" rows="4" class="form-control" required></textarea>
                                </div>
                                <button class="btn btn-submit" type="button" onclick="submitCommentaireKit(<?php $kit['id']; ?>);return false;"><?php echo $language[$langueAffichage]['Envoyer']; ?></button>
                            </form>
                        </div>
                    </div>
                </article>
            </div>
            <!-- Sidebar -->
            <div class="sidebar right">
                <!-- Widget - Recent posts -->
                <div class="widget widget-recent-posts">
                    <h6 class="text-muted"><?php echo $language[$langueAffichage]['Publicite']; ?></h6>
                    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- BlogLesKits -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-8560714656763639"
     data-ad-slot="3306506618"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
                </div>
                <!-- Widget - Twitter -->
  
            </div>
        </div>
        
    </section>
<CENTER style="margin-top: 5px;"><div class="addthis_inline_share_toolbox"></div></CENTER>
<?php
}
?>
<input type="hidden" id="supprimerCommentaireInput">
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>


