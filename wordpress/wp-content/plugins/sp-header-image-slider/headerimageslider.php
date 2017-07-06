<?php
/*
 * Plugin Name: WP Header image slider and carousel 
 * Plugin URL: https://www.wponlinesupport.com/
 * Description: A simple Header image slider plugin
 * Version: 1.3
 * Author: WP Online Support
 * Author URI: https://www.wponlinesupport.com
 * Contributors: WP Online Support
 * Text Domain: sphis
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Basic plugin definitions
 * 
 * @package WP Header image slider and carousel
 * @since 1.0.0
 */
if( !defined( 'SPHIS_VERSION' ) ) {
	define( 'SPHIS_VERSION', '1.3' );	// Version of plugin
}
if( !defined( 'SPHIS_DIR' ) ) {
	define( 'SPHIS_DIR', dirname( __FILE__ ) );	// Plugin dir
}
if( !defined( 'SPHIS_URL' ) ) {
	define( 'SPHIS_URL', plugin_dir_url( __FILE__ ) );	// Plugin url
}
if( !defined( 'SPHIS_POST_TYPE' ) ) {
	define( 'SPHIS_POST_TYPE', 'sp_imageslider' );	// Plugin Post Type
}
if( !defined( 'SPHIS_META_PREFIX' ) ) {
	define( 'SPHIS_META_PREFIX', '_sphis_' );	// Plugin Metabox Prefix
}

/**
 * Load Text Domain
 * This gets the plugin ready for translation
 * 
 * @package WP Header image slider and carousel
 * @since 1.1
 */
function sphis_load_textdomain() {
	load_plugin_textdomain( 'sphis', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
}

// Action to load plugin text domain
add_action('plugins_loaded', 'sphis_load_textdomain');

function wphimgs_imageslider_setup_post_types() {

	$imageslider_labels =  apply_filters( 'sp_imageslider_labels', array(
		'name'                => 'Header Image Slider',
		'singular_name'       => 'Header Image Slider',
		'add_new'             => __('Add New ', 'sp_imageslider'),
		'add_new_item'        => __('Add New Image', 'sp_imageslider'),
		'edit_item'           => __('Edit Image', 'sp_imageslider'),
		'new_item'            => __('New Image', 'sp_imageslider'),
		'all_items'           => __('All Image', 'sp_imageslider'),
		'view_item'           => __('View Image', 'sp_imageslider'),
		'search_items'        => __('Search Image', 'sp_imageslider'),
		'not_found'           => __('No Image found', 'sp_imageslider'),
		'not_found_in_trash'  => __('No Image found in Trash', 'sp_imageslider'),
		'parent_item_colon'   => '',
		'menu_name'           => __('Header Image Slider', 'sp_imageslider'),
		'exclude_from_search' => true
	) );


	$imageslider_args = array(
		'labels' 			=> $imageslider_labels,
		'public' 			=> true,
		'publicly_queryable'=> true,
		'show_ui' 			=> true,
		'show_in_menu' 		=> true,
		'query_var' 		=> true,
		'capability_type' 	=> 'post',
		'has_archive' 		=> true,
		'hierarchical' 		=> false,
		'menu_icon'			=> 'dashicons-images-alt2',
		'supports' => array('title','thumbnail')
	);
	register_post_type( SPHIS_POST_TYPE, apply_filters( 'sp_imageslider_post_type_args', $imageslider_args ) );

}

add_action('init', 'wphimgs_imageslider_setup_post_types');
/*
 * Add [sp_imageslider limit="-1"] shortcode
 *
 */

function wphimgs_imageslider_shortcode( $atts, $content = null ) {
	
	extract(shortcode_atts(array(
		'limit' 			=> '-1',
		'effect'			=> 'horizontal',
		'captions'			=> 'true',
		'autoplay'			=> 'true',		
		'speed'				=> 2000,
		'slide_margin'		=> 10,
		'auto_controls'		=> 'true',
		'loop'				=> 'true',
		'start_slide'		=> 0,
		'random_start'		=> 'false',
		'autoplay_interval'	=> 4000,
		'dots'              => 'true',
	), $atts));
	
	$limit 				= !empty($limit) ? $limit : '-1';
	$captions			= ($captions == 'true') 		? 1 : 0;
	$autoplay			= ($autoplay == 'true') 		? 1 : 0;
	$auto_controls		= ($auto_controls == 'true')	? 1 : 0;
	$loop				= ($loop == 'true') 			? 1 : 0;
	$random_start		= ($random_start == 'true')		? 1 : 0;
	$autoplay_interval	= ( !empty($autoplay_interval) && is_numeric($autoplay_interval) ) ? $autoplay_interval : 4000;
	$speed				= ( !empty($speed) && is_numeric($speed) ) ? $speed : 3000;
	$slide_margin		= ( !empty($slide_margin) && is_numeric($slide_margin) ) ? $slide_margin : 10;
	$start_slide		= ( !empty($start_slide) && is_numeric($start_slide) ) ? $start_slide : 0;
	$dots				= ($dots == 'true')		? 1 : 0;

	ob_start();

	// Create the Query
	$post_type 		= 'sp_imageslider';
	$orderby 		= 'post_date';
	$order 			= 'DESC';
				
	$query = new WP_Query( array ( 
								'post_type'      => $post_type,
								'posts_per_page' => $limit,
								'orderby'        => $orderby, 
								'order'          => $order,
								'no_found_rows'  => 1
								) 
						);
	
	//Get post type count
	$post_count = $query->post_count;
	$i = 1;	
	if( $post_count > 0) :
	?>
	
	<ul class="wphimgs-slides">
		<?php while ($query->have_posts()) : $query->the_post(); $feat_image = wp_get_attachment_url( get_post_thumbnail_id() ); ?>
				
			<li><img src="<?php echo $feat_image; ?>" title="<?php the_title(); ?>" alt="" ></li>
		
		<?php $i++; endwhile; ?>
	</ul>		
	<?php else : ?>
		
		<ul class="wphimgs-slides">			
			<li> <img src="<?php echo  plugin_dir_url( __FILE__ ); ?>/images/slide-1.jpg" title="First Image"  alt="" ></li>	
			<li><img src="<?php echo  plugin_dir_url( __FILE__ ); ?>/images/slide-2.jpg" title="Second Image"  alt=""></li>
			<li><img src="<?php echo  plugin_dir_url( __FILE__ ); ?>/images/slide-3.jpg" title="Third Image" alt=""></li>
		</ul>
		
	<?php	
	endif ;	
	wp_reset_query();
?>

	<script type="text/javascript">
	 jQuery(function(){
			jQuery('.wphimgs-slides').bxSlider({
			  mode 			: '<?php echo $effect; ?>', /*'horizontal', 'vertical', 'fade'*/
			  captions 		: <?php echo $captions; ?>,
			  auto 			: <?php echo $autoplay; ?>,
			  pause 		: <?php echo $autoplay_interval; ?>,
			  speed 		: <?php echo $speed; ?>,			  
			  slideMargin	: <?php echo $slide_margin; ?>,
			  autoControls	: <?php echo $auto_controls; ?>,
			  infiniteLoop	: <?php echo $loop; ?>,
			  startSlide	: <?php echo $start_slide; ?>,
			  randomStart	: <?php echo $random_start; ?>,
			  pager         : <?php echo $dots; ?>
			 
		});
	});
	</script>

<?php
	return ob_get_clean();
}
add_shortcode("sp_imageslider", "wphimgs_imageslider_shortcode");

/*
 * Add [sp_imagecarousel limit="-1"] shortcode
 *
 */

function wphimgs_imagecarousel_shortcode( $atts, $content = null ) {
	
	extract(shortcode_atts(array(
		'limit' 		=> '-1',
		'slide_width'	=> '600',
		'autoplay'			=> 'true',	
		'autoplay_interval'	=> 4000,
		'min_slides'	=> 2,
		'max_slides'	=> 2,
		'speed'			=> 2000,
		'slide_margin'	=> 10,
		'dots'          => 'true',
	), $atts));
	
	$limit = !empty($limit) ? $limit : '-1';
	$slide_width		= ( !empty($slide_width) && is_numeric($slide_width) ) 		? $slide_width 	: 600;
	$autoplay			= ($autoplay == 'true') 		? 1 : 0;
	$min_slides			= ( !empty($min_slides) && is_numeric($min_slides) ) 		? $min_slides 	: 2;
	$max_slides			= ( !empty($max_slides) && is_numeric($max_slides) ) 		? $max_slides 	: 2;
	$autoplay_interval	= ( !empty($autoplay_interval) && is_numeric($autoplay_interval) ) ? $autoplay_interval : 4000;
	$speed				= ( !empty($speed) && is_numeric($speed) ) ? $speed : 3000;
	$slide_margin		= ( !empty($slide_margin) && is_numeric($slide_margin) ) 	? $slide_margin : 10;
	$dots				= ($dots == 'true')		? 1 : 0;
	
	ob_start();

	// Create the Query
	$post_type 		= 'sp_imageslider';
	$orderby 		= 'post_date';
	$order 			= 'DESC';
				
	$query = new WP_Query( array ( 
								'post_type'      => $post_type,
								'posts_per_page' => $limit,
								'orderby'        => $orderby, 
								'order'          => $order,
								'no_found_rows'  => 1
								) 
						);
	
	//Get post type count
	$post_count = $query->post_count;
	$i = 1;	
	if( $post_count > 0) :
	?>
	
	<ul class="wphimgs-carousel">	
			
	<?php		
		while ($query->have_posts()) : $query->the_post();
		$feat_image = wp_get_attachment_url( get_post_thumbnail_id() );
		?>
		<li> <img src="<?php echo $feat_image; ?>" title="<?php the_title(); ?>"  alt="" >	 </li>	
		<?php
		$i++;
		endwhile; ?>			
		</ul>		
<?php	else : ?>
	
		<ul class="wphimgs-carousel">			
				<li> <img src="<?php echo  plugin_dir_url( __FILE__ ); ?>/images/slide-1.jpg" title="First Image"  alt="" >	 </li>	
				 <li> <img src="<?php echo  plugin_dir_url( __FILE__ ); ?>/images/slide-2.jpg" title="Second Image"  alt="">	</li>
				<li>  <img src="<?php echo  plugin_dir_url( __FILE__ ); ?>/images/slide-3.jpg" title="Third Image" alt=""></li>		
					
		</ul>		
	
	<?php	
	endif ;	
	wp_reset_query();
?>
	
	<script type="text/javascript">
	jQuery(function(){
		jQuery('.wphimgs-carousel').bxSlider({
			slideWidth	: <?php echo $slide_width; ?>,
			auto 	    : <?php echo $autoplay; ?>,
			pause 		: <?php echo $autoplay_interval; ?>,
			minSlides	: <?php echo $min_slides; ?>,
			maxSlides	: <?php echo $max_slides; ?>,
			speed 		: <?php echo $speed; ?>,
			slideMargin : <?php echo $slide_margin; ?>,
			pager         : <?php echo $dots; ?>
		});
	});
	</script>

<?php
	return ob_get_clean();
}
add_shortcode("sp_imagecarousel", "wphimgs_imagecarousel_shortcode");


/*
 * Add [sp_imagethumbnail_pager limit="-1"] shortcode
 *
 */

function wphimgs_imageThumbnailpager_shortcode( $atts, $content = null ) {
	
	extract(shortcode_atts(array(
		'limit' 			=> '-1',
		'effect'			=> 'horizontal',
		'captions'			=> 'true',
		'autoplay'			=> 'false',
		'speed'				=> 2000,
		'slide_margin'		=> 10,
		'auto_controls'		=> 'true',
		'loop'				=> 'true',
		'start_slide'		=> 0,
		'random_start'		=> 'false',
		'autoplay_interval'	=> 3000,
	), $atts));
	
	$limit 				= !empty($limit) ? $limit : '-1';
	$captions			= ($captions == 'true') 		? 1 : 0;
	$autoplay			= ($autoplay == 'true') 		? 1 : 0;
	$auto_controls		= ($auto_controls == 'true')	? 1 : 0;
	$loop				= ($loop == 'true') 			? 1 : 0;
	$random_start		= ($random_start == 'true')		? 1 : 0;
	$autoplay_interval	= ( !empty($autoplay_interval) && is_numeric($autoplay_interval) ) ? $autoplay_interval : 4000;
	$speed				= ( !empty($speed) && is_numeric($speed) ) ? $speed : 3000;
	$slide_margin		= ( !empty($slide_margin) && is_numeric($slide_margin) ) ? $slide_margin : 10;
	$start_slide		= ( !empty($start_slide) && is_numeric($start_slide) ) ? $start_slide : 0;

	ob_start();

	// Create the Query
	$post_type 		= 'sp_imageslider';
	$orderby 		= 'post_date';
	$order 			= 'DESC';
				
	$query = new WP_Query( array ( 
								'post_type'      => $post_type,
								'posts_per_page' => $limit,
								'orderby'        => $orderby, 
								'order'          => $order,
								'no_found_rows'  => 1
								) 
						);
	
	//Get post type count
	$post_count = $query->post_count;
	$i = 1;	
	if( $post_count > 0) :
	?>
	
	<ul class="wphimgs-thumbnail">		
		<?php while($query->have_posts()) : $query->the_post();

			$feat_image = wp_get_attachment_url( get_post_thumbnail_id() ); ?>
		
			<li><img src="<?php echo $feat_image; ?>" title="<?php the_title(); ?>"  alt="" ></li>
		
		<?php $i++; endwhile; ?>
	</ul>
	
	<div class="wphimgs-pager">
		<?php $j = 0; while ($query->have_posts()) : $query->the_post(); ?>

	  		<a data-slide-index="<?php echo $j; ?>" href=""><?php the_post_thumbnail(array(80,80)); ?></a>

		<?php $j++; endwhile; ?>
	</div>		

<?php else : ?>
	
	<ul class="wphimgs-thumbnail">			
		<li><img src="<?php echo  plugin_dir_url( __FILE__ ); ?>/images/slide-1.jpg" title="First Image"  alt="" ></li>
		<li><img src="<?php echo  plugin_dir_url( __FILE__ ); ?>/images/slide-2.jpg" title="Second Image"  alt=""></li>
		<li><img src="<?php echo  plugin_dir_url( __FILE__ ); ?>/images/slide-3.jpg" title="Third Image" alt=""></li>
	</ul>
	<div class="wphimgs-pager">
		<a data-slide-index="0" href=""><img src="<?php echo  plugin_dir_url( __FILE__ ); ?>/images/slide-1.jpg" width="100px"/></a>
		<a data-slide-index="1" href=""><img src="<?php echo  plugin_dir_url( __FILE__ ); ?>/images/slide-1.jpg" width="100px"/></a>
		<a data-slide-index="2" href=""><img src="<?php echo  plugin_dir_url( __FILE__ ); ?>/images/slide-1.jpg" width="100px"/></a>
	</div>		
	
<?php endif;	
	wp_reset_query();
?>

<script type="text/javascript">
	jQuery(function() {
		jQuery('.wphimgs-thumbnail').bxSlider({
			mode			: '<?php echo $effect; ?>', /*'horizontal', 'vertical', 'fade'*/
			captions 		: <?php echo $captions; ?>,
			auto 			: <?php echo $autoplay; ?>,
			pause 			: <?php echo $autoplay_interval; ?>,
			speed 			: <?php echo $speed; ?>,			  
			slideMargin 	: <?php echo $slide_margin; ?>,
			autoControls 	: <?php echo $auto_controls; ?>,
			infiniteLoop 	: <?php echo $loop; ?>,
			startSlide 		: <?php echo $start_slide; ?>,
			randomStart 	: <?php echo $random_start; ?>,	
			pagerCustom 	: '.wphimgs-pager'
		});
	});
</script>

<?php
	return ob_get_clean();
}
add_shortcode("sp_imagethumbnail_pager", "wphimgs_imageThumbnailpager_shortcode");

add_action( 'wp_enqueue_scripts','wphimgs_style_css' );
function wphimgs_style_css() {	
	wp_enqueue_style( 'wphimgs_slidercss',  plugin_dir_url( __FILE__ ). 'css/jquery.bxslider.css', array(), SPHIS_VERSION );
	wp_enqueue_script( 'wpfcas_slick_jquery', plugin_dir_url( __FILE__ ) . 'js/jquery.bxslider.min.js', array('jquery'), SPHIS_VERSION );
}

// Admin Class File
require_once( SPHIS_DIR . '/includes/admin/class-sphis-admin.php' );

// Load admin side files
if ( is_admin() || ( defined( 'WP_CLI' ) && WP_CLI ) ) {   
    // Designs file
    include_once( SPHIS_DIR . '/includes/admin/wp-sphis-how-it-work.php' );
}