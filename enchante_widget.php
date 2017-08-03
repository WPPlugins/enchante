<?php
/**
 * Plugin Name: Enchanté Widget
 * Plugin URI: http://enchante.adhese.com 
 * Description: Enchanté advertising.
 * Version: 0.1
 * Author: Ben
 * Author URI: http://enchante.adhese.com 
 *
 */

/**
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'load_enchante_widget' );

/**
 * Register our widget.
 * 'Enchante_Widget' is the widget class used below.
 */
function load_enchante_widget() {
	register_widget( 'Enchante_Widget' );
}

/**
 * Enchanté Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 */
class Enchante_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function Enchante_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'enchante', 'description' => __('An Enchanté Widget', 'enchante') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'example-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'example-widget', __('Enchanté Widget', 'enchante'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$name = $instance['name'];
		$lang = $instance['lang'];

		/* Before widget (defined by themes). */
		echo $before_widget;
		
		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

		/* Display name from widget settings if one was input. */
		if ( $name ){                                                
			$random_number = rand(1,100);
			printf('<!-- start adhese tag: '. $name .' Home Top - Enchante Tag -->');
			printf('<script language="Javascript" src="http://ads.enchante.adhese.com/ad/_'. $name .'_blogbanner_/'. $lang .'/?t='$random_number.'"></script>');
			printf('<!-- end adhese tag: '. $name .' Home Top - Enchante Tag -->');
		}else{
			printf('Your Enchanté plugin in not configured right!.');
		}
		
		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['name'] = strip_tags( $new_instance['name'] );
		
		$instance['lang'] = $new_instance['lang']; 
      
		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'name' => __('yourdomain.com', 'enchante'),  'lang' => 'nl'); // !!!!! dit kunnen we default invullen een doorsturen
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<!--Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'hybrid'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

		<!-- Your site id: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'name' ); ?>"><?php _e('Your site id:', 'enchante'); ?></label>
			<input id="<?php echo $this->get_field_id( 'name' ); ?>" name="<?php echo $this->get_field_name( 'name' ); ?>" value="<?php echo $instance['name']; ?>" style="width:100%;" />
		</p>

		<!-- Language: Select Box -->
		<p>
			<label for="<?php echo $this->get_field_id( 'lang' ); ?>"><?php _e('language:', 'enchante'); ?></label> 
			<select id="<?php echo $this->get_field_id( 'lang' ); ?>" name="<?php echo $this->get_field_name( 'lang' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'nl' == $instance['format'] ) echo 'selected="selected"'; ?>>nl</option>
				<option <?php if ( 'fr' == $instance['format'] ) echo 'selected="selected"'; ?>>fr</option>
				<option <?php if ( 'en' == $instance['format'] ) echo 'selected="selected"'; ?>>en</option>
			</select>
		</p>
        
	<?php
	}
}
/*
	we zouden een div rond heel de widget kunnen zetten met een ID. als er geen ad geladen is zouden we vanuit de tag (js) die div kunnen verbergen.
	dit om bv een titel "reklame" te verbergen als er geen reklame is
*/ 
?>