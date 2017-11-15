<?php ob_start() ; ?>
<section class="main dashboard">
    <section class="graph grid-2"> 
        <div>un div ou n'importe quoi d'autre</div>
        <div>un div ou n'importe quoi d'autre</div>
    </section>

    <section class="spending grid-1"> 
        <div>un div ou n'importe quoi d'autre</div>
    </section>

</section>
<?php $content = ob_get_clean() ; ?>

<?php include __DIR__ . '/../layouts/master.php' ?>