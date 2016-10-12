<article <?php post_class(); ?>>
    <h2 class="entry-title"><?php the_title(); ?></h2>
    <?php //get_template_part('templates/entry-meta'); ?>
  <div class="entry-summary">
    <?php the_content(); ?>
  </div>
</article>