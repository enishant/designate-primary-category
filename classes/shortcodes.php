<?php
class PCP_Shortcode {
  public function __construct() {
    add_shortcode( 'pcp', array( $this, 'pcp_query' ) );
  }
    
  public function pcp_query( $atts ) {
  	extract(
      shortcode_atts(
        array(
          'post_type' => 'post',
          'post_status' => 'publish',
          'orderby' => 'post_date',
          'order' => 'DESC',
          'count' => 10,
  		    'category' => 'Default Category'
  	    ), $atts 
      )
    );
  	$pc_query_args = array(
  		'post_type'     => $post_type, 
      'post_status' => $post_status,
      'orderby' => $orderby,
      'order' => $order,
      'posts_per_page' => $count,
  		'meta_key'      => 'primarycategory', 
  		'meta_value'    => $category
  	);
  	$pcp_query = new WP_Query( $pc_query_args );
  	if( $pcp_query->have_posts() ) {
  		echo '<ul>';
  		while ( $pcp_query->have_posts() ) {
  			$pcp_query->the_post();
  			echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
  		}
  		echo '</ul>';
  	} else {
      echo 'No posts found for primary category "' . $category . '"';
  	}
  	wp_reset_postdata(); 
  }
}
