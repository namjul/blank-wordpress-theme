<footer class="entry-meta">

  <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) .' '. __('ago', 'framework'); ?>

  <?php edit_post_link( __( '[Edit]', 'framework' ), '<span class="edit-link">', '</span>' ); ?>

  <?php if(is_single()) : ?>
    <?php next_post_link(__('%link', 'framework'), '%title') ?>
    <?php previous_post_link(__('%link', 'framework'), '%title') ?>
  <?php endif; ?>
 
</footer><!-- #entry-meta -->



