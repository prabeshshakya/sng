<?php
/**
 * Sage includes
 *
 * The $sage_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 *
 * @link https://github.com/roots/sage/pull/1042
 */
$sage_includes = [
  'lib/assets.php',    // Scripts and stylesheets
  'lib/extras.php',    // Custom functions
  'lib/setup.php',     // Theme setup
  'lib/titles.php',    // Page titles
  'lib/wrapper.php',   // Theme wrapper class
  'lib/customizer.php' // Theme customizer
];

foreach ($sage_includes as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error(sprintf(__('Error locating %s for inclusion', 'sage'), $file), E_USER_ERROR);
  }

  require_once $filepath;
}
unset($file, $filepath);


/**
*Custom Function
*/
function logoAreaCustomizer( $wp_customize ) {

    $wp_customize->add_section( 'snglogosection' , array(
      'title'       => __( 'Logo', 'sng' ),
      'priority'    => 30,
      'description' => 'Upload a logo for this theme',
  ) );

  $wp_customize->add_setting( 'snglogosection' );
  $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'snglogosection', array(

    'label'    => __( 'Current logo', 'sng' ),
    'section'  => 'snglogosection',
    'settings' => 'snglogosection',
  ) ) );

}
add_action('customize_register', 'logoAreaCustomizer');

// Creating the widget 
class wpb_widget extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
'wpb_widget', 

// Widget name will appear in UI
__('SNS', 'wpb_widget_domain'), 

// Widget description
array( 'description' => __( 'Custom HTML for SNS', 'wpb_widget_domain' ), ) 
);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['HTML'] );
$title =  $instance['HTML'];
// before and after widget arguments are defined by themes
//echo $args['before_widget'];
if ( ! empty( $title ) )
echo $title;

// This is where you run the code and display the output
//echo __( 'Hello, World!', 'wpb_widget_domain' );
//echo $args['after_widget'];
}
		
// Widget Backend 
public function form( $instance ) {
if ( isset( $instance[ 'HTML' ] ) ) {
$title = $instance[ 'HTML' ];
$stitle =  $instance[ 'snsTitle' ];
}
else {
//$title = __( 'SNS Title', 'wpb_widget_domain' );
//$stitle =  __( 'SNS HTML', 'wpb_widget_domain' );
    $title = " ";
    $stitle = " ";
}
// Widget admin form
?>
<p>
<?php /*
<label for="<?php echo $this->get_field_id( 'snsTitle' ); ?>"><?php _e( 'SNS Title:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'snsTitle' ); ?>" name="<?php echo $this->get_field_name( 'snsTitle' ); ?>" type="text" value="<?php echo esc_attr( $stitle ); ?>" />
</p>
*/
    ?>
<p>
<label for="<?php echo $this->get_field_id( 'HTML' ); ?>"><?php _e( 'Html:' ); ?></label>
<textarea class="widefat" name="<?php echo $this->get_field_name( 'HTML' ); ?>" id="<?php echo $this->get_field_id( 'HTML' ); ?>"><?php echo  $title ; ?></textarea>
</p>
<?php
}
	
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['HTML'] = ( ! empty( $new_instance['HTML'] ) ) ?  $new_instance['HTML']  : '';
$instance['snsTitle'] = ( ! empty( $new_instance['snsTitle'] ) ) ? strip_tags( $new_instance['snsTitle'] ) : '';
return $instance;
}
} // Class wpb_widget ends here

// Register and load the widget
function wpb_load_widget() {
	register_widget( 'wpb_widget' );
}
add_action( 'widgets_init', 'wpb_load_widget' );

// Register Widgets
function sns_sidebar() {
 
    $args = array(
        'id'            => 'sns-html',
        'name'          => __( 'SNS', 'text_domain' ),
        'description'   => __( 'Custom HTML for SNS.', 'text_domain' ),
    );
    register_sidebar( $args );
 
}
add_action( 'widgets_init', 'sns_sidebar' );