<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/SaurabhBagde
 * @since      1.0.0
 *
 * @package    Wp_Book
 * @subpackage Wp_Book/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Book
 * @subpackage Wp_Book/admin
 * @author     Saurabh Bagde <bagdesaurabh69@gmail.com>
 */
class Wp_Book_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Book_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Book_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-book-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'bootstrap-css', plugin_dir_url( __FILE__ ) . 'css/bootstrap.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Book_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Book_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-book-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'bootstrap-js', plugin_dir_url( __FILE__ ) . 'js/bootstrap.js', array( 'jquery' ), $this->version, false );
	}
	/**
	 * Add our custom menu.
	 *
	 * @return void
	 */
	public function my_admin_menu() {
		add_menu_page( 'book_settings', 'Books Menu', 'manage_options', 'book_settings', array( $this, 'book_admin_page' ), 'dashicons-tickets', 250 );
		add_submenu_page( 'booksettings', 'books settings', 'Book Setting', 'manage_options', 'book-submenu', array( $this, 'submenu' ) );

	}
	/**
	 * Admin Page Display.
	 *
	 * @return void
	 */
	public function book_admin_page() {
		// Return View.
		require_once 'partials/wp-book-admin-display.php';
	}
	/**
	 * Book seetings setup function
	 *
	 * @return void
	 */
	public function book_custom_settings() {
		register_setting( 'books-setting-group', 'currency' );
		register_setting( 'books-setting-group', 'post_per_page' );

		add_settings_section( 'book-config', 'Book Configuration', array( $this, 'book_config_section' ), 'book_settings' );

		add_settings_field( 'book-currency', 'Currency', array( $this, 'book_price_currency' ), 'book_settings', 'book-config' );
		add_settings_field( 'book-post-per-page', 'Books per page', array( $this, 'book_post_per_page' ), 'book_settings', 'book-config' );
	}
	/**
	 * Section setup Book Config
	 *
	 * @return void
	 */
	public function book_config_section() {
		echo 'Configure Book Options';
	}
	/**
	 * Book price post per page.
	 *
	 * @return void
	 */
	public function book_price_currency() {
		$currency = get_option( 'currency' );
		echo '<input type="text" name="currency" value="' . esc_attr( $currency ) . ' " placeholder = "$"/>';
	}
	/**
	 * Book price post per page
	 *
	 * @return void
	 */
	public function book_post_per_page() {
		$post_per_page = get_option( 'post_per_page' );
		echo '<input type="text" name="post_per_page" value="' . esc_attr( $post_per_page ) . ' " placeholder = "10"/>';
	}
	/**
	 * Submenu Page
	 *
	 * @return void
	 */
	public function submenu() {
		// Return Submenu view.
		require_once 'partials/submenu-page.php';
	}

	/**
	 * Custom Post Type Book
	 *
	 * @return void
	 */
	public function custom_post_type_book() {

		// Set UI labels for Custom Post Type.
		$labels = array(
			'name'               => _x( 'Books', 'Post Type General Name', 'twentytwenty' ),
			'singular_name'      => _x( 'Book', 'Post Type Singular Name', 'twentytwenty' ),
			'menu_name'          => __( 'Books', 'twentytwenty' ),
			'parent_item_colon'  => __( 'Parent Book', 'twentytwenty' ),
			'all_items'          => __( 'All Books', 'twentytwenty' ),
			'view_item'          => __( 'View Book', 'twentytwenty' ),
			'add_new_item'       => __( 'Add New Book', 'twentytwenty' ),
			'add_new'            => __( 'Add New Book', 'twentytwenty' ),
			'edit_item'          => __( 'Edit Book', 'twentytwenty' ),
			'update_item'        => __( 'Update Book', 'twentytwenty' ),
			'search_items'       => __( 'Search Book', 'twentytwenty' ),
			'not_found'          => __( 'Not Found', 'twentytwenty' ),
			'not_found_in_trash' => __( 'Not found in Trash', 'twentytwenty' ),
		);

		// Set other options for Custom Post Type.

		$args = array(
			'label'               => __( 'books', 'twentytwenty' ),
			'description'         => __( 'Books Collection', 'twentytwenty' ),
			'labels'              => $labels,
			// Features this CPT supports in Post Editor.
			'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields' ),
			// You can associate this CPT with a taxonomy or custom taxonomy.
			'taxonomies'          => array( 'books-category', 'books-tag' ),
			'hierarchical'        => true,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'rewrite'             => array( 'slug' => 'books' ),
			'menu_position'       => 5,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			'show_in_rest'        => true,

		);

		// Registering your Custom Post Type.
		register_post_type( 'books', $args );

	}
	/**
	 * Taxonomy hierarchical book category
	 *
	 * @return void
	 */
	public function book_category() {

		// Add new taxonomy, make it hierarchical like categories.
		// first do the translations part for GUI.

		$labels = array(
			'name'              => _x( 'Books Category', 'taxonomy general name' ),
			'singular_name'     => _x( 'Book Category', 'taxonomy singular name' ),
			'search_items'      => __( 'Search Books' ),
			'all_items'         => __( 'All Books' ),
			'parent_item'       => __( 'Parent Book' ),
			'parent_item_colon' => __( 'Parent Book:' ),
			'edit_item'         => __( 'Edit Book' ),
			'view_item'         => __( 'View Book' ),
			'update_item'       => __( 'Update Book category' ),
			'add_new_item'      => __( 'Add New Book category' ),
			'new_item_name'     => __( 'New Book category' ),
			'menu_name'         => __( 'Book Category' ),
			'not_found'         => __( 'No Book Category Found' ),
		);

		// Now register the taxonomy.
			register_taxonomy(
				'books-category',
				array( 'books' ),
				array(
					'hierarchical'       => true,
					'labels'             => $labels,
					'public'             => true,
					'show_ui'            => true,
					'show_in_rest'       => true,
					'show_admin_column'  => true,
					'show_in_nav_menus'  => false,
					'publicly_queryable' => true,
					'query_var'          => true,
					'rewrite'            => true,
				)
			);

	}
	/**
	 * Custom Book Tag
	 *
	 * @return void
	 */
	public function book_tag() {

		// Labels part for the GUI.

		$labels = array(
			'name'                       => _x( 'Books Tag', 'taxonomy general name' ),
			'singular_name'              => _x( 'Books Tag', 'taxonomy singular name' ),
			'search_items'               => __( 'Search Books Tag' ),
			'popular_items'              => __( 'Popular Books Tag' ),
			'all_items'                  => __( 'All Books Tag' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit Books Tag' ),
			'update_item'                => __( 'Update Books Tag' ),
			'add_new_item'               => __( 'Add New Books Tag' ),
			'new_item_name'              => __( 'New Books Tag Name' ),
			'separate_items_with_commas' => __( 'Separate books tag with commas' ),
			'add_or_remove_items'        => __( 'Add or remove Books Tag' ),
			'choose_from_most_used'      => __( 'Choose from the most used Books Tag' ),
			'menu_name'                  => __( 'Books Tag' ),
		);

		// Now register the non-hierarchical taxonomy like tag.

		register_taxonomy(
			'books-tag',
			'books',
			array(
				'hierarchical'          => false,
				'labels'                => $labels,
				'show_ui'               => true,
				'show_in_rest'          => true,
				'show_admin_column'     => true,
				'show_in_nav_menus'     => false,
				'update_count_callback' => '_update_post_term_count',
				'publicly_queryable'    => true,
				'query_var'             => true,
				'rewrite'               => true,
			)
		);
	}
	/**
	 *  Meta box setup function.
	 *
	 * @return void
	 */
	public function book_meta_boxes_setup() {

		// Add meta boxes on the 'add_meta_boxes' hook.
		add_action( 'add_meta_boxes', array( $this, 'book_post_meta_boxes' ) );
	}
	/**
	 * Adding meta box function
	 *
	 * @return void
	 */
	public function book_post_meta_boxes() {
		// Create one or more meta boxes to be displayed on the post editor screen.
		add_meta_box(
			'book-meta-box',                             // Unique ID.
			esc_html__( 'Book Meta', 'example' ),       // Title.
			array( $this, 'book_meta_box_display' ),   // Callback function.
			'books',                                  // Admin page (or post type).
			'side',                                  // Context.
			'default'                               // Priority.
		);
	}
	/**
	 *  Display the post meta box.
	 *
	 * @param [type] $post hook provided args.
	 * @return void
	 */
	public function book_meta_box_display( $post ) { ?>

		<?php wp_nonce_field( basename( __FILE__ ), 'wp_wpb_cpt_nonce' ); ?>

	<label for="author_name"><?php _e( 'Author Name' ); ?></label>
	<br />
	<input type="text" name="author_name" id="author_name" value="<?php echo $this->get_book_meta( $post->ID, 'book_author_name' ); ?>" size="30" />
	<br />
	<label for="price"><?php _e( 'Price' ); ?></label>
	<br />
	<input  type="number" name="price" id="price" value="<?php echo $this->get_book_meta( $post->ID, 'book_price' ); ?>" size="30" />
	<br />
	<label for="publisher"><?php _e( 'Publisher' ); ?></label>
	<br />
	<input  type="text" name="publisher" id="publisher" value=" <?php echo $this->get_book_meta( $post->ID, 'book_publisher' ); ?>" size="30" />
	<br />
	<label for="year"><?php _e( 'Year' ); ?></label>
	<br />
	<input  type="text" name="year" id="year" value="<?php echo $this->get_book_meta( $post->ID, 'book_year' ); ?>" size="30" />
	<br />
	<label for="edition"><?php _e( 'Edition' ); ?></label>
	<br />
	<input  type="text" name="edition" id="edition" value="<?php echo $this->get_book_meta( $post->ID, 'book_year' ); ?>" size="30" />
	<br />
	<label for="ur_l"><?php _e( 'URL' ); ?></label>
	<br />
	<input  type="text" name="ur_l" id="ur_l" value="<?php echo $this->get_book_meta( $post->ID, 'book_url' ); ?>" size="30" />
		<?php
	}

	// Meta Table.
	/**
	 * Meta table integrate
	 *
	 * @return void
	 */
	public function bookmeta_integrate_wpdb() {
		global $wpdb;

		$wpdb->bookmeta = $wpdb->prefix . 'bookmeta';
		$wpdb->tables[] = 'bookmeta';

		return;
	}
	/**
	 * Adds meta data field to a badge.
	 *
	 * @param int    $book_id    book ID.
	 * @param string $meta_key   Metadata name.
	 * @param mixed  $meta_value Metadata value.
	 * @param bool   $unique     Optional, default is false. Whether the same key should not be added.
	 * @return int|false Meta ID on success, false on failure.
	 */
	public function add_book_meta( $book_id, $meta_key, $meta_value, $unique = false ) {
		return add_metadata( 'books', $book_id, $meta_key, $meta_value, $unique );
	}

	/**
	 * Removes metadata matching criteria from a badge.
	 *
	 * You can match based on the key, or key and value. Removing based on key and
	 * value, will keep from removing duplicate metadata with the same key. It also
	 * allows removing all metadata matching key, if needed.
	 *
	 * @param int    $book_id    book ID.
	 * @param string $meta_key   Metadata name.
	 * @param mixed  $meta_value Optional. Metadata value.
	 * @return bool True on success, false on failure.
	 */
	public function delete_book_meta( $book_id, $meta_key, $meta_value = '' ) {
		return delete_metadata( 'book', $book_id, $meta_key, $meta_value );
	}

	/**
	 * Retrieve meta field for a book.
	 *
	 * @param int    $book_id book ID.
	 * @param string $key     Optional. The meta key to retrieve. By default, returns data for all keys.
	 * @param bool   $single  Whether to return a single value.
	 * @return mixed Will be an array if $single is false. Will be value of meta data field if $single is true.
	 */
	public function get_book_meta( $book_id, $key = '', $single = true ) {
		return get_metadata( 'book', $book_id, $key, $single );
	}

	/**
	 * Update book meta field based on badge ID.
	 *
	 * Use the $prev_value parameter to differentiate between meta fields with the
	 * same key and book ID.
	 *
	 * If the meta field for the user does not exist, it will be added.
	 *
	 * @param int    $book_id   book ID.
	 * @param string $meta_key   Metadata key.
	 * @param mixed  $meta_value Metadata value.
	 * @param mixed  $prev_value Optional. Previous value to check before removing.
	 * @return int|bool Meta ID if the key didn't exist, true on successful update, false on failure.
	 */
	public function update_book_meta( $book_id, $meta_key, $meta_value, $prev_value = '' ) {
		return update_metadata( 'book', $book_id, $meta_key, $meta_value, $prev_value );
	}

	/**
	 * Save book meta data into meta table.
	 *
	 * @param [type] $post_id post id.
	 * @param [type] $post post.
	 * @return int
	 */
	public function save_book_meta_table( $post_id, $post ) {

		if ( ! isset( $_POST['wp_wpb_cpt_nonce'] ) || ! wp_verify_nonce( $_POST['wp_wpb_cpt_nonce'], basename( __FILE__ ) ) ) {
			return $post_id;
		}
		$post_slug = 'books';
		if ( $post_slug !== $post->post_type ) {
			return;
		}

		$author_name = '';
		if ( ! empty( $_POST['author_name'] ) ) {
			$author_name = sanitize_text_field( wp_unslash( $_POST['author_name'] ) );
			$this->update_book_meta( $post_id, 'book_author_name', $author_name );
		}
		$price = '';
		if ( ! empty( $_POST['price'] ) ) {
			$price = sanitize_text_field( wp_unslash( $_POST['price'] ) );
			$this->update_book_meta( $post_id, 'book_price', $price );
		}
		$publisher = '';
		if ( ! empty( $_POST['publisher'] ) ) {
			$publisher = sanitize_text_field( wp_unslash( $_POST['publisher'] ) );
			$this->update_book_meta( $post_id, 'book_publisher', $publisher );
		}
		$year = '';
		if ( ! empty( $_POST['year'] ) ) {
			$year = sanitize_text_field( wp_unslash( $_POST['year'] ) );
			$this->update_book_meta( $post_id, 'book_year', $year );
		}
		$edition = '';
		if ( ! empty( $_POST['edition'] ) ) {
			$edition = sanitize_text_field( wp_unslash( $_POST['edition'] ) );
			$this->update_book_meta( $post_id, 'book_edition', $edition );
		}
		$url = '';
		if ( ! empty( $_POST['ur_l'] ) ) {
			$url = sanitize_text_field( wp_unslash( $_POST['ur_l'] ) );
			$this->update_book_meta( $post_id, 'book_url', $url );
		}
	}

	// ShortCode.
	/**
	 * Registering a shortcode
	 *
	 * @return void
	 */
	public function register_shortcodes() {
		add_shortcode( 'book', array( $this, 'book_shortcode' ) );
	}
	/**
	 * Shortcode for book plugin
	 *
	 * @param [type] $atts shortcode attributes.
	 * @return function
	 */
	public function book_shortcode( $atts ) {
		$atts = shortcode_atts(
			array(
				'book_id'     => '',
				'author_name' => '',
				'year'        => '',
				'category'    => '',
				'tag'         => '',
				'publisher'   => '',
			),
			$atts
		);

		$args = array(
			'post_type'   => 'books',
			'post_status' => 'publish',
			'author'      => $atts['author_name'],
		);

		if ( '' !== $atts['book_id'] ) {
			$args['book_id'] = $atts['book_id'];
		}
		if ( '' !== $atts['category'] ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'books_category',
					'terms'    => array( $atts['category'] ),
					'field'    => 'name',
					'operator' => 'IN',
				),
			);
		}
		if ( '' !== $atts['tag'] ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'books_tag',
					'terms'    => array( $atts['tag'] ),
					'field'    => 'name',
					'operator' => 'IN',
				),
			);
		}
		return $this->book_shortcode_function( $args );
	}



	/**
	 * Function for rendering the data
	 *
	 * @param [type] $args arguments passed by shortcode.
	 * @return void
	 */
	public function book_shortcode_function( $args ) {

		$currency = get_option( 'currency' );

		$wpb_query = new WP_Query( $args );
		if ( $wpb_query->have_posts() ) {
			while ( $wpb_query->have_posts() ) {
				$wpb_query->the_post();

				// Retriving the meta info of book from database.
				$info_author_name = $this->get_book_meta( get_the_id(), 'book_author_name' );
				$info_price       = $this->get_book_meta( get_the_id(), 'book_price' );
				$info_publisher   = $this->get_book_meta( get_the_id(), 'book_publisher' );
				$info_year        = $this->get_book_meta( get_the_id(), 'book_year' );
				$info_edition     = $this->get_book_meta( get_the_id(), 'book_edition' );
				$info_url         = $this->get_book_meta( get_the_id(), 'book_url' );

				?>
				<ul>
				<?php
				if ( get_the_title() !== '' ) {
					?>
						<li>Title: <a href="<?php get_post_permalink(); ?>"><?php echo get_the_title(); ?></a></li>
					<?php
				}
				if ( '' !== $info_author_name ) {
					?>
						<li>Author: <?php echo $info_author_name; ?></li>
					<?php
				}
				if ( '' !== $info_price ) {
					?>
						<li>Price: <?php echo $info_price . ' ' . $currency; ?></li>
					<?php
				}
				if ( '' !== $info_publisher ) {
					?>
						<li>Publisher: <?php echo $info_publisher; ?></li>
					<?php
				}
				if ( '' !== $info_year ) {
					?>
						<li>Year: <?php echo $info_year; ?></li>
					<?php
				}
				if ( '' !== $info_edition ) {
					?>
						<li>Edition: <?php echo $info_edition; ?></li>
					<?php
				}
				if ( '' !== $info_url ) {
					?>
						<li>Url: <?php echo $info_url; ?></li>
					<?php
				}
				if ( get_the_content() !== '' ) {
					?>
						<li>Content: <?php echo get_the_content(); ?></li>
					<?php
				}
				?>
				</ul>
				<?php
			}
		} else {
			?>
			<h1>Sorry no Books Found</h1>
			<?php
		}
	}

	/**
	 * Admin dashboard widget for top 5 books
	 *
	 * @return void
	 */
	public function admin_dashboard_widget() {
		wp_add_dashboard_widget( 'admin-category-count', 'Top 5 Books', array( $this, 'widget_top_books' ) );
	}

	/**
	 * Books widget top 5 display.
	 *
	 * @return void
	 */
	public function widget_top_books() {
		$args = array(
			'show_count' => 1,
			'style'      => 'none',
			'taxonomy'   => 'books-category',
			'order'      => 'ASC',
			'orderby'    => 'name',
			'number'     => 5,
		);
		wp_list_categories( $args );
	}
}
