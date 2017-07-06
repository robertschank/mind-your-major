<?php
/**
 * Admin Class
 *
 * Handles the Admin side functionality of plugin
 *
 * @package WP Header image slider and carousel
 * @since 1.1
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

class Sphis_Admin {
	
	function __construct() {
		
		// Action to add metabox
		add_action( 'add_meta_boxes', array($this, 'sphis_add_meta_box'), 10, 2 );

		// Action to save metabox value
		add_action( 'save_post', array($this, 'sphis_save_meta_box_data') );
	}

	/**
	 * Function to add metabox
	 * 
	 * @package WP Header image slider and carousel
	 * @since 1.1
	 */
	function sphis_add_meta_box( $post_type, $post ) {
		
		// Add metabox
		add_meta_box( 'sphis-meta-settings', __('Slider Settings', 'logoshowcase'), array($this, 'sphis_render_metabox'), SPHIS_POST_TYPE, 'normal', 'high' );
	}

	/**
	 * Function to handle 'Add Link URL' metabox HTML
	 * 
	 * @package WP Header image slider and carousel
	 * @since 1.1
	 */
	function sphis_render_metabox( $post ) {

		$prefix 		= SPHIS_META_PREFIX;
		$sphis_url 		= get_post_meta( $post->ID, $prefix.'slide_link', true );
		$link_behaviour	= get_post_meta( $post->ID, $prefix.'link_behaviour', true );

		wp_nonce_field( 'sphis_save_meta_box_data', 'sphis_meta_box_nonce' ); // Nonce
		
		// Metabox HTML
		include( SPHIS_DIR . '/includes/admin/metabox/sphis-metabox-settings.php' );
	}

	/**
	 * Function to save metabox values
	 * 
	 * @package WP Header image slider and carousel
	 * @since 1.1
	 */
	function sphis_save_meta_box_data( $post_id ){
		
		global $post_type;
		
		if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )                	// Check Autosave
		|| ( ! isset( $_POST['post_ID'] ) || $post_id != $_POST['post_ID'] )  	// Check Revision
		|| ( $post_type !=  SPHIS_POST_TYPE )              						// Check if current post type is supported.
		|| (!wp_verify_nonce( $_POST['sphis_meta_box_nonce'], 'sphis_save_meta_box_data' )) ) // Check nonce
		{
		  return $post_id;
		}
		
		$prefix = SPHIS_META_PREFIX; // Taking metabox prefix
		
		$sphis_url 		= isset($_POST[$prefix.'slide_link']) ? sanitize_text_field( $_POST[$prefix.'slide_link'] ) : '';
		$link_behaviour	= !empty($_POST[$prefix.'link_behaviour']) ? 1 : 0;

		update_post_meta( $post_id, $prefix.'slide_link', $sphis_url );
		update_post_meta( $post_id, $prefix.'link_behaviour', $link_behaviour );
	}
}

$sphis_admin = new Sphis_Admin();