<?php get_header(); ?>
<?php gs_theme_main_nav(); ?>
<?php if ( have_posts() ) : ?>

  <?php /* Start the Loop */ ?>
  <?php while ( have_posts() ) : the_post(); ?>

    <?php get_template_part( 'post', get_post_format() ); ?>

  <?php endwhile; ?>

<?php else : ?>

  <article id="post-0" class="post no-results not-found">
    <header class="entry-header">
      <h1 class="entry-title"><?php _e( 'Nothing Found', 'framework' ); ?></h1>
    </header><!-- .entry-header -->
  </article><!-- #post-0 -->

<?php endif; ?>

<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if (  $wp_query->max_num_pages > 1 ) : ?>
				<?php next_posts_link( __( '&larr; Older posts', 'framework' ) ); ?>
				<?php previous_posts_link( __( 'Newer posts &rarr;', 'framework' ) ); ?>
<?php endif; ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
