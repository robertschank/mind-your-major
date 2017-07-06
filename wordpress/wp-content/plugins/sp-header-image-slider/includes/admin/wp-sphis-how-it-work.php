<?php
/**
 * Pro Designs and Plugins Feed
 *
 * @package WP Header image slider and carousel
 * @since 1.1
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// Action to add menu
add_action('admin_menu', 'wphimgs_register_design_page');

/**
 * Register plugin design page in admin menu
 * 
 * @package WP Header image slider and carousel
 * @since 1.1
 */
function wphimgs_register_design_page() {
	add_submenu_page( 'edit.php?post_type='.SPHIS_POST_TYPE, __('How it works, our plugins and offers', 'sphis'), __('How It Works', 'sphis'), 'manage_options', 'wphimgs-how-it-works', 'wphimgs_designs_page' );
}

/**
 * Function to display plugin design HTML
 * 
 * @package WP Header image slider and carousel
 * @since 1.1
 */
function wphimgs_designs_page() {

	$wpos_feed_tabs = wphimgs_faqp_help_tabs();
	$active_tab 	= isset($_GET['tab']) ? $_GET['tab'] : 'how-it-work';
?>
		
	<div class="wrap spfaq-wrap">

		<h2 class="nav-tab-wrapper">
			<?php
			foreach ($wpos_feed_tabs as $tab_key => $tab_val) {
				$tab_name	= $tab_val['name'];
				$active_cls = ($tab_key == $active_tab) ? 'nav-tab-active' : '';
				$tab_link 	= add_query_arg( array( 'post_type' => SPHIS_POST_TYPE, 'page' => 'wphimgs-how-it-works', 'tab' => $tab_key), admin_url('edit.php') );
			?>

			<a class="nav-tab <?php echo $active_cls; ?>" href="<?php echo $tab_link; ?>"><?php echo $tab_name; ?></a>

			<?php } ?>
		</h2>
		
		<div class="spfaq-tab-cnt-wrp">
		<?php
			if( isset($active_tab) && $active_tab == 'how-it-work' ) {
				wphimgs_howitwork_page();
			}
			else if( isset($active_tab) && $active_tab == 'plugins-feed' ) {
				echo wphimgs_get_plugin_design( 'plugins-feed' );
			} else {
				echo wphimgs_get_plugin_design( 'offers-feed' );
			}
		?>
		</div><!-- end .spfaq-tab-cnt-wrp -->

	</div><!-- end .spfaq-wrap -->

<?php
}

/**
 * Gets the plugin design part feed
 *
 * @package WP Header image slider and carousel
 * @since 1.1
 */
function wphimgs_get_plugin_design( $feed_type = '' ) {
	
	$active_tab = isset($_GET['tab']) ? $_GET['tab'] : '';
	
	// If tab is not set then return
	if( empty($active_tab) ) {
		return false;
	}

	// Taking some variables
	$wpos_feed_tabs = wphimgs_faqp_help_tabs();
	$transient_key 	= isset($wpos_feed_tabs[$active_tab]['transient_key']) 	? $wpos_feed_tabs[$active_tab]['transient_key'] 	: 'spfaq_' . $active_tab;
	$url 			= isset($wpos_feed_tabs[$active_tab]['url']) 			? $wpos_feed_tabs[$active_tab]['url'] 				: '';
	$transient_time = isset($wpos_feed_tabs[$active_tab]['transient_time']) ? $wpos_feed_tabs[$active_tab]['transient_time'] 	: 172800;
	$cache 			= get_transient( $transient_key );
	
	if ( false === $cache ) {
		
		$feed 			= wp_remote_get( esc_url_raw( $url ), array( 'timeout' => 120, 'sslverify' => false ) );
		$response_code 	= wp_remote_retrieve_response_code( $feed );
		
		if ( ! is_wp_error( $feed ) && $response_code == 200 ) {
			if ( isset( $feed['body'] ) && strlen( $feed['body'] ) > 0 ) {
				$cache = wp_remote_retrieve_body( $feed );
				set_transient( $transient_key, $cache, $transient_time );
			}
		} else {
			$cache = '<div class="error"><p>' . __( 'There was an error retrieving the data from the server. Please try again later.', 'sphis' ) . '</div>';
		}
	}
	return $cache;	
}

/**
 * Function to get plugin feed tabs
 *
 * @package WP Header image slider and carousel
 * @since 1.1
 */
function wphimgs_faqp_help_tabs() {
	$wpos_feed_tabs = array(
						'how-it-work' 	=> array(
													'name' => __('How It Works', 'sphis'),
												),
						'plugins-feed' 	=> array(
													'name' 				=> __('Our Plugins', 'sphis'),
													'url'				=> 'http://wponlinesupport.com/plugin-data-api/plugins-data.php',
													'transient_key'		=> 'wpos_plugins_feed',
													'transient_time'	=> 172800
												),
						'offers-feed' 	=> array(
													'name'				=> __('WPOS Offers', 'sphis'),
													'url'				=> 'http://wponlinesupport.com/plugin-data-api/wpos-offers.php',
													'transient_key'		=> 'wpos_offers_feed',
													'transient_time'	=> 86400,
												)
					);
	return $wpos_feed_tabs;
}

/**
 * Function to get 'How It Works' HTML
 *
 * @package WP Header image slider and carousel
 * @since 1.1
 */
function wphimgs_howitwork_page() { ?>
	
	<style type="text/css">
		.wpos-pro-box .hndle{background-color:#0073AA; color:#fff;}
		.wpos-pro-box .postbox{background:#dbf0fa none repeat scroll 0 0; border:1px solid #0073aa; color:#191e23;}
		.postbox-container .wpos-list li:before{font-family: dashicons; content: "\f139"; font-size:20px; color: #0073aa; vertical-align: middle;}
		.spfaq-wrap .wpos-button-full{display:block; text-align:center; box-shadow:none; border-radius:0;}
		.spfaq-shortcode-preview{background-color: #e7e7e7; font-weight: bold; padding: 2px 5px; display: inline-block; margin:0 0 2px 0;}
	</style>

	<div class="post-box-container">
		<div id="poststuff">
			<div id="post-body" class="metabox-holder columns-2">
			
				<!--How it workd HTML -->
				<div id="post-body-content">
					<div class="metabox-holder">
						<div class="meta-box-sortables ui-sortable">
							<div class="postbox">
								
								<h3 class="hndle">
									<span><?php _e( 'How It Works - Display and shortcode', 'sphis' ); ?></span>
								</h3>
								
								<div class="inside">
									<table class="form-table">
										<tbody>
											<tr>
												<th>
													<label><?php _e('Getting Started with Header Image Slider', 'sphis'); ?>:</label>
												</th>
												<td>
													<ul>
														<li><?php _e('Step-1. Go to "Header Image Slider --> Add New".', 'sphis'); ?></li>
														<li><?php _e('Step-2. Add Title, External url(optional) and featured image', 'sphis'); ?></li>														
													</ul>
												</td>
											</tr>

											<tr>
												<th>
													<label><?php _e('How Shortcode Works', 'sphis'); ?>:</label>
												</th>
												<td>
													<ul>														
														<li><?php _e('Step-1. Create a page like Image Slider OR add the shortcode in any page.', 'sphis'); ?></li>
														<li><?php _e('Step-2. Put below shortcode as per your need.', 'sphis'); ?></li>
													</ul>
												</td>
											</tr>

											<tr>
												<th>
													<label><?php _e('All Shortcodes', 'sphis'); ?>:</label>
												</th>
												<td>
													<span class="spfaq-shortcode-preview">[sp_imageslider]</span> – <?php _e('Display Image slideshow with captions/without captions in Page', 'sphis'); ?><br>
													<span class="spfaq-shortcode-preview">[sp_imagecarousel]</span> – <?php _e('Display Image Carousel', 'sphis'); ?><br>
													<span class="spfaq-shortcode-preview">[sp_imagethumbnail_pager]</span> – <?php _e('Display Thumbnail pager', 'sphis'); ?>
												</td>
											</tr>

											<tr>
												<th>
													<label><?php _e('Need Support?', 'sphis'); ?>:</label>
												</th>
												<td>
													<span><?php _e('Check plugin document for shortcode parameters and demo for designs.','sphis'); ?></span><br><br>
													<a class="button button-primary" href="https://www.wponlinesupport.com/plugins-documentation/documentwp-header-image-slider-carousel/?utm_source=hp&event=doc" target="_blank"><?php _e('Documentation', 'sphis'); ?></a>
													<a class="button button-primary" href="http://demo.wponlinesupport.com/wp-header-image-slider-demo/?utm_source=hp&event=demo" target="_blank"><?php _e('Demo for Designs', 'sphis'); ?></a>
												</td>
											</tr>						
											
										</tbody>
									</table>
								</div><!-- .inside -->
							</div><!-- #general -->
						</div><!-- .meta-box-sortables ui-sortable -->
					</div><!-- .metabox-holder -->
				</div><!-- #post-body-content -->
				
				<!--Upgrad to Pro HTML -->
				<div id="postbox-container-1" class="postbox-container">
					<div class="metabox-holder wpos-pro-box">
						<div class="meta-box-sortables ui-sortable">
							<div class="postbox" style="">
									
								<h3 class="hndle">
									<span><?php _e('Upgrate to Pro', 'sphis'); ?></span>
								</h3>
								<div class="inside">										
									<ul class="wpos-list">
										<li><?php _e('30+ Beautiful Designs', 'responsive-header-image-slider'); ?></li>
										<li><?php _e('Visual composer support', 'responsive-header-image-slider'); ?></li>
										<li><?php _e('Drag & Drop order change', 'responsive-header-image-slider'); ?></li>
										<li><?php _e('24+ Slider designs', 'responsive-header-image-slider'); ?></li>
										<li><?php _e('18+ Carousel and center mode designs', 'responsive-header-image-slider'); ?></li>
										<li><?php _e('18+ Variable width designs', 'responsive-header-image-slider'); ?></li>
										<li><?php _e('Custom css', 'responsive-header-image-slider'); ?></li>
										<li><?php _e('Slider Center Mode Effect', 'responsive-header-image-slider'); ?></li>
										<li><?php _e('Slider RTL support', 'responsive-header-image-slider'); ?></li>
										<li><?php _e('Fully responsive', 'responsive-header-image-slider'); ?></li>
										<li><?php _e('100% Multi language', 'responsive-header-image-slider'); ?></li>
									</ul>
									<a class="button button-primary wpos-button-full" href="https://www.wponlinesupport.com/wp-plugin/wp-slick-slider-and-image-carousel/?utm_source=hp&event=go_premium" target="_blank">Go Premium </a>
									<p><a class="button button-primary wpos-button-full" href="http://demo.wponlinesupport.com/prodemo/pro-wp-slick-slider-and-carousel-demo/?utm_source=hp&event=pro_demo" target="_blank">View PRO Demo </a></p>
								</div><!-- .inside -->
							</div><!-- #general -->
						</div><!-- .meta-box-sortables ui-sortable -->
					</div><!-- .metabox-holder -->

					<!-- Help to improve this plugin! -->
					<div class="metabox-holder">
						<div class="meta-box-sortables ui-sortable">
							<div class="postbox">
									<h3 class="hndle">
										<span><?php _e( 'Help to improve this plugin!', 'sphis' ); ?></span>
									</h3>									
									<div class="inside">										
										<p><?php _e('Enjoyed this plugin? You can help by rate this plugin', 'sphis'); ?> <a href="https://wordpress.org/support/plugin/sp-header-image-slider/reviews/?filter=5" target="_blank">5 stars!</a></p>
									</div><!-- .inside -->
							</div><!-- #general -->
						</div><!-- .meta-box-sortables ui-sortable -->
					</div><!-- .metabox-holder -->
				</div><!-- #post-container-1 -->

			</div><!-- #post-body -->
		</div><!-- #poststuff -->
	</div><!-- #post-box-container -->
<?php }