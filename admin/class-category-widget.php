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
			'classname'   => 'category-widget',
			'description' => __( 'Custom widget to display selected category books', 'wp-book' ),
		);
		parent::__construct( 'custom_books_category', __( 'Book Category', 'wp-book' ), $widget_options );

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
		$taxonomy = '';
		if ( ! empty( $instance['title'] ) ) {
			$title = esc_attr( $instance['title'] );
		}

		if ( ! empty( $instance['taxonomy'] ) ) {
			$taxonomy = esc_attr( $instance['taxonomy'] );
		}

		?>
		<p>
			<label  for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'wp-book' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>	
			<label for="<?php echo $this->get_field_id( 'taxonomy' ); ?>"><?php _e( 'Choose the Taxonomy to display', 'wp-book' ); ?></label> <br/>
			<select class="widefat" name="<?php echo $this->get_field_name( 'taxonomy' ); ?>" id="<?php echo $this->get_field_id( 'taxonomy' ); ?>" />
				<?php
				$taxonomies = get_terms(
					array(
						'taxonomy'   => 'books-category',
						'hide_empty' => false,
					)
				);
				foreach ( $taxonomies as $option ) {
					if ( $option->taxonomy == 'books-category' ) {
						echo '<option  id="' . $option->name . '" value="'.$option->name.'"', $taxonomy == $option->name ? ' selected="selected"' : '', '>', $option->name, '</option>';
					}
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
	 * @param [type] $old_instance old.
	 * @return instance
	 */
	public function update( $new_instance, $old_instance ) {
		$instance             = $old_instance;
		$instance['title']    = wp_strip_all_tags( $new_instance['title'] );
		$instance['taxonomy'] = $new_instance['taxonomy'];
		return $instance;
	}

	// Front-end display of widget.

	/**
	 * WP_Widget::widget
	 *
	 * @param [type] $args widget argument.
	 * @param [type] $instance widget instance.
	 * @return void
	 */
	public function widget( $args, $instance ) {
		extract( $args );
		$title    = apply_filters( 'widget_title', $instance['title'] ); // the widget title.                               // the number of categories to show.
		$taxonomy = $instance['taxonomy'];                             // the taxonomy to display.

		$args = array(
			'post_type' => 'books',
			'tax_query' => array (
				array(
					'taxonomy' => 'books-category',
					'field'    => 'slug',
					'terms'    => $taxonomy
				)
			)
		);

		// Retrieves an array of categories or taxonomy terms.

		?>
		<?php echo $before_widget; ?>
		<?php
		if ( $title ) {
			echo $before_title . $title . $after_title; }
		?>
		<ul>
		<?php
			$the_query = new WP_Query($args);
			while($the_query->have_posts()){
				$the_query->the_post();
				echo '<li><a href="'.get_permalink( get_the_id() ).'">'.get_the_title().'</a></li>';
			}
		?>
		</ul>
		<?php echo $after_widget; ?>
		<?php
	}

}


