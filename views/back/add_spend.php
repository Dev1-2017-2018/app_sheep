<?php ob_start() ; ?>
<?php include __DIR__ . '/../partials/nav.php'; ?>
<script>
  $( function() {
    jQuery('#datetimepicker').datetimepicker();
  } );
</script>
<?php if( hasFlashMessage() ): ?> <p><?php echo getFlashMessage(); ?></p> <?php endif ; ?>
<form action="/spend_added" method="post" class="w100 center">
	<p style="display: inline-block;">Title: <input type="text" name="title"></p>
	<p style="display: inline-block;">Price: <input type="number" name="price" min="0"></p>
	<p style="display: inline-block;">Date: <input type="text" id="datetimepicker" name="date"></p>
	<div class="txtright">
	<?php foreach ($users as $user): ?>
		<p style="margin-top: 2%">
			<?php echo $user['name']; ?>
			<input style="margin-right: 2%" type="checkbox" name="check_list[]" value="<?php echo $user['user_id']; ?>"/>
			<input type="number" min="0" name="user_<?php echo $user['user_id']?>"/>
		</p>
	<?php endforeach; ?>
	</div>
	<div class="w100 txtcenter">
		<input type="submit" name="button" class="w20" value="add spend">
	</div>
	
</form>
<?php $content = ob_get_clean() ; ?>

<?php include __DIR__ . '/../layouts/master.php' ?>