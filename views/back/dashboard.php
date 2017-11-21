<?php ob_start() ; ?>
<?php include __DIR__ . '/../partials/nav.php'; ?>
<section class="sheep_main dashboard">
    <section class="sheep_graph grid-1"> 
 
 		<?php include  __DIR__ . '/../partials/graphic.php'; ?>
    
    </section>

    <section class="sheep_spending grid-1"> 
        <?php if( $lastDepenses != false ) : ?>
       	<ul>
        	<?php foreach ($lastDepenses as $data) : ?>
            	<li>Nom(s) <?php echo $data['names']; ?>, Prix : <?php echo $data['price']; ?>, date : <?php echo $data['pay_date']; ?></li>
            <?php endforeach; ?>
        </ul>
       <?php else : ?>
       	<p>Pas de dépenses pour l'instant </p>
       <?php endif; ?>
	
	<ul>
		<a href="/history">
			Toutes les dépONSES
		</a>
	</ul>

    </section>

</section>
<?php $content = ob_get_clean() ; ?>

<?php include __DIR__ . '/../layouts/master.php' ?>