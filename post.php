<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>> 
  <header class="entry-header">
    <?php if(!is_singular()) : ?>
      <h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php _e('Permalink to:', 'framework');?> <?php the_title(); ?>"><?php the_title(); ?></a></h1>
    <?php else :?>
      <h1 class="entry-title"><?php the_title(); ?></h1>
    <?php endif; ?>
  </header><!-- .entry-header-->
  <div class="entry-content">
    <?php the_content(''); ?>
    <?php wp_link_pages(); ?>
  </div><!-- .entry-content-->
  <?php get_template_part('post', 'meta'); ?>
</article><!-- #post-<?php the_ID(); ?> -->
