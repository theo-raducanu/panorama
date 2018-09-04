/* ================================================
	Scripts for uploading images to gallery field
	Daze Featured Area plugin
=================================================== */
	jQuery(function($){
	"use strict";
	
	var frame,
		gall_metabox = $('#daze_featured_area_meta_boxes-daze-featured-area-meta-boxes'),
		add_imgs_bttn = gall_metabox.find( '.add-images' ),
		remove_imgs_bttn = gall_metabox.find( '.remove-all' ),
		remove_img = gall_metabox.find( '.remove-image' ),
		gall_preview = gall_metabox.find( '.gallery-preview' ),
		gall_ids = gall_metabox.find( '.gallery-ids' ),	
		get_current_ids = gallargs.get_current_imgs;
		
// Insert selected images from media library into gallery
	add_imgs_bttn.on( 'click', function( event ){
		event.preventDefault();

		if ( frame ) {
			frame.open();
			return;
		}

		frame = wp.media({
			title: 'Select or upload images for the gallery',
			library: {
				type: 'image'
			},
			button: {
				text: 'Add to gallery'
			},
			multiple: true
		});

		frame.on( 'select', function() {
			var selected_ids_array = [],
				images_selection = frame.state().get('selection');
				
			images_selection.map( function(attachment) {
				selected_ids_array.push( attachment.toJSON() );
			});			
			
			var added_image = '';
			
			for ( var i in selected_ids_array ) {
			// Append the new ids to the current array
				gall_ids.val(
					gall_ids.val()
					+ ( gall_ids.val() ? ', ' : '' )
					+ selected_ids_array[i].id
				);
				
				get_current_ids.push( selected_ids_array[i].id.toString() );
			
			// Preview the chosen images
				added_image = '';
				added_image += '<div class="img-wrapper">';
				added_image += '<img src="'+selected_ids_array[i].sizes.thumbnail.url+'" class="gallery-img" />';
				
				added_image += '<input type="hidden" class="img-id"';
				added_image += 'id="img-id-' + selected_ids_array[i].id + '"';
				added_image += 'name="img-id-' + selected_ids_array[i].id + '"';
				added_image += 'value="' + selected_ids_array[i].id + '"';
				added_image += '>';
				
				added_image += '<span class="remove-image">X</span>';
				added_image += '</div>';
				
				gall_preview.append( added_image );				
			} 
		});

		frame.open();
	});
	
// Remove a single image
	gall_preview.on( 'click', '.remove-image', function( event ){
		event.preventDefault();

		var image_id = $(this).siblings('.img-id').val();

		$(this).parent().fadeOut(200, function(){
			$(this).remove();
		});
		
		get_current_ids.splice( get_current_ids.indexOf( image_id ), 1 );
		gall_ids.val( get_current_ids.join(", ") );
	});
	
// Remove all images
	remove_imgs_bttn.on( 'click', function( event ){
		event.preventDefault();

		gall_preview.html( '' );
		gall_ids.val( '' );
	});

// Make images sortable
	gall_preview.sortable().bind( 'sortupdate', function( e, ui ) {
		var new_order = [];
		
		$(".img-wrapper").each(function(){
			var $el = $(this).find('.img-id').val();
			new_order.push($el);
		});
		
		gall_ids.val('');
		gall_ids.val(new_order.join(", "));
	});
});