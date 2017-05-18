<?php
/**
 * @link              https://github.com/mathewcallaghan/wp-widget-bootstrap-jumbotron
 * @since             1.0.0
 * @package           Bootstrap_Jumbotron_Widget
 *
 * @wordpress-plugin
 * Plugin Name:       Bootstrap Jumbotron Widget
 * Plugin URI:        https://github.com/mathewcallaghan/wp-widget-bootstrap-jumbotron
 * Description:       Add a Bootstrap Jumbotron to widget areas (requires Bootstrap 4).
 * Version:           1.0.0
 * Author:            Mathew Callaghan
 * Author URI:        https://mathew.callaghan.xyz/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       bootstrap-jumbotron-widget
 * Domain Path:       /languages
 */


if ( ! defined( 'WPINC' ) ) {
	die;
}

class WP_Widget_Bootstrap_Jumbotron extends WP_Widget {

	public function __construct() {
		$widget_ops = array(
			'classname' => 'wp_widget_bootstrap_jumbotron',
			'description' => __( 'Add a Bootstrap Jumbotron to widget areas.' ),
			'customize_selective_refresh' => true,
		);
		$control_ops = array( 'width' => 400, 'height' => 350 );
		parent::__construct( 'bootstrap_jumbotron', __( 'Bootstrap Jumbotron' ), $widget_ops, $control_ops );
	}

	public function widget( $args, $instance ) {

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$widget_text = ! empty( $instance['bootstrap-jumbotron-text'] ) ? $instance['bootstrap-jumbotron-text'] : '';
		$jumbotron_img = ! empty( $instance['jumbotron-img'] ) ? $instance['jumbotron-img'] : '';		
		$jumbotron_link = ! empty( $instance['jumbotron-link'] ) ? $instance['jumbotron-link'] : '';
		$jumbotron_link_title = ! empty( $instance['jumbotron-link-title'] ) ? $instance['jumbotron-link-title'] : '';

		$text = apply_filters( 'widget_text', $widget_text, $instance, $this );
		$img = apply_filters( 'jumbotron_img', $jumbotron_img, $instance, $this ); 	
		$link = apply_filters( 'jumbotron_link', $jumbotron_link, $instance, $this );
		$link_title = apply_filters( 'jumbotron_link_title', $jumbotron_link_title, $instance, $this );
		
		echo $args['before_widget'];?>

		<div class="jumbotron" <?php if ( ! empty( $jumbotron_img ) ) { ?> style='background:url("<?php echo !empty( $instance['filter'] ) ? wpautop( $img ) : $img; ?>") no-repeat center center;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover' <?php } ?>>
				
		<?php if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		} ?>
			<p><?php echo !empty( $instance['filter'] ) ? wpautop( $text ) : $text; ?></p>
		
		<?php if ( ! empty( $link_title ) ) { ?>	
			<a class="btn btn-primary btn-lg" role="button" href="<?php echo !empty( $instance['filter'] ) ? wpautop( $link ) : $link; ?>">
				<?php echo !empty( $instance['filter'] ) ? wpautop( $link_title ) : $link_title; ?>
			</a>
		<?php } ?>
		
		</div>
		<?php
		echo $args['after_widget'];
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		if ( current_user_can( 'unfiltered_html' ) ) {
			$instance['bootstrap-jumbotron-text'] = $new_instance['bootstrap-jumbotron-text'];
			$instance['jumbotron-img'] = $new_instance['jumbotron-img'];
			$instance['jumbotron-link'] = $new_instance['jumbotron-link'];
			$instance['jumbotron-link-title'] = $new_instance['jumbotron-link-title'];
		} else {
			$instance['bootstrap-jumbotron-text'] = wp_kses_post( $new_instance['bootstrap-jumbotron-text'] );
			$instance['jumbotron-img'] = wp_kses_post( $new_instance['jumbotron-img'] );
			$instance['jumbotron-link'] = wp_kses_post( $new_instance['jumbotron-link'] );
			$instance['jumbotron-link-title'] = wp_kses_post( $new_instance['jumbotron-link-title'] );
		}
		$instance['filter'] = ! empty( $new_instance['filter'] );
		return $instance;
	}

	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'bootstrap-jumbotron-text' => '' ) );
		$instance = wp_parse_args( (array) $instance, array( 'jumbotron_img' => '', 'jumbotron-img' => '' ) );
		$instance = wp_parse_args( (array) $instance, array( 'jumbotron_link' => '', 'jumbotron-link' => '' ) );
		$instance = wp_parse_args( (array) $instance, array( 'jumbotron_link_title' => '', 'jumbotron-link-title' => '' ) );
		$filter = isset( $instance['filter'] ) ? $instance['filter'] : 0;
		$title = sanitize_text_field( $instance['title'] );

		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'bootstrap-jumbotron-text' ); ?>"><?php _e( 'Content:' ); ?></label>
		<textarea class="widefat" rows="11" cols="20" id="<?php echo $this->get_field_id('bootstrap-jumbotron-text'); ?>" name="<?php echo $this->get_field_name('bootstrap-jumbotron-text'); ?>"><?php echo esc_textarea( $instance['bootstrap-jumbotron-text'] ); ?></textarea></p>
		
		<p><label for="<?php echo $this->get_field_id('jumbotron-link-title'); ?>"><?php _e('Button Name:'); ?></label>
		<textarea class="widefat" rows="2" cols="20" id="<?php echo $this->get_field_id('jumbotron-link-title'); ?>" name="<?php echo $this->get_field_name('jumbotron-link-title'); ?>"><?php echo esc_textarea( $instance['jumbotron-link-title'] ); ?></textarea>
		
		<p><label for="<?php echo $this->get_field_id('jumbotron-link'); ?>"><?php _e('Button URL:'); ?></label>
		<textarea class="widefat" rows="2" cols="20" id="<?php echo $this->get_field_id('jumbotron-link'); ?>" name="<?php echo $this->get_field_name('jumbotron-link'); ?>"><?php echo esc_textarea( $instance['jumbotron-link'] ); ?></textarea>
		
		<p><label for="<?php echo $this->get_field_id('jumbotron-img'); ?>"><?php _e('Background Image URL:'); ?></label>
		<textarea class="widefat" rows="2" cols="20" id="<?php echo $this->get_field_id('jumbotron-img'); ?>" name="<?php echo $this->get_field_name('jumbotron-img'); ?>"><?php echo esc_textarea( $instance['jumbotron-img'] ); ?></textarea>

		<p><input id="<?php echo $this->get_field_id('filter'); ?>" name="<?php echo $this->get_field_name('filter'); ?>" type="checkbox"<?php checked( $filter ); ?> />&nbsp;<label for="<?php echo $this->get_field_id('filter'); ?>"><?php _e('Automatically add paragraphs'); ?></label></p>
		<?php
	}
}


// Register Widget
function register_wp_widget_bootstrap_jumbotron() {
    register_widget( 'WP_Widget_Bootstrap_Jumbotron' );
}

add_action( 'widgets_init', 'register_wp_widget_bootstrap_jumbotron' );

// Register widget area.
function wp_widget_bootstrap_jumbotron_area() {

	register_sidebar( array(
		'name'          => 'Bootstrap Jumbotron',
		'id'            => 'bootstrap_jumbotron_01',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '<h2>',
		'after_title'   => '</h2>',
	) );

}

add_action( 'widgets_init', 'wp_widget_bootstrap_jumbotron_area' );

//Hook bootstrap jumbotron
if ( ! function_exists( 'bootstrap_jumbotron_widget_region' ) ) {
	function bootstrap_jumbotron_widget_region() {
		if ( is_active_sidebar( 'bootstrap_jumbotron_01' ) ) {

	dynamic_sidebar( 'bootstrap_jumbotron_01' );

		}
	}
}

add_action( 'bootstrap_jumbotron', 'bootstrap_jumbotron_widget_region', 10 );
