<?php $title = 'Blog Ecrivain - Le blog'; ?>

<?php ob_start(); ?>

<style type="text/css">
    table
    {
        text-align: center;
    }
    table thead
    {
        margin-bottom: 15px;
    }
</style>




<!-- Page Title -->
    <div class="page-title pb-0">
        <div class="container-fluid container-custom">
            <h1> <?php if($articlesTotal) { echo 'Modifier un article';  } else { echo 'Créer un article'; } ?> 
            </h1>
           
        </div>
    </div>

    <section id="blog" class="section">

        <div class="container-fluid container-custom">
            <p>
          <strong>Tableau catégories </strong>
        <table>
            <thead>
                <tr>
                    <td>Catégorie</td>
                    <td>Numéro à écrire</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Découverte</td>
                    <td>1</td>
                </tr>
                <tr>
                    <td>Technologie</td>
                    <td>2</td>
                </tr>
                <tr>
                    <td>Voyages</td>
                    <td>3</td>
                </tr>                
            </tbody>         
        </table></p>




        <?php if($articlesTotal) { ?>
             <?php foreach($articlesTotal as $article):?>

                <form action="/reqAddArticle" method="post" id="form-article" class="validate-form">
                
                    <input type="hidden" id="idArticle" name="idArticle" value="<?php echo $article->getId(); ?>">

                    <input type="text"  id="titre" name="titre" class="form-control" placeholder="Titre de l'article" value="<?php echo $article->getTitre(); ?>" required>

                    <input type="number"  id="categorie_id" name="categorie_id" class="form-control" value="<?php echo $article->getCategorieID(); ?>" placeholder="Catégorie (voir tableau)" required>

                    <input type="text"  id="description_courte" name="description_courte" class="form-control" value="<?php echo $article->getDescriptionCourte(); ?>" placeholder="Description courte " required>

                    <input type="text"  id="texte_remplacement_img" name="texte_remplacement_img" value="<?php echo $article->getTitreAltPhoto(); ?>" class="form-control" placeholder="Description de l'image" required>

                    <input type="text"  id="url_image" name="url_image" class="form-control" value="<?php echo $article->getUrlImage(); ?>" placeholder="Url de l'image" required>

                   <div class="form-group">
                   <textarea id="contenu_html" name="contenu_html" cols="30" rows="4" class="form-control" required><?php echo $article->getContenuArticle(); ?></textarea>
                   </div>

                    <button class="btn btn-submit" type="button" onclick="submitFormAddArticle();return false;">Envoyer</button>
                    
                </form>
              <?php endforeach;?> 
         <?php } else { ?>

                <form action="/reqAddArticle" method="post" id="form-article" class="validate-form">
                

                    <input type="text"  id="titre" name="titre" class="form-control" placeholder="Titre de l'article" required>

                    <input type="text"  id="categorie_id" name="categorie_id" class="form-control" placeholder="Catégorie (voir tableau)" required>

                    <input type="text"  id="description_courte" name="description_courte" class="form-control" placeholder="Description courte " required>

                    <input type="text"  id="texte_remplacement_img" name="texte_remplacement_img" class="form-control" placeholder="Description de l'image" required>

                    <input type="text"  id="url_image" name="url_image" class="form-control" placeholder="Url de l'image" required>

                   <div class="form-group">
                   <textarea id="contenu_html" name="contenu_html" cols="30" rows="4" class="form-control" required></textarea>
                   </div>

                    <button class="btn btn-submit" type="button" onclick="submitFormAddArticle();return false;">Envoyer</button>
                    
                </form>

        <?php
        } ?>

        

        </div>
                
    </section>






<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>


