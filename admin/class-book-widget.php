<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/SaurabhBagde
 * @since      1.0.0
 *
 * @package    Wp_Book
 * @subpackage Wp_Book/admin/book-widget
 */

/**
 * Widget class
 */
class Category_Widget extends WP_Widget {
	/**
	 * Setup the widget name, description, etc..
	 */
	public function __construct() {

		$widget_options = array(
			'classname' => 'category-widget',
			'description' => __( 'Custom widget to display selected category books', 'wp-book' ),
		);
		parent::__construct( 'wpb_category', __( 'Book Category', 'wp-book' ), $widget_options );

	}

	/**
	 * Widget form
	 *
	 * @param [type] $instance instance of widget.
	 * @return void
	 */
	public function form( $instance ) {
		$title    = '';
		$number   = '';
		$exclude  = '';
		$taxonomy = '';
		if ( ! empty( $instance['title'] ) ) {
			$title = esc_attr( $instance['title'] );
		}
		if ( ! empty( $instance['number'] ) ) {
			$number     = esc_attr( $instance['number'] );
		}
		if ( ! empty( $instance['exclude'] ) ) {
			$exclude    = esc_attr( $instance['exclude'] );
		}
		if ( ! empty( $instance['taxonomy'] ) ) {
			$taxonomy   = esc_attr( $instance['taxonomy'] );
		}

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of categories to display' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" />
		</p>
		<p>	
			<label for="<?php echo $this->get_field_id( 'taxonomy' ); ?>"><?php _e( 'Choose the Taxonomy to display' ); ?></label> 
			<select name="<?php echo $this->get_field_name( 'taxonomy' ); ?>" id="<?php echo $this->get_field_id( 'taxonomy' ); ?>" class="widefat"/>
				<?php
				$taxonomies = get_taxonomies( array( 'public' => true ), 'names' );
				foreach ( $taxonomies as $option ) {
					echo '<option id="' . $option . '"', $taxonomy == $option ? ' selected="selected"' : '', '>', $option, '</option>';
				}
				?>
			</select>		
		</p>
		<?php
	}


	/**
	 * WP_Widget::update
	 *
	 * @param [type] $new_instance new instance.
	 * @param [type] $old_instance old
	 * @return instance
	 */
	public function update( $new_instance, $old_instance ) {
		$instance             = $old_instance;
		$instance['title']    = strip_tags( $new_instance['title'] );
		$instance['number']   = strip_tags( $new_instance['number'] );
		$instance['taxonomy'] = $new_instance['taxonomy'];
		return $instance;
	}

	// Front-end display of widget.

	/**
	 * WP_Widget::widget
	 *
	 * @param [type] $args
	 * @param [type] $instance
	 * @return void
	 */
	public function widget( $args, $instance ) {
		extract( $args );
		$title      = apply_filters( 'widget_title', $instance['title'] ); // the widget title.
		$number     = $instance['number'];                                // the number of categories to show.
		$taxonomy   = $instance['taxonomy'];                             // the taxonomy to display.

		$args = array(
			'number'    => $number,
			'taxonomy'  => $taxonomy,
		);

		// Retrieves an array of categories or taxonomy terms.
		$cats = get_categories( $args );
		?>
		<?php echo $before_widget; ?>
		<?php
		if ( $title ) {
			echo $before_title . $title . $after_title; }
		?>
		<ul>
		<?php foreach ( $cats as $cat ) { ?>
		<li><a href="<?php echo get_term_link( $cat->slug, $taxonomy ); ?>" title="<?php sprintf( __( 'View all posts in %s' ), $cat->name ); ?>"><?php echo $cat->name; ?></a></li>
		<?php } ?>
		</ul>
		<?php echo $after_widget; ?>
		<?php
	}

}


