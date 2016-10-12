<?php
/**
 * Template Name: Top Page
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?>
<div class="mainContent">
		<div class="mainbg" style="background-image:url(<?php echo (has_post_thumbnail())  ? the_post_thumbnail_url('full') : get_stylesheet_directory_uri().'assets/images/pro_bg.jpg'; ?>);"></div>

		<div class="contentMain">
			<div class="contentAreaImage">
			<?php if( have_rows('page_content') ): ?>
				<ul class="bxslider">
				<?php
					while ( have_rows('page_content') ) : the_row();
				?>
				<li>
					<?php
						while ( have_rows('image_repeater') ) : the_row();
						$image =get_sub_field('image');
					?>
					<div class="imageBlock">
						<figure>
							<img src="<?php echo $image['url']; ?>" alt="file">
						</figure>
					</div>
					<?php  endwhile; ?>
				</li>
				<?php  endwhile;  else : ?>
				</ul>
			<?php endif; ?>
			</div>
			<div class="contentAreaText">

				<div class="pagetitle">
					<h3><?php the_title(); ?></h3>
				</div>

				 <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<div class="welcomeText">
						<?php the_content(); ?>
					</div>
				<?php endwhile; endif; ?>
				<div id="bx-pager">
				<?php if( have_rows('page_content') ): ?>
					<ul>
					<?php
						$i = 0;
					   	while ( have_rows('page_content') ) : the_row();
					 ?>
						<li><a data-slide-index="<?php echo $i; ?>" href=""><?php the_sub_field('title'); ?></a></li>
					<?php  $i++; endwhile; 	 else : ?>
					</ul>
					<?php endif; ?>
				</div>
			</div>
		</div>

	</div>