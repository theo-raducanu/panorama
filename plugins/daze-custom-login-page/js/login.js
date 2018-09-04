/* ============================
	Scripts for login page
	Daze Custom Login Page
=============================== */
jQuery( document ).ready( function($) {
	"use strict";
	
	var titleBefore 		= args.title_before + ' ',
		titleAfter 			= ' ' + args.title_after,
		bgr 				= args.bgr,
		bgrClr 				= args.bgr_color,
		bgrImgSRC 			= args.bgr_img,
		txtClr 				= args.text_color,
		fieldsBgr			= args.fields_bgr,
		fieldsSolidClr		= args.fields_solid_color;
	
	$( 'body.login h1 a' ).css({ "background":"none", "height":"auto", "text-indent":0 }).prepend(titleBefore).append(titleAfter);
		
	$( 'body.login' ).find( '*' ).css({ 'color':txtClr, 'border-color':txtClr });
	$( 'body.login' ).find( '.message' ).css({ 'background-color':fieldsBgr });
	$( 'body.login' ).find( 'input' ).css({ 'background-color':fieldsBgr });
	$( 'body.login' ).find( 'input#wp-submit' ).css({ 'color':fieldsSolidClr, 'background-color':txtClr });
	
	if ( ( 'image' === bgr || 'pattern' === bgr ) && undefined != bgrImgSRC ) {
		$( 'body.login' ).css({ 'background-image':'url(' + bgrImgSRC + ')' });
		
		if ( 'pattern' === bgr ) {
			$( 'body.login' ).addClass( 'pattern' );
			
		} else {
			$( 'body.login' ).removeClass( 'pattern' );
		}
		
	} else {
		$( 'body.login' ).css({ 'background-color':bgrClr });
	}
	
	var showNWlogo = args.show_nw_logo,
		NWLogo = args.nw_logo;
		
	if ( 1 == showNWlogo ) {
		$("body.login").append('<div class="nordwood-admin-footer"><a href="http://nordwoodthemes.com/" target="_blank" ><img src="'+NWLogo+'" alt="NordWood Themes" title="NordWood Themes" /></a></div>');
	}	
	
    $(window).on('resize', function() {
		var windowH = window.innerHeight,
			loginBoxH = $("body.login div#login").outerHeight(),
			vertSpace = windowH - loginBoxH;
		
		if( vertSpace > 100 ) {
			$("body.login .nordwood-admin-footer").addClass( "absBottom" );
			
		} else {
			$("body.login .nordwood-admin-footer").removeClass( "absBottom" );
		}
		
    }).trigger('resize');
});