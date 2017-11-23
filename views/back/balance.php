<?php ob_start() ; ?>
<?php include __DIR__ . '/../partials/nav.php'; ?>
<?php if( hasFlashMessage() ): ?> <p><?php echo getFlashMessage(); ?></p> <?php endif ; ?>



<?php $content = ob_get_clean() ; ?>

<?php include __DIR__ . '/../layouts/master.php' ?>