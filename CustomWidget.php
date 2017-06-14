/**
* Here is no '<?php' because you should paste this code into functions.php or CustomPlugin
*/

// Register and load the widget
function custom_load_widget() {
	register_widget( 'custom_widget' );
}
add_action( 'widgets_init', 'custom_load_widget' );

// Creating the widget 
class custom_widget extends WP_Widget {

	function __construct() {
		parent::__construct(

			// Base ID of your widget
			'custom_widget', 

			// Widget name will appear in UI
			__('Custom Widget', 'custom_widget_domain'), 

			// Widget description
			array( 'description' => __( 'Custom Widget Description', 'custom_widget_domain' ), ) 
		);
	}

	// Creating widget front-end
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		$text = apply_filters( 'widget_text', $instance['text'] );

		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];
		if ( ! empty( $text ) )
			echo $text;
		echo $args['after_widget'];
	}
		
	// Widget Backend 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'New title', 'custom_widget_domain' );
		}
		if ( isset( $instance[ 'text' ] ) ) {
			$text = $instance[ 'text' ];
		}
		else {
			$text = __( 'Some text', 'custom_widget_domain' );
		}
		// Widget admin form
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e( 'text:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>" type="text" value="<?php echo esc_attr( $text ); ?>" />
		</p>
		<?php 
	}
	
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['text'] = ( ! empty( $new_instance['text'] ) ) ? strip_tags( $new_instance['text'] ) : '';
		return $instance;
	}
} // Class custom_widget ends here
