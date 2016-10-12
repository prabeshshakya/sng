<div class="loaderDummy"></div>
  <header>
   <h1 class="sng-logo">
    <a href="<?php echo home_url(); ?>">
<?php
  if ( get_theme_mod( 'snglogosection' ) ) :
    echo '<img src="' . esc_url( get_theme_mod( 'snglogosection' ) ) . '">';
  else:
    echo get_bloginfo('name') . '<span>' . get_bloginfo('description') . '</span>';
  endif;
?>
    </a>
</h1>

<div class="socialBlock">
    <?php if ( is_active_sidebar( 'sns-html' ) ) : ?>
        <ul>
            <?php echo dynamic_sidebar( 'sns-html' ); ?>
        </ul>    
    <?php endif; ?>
</div>


</header>
<div class="menuWrap">
  <div class="menuMain">
    <?php
    if (has_nav_menu('primary_navigation')) :
      wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => '']);
    endif;
    ?>
  </div>
</div>
