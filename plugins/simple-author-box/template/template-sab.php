<?php
if ( '1' == $sabox_options['sab_colored'] ) {
	$sabox_color = 'sabox-colored';
} else {
	$sabox_color = '';
}

if ( '0' != $sabox_options['sab_web_position'] ) {
	$sab_web_align = 'sab-web-position';
} else {
	$sab_web_align = '';
}

if ( '1' == $sabox_options['sab_web_target'] ) {
	$sab_web_target = '_blank';
} else {
	$sab_web_target = '_self';
}

if ( '1' == $sabox_options['sab_web_rel'] ) {
	$sab_web_rel = 'rel="nofollow"';
} else {
	$sab_web_rel = '';
}

$sab_author_link = sprintf( '<a href="%s" class="vcard author"><span class="fn">%s</span></a>', esc_url( get_author_posts_url( $sabox_author_id ) ), esc_html( get_the_author_meta( 'display_name', $sabox_author_id ) ) );

if ( get_the_author_meta( 'description' ) != '' || '0' == $sabox_options['sab_no_description'] ) { // hide the author box if no description is provided


	echo '<div class="saboxplugin-wrap">'; // start saboxplugin-wrap div

	// author box gravatar
	echo '<div class="saboxplugin-gravatar">';
	$custom_profile_image = get_the_author_meta( 'sabox-profile-image', $sabox_author_id );
	if ( '' != $custom_profile_image ) {
		echo '<img src="' . esc_url( $custom_profile_image ) . '">';
	} else {
		echo get_avatar( get_the_author_meta( 'user_email', $sabox_author_id ), '100' );
	}

	echo '</div>';

	// author box name
	echo '<div class="saboxplugin-authorname">';
	echo apply_filters( 'sabox_author_html', $sab_author_link, $sabox_options, $sabox_author_id );
	if ( is_user_logged_in() && get_current_user_id() == $sabox_author_id ) {
		echo '<a  class="sab-profile-edit" target="_blank" href="' . get_edit_user_link() . '"> ' . __( 'Edit profile', 'saboxplugin' ) . '</a>';
	}
	echo '</div>';


	// author box description
	echo '<div class="saboxplugin-desc">';
	echo '<div>';
	$description = get_the_author_meta( 'description', $sabox_author_id );
	$description = wptexturize( $description );
	$description = wpautop( $description );
	echo wp_kses_post( $description );
	echo '</div>';
	echo '</div>';

	if ( is_single() ) {
		if ( get_the_author_meta( 'user_url' ) != '' && '1' == $sabox_options['sab_web'] ) { // author website on single
			echo '<div class="saboxplugin-web ' . esc_attr( $sab_web_align ) . '">';
			echo '<a href="' . esc_url( get_the_author_meta( 'user_url', $sabox_author_id ) ) . '" target="' . esc_attr( $sab_web_target ) . '" ' . $sab_web_rel . '>' . esc_html( get_the_author_meta( 'user_url', $sabox_author_id ) ) . '</a>';
			echo '</div>';
		}
	}


	if ( is_author() or is_archive() ) {
		if ( get_the_author_meta( 'user_url' ) != '' ) { // force show author website on author.php or archive.php
			echo '<div class="saboxplugin-web ' . esc_attr( $sab_web_align ) . '">';
			echo '<a href="' . esc_url( get_the_author_meta( 'user_url', $sabox_author_id ) ) . '" target="' . esc_attr( $sab_web_target ) . '" ' . $sab_web_rel . '>' . esc_html( get_the_author_meta( 'user_url', $sabox_author_id ) ) . '</a>';
			echo '</div>';
		}
	}

	// author box clearfix
	echo '<div class="clearfix"></div>';

	// author box social icons
	$author            = get_userdata( $sabox_author_id );
	$show_social_icons = apply_filters( 'sabox_hide_social_icons', true, $author );



	if ( is_user_logged_in() && current_user_can( 'manage_options' ) ) {
		echo '<div class="sab-edit-settings">';
		echo '<a target="_blank" href="' . admin_url() . 'admin.php?page=simple-author-box-options">' . __( 'Settings', 'saboxplugin' ) . '<i class="dashicons dashicons-admin-settings"></i></a>';
		echo '</div>';
	}

	$show_email = '0' == $sabox_options['sab_email'] ? false : true;
	$social_links = Simple_Author_Box_Helper::get_user_social_links( $sabox_author_id, $show_email );

	if ( '0' == $sabox_options['sab_hide_socials'] && $show_social_icons && ! empty( $social_links ) ) { // hide social icons div option
		echo '<div class="saboxplugin-socials ' . esc_attr( $sabox_color ) . '">';
		
		foreach ( $social_links as $social_platform => $social_link ) {

			if ( 'user_email' == $social_platform ) {
				$social_link = 'mailto:' . antispambot( $social_link );
			}

			if ( ! empty( $social_link ) ) {
				echo Simple_Author_Box_Helper::get_sabox_social_icon( $social_link, $social_platform );
			}
		}


		echo '</div>';
	} // end of social icons
	echo '</div>'; // end of saboxplugin-wrap div
}
