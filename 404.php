<?php
header("HTTP/1.1 404 Not Found");
header("Status: 404 Not Found");
?>
<?php get_header(); ?>

 <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<h1 class="entry-title"><?php _e('Error 404 - Not Found', 'framework') ?></h1>
	</header><!-- .entry-header -->

	<div class="entry-content">
	  <p><?php _e("Sorry, but you are looking for something that isn't here.", "framework") ?></p>
	</div><!-- .entry-content-->

</article><!-- #post-<?php the_ID(); ?> -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
