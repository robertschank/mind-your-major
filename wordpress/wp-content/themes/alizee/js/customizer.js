/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Primary color
	wp.customize('primary_color',function( value ) {
		value.bind( function( newval ) {
			$('.main-navigation a, .social-navigation li a, .widget-title, .widgettitle, .social-widget li a::before, .author-social a, .view-all, .view-all a').css('color', newval );
			$('.main-navigation li').hover(
			  function() {
				$( this ).css('background-color', newval );
			  }, function() {
				$( this ).css('background-color', 'transparent' );
			  });
			$('.post-navigation .nav-previous, .post-navigation .nav-next, .paging-navigation .nav-previous, .paging-navigation .nav-next, #today, .tagcloud a, .entry-thumb, .comment-respond input[type="submit"], .cat-link, .search-submit, ::selection').css('background-color', newval );
			$('.widget-title, .widgettitle, .entry-thumb, .author-name, .site-header, .page-header, blockquote').css('border-color', newval );
			$('.sidebar-toggle').css('border-right-color', newval );
			$('.social-toggle').css('border-left-color', newval );						
		} );
	});
	// Header background
	wp.customize('header_color',function( value ) {
		value.bind( function( newval ) {
			$('.site-header').css('background-color', newval );
		} );
	});	
	// Site title
	wp.customize('site_title_color',function( value ) {
		value.bind( function( newval ) {
			$('.site-title a').css('color', newval );
		} );
	});
	// Site description
	wp.customize('site_desc_color',function( value ) {
		value.bind( function( newval ) {
			$('.site-description').css('color', newval );
		} );
	});
	// Entry title
	wp.customize('entry_title_color',function( value ) {
		value.bind( function( newval ) {
			$('.entry-title, .entry-title a').css('color', newval );
		} );
	});
	// Body text color
	wp.customize('body_text_color',function( value ) {
		value.bind( function( newval ) {
			$('body').css('color', newval );
		} );
	});
	// Footer background
	wp.customize('footer_color',function( value ) {
		value.bind( function( newval ) {
			$('.footer-widget-area, .site-info').css('background-color', newval );
		} );
	});	



} )( jQuery );
