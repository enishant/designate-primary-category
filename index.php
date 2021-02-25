<?php
/**
 * Plugin Name: Primary Category Project
 * Description: Allows publishers to designate a primary category for posts. And query related posts according to post category on front-end.
 * Plugin URI: https://github.com/enishant/primary-category-project
 * Author: Nishant Vaity
 * Version: 1.0
 * Author URI: https://www.nishantvaity.com/
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package primary_category_project
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PCP_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
if ( file_exists( PCP_PLUGIN_PATH . 'classes/class-pcp-metabox.php' ) ) {
	include PCP_PLUGIN_PATH . 'classes/class-pcp-metabox.php';
	new PCP_MetaBox();
}
if ( file_exists( PCP_PLUGIN_PATH . 'classes/class-pcp-shortcode.php' ) ) {
	include PCP_PLUGIN_PATH . 'classes/class-pcp-shortcode.php';
	new PCP_Shortcode();
}
