<?php
/*
Plugin Name: Auto iFrame
Plugin URI: http://toolstack.com/auto-iframe
Description: A quick and easy shortcode to embed iframe's that resize to the content of the remote site.
Version: 0.5
Author: Greg Ross
Author URI: http://toolstack.com/
License: GPL2
*/

add_shortcode( 'auto-iframe', 'auto_iframe_shortcode' );

function auto_iframe_shortcode( $atts ) {
	/*
		Auto iFrame shortcode is in the format of:
		
			[auto-iframe link=xxx tag=xxx width=xxx height=xxx autosize=yes/no]
			
		Where:
			link = the url of the source for the iFrame.  REQUIRED.
			tag = a unique identifier in case you want more than one iFrame on a page.  Default = auto-iframe.
			width = width of the iFrame (100% by default).  Can be % or px.  Default = 100%.
			height = the initial height of the iframe (100% by default).  Can be % or px.  Default = 100%.
			autosize = enable the auto sizing of the iFrame based on the content.  The initial height of the iFrame will be set to "height" and then resized.  Default = true.
			fudge = a fudge factor to apply when changing the height (integer number, no "px").  Default = 50.
			border = enable the border on the iFrame.  Default = 0.
			scroll = enable the scroll bar on the iFrame.  Default = no.
	*/

	// We don't have any parameters, just return a blank string.
	if( !is_array( $atts ) ) { return ''; }
	
	// Enqueue the javascript and jquery code.
	wp_enqueue_script( 'auto_iframe_js', plugins_url( 'auto-iframe.js', __FILE__ ), array( 'jquery' ) );
	
	// Get the link.
	$link = '';
	if( array_key_exists( 'link', $atts ) ) { $link = htmlentities(trim( $atts['link'] ), ENT_QUOTES ); }
	
	// If no link has been passed in, there's nothing to do so just return a blank string.
	if( $link == '' ) { return ''; }
	
	// Get the rest of the attributes.
	$tag = 'auto-iframe';
	if( array_key_exists( 'tag', $atts ) ) { $tag = htmlentities(trim( $atts['tag'] ), ENT_QUOTES ); }
	
	$width = '100%';
	if( array_key_exists( 'width', $atts ) ) { $width = htmlentities(trim( $atts['width'] ), ENT_QUOTES ); }
	
	$height = '100%';
	if( array_key_exists( 'height', $atts ) ) { $height = htmlentities(trim( $atts['height'] ), ENT_QUOTES ); }
	
	$autosize = true;
	if( array_key_exists( 'autosize', $atts ) ) { if( strtolower( $atts['autosize'] ) != 'yes' ) { $autosize = false; } ; }
	
	$fudge = 50;
	if( array_key_exists( 'fudge', $atts ) ) { $fudge = intval( $atts['fudge'] ); }
	
	$border = '0';
	if( array_key_exists( 'border', $atts ) ) { $border = htmlentities(trim( $atts['border'] ), ENT_QUOTES ); }
	
	$scroll = 'no';
	if( array_key_exists( 'scroll', $atts ) ) { if( strtolower( $atts['autosize'] ) != 'yes' ) { $scroll = 'yes'; } ; }
	
	$result = '<script type="text/javascript">// <![CDATA[' . "\n";
	$result .= 'jQuery(document).ready(function(){' . "\n";
	$result .= '	setInterval( function() { AutoiFrameAdjustiFrameHeight( \'' . $tag . '\', 200); }, 1000 );' . "\n";
	$result .= '});' . "\n";
	$result .= '// ]]></script>' . "\n";

	$result .= '<iframe id="' . $tag . '" src="' . $link . '" width="' . $width . '" height="' . $height . '" frameborder="' . $border . '" scrolling="' . $scroll . '" onload="AutoiFrameAdjustiFrameHeight(\'' . $tag . '\',' . $fudge . ');"></iframe>';

	return $result;
}		

?>