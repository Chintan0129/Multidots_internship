<?php
/**
 * Twenty Twenty-Four functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Twenty Twenty-Four
 * @since Twenty Twenty-Four 1.0
 */

/**
 * Register block styles.
 */

if ( ! function_exists( 'twentytwentyfour_block_styles' ) ) :
	/**
	 * Register custom block styles
	 *
	 * @since Twenty Twenty-Four 1.0
	 * @return void
	 */
	function twentytwentyfour_block_styles() {

		register_block_style(
			'core/details',
			array(
				'name'         => 'arrow-icon-details',
				'label'        => __( 'Arrow icon', 'twentytwentyfour' ),
				/*
				 * Styles for the custom Arrow icon style of the Details block
				 */
				'inline_style' => '
				.is-style-arrow-icon-details {
					padding-top: var(--wp--preset--spacing--10);
					padding-bottom: var(--wp--preset--spacing--10);
				}

				.is-style-arrow-icon-details summary {
					list-style-type: "\2193\00a0\00a0\00a0";
				}

				.is-style-arrow-icon-details[open]>summary {
					list-style-type: "\2192\00a0\00a0\00a0";
				}',
			)
		);
		register_block_style(
			'core/post-terms',
			array(
				'name'         => 'pill',
				'label'        => __( 'Pill', 'twentytwentyfour' ),
				/*
				 * Styles variation for post terms
				 * https://github.com/WordPress/gutenberg/issues/24956
				 */
				'inline_style' => '
				.is-style-pill a,
				.is-style-pill span:not([class], [data-rich-text-placeholder]) {
					display: inline-block;
					background-color: var(--wp--preset--color--base-2);
					padding: 0.375rem 0.875rem;
					border-radius: var(--wp--preset--spacing--20);
				}

				.is-style-pill a:hover {
					background-color: var(--wp--preset--color--contrast-3);
				}',
			)
		);
		register_block_style(
			'core/list',
			array(
				'name'         => 'checkmark-list',
				'label'        => __( 'Checkmark', 'twentytwentyfour' ),
				/*
				 * Styles for the custom checkmark list block style
				 * https://github.com/WordPress/gutenberg/issues/51480
				 */
				'inline_style' => '
				ul.is-style-checkmark-list {
					list-style-type: "\2713";
				}

				ul.is-style-checkmark-list li {
					padding-inline-start: 1ch;
				}',
			)
		);
		register_block_style(
			'core/navigation-link',
			array(
				'name'         => 'arrow-link',
				'label'        => __( 'With arrow', 'twentytwentyfour' ),
				/*
				 * Styles for the custom arrow nav link block style
				 */
				'inline_style' => '
				.is-style-arrow-link .wp-block-navigation-item__label:after {
					content: "\2197";
					padding-inline-start: 0.25rem;
					vertical-align: middle;
					text-decoration: none;
					display: inline-block;
				}',
			)
		);
		register_block_style(
			'core/heading',
			array(
				'name'         => 'asterisk',
				'label'        => __( 'With asterisk', 'twentytwentyfour' ),
				'inline_style' => "
				.is-style-asterisk:before {
					content: '';
					width: 1.5rem;
					height: 3rem;
					background: var(--wp--preset--color--contrast-2, currentColor);
					clip-path: path('M11.93.684v8.039l5.633-5.633 1.216 1.23-5.66 5.66h8.04v1.737H13.2l5.701 5.701-1.23 1.23-5.742-5.742V21h-1.737v-8.094l-5.77 5.77-1.23-1.217 5.743-5.742H.842V9.98h8.162l-5.701-5.7 1.23-1.231 5.66 5.66V.684h1.737Z');
					display: block;
				}

				/* Hide the asterisk if the heading has no content, to avoid using empty headings to display the asterisk only, which is an A11Y issue */
				.is-style-asterisk:empty:before {
					content: none;
				}

				.is-style-asterisk:-moz-only-whitespace:before {
					content: none;
				}

				.is-style-asterisk.has-text-align-center:before {
					margin: 0 auto;
				}

				.is-style-asterisk.has-text-align-right:before {
					margin-left: auto;
				}

				.rtl .is-style-asterisk.has-text-align-left:before {
					margin-right: auto;
				}",
			)
		);
	}
endif;

add_action( 'init', 'twentytwentyfour_block_styles' );

/**
 * Enqueue block stylesheets.
 */

if ( ! function_exists( 'twentytwentyfour_block_stylesheets' ) ) :
	/**
	 * Enqueue custom block stylesheets
	 *
	 * @since Twenty Twenty-Four 1.0
	 * @return void
	 */
	function twentytwentyfour_block_stylesheets() {
		/**
		 * The wp_enqueue_block_style() function allows us to enqueue a stylesheet
		 * for a specific block. These will only get loaded when the block is rendered
		 * (both in the editor and on the front end), improving performance
		 * and reducing the amount of data requested by visitors.
		 *
		 * See https://make.wordpress.org/core/2021/12/15/using-multiple-stylesheets-per-block/ for more info.
		 */
		wp_enqueue_block_style(
			'core/button',
			array(
				'handle' => 'twentytwentyfour-button-style-outline',
				'src'    => get_parent_theme_file_uri( 'assets/css/button-outline.css' ),
				'ver'    => wp_get_theme( get_template() )->get( 'Version' ),
				'path'   => get_parent_theme_file_path( 'assets/css/button-outline.css' ),
			)
		);
	}
endif;

add_action( 'init', 'twentytwentyfour_block_stylesheets' );

/**
 * Register pattern categories.
 */

if ( ! function_exists( 'twentytwentyfour_pattern_categories' ) ) :
	/**
	 * Register pattern categories
	 *
	 * @since Twenty Twenty-Four 1.0
	 * @return void
	 */
	function twentytwentyfour_pattern_categories() {

		register_block_pattern_category(
			'twentytwentyfour_page',
			array(
				'label'       => _x( 'Pages', 'Block pattern category', 'twentytwentyfour' ),
				'description' => __( 'A collection of full page layouts.', 'twentytwentyfour' ),
			)
		);
	}
endif;

add_action( 'init', 'twentytwentyfour_pattern_categories' );

// Woocommerce store - Disable cart, checkout, and order mode

    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
    remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
    remove_action( 'woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20 );
    remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );
    remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_coupon_form', 10 );


// Enqueue main style.css
function enqueue_styles() {
    wp_enqueue_style( 'main-style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'enqueue_styles' );

// Enqueue custom JavaScript file
function custom_enqueue_scripts() {
    wp_enqueue_script( 'custom-script', get_template_directory_uri() . '/js/custom-script.js', array(), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'custom_enqueue_scripts' );

// Enable catalogue mode with inquiry form
function enable_catalogue_mode_with_inquiry_form() {
    echo '<button class="show-inquiry-form-btn">Inquiry Form</button>';
    echo '<form class="product-inquiry-form" method="post" action="" style="display: none;">
              <label for="inquiry-email">Your Email:</label><br>
              <input type="email" id="inquiry-email" name="inquiry-email" required><br>
              <label for="inquiry-message">Your Message:</label><br>
              <textarea id="inquiry-message" name="inquiry-message" rows="4" cols="50" required></textarea><br>
              <input type="submit" value="Submit Inquiry">
          </form>';
}
add_action( 'woocommerce_single_product_summary', 'enable_catalogue_mode_with_inquiry_form');
function create_custom_faq_post_type() {
    $labels = array(
        'name'               => _x( 'FAQs', 'post type general name' ),
        'singular_name'      => _x( 'FAQ', 'post type singular name' ),
        'menu_name'          => _x( 'FAQs', 'admin menu' ),
        'name_admin_bar'     => _x( 'FAQ', 'add new on admin bar' ),
        'add_new'            => _x( 'Add New', 'FAQ' ),
        'add_new_item'       => __( 'Add New FAQ' ),
        'new_item'           => __( 'New FAQ' ),
        'edit_item'          => __( 'Edit FAQ' ),
        'view_item'          => __( 'View FAQ' ),
        'all_items'          => __( 'All FAQs' ),
        'search_items'       => __( 'Search FAQs' ),
        'parent_item_colon'  => __( 'Parent FAQs:' ),
        'not_found'          => __( 'No FAQs found.' ),
        'not_found_in_trash' => __( 'No FAQs found in Trash.' )
    );

    $args = array(
        'labels'             => $labels,
        'description'        => __( 'Description.', 'your-plugin-textdomain' ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'faq' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor' ),
    );

    register_post_type( 'faq', $args );
}
add_action( 'init', 'create_custom_faq_post_type' );

function custom_faq_taxonomy() {
    // FAQ Categories
    $labels = array(
        'name'              => _x( 'FAQ Categories', 'taxonomy general name' ),
        'singular_name'     => _x( 'FAQ Category', 'taxonomy singular name' ),
        'search_items'      => __( 'Search FAQ Categories' ),
        'all_items'         => __( 'All FAQ Categories' ),
        'edit_item'         => __( 'Edit FAQ Category' ),
        'update_item'       => __( 'Update FAQ Category' ),
        'add_new_item'      => __( 'Add New FAQ Category' ),
        'new_item_name'     => __( 'New FAQ Category Name' ),
        'menu_name'         => __( 'FAQ Categories' ),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'faq-category' ),
    );

    register_taxonomy( 'faq-category', array( 'faq' ), $args );

    // FAQ Tags
    $labels = array(
        'name'                       => _x( 'FAQ Tags', 'taxonomy general name' ),
        'singular_name'              => _x( 'FAQ Tag', 'taxonomy singular name' ),
        'search_items'               => __( 'Search FAQ Tags' ),
        'popular_items'              => __( 'Popular FAQ Tags' ),
        'all_items'                  => __( 'All FAQ Tags' ),
        'edit_item'                  => __( 'Edit FAQ Tag' ),
        'update_item'                => __( 'Update FAQ Tag' ),
        'add_new_item'               => __( 'Add New FAQ Tag' ),
        'new_item_name'              => __( 'New FAQ Tag Name' ),
        'separate_items_with_commas' => __( 'Separate FAQ tags with commas' ),
        'add_or_remove_items'        => __( 'Add or remove FAQ tags' ),
        'choose_from_most_used'      => __( 'Choose from the most used FAQ tags' ),
        'not_found'                  => __( 'No FAQ tags found.' ),
        'menu_name'                  => __( 'FAQ Tags' ),
    );

    $args = array(
        'hierarchical'          => false,
        'labels'                => $labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var'             => true,
        'rewrite'               => array( 'slug' => 'faq-tag' ),
        'show_tagcloud'         => true,
    );

    register_taxonomy( 'faq-tag', array( 'faq' ), $args );
}
add_action( 'init', 'custom_faq_taxonomy' );

function create_portfolio_post_type() {
    register_post_type('portfolio',
        array(
            'labels' => array(
                'name' => __('Portfolio'),
                'singular_name' => __('Portfolio')
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'thumbnail', 'excerpt'), 
            'menu_icon' => 'dashicons-portfolio', // Add an icon to the admin menu
            'show_in_menu' => true, // Show in the admin menu
        )
    );
}
add_action('init', 'create_portfolio_post_type');

function create_portfolio_taxonomies() {
    register_taxonomy(
        'project_type',
        'portfolio',
        array(
            'label' => __('Project Type'),
            'hierarchical' => true,
        )
    );

    register_taxonomy(
        'project_category',
        'portfolio',
        array(
            'label' => __('Project Category'),
            'hierarchical' => true,
        )
    );

}
add_action('init', 'create_portfolio_taxonomies');

function add_project_client_meta_box() {
    add_meta_box(
        'project_client_meta_box',
        __('Project Client'),
        'project_client_meta_box_callback',
        'portfolio',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'add_project_client_meta_box');

function project_client_meta_box_callback($post) {
    $value = get_post_meta($post->ID, '_project_client', true);
    echo '<label for="project_client">Client Name: </label>';
    echo '<input type="text" id="project_client" name="project_client" value="' . esc_attr($value) . '" />';
}


function save_project_client_meta_data($post_id) {
    if (array_key_exists('project_client', $_POST)) {
        update_post_meta(
            $post_id,
            '_project_client',
            sanitize_text_field($_POST['project_client'])
        );
    }
}
add_action('save_post', 'save_project_client_meta_data');


