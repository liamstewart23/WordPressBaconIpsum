<?php
/*
Plugin Name: Bacon Ipsum Shortcode
Plugin URI: https://github.com/liamstewart23/WordPressBaconIpsum
Description: 🥓 Shortcode for Bacon Ipsum dummy content. Built using baconipsum.com JSON API 🥓
Version: 1.0.0
Author: Liam Stewart
Author URI: https://liamstewart.ca
*/

/**
 * @param $atts
 *
 * @return string
 */
function ls_bacon($atts){
    extract(shortcode_atts(array(
        'p' => 1,//paras: optional number of paragraphs, defaults to 5.
        't' => 'all-meat',//type: all-meat for meat only or meat-and-filler for meat mixed with miscellaneous ‘lorem ipsum’ filler.
        's' => 0//start-with-lorem: optional pass 1 to start the first paragraph with ‘Bacon ipsum dolor sit amet’.
    ), $atts));

    $shortcode="<script>jQuery(document).ready(function() 
{
		jQuery.getJSON('https://baconipsum.com/api/?callback=?', 
			{ 'type':'".$t."', 'start-with-lorem':'".$s."', 'paras':'".$p."' }, 
			function(baconGoodness)
		{
			if (baconGoodness && baconGoodness.length > 0)
			{
				jQuery(\"#baconIpsumOutput\").html('');
				for (var i = 0; i < baconGoodness.length; i++)
					jQuery(\"#baconIpsumOutput\").append('<p>' + baconGoodness[i] + '</p>');
				jQuery(\"#baconIpsumOutput\").show();
			}
		});
	
});</script><span id='baconIpsumOutput'></span>";

    return $shortcode;//return the meat
}

function ls_bacon_register_shortcodes(){
    add_shortcode('bacon', 'ls_bacon');// register shortcode
    add_filter('widget_text', 'do_shortcode');// shortcodes in widgets
    add_filter( 'the_excerpt', 'do_shortcode');// shortcodes in widgets
    add_filter( 'comment_text', 'do_shortcode' );// shortcodes in comments
}
add_action( 'init', 'ls_bacon_register_shortcodes');// init

