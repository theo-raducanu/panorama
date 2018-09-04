/* ====================================
	Styles for featured area metaboxes
	Daze Featured Area plugin
======================================= */
jQuery(document).ready( function($) {
	"use strict";
	
	var pf_metabox = $( "#daze_featured_area_meta_boxes-daze-featured-area-meta-boxes" ),
		image_metabox = pf_metabox.find( "#daze-featured-image" ),
		video_metabox = pf_metabox.find( "#daze-featured-video" ),
		audio_metabox = pf_metabox.find( "#daze-featured-audio" ),
		quote_metabox = pf_metabox.find( "#daze-featured-quote" ),
		link_metabox = pf_metabox.find( "#daze-featured-link" ),
		gallery_metabox = pf_metabox.find( "#daze-featured-gallery" ),
		format_saved_as = $( "input:radio[name=post_format]:checked" ).val();
	
// Hide all metaboxes initially
	$( ".daze-featured-metabox" ).hide();
	
// If the post has a post format assigned, open its metabox
	switch( format_saved_as ) {		
		case "image":
			pf_metabox.show();
			image_metabox.show();
			break;
			
		case "video":
			pf_metabox.show();
			video_metabox.show();
			break;
			
		case "audio":
			pf_metabox.show();
			audio_metabox.show();
			break;
			
		case "quote":
			pf_metabox.show();
			quote_metabox.show();
			break;
			
		case "link":
			pf_metabox.show();
			link_metabox.show();
			break;
			
		case "gallery":
			pf_metabox.show();
			gallery_metabox.show();
			break;
			
		default:
			pf_metabox.hide();
	}	
	
// Replace the metabox if the post format changes
	$( "input:radio[name=post_format]" ).change( function() {
		$( ".daze-featured-metabox" ).hide( 100, "swing" );
		
		switch( $(this).val() ) {		
			case "image":
				pf_metabox.show();
				image_metabox.show( 300, "swing" );
				break;
				
			case "video":
				pf_metabox.show();
				video_metabox.show( 300, "swing" );
				break;
				
			case "audio":
				pf_metabox.show();
				audio_metabox.show( 300, "swing" );
				break;
				
			case "quote":
				pf_metabox.show();
				quote_metabox.show( 300, "swing" );
				break;
				
			case "link":
				pf_metabox.show();
				link_metabox.show( 300, "swing" );
				break;
				
			case "gallery":
				pf_metabox.show();
				gallery_metabox.show( 300, "swing" );
				break;
				
			default:
				pf_metabox.hide( 100, "swing" );
		}
	});
});