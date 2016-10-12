<?php get_template_part('templates/page', 'header'); ?>

<div class="mainContent">
        <?php
            $queried_object = get_queried_object(); 
            $taxonomy = $queried_object->taxonomy;
            $term_id = $queried_object->term_id;  
            $image = get_field('banner_image', $queried_object);
        ?>
		<div class="mainbg" style="background-image:url(<?php echo (!empty($image['url']))  ? $image['url'] : get_stylesheet_directory_uri().'assets/images/pro_bg.jpg'; ?>);"></div>
		
<?php if (!have_posts()) : ?>
  <div class="alert alert-warning">
    <?php _e('Sorry, no results were found.', 'sage'); ?>
  </div>
  <?php get_search_form(); ?>
<?php endif; ?>

<div class="contentMain newsListContainer">
			<div class="contentAreaImage">
                    <ul class="newsList">
                        <?php while (have_posts()) : the_post(); ?>
                          <li class="newsListScroll">
			                    <div class="scrollWrap">
                                  <?php get_template_part('templates/content', get_post_type() != 'post' ? get_post_type() : get_post_format()); ?>
            	                </div>
                          </li>
                        <?php endwhile; ?>
                    </ul>
			</div>
			<div class="contentAreaText">

				<div class="pagetitle">
					<h3><?php echo $queried_object -> name; ?></h3>
				</div>
				
				<div id="bx-pager">
					<ul>
                        <?php
                        $i = 0;
                        while (have_posts()) : the_post();                         
                        ?>
                          <li>
                             <a href="" data-slide-index="<?php echo $i; ?>"><?php the_title(); ?></a>
                          </li>
                        <?php $i++; endwhile; ?>
					</ul>
				</div>

			</div>

</div>
<!--mainContent-->