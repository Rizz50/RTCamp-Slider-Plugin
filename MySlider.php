<?php
	/*
		Plugin Name: Image Slider
		Plugin URI: http://www.shaikhrizwan.ml
		Description: A simple plugin that integrates Image Slider in WordPress using the following Short Code : [ef_slider].
		Author: Rizwan Shaikh
		Version: 1.0
		Author URI: http://www.shaikhrizwan.ml
	*/

	define('EFS_PATH', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );
	define('EFS_NAME', "MySlider");
	define ("EFS_VERSION", "1.0");

	require_once('slider-img-type.php');
	wp_enqueue_script('slider', EFS_PATH.'jquery.slider-min.js', array('jquery'));
	wp_enqueue_style('slider_css', EFS_PATH.'slider.css');

	function efs_script()
	{
		print '<script type="text/javascript" charset="utf-8">				
			jQuery(window).load(function()
			{
				jQuery(\'.slider\').slider();
			});
		</script>';     
	}
	add_action('wp_head', 'efs_script');

	function efs_get_slider()
	{
		$slider= '<div class="slider"><ul class="slides">';
		$efs_query= "post_type=slider-image";
		query_posts($efs_query);
		if (have_posts()) : while (have_posts()) : the_post(); 
		$img= get_the_post_thumbnail( $post->ID, 'large' );
		$slider.='<li>'.$img.'</li>';
		endwhile; endif; wp_reset_query();
		$slider.= '</ul></div>';	
		return $slider;
	}

	/**add the shortcode for the slider- for use in editor**/
	function efs_insert_slider($atts, $content=null)
	{ 
		$slider= efs_get_slider();
		return $slider;
	}
	add_shortcode('ef_slider', 'efs_insert_slider');

	/**add template tag- for use in themes**/
	function efs_slider()
	{
		print efs_get_slider();
	}
?>