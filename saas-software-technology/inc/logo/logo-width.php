<?php
/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function saas_software_technology_logo_customize_register( $wp_customize ) {
	// Logo Resizer additions
	$wp_customize->add_setting( 'logo_width', array(
		'default'              => 25,
		'type'                 => 'theme_mod',
		'theme_supports'       => 'custom-logo',
		'transport'            => 'refresh',
		'sanitize_callback'    => 'absint',
		'sanitize_js_callback' => 'absint',
	) );

	$wp_customize->add_control( 'logo_width', array(
		'label'       => esc_html__( 'Logo Width','saas-software-technology' ),
		'section'     => 'title_tagline',
		'priority'    => 9,
		'type'        => 'number',
		'settings'    => 'logo_width',
		'input_attrs' => array(
			'step'             => 5,
			'min'              => 0,
			'max'              => 100,
			'aria-valuemin'    => 0,
			'aria-valuemax'    => 100,
			'aria-valuenow'    => 25,
			'aria-orientation' => 'horizontal',
		),
	) );

	$wp_customize->add_setting('saas_software_technology_site_title',array(
       'default' => 'true',
       'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('saas_software_technology_site_title',array(
	   'type' => 'checkbox',
	   'label' => __('Show / Hide Site Title','saas-software-technology'),
	   'section' => 'title_tagline',
	));

    $wp_customize->add_setting( 'saas_software_technology_site_title_color_setting', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'saas_software_technology_site_title_color_setting', array(
  		'label' => __('Site Title Color Option', 'saas-software-technology'),
		'section' => 'title_tagline',
		'settings' => 'saas_software_technology_site_title_color_setting',
  	)));

	$wp_customize->add_setting('saas_software_technology_site_title_fontsize',array(
		'default'=> '',
		'sanitize_callback'	=> 'saas_software_technology_sanitize_float'
	));
	$wp_customize->add_control('saas_software_technology_site_title_fontsize',array(
		'label'	=> __('Site Title Font Size','saas-software-technology'),
		'input_attrs' => array(
            'step' => 1,
			'min'  => 0,
			'max'  => 100,
        ),
		'section'=> 'title_tagline',
		'type'=> 'number',
	));

	$wp_customize->add_setting('saas_software_technology_site_tagline',array(
       'default' => 'false',
       'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('saas_software_technology_site_tagline',array(
	   'type' => 'checkbox',
	   'label' => __('Show / Hide Site Description','saas-software-technology'), 
	   'section' => 'title_tagline',
	));

	$wp_customize->add_setting('saas_software_technology_site_description_fontsize',array(
		'default'=> '',
		'sanitize_callback'	=> 'saas_software_technology_sanitize_float'
	));
	$wp_customize->add_control('saas_software_technology_site_description_fontsize',array(
		'label'	=> __('Site Description Font Size','saas-software-technology'),
		'input_attrs' => array(
            'step' => 1,
			'min'  => 0,
			'max'  => 100,
        ),
		'section'=> 'title_tagline',
		'type'=> 'number',
	));

	$wp_customize->add_setting( 'saas_software_technology_tagline_color_setting', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'saas_software_technology_tagline_color_setting', array(
  		'label' => __('Site Description Color Option', 'saas-software-technology'),
		'section' => 'title_tagline',
		'settings' => 'saas_software_technology_tagline_color_setting',
  	)));
}
add_action( 'customize_register', 'saas_software_technology_logo_customize_register' );

/**
 * Add support for logo resizing by filtering `get_custom_logo`
 */
function saas_software_technology_customize_logo_resize( $html ) {
	$size = get_theme_mod( 'logo_width', '25' );
	$custom_logo_id = get_theme_mod( 'custom_logo' );
	// set the short side minimum
	$min = 48;

	// don't use empty() because we can still use a 0
	if ( is_numeric( $size ) && is_numeric( $custom_logo_id ) ) {

		// we're looking for $img['width'] and $img['height'] of original image
		$logo = wp_get_attachment_metadata( $custom_logo_id );
		if ( ! $logo ) return $html;

		// get the logo support size
		$sizes = get_theme_support( 'custom-logo' );

		// Check for max height and width, default to image sizes if none set in theme
		$max['height'] = isset( $sizes[0]['height'] ) ? $sizes[0]['height'] : $logo['height'];
		$max['width'] = isset( $sizes[0]['width'] ) ? $sizes[0]['width'] : $logo['width'];

		// landscape or square
		if ( $logo['width'] >= $logo['height'] ) {
			$output = saas_software_technology_min_max( $logo['height'], $logo['width'], $max['height'], $max['width'], $size, $min );
			$img = array(
				'height'	=> $output['short'],
				'width'		=> $output['long']
			);
		// portrait
		} else if ( $logo['width'] < $logo['height'] ) {
			$output = saas_software_technology_min_max( $logo['width'], $logo['height'], $max['width'], $max['height'], $size, $min );
			$img = array(
				'height'	=> $output['long'],
				'width'		=> $output['short']
			);
		}

		// add the CSS
		$css = '
			<style>
			.custom-logo {
				height: ' . $img['height'] . 'px;
				max-height: ' . $max['height'] . 'px;
				max-width: ' . $max['width'] . 'px;
				width: ' . $img['width'] . 'px;
			}
			</style>';

		$html = $css . $html;
	}

	return $html;
}
add_filter( 'get_custom_logo', 'saas_software_technology_customize_logo_resize' );

/* Helper function to determine the max size of the logo */
function saas_software_technology_min_max( $short, $long, $short_max, $long_max, $percent, $min ){
	$ratio = ( $long / $short );
	$max['long'] = ( $long_max >= $long ) ? $long : $long_max;
	$max['short'] = ( $short_max >= ( $max['long'] / $ratio ) ) ? floor( $max['long'] / $ratio ) : $short_max;

	$ppp = ( $max['short'] - $min ) / 100;

	$size['short'] = round( $min + ( $percent * $ppp ) );
	$size['long'] = round( $size['short'] / ( $short / $long ) );

	return $size;
}

/**
 * JS handlers for Customizer Controls
 */
function saas_software_technology_customize_controls_js() {
	wp_enqueue_script( 'saas-software-technology-customizer-controls', esc_url(get_template_directory_uri()) . '/inc/logo/js/customize-controls.js', array( 'jquery', 'customize-preview' ), '201709071000', true );
}
add_action( 'customize_controls_enqueue_scripts', 'saas_software_technology_customize_controls_js' );

/**
 * Adds CSS to the Customizer controls.
 */
function saas_software_technology_customize_css() {
	wp_add_inline_style( 'customize-controls', '#customize-control-logo_size input[type=range] { width: 100%; }' );
}
add_action( 'customize_controls_enqueue_scripts', 'saas_software_technology_customize_css' );

/**
 * Testing function to remove logo_width theme mod
 */
function saas_software_technology_remove_theme_mod() {
	if ( isset( $_GET['remove_logo_size'] ) && 'true' == $_GET['remove_logo_size'] ){
		set_theme_mod( 'logo_width', '' );
	}
}
add_action( 'wp_loaded', 'saas_software_technology_remove_theme_mod' );