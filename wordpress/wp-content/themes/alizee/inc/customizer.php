<?php
/**
 * Alizee Theme Customizer
 *
 * @package Alizee
 */


function alizee_customize_register( $wp_customize ) {
	/**
	 * Add postMessage support for site title and description for the Theme Customizer.
	 */	
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->remove_control('header_textcolor');


	//___General___//
    $wp_customize->add_section(
        'alizee_general',
        array(
            'title' => __('General', 'alizee'),
            'priority' => 9,
        )
    );
	//Logo Upload
	$wp_customize->add_setting(
		'site_logo',
		array(
			'default-image' => '',
		)
	);
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'site_logo',
            array(
               'label'          => __( 'Upload your logo', 'alizee' ),
			   'type' 			=> 'image',
               'section'        => 'alizee_general',
               'settings'       => 'site_logo',
            )
        )
    );
	//Favicon Upload
	$wp_customize->add_setting(
		'site_favicon',
		array(
			'default-image' => '',
		)
	);
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'site_favicon',
            array(
               'label'          => __( 'Upload your favicon', 'alizee' ),
			   'type' 			=> 'image',
               'section'        => 'alizee_general',
               'settings'       => 'site_favicon',
            )
        )
    );
	$wp_customize->add_setting(
		'alizee_scroller',
		array(
			'sanitize_callback' => 'alizee_sanitize_checkbox',
			'default' => 0,			
		)		
	);
	$wp_customize->add_control(
		'alizee_scroller',
		array(
			'type' => 'checkbox',
			'label' => __('Check this box if you want to disable the custom scroller.', 'alizee'),
			'section' => 'alizee_general',
            'priority' => 9,			
		)
	);          
	//___Layout___//
    $wp_customize->add_section(
        'alizee_layout',
        array(
            'title' => __('Home layout', 'alizee'),
	        'description' => __('The layout choices below refer to the number of displayed columns on the home page, when your website is viewed on a desktop. Because the theme is responsive and the Customizer takes some space, you need to collapse this panel in order to see how your chosen layout really looks like in full width.', 'alizee'),            
            'priority' => 11,
        )
    );     
	$wp_customize->add_setting(
	    'home_layout',
	    array(
	        'default' => 'three_col',
	        'sanitize_callback' => 'alizee_sanitize_layout',
	    )
	);
	$wp_customize->add_control(
	    'home_layout',
	    array(
	        'type' => 'radio',
	        'label' => __('Home layout', 'alizee'),
	        'section' => 'alizee_layout',
	        'choices' => array(
	            'one_col' => 'One column',
	            'two_col' => 'Two columns',
	            'three_col' => 'Three columns',
	            'four_col' => 'Four columns',
	        ),
	    )
	);
	//___Single posts___//
    $wp_customize->add_section(
        'alizee_singles',
        array(
            'title' => __('Single posts/pages', 'alizee'),
            'priority' => 13,
        )
    );
	//Single posts
	$wp_customize->add_setting(
		'alizee_post_img',
		array(
			'sanitize_callback' => 'alizee_sanitize_checkbox',
		)		
	);
	$wp_customize->add_control(
		'alizee_post_img',
		array(
			'type' => 'checkbox',
			'label' => __('Check this box to show featured images on single posts', 'alizee'),
			'section' => 'alizee_singles',
		)
	);
	//Pages
	$wp_customize->add_setting(
		'alizee_page_img',
		array(
			'sanitize_callback' => 'alizee_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'alizee_page_img',
		array(
			'type' => 'checkbox',
			'label' => __('Check this box to show featured images on pages', 'alizee'),
			'section' => 'alizee_singles',
		)
	);
	//Author bio
	$wp_customize->add_setting(
		'author_bio',
		array(
			'sanitize_callback' => 'alizee_sanitize_checkbox',
		)		
	);
	$wp_customize->add_control(
		'author_bio',
		array(
			'type' => 'checkbox',
			'label' => __('Check this box to display the author bio on single posts. You can add your author bio and social links on the Users screen in the Your Profile section.', 'alizee'),
			'section' => 'alizee_singles',
		)
	);
	//___Colors___//
	//Menu background
	$wp_customize->add_setting(
		'menu_color',
		array(
			'default'			=> '#3C3C3C',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'menu_color_color',
			array(
				'label' => __('Menu background (opacity is added automatically)', 'alizee'),
				'section' => 'colors',
				'settings' => 'menu_color',
				'priority' => 11
			)
		)
	);	
	//Primary color
	$wp_customize->add_setting(
		'primary_color',
		array(
			'default'			=> '#FBB829',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'			=> 'postMessage'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'primary_color',
			array(
				'label' => __('Primary color', 'alizee'),
				'section' => 'colors',
				'settings' => 'primary_color',
				'priority' => 12
			)
		)
	);
	//Header background
	$wp_customize->add_setting(
		'header_color',
		array(
			'default'			=> '#3c3c3c',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'			=> 'postMessage'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'header_color',
			array(
				'label' => __('Header background', 'alizee'),
				'section' => 'colors',
				'settings' => 'header_color',
				'priority' => 13
			)
		)
	);	
	//Site title
	$wp_customize->add_setting(
		'site_title_color',
		array(
			'default'			=> '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'			=> 'postMessage'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'site_title_color',
			array(
				'label' => __('Site title', 'alizee'),
				'section' => 'colors',
				'settings' => 'site_title_color',
				'priority' => 14
			)
		)
	);
	//Site description
	$wp_customize->add_setting(
		'site_desc_color',
		array(
			'default'			=> '#b9b9b9',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'			=> 'postMessage'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'site_desc_color',
			array(
				'label' => __('Site description', 'alizee'),
				'section' => 'colors',
				'settings' => 'site_desc_color',
				'priority' => 15
			)
		)
	);
	//Entry title
	$wp_customize->add_setting(
		'entry_title_color',
		array(
			'default'			=> '#505050',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'			=> 'postMessage'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'entry_title_color',
			array(
				'label' => __('Entry title', 'alizee'),
				'section' => 'colors',
				'settings' => 'entry_title_color',
				'priority' => 16
			)
		)
	);	
	//Body
	$wp_customize->add_setting(
		'body_text_color',
		array(
			'default'			=> '#868686',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'			=> 'postMessage'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'body_text_color',
			array(
				'label' => __('Text', 'alizee'),
				'section' => 'colors',
				'settings' => 'body_text_color',
				'priority' => 17
			)
		)
	);
	//Footer
	$wp_customize->add_setting(
		'footer_color',
		array(
			'default'			=> '#3c3c3c',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'			=> 'postMessage'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'footer_color',
			array(
				'label' => __('Footer background', 'alizee'),
				'section' => 'colors',
				'settings' => 'footer_color',
				'priority' => 18
			)
		)
	);
	//___Fonts___//
    $wp_customize->add_section(
        'alizee_typography',
        array(
            'title' => __('Fonts', 'alizee' ),
            'priority' => 15,
        )
    );
	$font_choices = 
		array(
			'Source Sans Pro:400,700,400italic,700italic' => 'Source Sans Pro',		
			'Droid Sans:400,700' => 'Droid Sans',
			'Lato:400,700,400italic,700italic' => 'Lato',
			'Arvo:400,700,400italic,700italic' => 'Arvo',
			'Lora:400,700,400italic,700italic' => 'Lora',
			'PT Sans:400,700,400italic,700italic' => 'PT Sans',
			'PT+Sans+Narrow:400,700' => 'PT Sans Narrow',
			'Arimo:400,700,400italic,700italic' => 'Arimo',
			'Ubuntu:400,700,400italic,700italic' => 'Ubuntu',
			'Bitter:400,700,400italic' => 'Bitter',
			'Droid Serif:400,700,400italic,700italic' => 'Droid Serif',
			'Open+Sans:400italic,700italic,400,700' => 'Open Sans',
			'Roboto:400,400italic,700,700italic' => 'Roboto',
			'Oswald:400,700' => 'Oswald',
			'Open Sans Condensed:700,300italic,300' => 'Open Sans Condensed',
			'Roboto Condensed:400italic,700italic,400,700' => 'Roboto Condensed',
			'Raleway:400,700' => 'Raleway',
			'Roboto Slab:400,700' => 'Roboto Slab',
			'Yanone Kaffeesatz:400,700' => 'Yanone Kaffeesatz',
			'Rokkitt:400' => 'Rokkitt',
		);
	
	$wp_customize->add_setting(
		'headings_fonts',
		array(
			'sanitize_callback' => 'alizee_sanitize_fonts',
		)
	);
	
	$wp_customize->add_control(
		'headings_fonts',
		array(
			'type' => 'select',
			'label' => __('Select your desired font for the headings.', 'alizee'),
			'section' => 'alizee_typography',
			'choices' => $font_choices
		)
	);
	
	$wp_customize->add_setting(
		'body_fonts',
		array(
			'sanitize_callback' => 'alizee_sanitize_fonts',
		)
	);
	
	$wp_customize->add_control(
		'body_fonts',
		array(
			'type' => 'select',
			'label' => __('Select your desired font for the body.', 'alizee'),
			'section' => 'alizee_typography',
			'choices' => $font_choices
		)
	);		

}
add_action( 'customize_register', 'alizee_customize_register' );

/**
 * Sanitization
 */
//Checkboxes
function alizee_sanitize_checkbox( $input ) {
	if ( $input == 1 ) {
		return 1;
	} else {
		return '';
	}
}
//Radio layout
function alizee_sanitize_layout( $input ) {
    $valid = array(
	            'one_col' => 'One column',
	            'two_col' => 'Two columns',
	            'three_col' => 'Three columns',
	            'four_col' => 'Four columns',
    );
 
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}
//Fonts
function alizee_sanitize_fonts( $input ) {
    $valid = array(
			'Source Sans Pro:400,700,400italic,700italic' => 'Source Sans Pro',		
			'Droid Sans:400,700' => 'Droid Sans',
			'Lato:400,700,400italic,700italic' => 'Lato',
			'Arvo:400,700,400italic,700italic' => 'Arvo',
			'Lora:400,700,400italic,700italic' => 'Lora',
			'PT Sans:400,700,400italic,700italic' => 'PT Sans',
			'PT+Sans+Narrow:400,700' => 'PT Sans Narrow',
			'Arimo:400,700,400italic,700italic' => 'Arimo',
			'Ubuntu:400,700,400italic,700italic' => 'Ubuntu',
			'Bitter:400,700,400italic' => 'Bitter',
			'Droid Serif:400,700,400italic,700italic' => 'Droid Serif',
			'Open+Sans:400italic,700italic,400,700' => 'Open Sans',
			'Roboto:400,400italic,700,700italic' => 'Roboto',
			'Oswald:400,700' => 'Oswald',
			'Open Sans Condensed:700,300italic,300' => 'Open Sans Condensed',
			'Roboto Condensed:400italic,700italic,400,700' => 'Roboto Condensed',
			'Raleway:400,700' => 'Raleway',
			'Roboto Slab:400,700' => 'Roboto Slab',
			'Yanone Kaffeesatz:400,700' => 'Yanone Kaffeesatz',
			'Rokkitt:400' => 'Rokkitt',
    );
 
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function alizee_customize_preview_js() {
	wp_enqueue_script( 'alizee_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), true );
}
add_action( 'customize_preview_init', 'alizee_customize_preview_js' );
