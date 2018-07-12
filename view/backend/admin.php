<?php $title = 'Blog Ecrivain - Le blog'; ?>

<?php ob_start(); ?>




<!-- Page Title -->
    <div class="page-title pb-0">
        <div class="container-fluid container-custom">
            <h1>Panneau d'administration
            </h1>
            <p class="lead text-muted">Articles & Commentaires</p>
        </div>
    </div>


    <section id="blog" class="section">

        <div class="container-fluid container-custom">

            <center><a href="/add-article" class="btn btn-primary btn-lg"> Créer un article</a></center>                   
            <h2> Articles </h2>
                

            <table style="width:100%;">


            <thead>
                <tr>
                    <td>Titre</td>
                    <td>Date</td>
                    <td>Action</td>
   
                </tr>
            </thead>

            <tbody>


                    <?php  foreach($articlesTotal as $article):?>
                         <tr id="trArticle<?php echo $article->getId(); ?>">
                        <td><?php echo $article->getTitre();?></td>
                        <td><?php echo $article->getDate();?></td>
                        <td><a href="#" onclick="deleteArticle(<?php echo $article->getId(); ?>)"> Supprimer </a> - <a href="/add-article?id_article=<?php echo $article->getId(); ?>"> Modifier</a></td>
                        <td></td>
                        </tr>
                    <?php endforeach;?>
            </tbody>
            </table>



            <h2  style="margin-top: 60px;"> Commentaires signalés </h2>
     

         <table style="width:100%;">

            <thead>
                <tr>
                    <td>Commentaire</td>
                    <td>Date</td>
                    <td>Id article</td>
                    <td>Pseudo</td>
                    <td>Action</td>
   
                </tr>
            </thead>

            <tbody>



                    <?php  foreach($signalerCommentaireTotal as $commentaireSignaler):?>

                         <tr id="trCommentaire<?php echo $commentaireSignaler->getId(); ?>">
                        <td><?php echo $commentaireSignaler->getCommentaire();?></td>
                        <td><?php echo $commentaireSignaler->getDate();?></td>
                        <td><?php echo $commentaireSignaler->getIdArticle();?></td>
                        <td><?php echo $commentaireSignaler->getPseudo();?></td>
                        <td><a href="javascript:void(0)" onclick="deleteCommentaire(<?php echo $commentaireSignaler->getIdCommentaire(); ?>, <?php echo $commentaireSignaler->getId(); ?>)"> Supprimer </a> - <a href="javascript:void(0)" onclick="annulerSignalement(<?php echo $commentaireSignaler->getId(); ?>)"> Signalement inutile </a> </td>
                        <td></td>
                        </tr>
                    <?php endforeach;?>
            </tbody>
            </table>

         



        

        </div>
                
    </section>






<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>


