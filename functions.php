<?php


class GameLoungeTheme {

	public function __construct() {
		add_action( 'after_setup_theme', [ $this, 'setup' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		add_action( 'init', [ $this, 'register_post_types' ] );
		add_action( 'add_meta_boxes', [ $this, 'add_meta_boxes' ] );
		add_action( 'save_post', [ $this, 'save_meta_box_data' ] );
		add_filter( 'the_title', [ $this, 'filter_document_title_parts' ], 10, 2 );
		add_action( 'pre_get_posts', array( $this, 'add_book_to_main_query' ) );
	}

	/**
	 * Add the theme support
	 *
	 * @return void
	 */
	public function setup() {
		add_theme_support( 'title-tag' );
		add_theme_support( 'html5', [ 'style', 'script' ] );
	}

	/**
	 * Enqueue the css and js according to specifications
	 *
	 * @return void
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( 'style', get_stylesheet_uri() );
		wp_enqueue_style( 'bootstrap', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css', [], '5.1.3', 'all' );
		wp_enqueue_script( 'app', get_template_directory_uri() . '/src/js/app.js', [], '1.0', true );
	}

	/**
	 * Create the book CPT
	 *
	 * @return void
	 */
	public function register_post_types() {
		register_post_type( 'book',
			[
				'labels'   => [
					'name'          => __( 'Books' ),
					'singular_name' => __( 'Book' )
				],
				'public'   => true,
				'rewrite'  => [ 'slug' => 'books' ],
				'supports' => [ 'title', 'editor', 'excerpt' ]
			]
		);
	}

	/**
	 * Add meta boxes manually (usually i do this with ACF Pro
	 *
	 * @return void
	 */
	public function add_meta_boxes() {
		add_meta_box(
			'book_tagline',
			__( 'Tagline' ),
			[ $this, 'book_tagline_meta_box_callback' ],
			'book',
			'normal',
			'default'
		);
	}

	/**
	 * Render the tagline field
	 *
	 * @param $post
	 *
	 * @return void
	 */
	public function book_tagline_meta_box_callback( $post ) {
		wp_nonce_field( 'book_tagline_meta_box', 'book_tagline_meta_box_nonce' );
		$tagline_value = get_post_meta( $post->ID, '_book_tagline_value', true );
		echo '<textarea id="book_tagline_value" name="book_tagline_value" style="width:100%;">' . esc_attr( $tagline_value ) . '</textarea>';
	}

	/**
	 * Save the tagline
	 *
	 * @param $post_id
	 *
	 * @return void
	 */
	public function save_meta_box_data( $post_id ) {
		if ( ! isset( $_POST['book_tagline_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['book_tagline_meta_box_nonce'], 'book_tagline_meta_box' ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		if ( isset( $_POST['post_type'] ) && 'book' == $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		}
		if ( ! isset( $_POST['book_tagline_value'] ) ) {
			return;
		}
		$tagline_value = sanitize_textarea_field( $_POST['book_tagline_value'] );
		update_post_meta( $post_id, '_book_tagline_value', $tagline_value );
	}

	/**
	 * Override the titles if tagline present
	 *
	 * @param $title
	 * @param $id
	 *
	 * @return mixed
	 */
	public function filter_document_title_parts( $title, $id ) {
		// no need to check for post type because only books have taglines
		if ( $tagline_value = get_post_meta( $id, '_book_tagline_value', true ) ) {
			$title = $tagline_value;
		}

		return $title;
	}

	/**
	 * Add CPT to query
	 *
	 * @param $query
	 *
	 * @return void
	 */
	public function add_book_to_main_query( $query ) {
		if ( ! is_admin() && $query->is_main_query() && $query->is_home() ) {
			$query->set( 'post_type', array( 'post', 'book' ) );
		}
	}
}

new GameLoungeTheme;
