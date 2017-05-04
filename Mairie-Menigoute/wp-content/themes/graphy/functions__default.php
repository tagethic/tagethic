<?php
/**
 * Graphy functions and definitions
 *
 * @package Graphy
 */

if ( ! function_exists( 'graphy_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function graphy_setup() {

	/**
	 * Set the content width based on the theme's design and stylesheet.
	 */
	global $content_width;
	if ( ! isset( $content_width ) ) {
		$content_width = 700;
	}

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Graphy, use a find and replace
	 * to change 'graphy' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'graphy', get_template_directory() . '/languages' );

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
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 800 );
	add_image_size( 'graphy-post-thumbnail-large', 1080, 600, true );
	add_image_size( 'graphy-post-thumbnail-medium', 482, 300, true );
	add_image_size( 'graphy-post-thumbnail-small', 80, 60, true );
	add_image_size( 'graphy-page-thumbnail', 1260, 350, true );
	update_option( 'large_size_w', 700 );
	update_option( 'large_size_h', 0 );

	// This theme uses wp_nav_menu() in two location.
	register_nav_menus( array(
		'primary'       => esc_html__( 'Main Navigation', 'graphy' ),
		'header-social' => esc_html__( 'Header Social Links', 'graphy' ),
	) );
	
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video'
	) );

	// Setup the WordPress core custom header feature.
	add_theme_support( 'custom-header', apply_filters( 'graphy_custom_header_args', array(
		'default-image' => '',
		'width'         => 1260,
		'height'        => 350,
		'flex-height'   => true,
		'header-text'   => false,
	) ) );

	// This theme styles the visual editor to resemble the theme style.
	add_editor_style( array( 'css/normalize.css', 'style.css', 'css/editor-style.css', str_replace( ',', '%2C', graphy_fonts_url() ) ) );
}
endif; // graphy_setup
add_action( 'after_setup_theme', 'graphy_setup' );

/**
 * Adjust content_width value for full width template.
 */
function graphy_content_width() {
	if ( is_page_template( 'page_fullwidth.php' ) ) {
		global $content_width;
		$content_width = 1080;
	}
}
add_action( 'template_redirect', 'graphy_content_width' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function graphy_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'graphy' ),
		'id'            => 'sidebar',
		'description'   => esc_html__( 'This is the normal sidebar. If you do not use this sidebar, the page will be a one-column design.', 'graphy' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 1', 'graphy' ),
		'id'            => 'footer-1',
		'description'   => esc_html__( 'From left to right there are 4 sequential footer widget areas, and the width is auto-adjusted based on how many you use. If you do not use a footer widget, nothing will be displayed.', 'graphy' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer 2', 'graphy' ),
		'id'            => 'footer-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer 3', 'graphy' ),
		'id'            => 'footer-3',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer 4', 'graphy' ),
		'id'            => 'footer-4',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'graphy_widgets_init' );

if ( ! function_exists( 'graphy_fonts_url' ) ) :
/**
 * Register Google Fonts.
 *
 * This function is based on code from Twenty Fifteen.
 * https://wordpress.org/themes/twentyfifteen/
 */
function graphy_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Source Serif Pro, translate this to 'off'. Do not translate into your own language.
	 */
	$source_serif_pro = esc_html_x( 'on', 'Source Serif Pro font: on or off', 'graphy' );
	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Lora, translate this to 'off'. Do not translate into your own language.
	 */
	$lora = esc_html_x( 'on', 'Lora font: on or off', 'graphy' );
	/*
	 * Translators: To add an additional character subset specific to your language,
	 * translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'. Do not translate into your own language.
	 */
	$subset = esc_html_x( 'no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'graphy' );

	if ( 'off' !== $source_serif_pro ) {
		$fonts[] = 'Source Serif Pro:400';
	}
	if ( 'off' !== $lora ) {
		$fonts[] = 'Lora:400,400italic,700';
	}

	if ( 'cyrillic' == $subset ) {
		$subsets .= ',cyrillic,cyrillic-ext';
	} elseif ( 'greek' == $subset ) {
		$subsets .= ',greek,greek-ext';
	} elseif ( 'devanagari' == $subset ) {
		$subsets .= ',devanagari';
	} elseif ( 'vietnamese' == $subset ) {
		$subsets .= ',vietnamese';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}

	return $fonts_url;
}
endif;

/**
 * Enqueue scripts and styles.
 */
function graphy_scripts() {
	wp_enqueue_style( 'graphy-font', esc_url( graphy_fonts_url() ), array(), null );
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.4.1' );
	wp_enqueue_style( 'normalize', get_template_directory_uri() . '/css/normalize.css',  array(), '4.1.1' );
	wp_enqueue_style( 'graphy-style', get_stylesheet_uri(), array(), '2.0.4' );
	if ( 'ja' == get_bloginfo( 'language' ) ) {
		wp_enqueue_style( 'graphy-style-ja', get_template_directory_uri() . '/css/ja.css', array(), null );
	}

	wp_enqueue_script( 'graphy-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20160525', true );
	if ( ! get_theme_mod( 'graphy_hide_navigation' ) ) {
		wp_enqueue_script( 'graphy-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20160525', true );
		wp_enqueue_script( 'double-tap-to-go', get_template_directory_uri() . '/js/doubletaptogo.min.js', array( 'jquery' ), '1.0.0', true );
	}
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	wp_enqueue_script( 'graphy-functions', get_template_directory_uri() . '/js/functions.js', array(), '20160822', true );
}
add_action( 'wp_enqueue_scripts', 'graphy_scripts' );

/**
 * Add customizer style to the header.
 */
function graphy_customizer_css() {
	?>
	<style type="text/css">
		/* Colors */
		<?php if ( $graphy_link_color = get_theme_mod( 'graphy_link_color' ) ) : ?>
		.entry-content a, .entry-summary a, .page-content a, .author-profile-description a, .comment-content a, .main-navigation .current_page_item > a, .main-navigation .current-menu-item > a {
			color: <?php echo esc_attr( $graphy_link_color ); ?>;
		}
		<?php endif; ?>
		<?php if ( $graphy_link_hover_color = get_theme_mod( 'graphy_link_hover_color' ) ) : ?>
		.main-navigation a:hover, .entry-content a:hover, .entry-summary a:hover, .page-content a:hover, .author-profile-description a:hover, .comment-content a:hover {
			color: <?php echo esc_attr( $graphy_link_hover_color ); ?>;
		}
		<?php endif; ?>

		<?php if ( get_theme_mod( 'graphy_logo' ) ) : ?>
		/* Logo */
			.site-logo {
				<?php if ( $graphy_logo_margin_top = get_theme_mod( 'graphy_top_margin' ) ) : ?>
				margin-top: <?php echo esc_attr( $graphy_logo_margin_top ); ?>px;
				<?php endif; ?>
				<?php if ( $graphy_logo_margin_bottom = get_theme_mod( 'graphy_bottom_margin' ) ) : ?>
				margin-bottom: <?php echo esc_attr( $graphy_logo_margin_bottom ); ?>px;
				<?php endif; ?>
			}
			<?php if ( get_theme_mod( 'graphy_add_border_radius' ) ) : ?>
				.site-logo img {
					border-radius: 50%;
				}
			<?php endif; ?>
		<?php endif; ?>
	</style>
	<?php
}
add_action( 'wp_head', 'graphy_customizer_css' );

/**
 * Add custom classes to the body.
 */
function graphy_body_classes( $classes ) {
	if ( is_page_template( 'fullwidth.php' ) ) {
		$classes[] = 'full-width';
	} elseif ( ! is_active_sidebar( 'sidebar' ) || is_page_template( 'nosidebar.php' ) || is_404() ) {
		$classes[] = 'no-sidebar';
	} else {
		$classes[] = 'has-sidebar';
	}

	$footer_widgets = 0;
	$footer_widgets_max = 4;
	for( $i = 1; $i <= $footer_widgets_max; $i++ ) {
		if ( is_active_sidebar( 'footer-' . $i ) ) {
				$footer_widgets++;
		}
	}
	$classes[] = 'footer-' . $footer_widgets;

	if ( get_option( 'show_avatars' ) ) {
		$classes[] = 'has-avatars';
	}

	return $classes;
}
add_filter( 'body_class', 'graphy_body_classes' );

/**
 * Add social links on profile
 */
function graphy_modify_user_contact_methods( $user_contact ) {
	$user_contact['social_1'] = esc_html__( 'Social Link 1', 'graphy' );
	$user_contact['social_2'] = esc_html__( 'Social Link 2', 'graphy' );
	$user_contact['social_3'] = esc_html__( 'Social Link 3', 'graphy' );
	$user_contact['social_4'] = esc_html__( 'Social Link 4', 'graphy' );
	$user_contact['social_5'] = esc_html__( 'Social Link 5', 'graphy' );
	$user_contact['social_6'] = esc_html__( 'Social Link 6', 'graphy' );
	$user_contact['social_7'] = esc_html__( 'Social Link 7', 'graphy' );

	return $user_contact;
}
add_filter( 'user_contactmethods', 'graphy_modify_user_contact_methods' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom widgets for this theme.
 */
require get_template_directory() . '/inc/widgets.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


apply_filters( 'override_load_textdomain', true, 'graphy', get_template_directory() . '/languages/de_DE.mo' );