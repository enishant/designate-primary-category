<?php
/**
 * PCP_Shortcode
 *
 * Shortcode file.
 *
 * @package    primary_category_project
 * @author     Nishant Vaity <me@nishantvaity.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://www.nishantvaity.com/
 * @since      1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * PCP_Shortcode Class for primary category post listing shortcode
 *
 * @category PCP_Shortcode
 * @package  primary_category_project
 * @author   Nishant Vaity <me@nishantvaity.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://www.nishantvaity.com/
 */
class PCP_Shortcode {
	/**
	 * PCP_Shortcode constructor
	 *
	 * @return void
	 */
	public function __construct() {
		add_shortcode( 'pcp', array( $this, 'pcp_query' ) );
	}

	/**
	 * Modify navigation menu items.
	 *
	 * This is only used for Mobile navigation menu.
	 *
	 * @param  array $atts shortcode parameters.
	 * @return string HTML output.
	 */
	public function pcp_query( $atts ) {
		extract(
			shortcode_atts(
				array(
					'post_type'   => 'post',
					'post_status' => 'publish',
					'orderby'     => 'post_date',
					'order'       => 'DESC',
					'count'       => 10,
					'category'    => 'Default Category',
				),
				$atts
			)
		);
		$pc_query_args = array(
			'post_type'      => $post_type,
			'post_status'    => $post_status,
			'orderby'        => $orderby,
			'order'          => $order,
			'posts_per_page' => $count,
			'meta_key'       => 'primarycategory',
			'meta_value'     => $category,
		);
		$pcp_query     = new WP_Query( $pc_query_args );
		$output        = '';
		if ( $pcp_query->have_posts() ) {
			$output .= '<ul>';
			while ( $pcp_query->have_posts() ) {
				$pcp_query->the_post();
				$output .= '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
			}
			$output .= '</ul>';
		} else {
			$output .= 'No posts found for primary category "' . $category . '"';
		}
		wp_reset_postdata();
		return $output;
	}
}
