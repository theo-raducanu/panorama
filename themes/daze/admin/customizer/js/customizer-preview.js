/* ===============================================
	CUSTOMIZER PREVIEW
	Daze - Premium WordPress Theme, by NordWood
================================================== */
(function($) {
	"use strict";
	$(document).ready( function() {
		
	// Sticky banner height
		wp.customize( 'daze_sticky_banner_height', function(value) {
			value.bind( function(v) {
				if(v) {
					$( '.sticky-banner img' ).css({ "height":v });					
				}
			});
		});
		
	// Sticky banner position
		wp.customize( 'daze_sticky_banner_position', function(value) {
			value.bind( function(v) {
				if( 'bottom-right' === v ) {
					$( '.sticky-banner' ).css({ "right":"7px", "left":"auto" });					
				}
				
				if( 'bottom-left' === v ) {
					$( '.sticky-banner' ).css({ "left":"7px", "right":"auto" });	
				}
			});
		});
		
	// Sticky banner close button
		wp.customize( 'daze_sticky_banner_close', function(value) {
			value.bind( function(v) {
				if ( v ) {
					$( '.sticky-banner' ).find( '.close' ).fadeIn();
					
				} else {					
					$( '.sticky-banner' ).find( '.close' ).fadeOut();
				}
				
			});
		});		
	});	
})(jQuery);