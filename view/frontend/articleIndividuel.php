
<?php ob_start(); 
foreach($articlesTotal as $article):?>


    <!-- Section / Blog -->
    <section id="blog" class="section">

        <div class="container-fluid container-custom clearfix">
            <!-- Main -->
            <div class="main left">
                <!-- Post / Single -->
                <article class="post single">
              
                    <span class="date text-muted"><?php echo $article->getDate();?></span>
                    <h1 class="post-title"><?php echo $article->getTitre();?></h1>
                    <ul class="post-meta">
                        <li><i class="li-usb1"></i><a href="/?categ=<?php echo $article->getCategorieID();?>"><?php echo $article->getCategorieName();?></a></li>
                      
                    </ul>
                    <div class="post-image"><img src="<?php echo $article->getUrlImage();?>" alt="<?php echo $article->getTitreAltPhoto();?>"></div>
                    <div class="post-content">
                      
                     Contenu

              
                    </div>
                    <div class="post-comments post-module" style="margin-top: 50px;">
                        <div class="content">
                             <ul class="comments">
                                 

                               <?php foreach($commentairesTotal as $commentaire):?>
                                  
                                    
                                    <li>
                                        <div class="avatar"> <img src="https://www.limestone.edu/sites/default/files/user.png" alt=""></div>
                                        <div class="content">
                                           <span class="details">
                                                <?php echo $commentaire->getPseudo(); ?> le <?php echo $commentaire->getTemps(); ?> •

                                                 <a href="#" data-toggle="modal" onclick="signalerCommentaire('commentaire', <?php echo $commentaire->getId(); ?>)" data-target="#signalerLeCommentaire" class="text-primary">Signaler le commentaire</a> 

                                           </span>  
                                          
                                         <p>  <?php echo $commentaire->getCommentaire(); ?></p>
               
                                       </div>

                                    </li>


                               <?php endforeach;?> 

                             </ul>

                        </div>


                    </div>
          
                    <div class="post-add-comment post-module" style="width:100%;">
                        <h4>Ajouter un commentaire</h4>
                        <div class="content">

                            <DIV class="alert alert-success" id="successAjoutCommentaire" style="display:none;" role="alert">Le commentaire a bien été ajouté.</DIV>

                            <DIV class="alert alert-danger" id="errorAjoutCommentaire"  style="display:none;" role="alert" ></DIV>

                            <center><img src="https://leskits.com/assets/img/loader.svg" id="loaderAjoutCommentaire" style="display:none;"></center>


                            <form action="https://leskits.com/ajaxRequest/ajoutCommentaireKit.php" method="post" id="form-ajoutCommentaire" class="validate-form">
                                 <input type="hidden" value="3" id="idKit" name="idKit">
                                 <input type="hidden" value="article" id="type" name="type">

                                <div class="form-group">
                                    <textarea id="commentKit" name="commentKit" cols="30" rows="4" class="form-control" required></textarea>
                                </div>

                                <button class="btn btn-submit" type="button" onclick="submitCommentaireKit();return false;">Envoyer</button>
                            </form>
                        </div>
                    </div>



                </article>
            </div>
            <!-- Sidebar -->
            <div class="sidebar right">
                <!-- Widget - Recent posts -->
                <div class="widget widget-recent-posts">
                    <h6 class="text-muted">Ads</h6>

                </div>
                <!-- Widget - Twitter -->
  
            </div>
        </div>
        
    </section>

 <?php endforeach;?>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>


