<?php
/**
 * PCP_MetaBox
 *
 * MetaBox file.
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
 * PCP_MetaBox Class for primary category meta settings
 *
 * @category PCP_Shortcode
 * @package  primary_category_project
 * @author   Nishant Vaity <me@nishantvaity.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://www.nishantvaity.com/
 */
class PCP_MetaBox {
	/**
	 * PCP_Shortcode constructor
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'display_metabox' ) );
		add_action( 'save_post', array( $this, 'save_data' ) );
	}

	/**
	 * Display Metabox
	 *
	 * Show metabox for Primary Category.
	 *
	 * @return void
	 */
	public function display_metabox() {
		$post_types = get_post_types();
		foreach ( $post_types as $post_type ) {
			add_meta_box(
				'primarycategory',
				'Designate Primary Category',
				array( $this, 'metabox_content' ),
				$post_type,
				'normal',
				'high'
			);
		}
	}

	/**
	 * Metabox Content
	 *
	 * Metabox form for selecting Primary Category
	 *
	 * @return void
	 */
	public function metabox_content() {
		global $post;
		$primarycategory = '';
		$old_category    = get_post_meta( $post->ID, 'primarycategory', true );
		if ( ! empty( $old_category ) ) {
			$primarycategory = $old_category;
		}
		$post_categories = get_the_category();
		$output          = '';
		if ( ! empty( $post_categories ) ) {
			$output .= '<select name="primarycategory" id="primarycategory">';
			foreach ( $post_categories as $category ) {
				$output .= '<option value="' . $category->name . '" ' . selected( $primarycategory, $category->name, false ) . '>' . $category->name . '</option>';
			}
			$output .= '</select>';
		} else {
			$output .= '<p>Please select categories and update post</p>';
		}
		$allowed_html = array(
			'select' => array(
				'name' => array(),
				'id'   => array(),
			),
			'option' => array(),
			'p'      => array(),
		);
		echo wp_kses( $output, $allowed_html );
	}

	/**
	 * Save Primary Category
	 * Metabox for saving Primary Category
	 *
	 * @return void
	 */
	public function save_data() {
		global $post;
		$post_categories = get_the_category();
		$post_data       = wp_unslash( $_POST );
		if ( isset( $post_data['primarycategory'] ) && ! empty( $post_categories ) ) {
			$primarycategory = sanitize_text_field( $post_data['primarycategory'] );
			update_post_meta( $post->ID, 'primarycategory', $primarycategory );
		} else {
			update_post_meta( $post->ID, 'primarycategory', '' );
		}
	}
}
