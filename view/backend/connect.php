<?php $title = 'Blog Ecrivain - Le blog'; ?>

<?php ob_start(); ?>




<!-- Page Title -->
    <div class="page-title pb-0">
        <div class="container-fluid container-custom">
            <h1>Panneau d'administration
            </h1>
            <p class="lead text-muted">Accéder au panneau admin</p>
        </div>
    </div>


    <section id="blog" class="section">

        <div class="container-fluid container-custom">

  
        <form action="/connexionPanneauAdmin" method="post" id="form-connexion" class="validate-form">
                

                    <input type="password"  id="mdp" name="mdp" class="form-control" placeholder="Mot de passe" required>


                    <button class="btn btn-submit" type="submit">Go</button>
                    
        </form>



        

        </div>
                
    </section>






<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>


