/* ====================================
	Scripts for Popout page metaboxes
	Daze Pop-out pages plugin
======================================= */
jQuery( document ).ready( function($) {
	"use strict";
	
	var metabox = $( '#daze_popout_pages_meta_box-daze-popout-pages-meta-boxes' ),
		pages = metabox.find( '.daze-pages-list' ),
		chosenPages = $( '#daze_popout_on_load_pages' ),
		cats = metabox.find( '.daze-cats-list' ),
		chosenCats = $( '#daze_popout_on_load_cats' );
	
	function updateChosenPages() {
		var newPages = '';
		
		pages.find( '.daze-page' ).each( function() {
			var page = $(this);
			
			if( 'on' === page.attr( 'data-page-on' ) ) {
				var pageID = page.attr( 'data-page-id' );
				
				newPages += pageID + ',';
			}
		});
		
		chosenPages.val( newPages );
		chosenPages.change();
	}
	
	pages.on( 'click', '.daze-page', function() {
		var page = $(this),
			pageID = page.attr( 'data-page-id' );
		
		page.attr( 'data-page-on', function(index, attr) {
			return attr == 'off' ? 'on' : 'off';
		});
		
		updateChosenPages();
	});
	
	function updateChosenCats() {
		var newCats = '';
		
		cats.find( '.daze-cat' ).each( function() {
			var cat = $(this);
			
			if( 'on' === cat.attr( 'data-cat-on' ) ) {
				var catID = cat.attr( 'data-cat-id' );
				
				newCats += catID + ',';
			}
		});
		
		chosenCats.val( newCats );
		chosenCats.change();
	}
		
	cats.on( 'click', '.daze-cat', function() {
		var cat = $(this),
			catID = cat.attr( 'data-cat-id' );
		
		cat.attr( 'data-cat-on', function(index, attr) {
			return attr == 'off' ? 'on' : 'off';
		});
		
		updateChosenCats();
	});
});