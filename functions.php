<?php
/**
 * chirs functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package chirs
 */

if ( ! function_exists( 'chirs_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function chirs_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on chirs, use a find and replace
	 * to change 'chirs' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'chirs', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'menu-1' => esc_html__( 'Primary', 'chirs' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'chirs_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
endif;
add_action( 'after_setup_theme', 'chirs_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function chirs_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'chirs_content_width', 1200 );
}
add_action( 'after_setup_theme', 'chirs_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function chirs_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'chirs' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'chirs' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'chirs_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function chirs_scripts() {
	wp_enqueue_style( 'chirs-style', get_stylesheet_uri() );

	wp_enqueue_script( 'chirs-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'chirs-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );
	
	wp_enqueue_script( 'smoothstate-js', get_template_directory_uri() . '/js/jquery.smoothState.min.js', array('jquery'), '0.5.2', true );
	
	wp_enqueue_script( 'chirs-site', get_template_directory_uri() . '/js/site.min.js', array('jquery', 'smoothstate-js'), '20170614', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'chirs_scripts' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function chirs_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'chirs_pingback_header' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Additional features to allow styling of the templates.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


/* ADDITIONS FROM RANDY */


/**
 * Enqueue styles for admin.
 */
function admin_style() {
  wp_enqueue_style('admin-styles', get_template_directory_uri() . '/admin.css');
}
add_action('admin_enqueue_scripts', 'admin_style');

/**
 * 'Disabling' comments (removing it from admin menu)
 */
function remove_menus(){
  remove_menu_page( 'edit-comments.php' );          //Comments
}
add_action( 'admin_menu', 'remove_menus' );
/**
 * Re-ordering the admin menu
 */
function custom_menu_order($menu_ord) {
	if (!$menu_ord) return true;

	return array(
		'index.php', // Dashboard
		'separator1', // First separator
		'edit.php', // Posts (Projects)
		'edit.php?post_type=page', // Pages
		'upload.php', // Media
		'separator2', // Second separator
		'themes.php', // Appearance
		'plugins.php', // Plugins
		'users.php', // Users
		'tools.php', // Tools
		'options-general.php', // Settings
		'separator-last', // Last separator
	);
}
add_filter('custom_menu_order', 'custom_menu_order'); // Activate custom_menu_order
add_filter('menu_order', 'custom_menu_order');


/**
 * Reformating posts into a poster content type.
 */
// Renaming labels
function projects_change_post_label() {
	global $menu;
	global $submenu;
	$menu[5][0] = 'Projects';
	$submenu['edit.php'][5][0] = 'Projects';
	$submenu['edit.php'][10][0] = 'Add Project';
	$submenu['edit.php'][16][0] = 'Project Tags';
}
function projects_change_post_object() {
	global $wp_post_types;
	$labels = &$wp_post_types['post']->labels;
	$labels->name = 'Projects';
	$labels->singular_name = 'Project';
	$labels->add_new = 'Add Project';
	$labels->add_new_item = 'Add Project';
	$labels->edit_item = 'Edit Project';
	$labels->new_item = 'Project';
	$labels->view_item = 'View Projects';
	$labels->search_items = 'Search Projects';
	$labels->not_found = 'No Projects found';
	$labels->not_found_in_trash = 'No Projects found in Trash';
	$labels->all_items = 'All Projects';
	$labels->menu_name = 'Projects';
	$labels->name_admin_bar = 'Projects';
	$menu_icon = &$wp_post_types['post']->menu_icon;
	$menu_icon = 'dashicons-thumbs-up';
}

add_action( 'admin_menu', 'projects_change_post_label' );
add_action( 'init', 'projects_change_post_object' );


/**
 * Load a custom admin.min.js Javascript file for running in the admin backend.
 */
function admin_enqueue() {
	wp_enqueue_script( 'chirs-admin', get_template_directory_uri() . '/js/admin.min.js', array('jquery'), '20170614', true );
}

add_action('admin_enqueue_scripts', 'admin_enqueue');


/**
 * Custom meta box #1 for projects
 * Generated by the WordPress Meta Box Generator at https://jeremyhixon.com/tool/wordpress-meta-box-generator-v2-beta/
 */
class chirs_meta_box_setup {
	private $screens = array(
		'post',
	);
	private $fields = array(
		array(
			'id' => 'gradient-left',
			'label' => 'Left Color:',
			'type' => 'text'
		),
		array(
			'id' => 'gradient-right',
			'label' => 'Right Color:',
			'type' => 'text'
		),
		array(
			'id' => 'column-1-label',
			'label' => 'Label', // It's probably a terrible idea to make the labels for all these generic "label" and "text", but whatever
			'type' => 'text',
		),
		array(
			'id' => 'column-1-text',
			'label' => 'Text',
			'type' => 'textarea',
		),
		array(
			'id' => 'column-2-label',
			'label' => 'Label',
			'type' => 'text',
		),
		array(
			'id' => 'column-2-text',
			'label' => 'Text',
			'type' => 'textarea',
		),
		array(
			'id' => 'column-3-label',
			'label' => 'Label',
			'type' => 'text',
		),
		array(
			'id' => 'column-3-text',
			'label' => 'Text',
			'type' => 'textarea',
		),
		array(
			'id' => 'column-4-label',
			'label' => 'Label',
			'type' => 'text',
		),
		array(
			'id' => 'column-4-text',
			'label' => 'Text',
			'type' => 'textarea',
		),
		array(
			'id' => 'column-5-label',
			'label' => 'Label',
			'type' => 'text',
		),
		array(
			'id' => 'column-5-text',
			'label' => 'Text',
			'type' => 'textarea',
		),
	);

	/**
	 * Class construct method. Adds actions to their respective WordPress hooks.
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_post' ) );
	}

	/**
	 * Hooks into WordPress' add_meta_boxes function.
	 * Goes through screens (post types) and adds the meta box.
	 */
	public function add_meta_boxes() {
		foreach ( $this->screens as $screen ) {
			add_meta_box(
				'project-set-up',
				__( 'Project Set-up', 'chirs-metabox' ),
				array( $this, 'add_meta_box_callback' ),
				$screen,
				'normal',
				'default'
			);
		}
	}

	/**
	 * Generates the HTML for the meta box
	 * 
	 * @param object $post WordPress post object
	 */
	public function add_meta_box_callback( $post ) {
		wp_nonce_field( 'project_set_up_data', 'project_set_up_nonce' );
		$this->generate_fields( $post );
	}

	/**
	 * Generates the field's HTML for the meta box.
	 */
	public function generate_fields( $post ) {
		// Just write out some custom HTML instead, use a modified function to set up each field
		echo '<div id="chirs_custom_metabox">
				<div class="clearfix">
					<label>Project gradient:</label><div id="gradient-bg"></div><div id="gradient"></div>
					<div class="left">' . $this->format_field($this->fields[0], $post) . '</div>
					<div class="right">' . $this->format_field($this->fields[1], $post) . '</div>
				</div>
				<div class="clearfix">
					<div class="meta-section clearfix">
						<label>Project Meta</label>' .
							'<div class="meta-section-column">
								<label>Column 1</label>' . 
								$this->format_field($this->fields[2], $post) . 
								$this->format_field($this->fields[3], $post) . 
							'</div>
							<div class="meta-section-column">
								<label>Column 2</label>' . 
								$this->format_field($this->fields[4], $post) . 
								$this->format_field($this->fields[5], $post) . 
							'</div>
							<div class="meta-section-column">
								<label>Column 3</label>' . 
								$this->format_field($this->fields[6], $post) . 
								$this->format_field($this->fields[7], $post) . 
							'</div>
							<div class="meta-section-column">
								<label>Column 4</label>' . 
								$this->format_field($this->fields[8], $post) . 
								$this->format_field($this->fields[9], $post) . 
							'</div>
							<div class="meta-section-column">
								<label>Column 5</label>' . 
								$this->format_field($this->fields[10], $post) . 
								$this->format_field($this->fields[11], $post) . 
							'</div>
					</div>
				</div>
			</div>';
	}

	/**
	 * Generates the HTML for table rows.
	 */
	public function format_field( $field, $post ) {
		$label = '<label for="' . $field['id'] . '">' . $field['label'] . '</label>';
		$db_value = get_post_meta( $post->ID, 'project_set_up_' . $field['id'], true );
		switch ( $field['type'] ) {
			case 'textarea':
				$input = sprintf(
					'<textarea class="large-text" id="%s" name="%s" rows="5">%s</textarea>',
					$field['id'],
					$field['id'],
					$db_value
				);
				break;
			default:
				$input = sprintf(
					'<input %s id="%s" name="%s" type="%s" value="%s">',
					$field['type'] !== 'color' ? 'class="regular-text"' : '',
					$field['id'],
					$field['id'],
					$field['type'],
					$db_value
				);
		}
		return $label . $input;
	}
	/**
	 * Hooks into WordPress' save_post function
	 */
	public function save_post( $post_id ) {
		if ( ! isset( $_POST['project_set_up_nonce'] ) )
			return $post_id;

		$nonce = $_POST['project_set_up_nonce'];
		if ( !wp_verify_nonce( $nonce, 'project_set_up_data' ) )
			return $post_id;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;

		foreach ( $this->fields as $field ) {
			if ( isset( $_POST[ $field['id'] ] ) ) {
				switch ( $field['type'] ) {
					case 'email':
						$_POST[ $field['id'] ] = sanitize_email( $_POST[ $field['id'] ] );
						break;
					case 'text':
						$_POST[ $field['id'] ] = sanitize_text_field( $_POST[ $field['id'] ] );
						break;
				}
				update_post_meta( $post_id, 'project_set_up_' . $field['id'], $_POST[ $field['id'] ] );
			} else if ( $field['type'] === 'checkbox' ) {
				update_post_meta( $post_id, 'project_set_up_' . $field['id'], '0' );
			}
		}
	}
}
new chirs_meta_box_setup;


/*
 * Custom meta box #2 for pages
 * Generated by the WordPress Meta Box Generator at http://goo.gl/8nwllb
 */
class chirs_page_meta_box_setup {
	private $screens = array(
		'page',
	);
	private $fields = array(
		array(
			'id' => 'column-1',
			'label' => 'Column 1',
			'type' => 'textarea',
		),
		array(
			'id' => 'column-2',
			'label' => 'Column 2',
			'type' => 'textarea',
		),
		array(
			'id' => 'column-3',
			'label' => 'Column 3',
			'type' => 'textarea',
		),
	);

	/**
	 * Class construct method. Adds actions to their respective WordPress hooks.
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_post' ) );
	}

	/**
	 * Hooks into WordPress' add_meta_boxes function.
	 * Goes through screens (post types) and adds the meta box.
	 */
	public function add_meta_boxes() {
		foreach ( $this->screens as $screen ) {
			add_meta_box(
				'advanced-options',
				__( 'Advanced Options', 'chirs2' ),
				array( $this, 'add_meta_box_callback' ),
				$screen,
				'normal',
				'default'
			);
		}
	}

	/**
	 * Generates the HTML for the meta box
	 * 
	 * @param object $post WordPress post object
	 */
	public function add_meta_box_callback( $post ) {
		wp_nonce_field( 'advanced_options_data', 'advanced_options_nonce' );
		$this->generate_fields( $post );
	}

	/**
	 * Generates the field's HTML for the meta box.
	 */
	public function generate_fields( $post ) {
		$output = '';
		foreach ( $this->fields as $field ) {
			$label = '<label for="' . $field['id'] . '">' . $field['label'] . '</label>';
			$db_value = get_post_meta( $post->ID, 'advanced_options_' . $field['id'], true );
			switch ( $field['type'] ) {
				case 'textarea':
					$input = sprintf(
						'<textarea class="large-text" id="%s" name="%s" rows="5">%s</textarea>',
						$field['id'],
						$field['id'],
						$db_value
					);
					break;
				default:
					$input = sprintf(
						'<input %s id="%s" name="%s" type="%s" value="%s">',
						$field['type'] !== 'color' ? 'class="regular-text"' : '',
						$field['id'],
						$field['id'],
						$field['type'],
						$db_value
					);
			}
			$output .= $this->row_format( $label, $input );
		}
		echo '<table class="form-table"><tbody>' . $output . '</tbody></table>';
	}

	/**
	 * Generates the HTML for table rows.
	 */
	public function row_format( $label, $input ) {
		return sprintf(
			'<tr><th scope="row">%s</th><td>%s</td></tr>',
			$label,
			$input
		);
	}
	/**
	 * Hooks into WordPress' save_post function
	 */
	public function save_post( $post_id ) {
		if ( ! isset( $_POST['advanced_options_nonce'] ) )
			return $post_id;

		$nonce = $_POST['advanced_options_nonce'];
		if ( !wp_verify_nonce( $nonce, 'advanced_options_data' ) )
			return $post_id;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;

		foreach ( $this->fields as $field ) {
			if ( isset( $_POST[ $field['id'] ] ) ) {
				switch ( $field['type'] ) {
					case 'email':
						$_POST[ $field['id'] ] = sanitize_email( $_POST[ $field['id'] ] );
						break;
					case 'text':
						$_POST[ $field['id'] ] = sanitize_text_field( $_POST[ $field['id'] ] );
						break;
				}
				update_post_meta( $post_id, 'advanced_options_' . $field['id'], $_POST[ $field['id'] ] );
			} else if ( $field['type'] === 'checkbox' ) {
				update_post_meta( $post_id, 'advanced_options_' . $field['id'], '0' );
			}
		}
	}
}
new chirs_page_meta_box_setup;


/**
 * Let's remove the paragraph tags around images and iframes
 */
function filter_ptags_on_images($content) {
	$content = preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
	return preg_replace('/<p>\s*(<iframe .*>*.<\/iframe>)\s*<\/p>/iU', '\1', $content);
}
add_filter('acf_the_content', 'filter_ptags_on_images');
add_filter('the_content', 'filter_ptags_on_images');


/**
 *   Add responsive container to embeds
 */ 
function alx_embed_html( $html ) {
	return '<div class="video"><div class="video-container">' . $html . '</div></div>';
}

add_filter( 'embed_oembed_html', 'alx_embed_html', 10, 3 );
add_filter( 'video_embed_html', 'alx_embed_html' ); // Jetpack


/**
 *   Add responsive container to embeds
 */
function my_login_logo() { ?>
	<script src="https://use.typekit.net/irq6uhd.js"></script>
	<script>try{Typekit.load({ async: true });}catch(e){}</script>
	<style type="text/css">
		#login h1 a, .login h1 a {
			font-family: "aktiv-grotesk", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
			background-image: none;
			text-indent: 0;
			width: auto;
			height: auto;
			font-size: 35px;
			display: inline-block;
			background-image: linear-gradient(to right, #00d2ff 0%, #3a7bd5 100%);
			background-size: 100% 4px;
			background-position: left bottom;
			
			animation: login-animation-part1 1s, login-animation-part2 0.5s;
			animation-delay: 0s, 1s;
			animation-timing-function: @easeInOutQuint;
			
			transition: all 0.2s linear;
		}
		#login h1 a:before, .login h1 a:before {
			content: '';
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			z-index: -1000;
			background-image: linear-gradient(135deg, #00d2ff 0%, #3a7bd5 100%);
			opacity: 0;
			transition: opacity 0.2s linear;
		}
		#login h1 a:hover, .login h1 a:hover {
			color: white;
			background-size: 100% 0;
		}
		#login h1 a:hover:before, .login h1 a:before {
			opacity: 1;
		}
		@keyframes login-animation-part1 {
			from {
				background-size: 0% 73%;
				color: transparent;
			}
			to {
				background-size: 100% 73%;
				color: transparent;
			}
		}
		
		@keyframes login-animation-part2 {
			from {
				background-size: 100% 73%;
				background-position: left bottom;
				color: transparent;
			}
			to {
				background-size: 100% @unerline-size;
				background-position: left bottom;
				color: inherit;
			}
		}
	</style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );
