<?php $title = 'LesKits - '.$language[$langueAffichage]['Erreur']; ?>

<?php ob_start(); ?>
<section>
<center>
<h1> <?php echo $language[$langueAffichage]['Erreur']; ?> <?php echo $erreur; ?> </h1>

<p class="lead"><?php echo $text; ?></p>

<img src="https://leskits.com/assets/img/emoji-panda-2.png" style="max-width: 300px;">
</center></section>
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>