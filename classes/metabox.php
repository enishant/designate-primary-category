<?php
class PCP_MetaBox {
  public function __construct() {
    add_action( 'add_meta_boxes', array( $this, 'display_metabox' ) );
    add_action( 'save_post', array( $this, 'save_data' ) );
  }
  
  public function display_metabox() {
  	$post_types = get_post_types();
  	foreach ( $post_types as $post_type ) {
  		if ( $post_type == 'page' ) {
  			continue;
  		}
  		add_meta_box (
  			'primarycategory',
  			'Designate Primary Category',
  			array( $this, 'metabox_content' ),
  			$post_type,
  			'normal',
  			'high'
  		);
  	}
  }
  
  public function metabox_content() {
    global $post;
  	$primarycategory = '';
  	$old_category = get_post_meta( $post->ID, 'primarycategory', true );
  	if ( $old_category != '' ) {
  		$primarycategory = $old_category;
  	}
  	$post_categories = get_the_category();
    if(!empty($post_categories)) {
      $html = '<select name="primarycategory" id="primarycategory">';
      foreach( $post_categories as $category ) {
        $html .= '<option value="' . $category->name . '" ' . selected( $primarycategory, $category->name, false ) . '>' . $category->name . '</option>';
      }
      $html .= '</select>';
    } else {
      $html = 'Please select categories and update post';
    }
  	echo $html; 
  }
  
  public function save_data() {
    global $post;
    $post_categories = get_the_category();
  	if ( isset( $_POST[ 'primarycategory' ] ) && !empty($post_categories) ) {
  		$primarycategory = sanitize_text_field( $_POST[ 'primarycategory' ] );
      update_post_meta( $post->ID, 'primarycategory',$primarycategory);
    } else {
  		update_post_meta( $post->ID, 'primarycategory','');
    }
  }    
}
