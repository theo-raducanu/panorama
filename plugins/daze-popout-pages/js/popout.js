/* ============================
	Scripts Popout page
	Daze Pop-out pages plugin
=============================== */
	"use strict";

	function popout(post_link, pop_timeout) {
	// Remove the previously opened lightboxes
		if( $(".popout-holder").length > 0 )
			$('.popout-holder-overlay').detach();
		
		var top,
			holder_top,
			content_height;
			
	// Build a clone
		var popout_0 = '<div class="popout-clone-holder">';
			popout_0 += '<div class="popout-clone-wrapper"></div>';
			popout_0 += '</div>';
			
		$("body").prepend(popout_0);
		
	// Insert the post content
		$( ".popout-clone-wrapper" ).load(post_link, function() {			
			$( ".popout-clone-wrapper" ).imagesLoaded( function() {
			// Calculate the clone's height
				content_height = $( ".popout-clone-wrapper" ).height();
				
				if( window.innerHeight > content_height ) {
					holder_top = ( window.innerHeight/2 ) - ( content_height/2 );
					top = holder_top + 'px';
					content_height = content_height-1 + 'px';
					
				} else {
					top = ( window.innerWidth > 1023 )
					? '75px'
					: '6%';
					
					content_height = 'auto';
				}
				
			// Build the popout
				setTimeout(
					function() {
						var popout = '<div class="popout-holder-overlay">';
							popout += '<div class="popout-holder" style="margin-top:' + top + ';">';
							popout += '<span class="popout-close va-middle"><svg x="0px" y="0px" width="14.484px" height="14.484px" viewBox="9.758 9.758 14.484 14.484" enable-background="new 9.758 9.758 14.484 14.484"><g><path d="M10.05,23.95c0.39,0.39,1.024,0.39,1.414,0L17,18.414l5.536,5.536c0.39,0.39,1.024,0.39,1.414,0s0.39-1.024,0-1.414 L18.414,17l5.536-5.536c0.39-0.39,0.39-1.024,0-1.414c-0.39-0.39-1.024-0.39-1.414,0L17,15.586l-5.536-5.536 c-0.39-0.39-1.024-0.39-1.414,0c-0.39,0.39-0.39,1.024,0,1.414L15.586,17l-5.536,5.536C9.66,22.926,9.66,23.561,10.05,23.95z"/></g></svg></span>';	
							popout += '<div class="popout-wrapper" style="height:' + content_height + ';"></div>';		
							popout += '</div>';		
							popout += '</div>';
						
						$(".popout-clone-holder").remove();
				
						$("html,body").addClass("popout-active");
						$("body").prepend(popout);
						
					// Insert the post content
						$(".popout-wrapper").html("content loading");
						$(".popout-wrapper").load(post_link, function() {
							
							$("body").find('.popout-holder-overlay').addClass('reveal');
							
							$('.popout-holder').prepend('<svg class="popout-bgr"><rect class="frame" width="1" height="1" stroke="#fff"></rect></svg>').addClass('reveal').find('.popout-wrapper').addClass('reveal');
							$('.popout-holder').find('.popout-close').addClass('reveal');
							
							
						// Close the lightbox on close button
							$('.popout-holder').on('click', '.popout-close', function (e) {
								remove_popout();
							});
					
						// Close the lightbox on esc
							$(document).keyup(function(e) {
								if (e.keyCode === 27) {
									remove_popout();
								}
							});
							
						// Close the lightbox by clicking outside of it
							$(document).on('click', function (e) {
								if ($(e.target).closest(".popout-holder").length === 0) {
									remove_popout();
								}
							});
						});
					},
					pop_timeout*1000
				);
			});
		});
	}

function remove_popout() {
	"use strict";
	
	$('.popout-wrapper').removeClass('reveal');
	$('.popout-holder').removeClass('reveal').find('.popout-close').removeClass('reveal');
	$('.popout-holder').find('svg.popout-bgr').fadeOut();
	
	$('.popout-holder-overlay').delay(800).queue(
		function() {		
			$(this).remove();
			$("html,body").removeClass("popout-active");					
		}
	);
}

jQuery( document ).ready( function($) {
	"use strict";
	
	var popoutLink = $( '.menu-item-object-popout a, a.popout-page' ),
		postlink;
		
	$(document).on( 'click auxclick contextmenu', '.menu-item-object-popout a, a.popout-page', function(e) {
		e.preventDefault();
				
		if ( 1 === e.which ) {		
			postlink = $(this).attr("href");		
			popout(postlink, 0);
		}
		
		return false;
	});
});