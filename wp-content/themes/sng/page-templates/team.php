<?php
/**
 * Template Name:  Team
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?>
<div class="mainContent staffs">
		<div class="mainbg" style="background-image:url(<?php echo (has_post_thumbnail())  ? the_post_thumbnail_url('full') : get_stylesheet_directory_uri().'assets/images/pro_bg.jpg'; ?>);"></div>

		<div class="contentMain">
			<div class="contentAreaImage">
               
                <?php
                $obj = get_field_object('staff_image');
                $grpArray = array_chunk($obj['value'], 2);                    
                if( !empty($obj) ):
                ?>
			    <div class="staffContainer">
                    <?php 
                        foreach($grpArray as $key => $val): 
                        if($key == 0){                            
                    ?>
			        <div class="row">
			            <div class="col-md-4">
			                <ul>
                               <?php foreach($val as $key => $value): ?>
                                <li>
			                        <div class="figure">
			                            <img src="<?php echo $value['image']['url']; ?>" alt="">
			                        </div>
			                        <div class="staffName">
			                            <?php echo $value['staff_name']; ?>
			                        </div>
			                    </li>	
			                    <?php endforeach; ?>
			                </ul>
			            </div>
			        </div>
                    <div class="row">  
			        <?php }elseif($key > 0){ ?>
			            <div class="col-md-4">
			                <ul>
                            <?php foreach($val as $key => $value): ?>        
			                    <li>
			                       <div class="figure">
			                            <img src="<?php echo $value['image']['url']; ?>" alt="">
			                        </div>
			                        <div class="staffName">
			                            <?php echo $value['staff_name']; ?>
			                        </div>
			                    </li>
                            <?php endforeach; ?>
			                </ul>
			            </div>	
			            <?php } endforeach; ?>      
			        </div>
                </div>
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
			</div>
		</div>

	</div>