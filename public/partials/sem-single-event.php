<?php get_header(); ?>
<?php
while (have_posts()) {
	the_post();
	$featured_img = get_the_post_thumbnail_url(get_the_id(),'full');
	if (!$featured_img) {
		$featured_img = plugin_dir_url( dirname( __FILE__ ) ).'partials/img/event-bg.png';
	}
	?>
	<article class="sem-article">
		<header class="sem-header" style="background-image:url('<?php echo $featured_img; ?>');">
			<div class="sem-container">
				<div class="sem-info">
					<h1 class="sem-title"><?php the_title(); ?></h1>
					<time class="sem-date"><?php echo get_post_meta(get_the_id(), 'sem_date', true ); ?></time>
				</div>
			</div>
		</header>
		<div class="sem-container">
			<div class="sem-content">
				<?php the_content(); ?>
			</div>
			<aside class="sem-registration">
				<?php
				include(plugin_dir_path( dirname( __FILE__ ) ).'partials/sem-registration.php');
				?>
			</aside>
		</div>
	</article>
	<?php
}
?>

<?php get_footer(); ?>