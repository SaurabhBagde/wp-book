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
		add_menu_page( 'New Plugin Settings', 'Books Menu', 'manage_options', 'booksettings', array( $this, 'book_admin_page' ), 'dashicons-tickets', 250 );
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
	<input type="text" name="author_name" id="author_name"  size="30" />
	<br />
	<label for="price"><?php _e( 'Price' ); ?></label>
	<br />
	<input  type="number" name="price" id="price"  size="30" />
	<br />
	<label for="publisher"><?php _e( 'Publisher' ); ?></label>
	<br />
	<input  type="text" name="publisher" id="publisher"  size="30" />
	<br />
	<label for="year"><?php _e( 'Year' ); ?></label>
	<br />
	<input  type="text" name="year" id="year"  size="30" />
	<br />
	<label for="edition"><?php _e( 'Edition' ); ?></label>
	<br />
	<input  type="text" name="edition" id="edition" size="30" />
	<br />
	<label for="ur_l"><?php _e( 'URL' ); ?></label>
	<br />
	<input  type="text" name="ur_l" id="ur_l" size="30" />
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

		$wpdb->bookmeta  = $wpdb->prefix . 'bookmeta';
		$wpdb->tables[]  = 'bookmeta';

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
		return delete_metadata( 'books', $book_id, $meta_key, $meta_value );
	}

	/**
	 * Retrieve meta field for a badge.
	 *
	 * @param int    $book_id book ID.
	 * @param string $key     Optional. The meta key to retrieve. By default, returns data for all keys.
	 * @param bool   $single  Whether to return a single value.
	 * @return mixed Will be an array if $single is false. Will be value of meta data field if $single is true.
	 */
	public function get_book_meta( $book_id, $key = '', $single = false ) {
		return get_metadata( 'books', $book_id, $key, $single );
	}

	/**
	 * Update badge meta field based on badge ID.
	 *
	 * Use the $prev_value parameter to differentiate between meta fields with the
	 * same key and badge ID.
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
	 * @return int post id.
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
			$author_name = sanitize_text_field( $_POST['author_name'] );
			$this->update_book_meta( $post_id, 'book_author_name', $author_name );
		}
		$price = '';
		if ( ! empty( $_POST['price'] ) ) {
			$price = sanitize_text_field( $_POST['price'] );
			$this->update_book_meta( $post_id, 'book_price', $price );
		}
		$publisher = '';
		if ( ! empty( $_POST['publisher'] ) ) {
			$publisher = sanitize_text_field( $_POST['publisher'] );
			$this->update_book_meta( $post_id, 'book_publisher', $publisher );
		}
		$year = '';
		if ( ! empty( $_POST['year'] ) ) {
			$year = sanitize_text_field( $_POST['year'] );
			$this->update_book_meta( $post_id, 'book_year', $year );
		}
		$edition = '';
		if ( ! empty( $_POST['edition'] ) ) {
			$edition = sanitize_text_field( $_POST['edition'] );
			$this->update_book_meta( $post_id, 'book_edition', $edition );
		}
		$url = '';
		if ( ! empty( $_POST['ur_l'] ) ) {
			$url = sanitize_text_field( $_POST['ur_l'] );
			$this->update_book_meta( $post_id, 'book_url', $url );
		}
	}
}
