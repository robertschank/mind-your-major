<?php
/**
 * Function to add metabox
 * 
 * @package WP Header image slider and carousel
 * @since 1.1
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;
?>

<table class="form-table sphis-metabox-sett-table">
	<tbody>
		<tr valign="top">
			<th scope="row">
				<label for="sphis-slide-link"><?php _e('URL', 'sphis'); ?></label>
			</th>
			<td>
				<input type="url" name="<?php echo $prefix; ?>slide_link" value="<?php echo esc_attr($sphis_url); ?>" class="regular-text sphis-slide-link" id="sphis-slide-link" /><br/>
				<span class="description"><?php _e('Enter link url for image. i.e http://www.google.com', 'sphis'); ?></span>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row">
				<label for="sphis-slide-link-behaviour"><?php _e('Open Link in new tab', 'sphis'); ?></label>
			</th>
			<td>
				<input type="checkbox" name="<?php echo $prefix; ?>link_behaviour" value="1" class="sphis-slide-link-behaviour" id="sphis-slide-link-behaviour" <?php checked( $link_behaviour, 1 ); ?> /><br/>
				<span class="description"><?php _e('Check this box if you want to open the image link in new tab.', 'sphis'); ?></span>
			</td>
		</tr>
	</tbody>
</table><!-- end .sphis-metabox-sett-table -->