<?php $title = 'Blog Ecrivain - Le blog'; ?>

<?php ob_start(); ?>



<!-- Page Title -->
    <div class="page-title pb-0">
        <div class="container-fluid container-custom">
            <h1>Le blog</h1>
            <p class="lead text-muted">Blog de l'écrivain</p>
        </div>
    </div>

    <section id="blog" class="section">

        <div class="container-fluid container-custom">
                        
             <nav class="mb-40">
                      

                <ul class="nav nav-pills mb-50 text-center" data-filter-list="#works-list">
                     
                     <li class="nav-item  <?php if($categorie == "noCateg")  { echo 'active'; } ?>"><a href="/" class="nav-link" ><i class="pe-7s-folder"></i>Tous</a></li>
                

                <?php foreach($categTotal as $categorieReq):?>

                      <li class="nav-item"><a href="?categ=<?php echo $categorieReq->getId();?>" class="nav-link <?php if($categorie == $categorieReq->getId()) { echo 'active';  } ?>"><i class="pe-7s-graph1"></i><?php echo $categorieReq->getName();?></a></li>

                <?php endforeach; ?>

                </ul>         

            </nav>



            <div class="main left">
                
                <div class="row masonry">  
                   
                    <div class="masonry-sizer col-sm-6 col-xs-12"></div>
                               

                    <?php  foreach($articlesTotal as $article):?>

                        <div class="masonry-item col-sm-6 col-xs-12">
                                            <!-- Post - Item -->
                            <article class="post item">
                                 
                                <div class="post-image">
                                     <img src="<?php echo $article->getUrlImage();?>" alt="<?php echo $article->getTitreAltPhoto();?>">
                                </div>
                                                
                                <div class="post-content">
                                     <span class="date text-muted"><?php echo $article->getDate();?></span>
                                    
                                     <h4><?php echo $article->getTitre();?></h4>
                                    
                                    <p> <?php echo $article->getDescriptionCourte();?> </p>
         
                                     <a href="articleIndividuel?idArticle=<?php echo $article->getId();?>" class="btn btn-primary btn-sm">Lire l'article</a>
                                
                                </div>
                                
                             <ul class="post-meta">
                                <li><i class="li-usb1"></i><a href="?categ=<?php echo $article->getCategorieID();?>"><?php echo $article->getCategorieName();?></a></li>
                        
                            </ul>

                            
                            </article>

                        </div>
                                
                    <?php endforeach;?>

                </div>
                               
                                <!-- Pagination -->

                <center>
                <UL class="pagination">

                <?php
                if($categorie != "noCateg")
                {
                $urlAajouter = "&categ=".$_GET['categ'];
                }
                else
                {
                $urlAajouter = "";

                }
                if($numeroPage != 1)
                {
                $pageMoinsUn = $numeroPage-1;
                ?>

                    <LI class="page-item">
                        <A class="page-link" href="?numeroPage=<?php echo $pageMoinsUn.$urlAajouter; ?>" aria-label="Previous">
                            <I class="ti-angle-left"></I>
                            <SPAN class="sr-only">Précédent</SPAN>
                        </A>
                    </LI>
                <?php
                }
                for ($i = 1 ; $i <= $nombreDePages ; $i++)
                {
                  ?>


                    <LI class="page-item <?php if($numeroPage == $i) { echo 'active';  } ?>"><A class="page-link" href="?numeroPage=<?php echo $i.$urlAajouter; ?>"><?php echo $i; ?></A></LI>


                <?php
                }
                ?>
                <?php if($numeroPage != $nombreDePages)
                {
                $pagePlusUn = $numeroPage+1;
                ?>
                    <LI class="page-item">
                        <A class="page-link" href="?numeroPage=<?php echo $pagePlusUn.$urlAajouter; ?>" aria-label="Next">
                            <I class="ti-angle-right"></I>
                            <SPAN class="sr-only">Suivant</SPAN>
                        </A>
                    </LI>

                <?php
                } ?>
                </UL></center>



                </div>
                            <!-- Sidebar -->
                <div class="sidebar right">
                                <!-- Widget - Recent posts -->
                    <div class="widget widget-recent-posts">
                        
                        <h6 class="text-muted">Ads</h6>
           
                    </div>
                           
                </div>
        
        </div>
                
    </section>






<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>


