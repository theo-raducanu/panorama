/* =======================================
	Scripts for Popout page on site load
	Daze Pop-out pages plugin
========================================== */
jQuery( document ).ready( function($) {
	"use strict";
	
	var isCat 	= on_load.is_cat,
		isPage 	= on_load.is_page;
	
	if( true == isCat ) {
		var hours = on_load.expires,
			popout_timeout = on_load.timeout,
			post_link = on_load.permalink,
			catID = on_load.cat_id,
			now = new Date().getTime(),
			set_delay = localStorage.getItem('daze_popout_delay_cat_'+catID);
		
		if( null == set_delay ) {
			if( 'true' !== localStorage.getItem('daze_popout_shown_cat_'+catID) ) {
				popout(post_link, popout_timeout);
				
				localStorage.setItem('daze_popout_shown_cat_'+catID,'true');
			}
			
			localStorage.setItem('daze_popout_delay_cat_'+catID, now);
			
		} else {
			if( ( now - set_delay ) > hours*60*60*1000 ) {
				localStorage.removeItem( 'daze_popout_delay_cat_'+catID );
				localStorage.removeItem( 'daze_popout_shown_cat_'+catID );
				
				if( 'true' !== localStorage.getItem('daze_popout_shown_cat_'+catID) ) {
					popout(post_link, popout_timeout);
					localStorage.setItem('daze_popout_shown_cat_'+catID,'true');
				}
				
				localStorage.setItem('daze_popout_delay_cat_'+catID, now);
			}
		}
		
	} else if( true == isPage ) {
		var hours = on_load.expires,
			popout_timeout = on_load.timeout,
			post_link = on_load.permalink,
			pageID = on_load.page_id,
			now = new Date().getTime(),
			set_delay = localStorage.getItem('daze_popout_delay_page_'+pageID);
		
		if( null == set_delay ) {
			if( 'true' !== localStorage.getItem('daze_popout_shown_page_'+pageID) ) {
				popout(post_link, popout_timeout);
				
				localStorage.setItem('daze_popout_shown_page_'+pageID,'true');
			}
			
			localStorage.setItem('daze_popout_delay_page_'+pageID, now);
			
		} else {
			if( ( now - set_delay ) > hours*60*60*1000 ) {
				localStorage.removeItem( 'daze_popout_delay_page_'+pageID );
				localStorage.removeItem( 'daze_popout_shown_page_'+pageID );
				
				if( 'true' !== localStorage.getItem('daze_popout_shown_page_'+pageID) ) {
					popout(post_link, popout_timeout);
					localStorage.setItem('daze_popout_shown_page_'+pageID,'true');
				}
				
				localStorage.setItem('daze_popout_delay_page_'+pageID, now);
			}
		}
		
	} else {
		var hours = on_load.expires,
			popout_timeout = on_load.timeout,
			post_link = on_load.permalink,
			now = new Date().getTime(),
			set_delay = localStorage.getItem('daze_popout_delay');
		
		if( null == set_delay ) {
			if( 'true' !== localStorage.getItem('daze_popout_shown') ) {
				popout(post_link, popout_timeout);
				
				localStorage.setItem('daze_popout_shown','true');
			}
			
			localStorage.setItem('daze_popout_delay', now);
			
		} else {
			if( ( now - set_delay ) > hours*60*60*1000 ) {
				localStorage.removeItem( 'daze_popout_delay' );
				localStorage.removeItem( 'daze_popout_shown' );
				
				if( 'true' !== localStorage.getItem('daze_popout_shown') ) {
					popout(post_link, popout_timeout);
					localStorage.setItem('daze_popout_shown','true');
				}
				
				localStorage.setItem('daze_popout_delay', now);
			}
		}
	}
});