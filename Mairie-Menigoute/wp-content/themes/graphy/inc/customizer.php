<?php
/**
 * Graphy Theme Customizer
 *
 * @package Graphy
 */

/**
 * Set the Customizer
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function graphy_customize_register( $wp_customize ) {

	class Graphy_Read_Me extends WP_Customize_Control {
		public function render_content() {
			?>
			<div class="graphy-read-me">
				<p><?php esc_html_e( 'Thank you for using the Graphy theme.', 'graphy' ); ?></p>
				<h3><?php esc_html_e( 'Documentation', 'graphy' ); ?></h3>
				<p class="graphy-read-me-text"><?php esc_html_e( 'For instructions on theme configuration, please see the documentation.', 'graphy' ); ?></p>
				<p class="graphy-read-me-link"><a href="<?php echo esc_url( __( 'http://themegraphy.com/documents/graphy/', 'graphy' ) ); ?>" target="_blank"><?php esc_html_e( 'Theme Documentation', 'graphy' ); ?></a></p>
				<h3><?php esc_html_e( 'Support', 'graphy' ); ?></h3>
				<p class="graphy-read-me-text"><?php esc_html_e( 'If there is something you don\'t understand even after reading the documentation, please use the support forum.', 'graphy' ); ?></p>
				<p class="graphy-read-me-link"><a href="<?php echo esc_url( __( 'https://wordpress.org/support/theme/graphy', 'graphy' ) ); ?>" target="_blank"><?php esc_html_e( 'Support Forum', 'graphy' ); ?></a></p>
				<h3><?php esc_html_e( 'Review', 'graphy' ); ?></h3>
				<p class="graphy-read-me-text"><?php esc_html_e( 'If you are satisfied with the theme, we would greatly appreciate if you would review it.', 'graphy' ); ?></p>
				<p class="graphy-read-me-link"><a href="<?php echo esc_url( __( 'https://wordpress.org/support/view/theme-reviews/graphy?filter=5', 'graphy' ) ); ?>" target="_blank"><?php esc_html_e( 'Review This Theme', 'graphy' ); ?></a></p>
				<h3><?php esc_html_e( 'Upgrade', 'graphy' ); ?></h3>
				<p class="graphy-read-me-text"><?php esc_html_e( 'If you would like even more features and/or 1-on-1 personal support, it is recommended you upgrade to Graphy Pro.', 'graphy' ); ?></p>
				<p class="graphy-read-me-link"><a href="<?php echo esc_url( __( 'http://themegraphy.com/wordpress-themes/graphy/#pro', 'graphy' ) ); ?>" target="_blank"><?php esc_html_e( 'Graphy Pro', 'graphy' ); ?></a></p>
			</div>
			<?php
		}
	}

	class Graphy_Upgrade extends WP_Customize_Control {
		public function render_content() {
			esc_html_e( 'To use this feature, please upgrade to Graphy Pro.', 'graphy' );
		}
	}

	// Site Identity
	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
	$wp_customize->add_setting( 'graphy_hide_blogdescription', array(
		'default'           => '',
		'sanitize_callback' => 'graphy_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'graphy_hide_blogdescription', array(
		'label'   => esc_html__( 'Hide Tagline', 'graphy' ),
		'section' => 'title_tagline',
		'type'    => 'checkbox',
	) );

	// READ ME
	$wp_customize->add_section( 'graphy_read_me', array(
		'title'    => esc_html__( 'READ ME', 'graphy' ),
		'priority' => 1,
	) );
	$wp_customize->add_setting( 'graphy_read_me_text', array(
		'default'           => '',
		'sanitize_callback' => 'graphy_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Graphy_Read_Me( $wp_customize, 'graphy_read_me_text', array(
		'section'  => 'graphy_read_me',
		'priority' => 1,
	) ) );

	// Fonts
	$wp_customize->add_section( 'graphy_fonts', array(
		'title'       => esc_html__( 'Fonts', 'graphy' ),
		'description' => esc_html__( 'You can set the header and body text to a variety of fonts.', 'graphy' ),
		'priority'    => 30,
	) );
	$wp_customize->add_setting( 'graphy_fonts_text', array(
		'default'           => '',
		'sanitize_callback' => 'graphy_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Graphy_Upgrade( $wp_customize, 'graphy_fonts_text', array(
		'section'  => 'graphy_fonts',
		'priority' => 1,
	) ) );

	// Colors
	$wp_customize->get_section( 'colors' )->priority     = 35;
	$wp_customize->add_setting( 'graphy_link_color' , array(
		'default'   => '#a62425',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'graphy_link_color', array(
		'label'    => esc_html__( 'Link Color', 'graphy' ),
		'section'  => 'colors',
		'priority' => 13,
	) ) );
	$wp_customize->add_setting( 'graphy_link_hover_color' , array(
		'default'           => '#b85051',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'graphy_link_hover_color', array(
		'label'    => esc_html__( 'Link Hover Color', 'graphy' ),
		'section'  => 'colors',
		'priority' => 14,
	) ) );

	// Title
	$wp_customize->add_section( 'graphy_title', array(
		'title'       => esc_html__( 'Title', 'graphy' ),
		'description' => esc_html__( 'You can set the title font.', 'graphy' ),
		'priority'    => 50,
	) );
	$wp_customize->add_setting( 'graphy_title_text', array(
		'default'           => '',
		'sanitize_callback' => 'graphy_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Graphy_Upgrade( $wp_customize, 'graphy_title_text', array(
		'section'  => 'graphy_title',
		'priority' => 1,
	) ) );

	// Logo
	$wp_customize->add_section( 'graphy_logo', array(
		'title'       => esc_html__( 'Logo', 'graphy' ),
		'description' => esc_html__( 'In order to use a retina logo image, you must have a version of your logo that is doubled in size.', 'graphy' ),
		'priority'    => 55,
	) );
	$wp_customize->add_setting( 'graphy_logo', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw'
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'graphy_logo', array(
		'label'    => esc_html__( 'Upload Logo', 'graphy' ),
		'section'  => 'graphy_logo',
		'priority' => 11,
	) ) );
	$wp_customize->add_setting( 'graphy_replace_blogname', array(
		'default'           => '',
		'sanitize_callback' => 'graphy_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'graphy_replace_blogname', array(
		'label'    => esc_html__( 'Replace Title', 'graphy' ),
		'section'  => 'graphy_logo',
		'type'     => 'checkbox',
		'priority' => 12,
	) );
	$wp_customize->add_setting( 'graphy_retina_logo', array(
		'default'           => '',
		'sanitize_callback' => 'graphy_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'graphy_retina_logo', array(
		'label'    => esc_html__( 'Retina Ready', 'graphy' ),
		'section'  => 'graphy_logo',
		'type'     => 'checkbox',
		'priority' => 13,
	) );
	$wp_customize->add_setting( 'graphy_add_border_radius', array(
		'default'           => '',
		'sanitize_callback' => 'graphy_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'graphy_add_border_radius', array(
		'label'    => esc_html__( 'Add Border Radius', 'graphy' ),
		'section'  => 'graphy_logo',
		'type'     => 'checkbox',
		'priority' => 14,
	) );
	$wp_customize->add_setting( 'graphy_top_margin', array(
		'default'           => '0',
		'sanitize_callback' => 'graphy_sanitize_margin',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'graphy_top_margin', array(
		'label'    => esc_html__( 'Margin Top (px)', 'graphy' ),
		'section'  => 'graphy_logo',
		'type'     => 'text',
		'priority' => 15,
	));
	$wp_customize->add_setting( 'graphy_bottom_margin', array(
		'default'           => '0',
		'sanitize_callback' => 'graphy_sanitize_margin',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'graphy_bottom_margin', array(
		'label'    => esc_html__( 'Margin Bottom (px)', 'graphy' ),
		'section'  => 'graphy_logo',
		'type'     => 'text',
		'priority' => 16,
	));

	// Featured Posts
	$wp_customize->add_section( 'graphy_featured', array(
		'title'       => esc_html__( 'Featured Posts', 'graphy' ),
		'description' => esc_html__( 'You can set the posts that will be featured on the homepage slider as well as in the Graphy Featured Posts widget.', 'graphy' ),
		'priority'    => 75,
	) );
	$wp_customize->add_setting( 'graphy_featured_text', array(
		'default'           => '',
		'sanitize_callback' => 'graphy_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Graphy_Upgrade( $wp_customize, 'graphy_featured_text', array(
		'section'  => 'graphy_featured',
		'priority' => 1,
	) ) );

	// Posts
	$wp_customize->add_section( 'graphy_post', array(
		'title'       => esc_html__( 'Post Display', 'graphy' ),
		'description' => esc_html__( 'You can set how posts are displayed on the blog posts index page. You can also hide elements such as categories, date, author name, comments number, featured image, author profile, and post navigation.', 'graphy' ),
		'priority'    => 80,
	) );
	$wp_customize->add_setting( 'graphy_post_text', array(
		'default'           => '',
		'sanitize_callback' => 'graphy_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Graphy_Upgrade( $wp_customize, 'graphy_post_text', array(
		'section'  => 'graphy_post',
		'priority' => 1,
	) ) );

	// Category Colors
	$wp_customize->add_section( 'graphy_category_colors', array(
		'title'       => esc_html__( 'Category Colors', 'graphy' ),
		'description' => esc_html__( 'You can set the colors for various categories.', 'graphy' ),
		'priority'    => 85,
	) );
	$wp_customize->add_setting( 'graphy_category_colors_text', array(
		'default'           => '',
		'sanitize_callback' => 'graphy_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Graphy_Upgrade( $wp_customize, 'graphy_category_colors_text', array(
		'section'  => 'graphy_category_colors',
		'priority' => 1,
	) ) );

	// Footer
	$wp_customize->add_section( 'graphy_footer', array(
		'title'       => esc_html__( 'Footer', 'graphy' ),
		'description' => esc_html__( 'You can set the footer text and hide the theme credits from here.', 'graphy' ),
		'priority'    => 90,
	) );
	$wp_customize->add_setting( 'graphy_footer_text', array(
		'default'           => '',
		'sanitize_callback' => 'graphy_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Graphy_Upgrade( $wp_customize, 'graphy_footer_text', array(
		'section'  => 'graphy_footer',
		'priority' => 1,
	) ) );

	// Custom CSS
	$wp_customize->add_section( 'graphy_custom_css', array(
		'title'       => esc_html__( 'Custom CSS', 'graphy' ),
		'description' => esc_html__( 'You can set custom CSS or Google Fonts.', 'graphy' ),
		'priority'    => 95,
	) );
	$wp_customize->add_setting( 'graphy_custom_css_text', array(
		'default'           => '',
		'sanitize_callback' => 'graphy_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Graphy_Upgrade( $wp_customize, 'graphy_custom_css_text', array(
		'section'  => 'graphy_custom_css',
		'priority' => 1,
	) ) );

	// Menus
	$wp_customize->add_setting( 'graphy_hide_navigation', array(
		'default'           => '',
		'sanitize_callback' => 'graphy_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'graphy_hide_navigation', array(
		'label'    => esc_html__( 'Hide Main Navigation', 'graphy' ),
		'section'  => 'menu_locations',
		'type'     => 'checkbox',
		'priority' => 1,
	) );
	$wp_customize->add_setting( 'graphy_hide_search', array(
		'default'           => '',
		'sanitize_callback' => 'graphy_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'graphy_hide_search', array(
		'label'    => esc_html__( 'Hide Search on Main Navigation', 'graphy' ),
		'section'  => 'menu_locations',
		'type'     => 'checkbox',
		'priority' => 2,
	) );
}
add_action( 'customize_register', 'graphy_customize_register' );

/**
 * Sanitize user inputs.
 */
function graphy_sanitize_checkbox( $value ) {
	if ( $value == 1 ) {
		return 1;
	} else {
		return '';
	}
}
function graphy_sanitize_margin( $value ) {
	if ( preg_match("/^-?[0-9]+$/", $value) ) {
		return $value;
	} else {
		return '0';
	}
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function graphy_customize_preview_js() {
	wp_enqueue_script( 'graphy_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20160603', true );
}
add_action( 'customize_preview_init', 'graphy_customize_preview_js' );

/**
 * Enqueue Customizer CSS
 */
function graphy_customizer_style() {
	wp_enqueue_style( 'graphy-customizer-style', get_template_directory_uri() . '/css/customizer.css', array() );
}
add_action( 'customize_controls_print_styles', 'graphy_customizer_style');

/**
 * Enqueue Customizer JS
 */
function graphy_customizer_js() {
	wp_enqueue_script( 'graphy-customizer-js', get_template_directory_uri() . '/js/customizer-js.js', array( 'jquery' ), '20160603', true);
	wp_localize_script( 'graphy-customizer-js', 'graphy_customizer_links', array(
		'url' => esc_url( __( 'http://themegraphy.com/wordpress-themes/graphy/#pro', 'graphy' ) ),
		'label' => esc_html__( 'Upgrade to Graphy Pro', 'graphy' ),
	));
}
add_action( 'customize_controls_enqueue_scripts', 'graphy_customizer_js' );

