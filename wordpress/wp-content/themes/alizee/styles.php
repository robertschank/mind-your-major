<?php

//Converts hex colors to rgba for the menu background color - credits @ http://mekshq.com/how-to-convert-hexadecimal-color-code-to-rgb-or-rgba-using-php/
function alizee_hex2rgba($color, $opacity = false) {

        if ($color[0] == '#' ) {
        	$color = substr( $color, 1 );
        }
        $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        $rgb =  array_map('hexdec', $hex);
        $opacity = 0.8;
        $output = 'rgba('.implode(",",$rgb).','.$opacity.')';

        return $output;
}

//Dynamic styles
function alizee_custom_styles($custom) {
	//Primary color
	$primary_color = esc_html(get_theme_mod( 'primary_color' ));
	if ( isset($primary_color) && ( $primary_color != '#FBB829' ) ) {
		$custom = ".main-navigation a, .social-navigation li a, .entry-title a:hover, .widget-title, .widgettitle, .social-widget li a::before, .author-social a, .view-all, .view-all a { color: {$primary_color}; }"."\n";
		$custom .= ".main-navigation li:hover, .post-navigation .nav-previous, .post-navigation .nav-next, .paging-navigation .nav-previous, .paging-navigation .nav-next, #today, .tagcloud a, .entry-thumb, .comment-respond input[type=\"submit\"], .cat-link, .search-submit { background-color: {$primary_color}; }"."\n";
		$custom .= ".widget-title, .widgettitle, .entry-thumb, .author-name, .site-header, .page-header, blockquote { border-color: {$primary_color}; }"."\n";
		$custom .= ".sidebar-toggle { border-right-color: {$primary_color}; }"."\n";
		$custom .= ".social-toggle { border-left-color: {$primary_color}; }"."\n";
	}
	//Site title
	$site_title = esc_html(get_theme_mod( 'site_title_color' ));
	if ( isset($site_title) && ( $site_title != '#fff' )) {
		$custom .= ".site-title a { color: {$site_title}; }"."\n";
	}
	//Site description
	$site_desc = esc_html(get_theme_mod( 'site_desc_color' ));
	if ( isset($site_desc) && ( $site_desc != '#B9B9B9' )) {
		$custom .= ".site-description { color: {$site_desc}; }"."\n";
	}	
	//Entry title
	$entry_title = esc_html(get_theme_mod( 'entry_title_color' ));
	if ( isset($entry_title) && ( $entry_title != '#505050' )) {
		$custom .= ".entry-title, .entry-title a { color: {$entry_title}; }"."\n";
	}
	//Body text
	$body_text = esc_html(get_theme_mod( 'body_text_color' ));
	if ( isset($body_text) && ( $body_text != '#868686' )) {
		$custom .= "body { color: {$body_text}; }"."\n";
	}
	//Menu background
	$menu_color = esc_html(get_theme_mod( 'menu_color', '#3C3C3C' ));
	$rgba = alizee_hex2rgba($menu_color, 0.8);
	if ( isset($menu_color) && ($menu_color != '#3C3C3C') ) {
		$custom .= ".main-navigation, .main-navigation ul ul { background-color: {$rgba}; }"."\n";
	}
	//Header background
	$header_bg = esc_html(get_theme_mod( 'header_color' ));
	if ( isset($header_bg) && ( $header_bg != '#3c3c3c' )) {
		$custom .= ".site-header { background-color: {$header_bg}; }"."\n";
	}
	//Footer background
	$footer_bg = esc_html(get_theme_mod( 'footer_color' ));
	if ( isset($footer_bg) && ( $footer_bg != '#3c3c3c' )) {
		$custom .= ".footer-widget-area, .site-info { background-color: {$footer_bg}; }"."\n";
	}		
	
	//Fonts
	$headings_font = esc_html(get_theme_mod('headings_fonts'));	
	$body_font = esc_html(get_theme_mod('body_fonts'));	
	
	if ( $headings_font ) {
		$font_pieces = explode(":", $headings_font);
		$custom .= "h1, h2, h3, h4, h5, h6 { font-family: {$font_pieces[0]}; }"."\n";
	}
	if ( $body_font ) {
		$font_pieces = explode(":", $body_font);
		$custom .= "body { font-family: {$font_pieces[0]}; }"."\n";
	}
	
	//Output all the styles
	wp_add_inline_style( 'alizee-style', $custom );	
}
add_action( 'wp_enqueue_scripts', 'alizee_custom_styles' );