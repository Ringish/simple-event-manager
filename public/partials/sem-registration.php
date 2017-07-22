<form>
<?php
$fields = get_post_meta(get_the_id(), 'sem_custom_field', true );
foreach ($fields as $field) {
	?>
	<label class="sem-label"><span class="sem-custom-label"><?php echo $field; ?></span>
	<input class="sem-input" type="text" name="<?php echo $field; ?>"></label>
	<?php
}
?>
<input type="submit" name="sem-register" class="sem-register sem-btn" value="<?php _e( "Register", 'sem' ); ?>">
</form>