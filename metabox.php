<?php

function um_change_url_metabox() {
	$screens = get_option(um_post_type_url_changer_post_types);
	foreach ( $screens as $screen ) {
		add_meta_box(
			'um_change_url_metabox',
			__( 'Enter a custom URL for this post', 'um_lang' ),
			'um_change_url_metabox_callback',
			$screen
		);
	}
}
add_action( 'add_meta_boxes', 'um_change_url_metabox' );

function um_change_url_metabox_callback( $post ) {
	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'um_change_url', 'um_change_url_nonce' );
	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
	$url = get_post_meta( $post->ID, 'um_custom_post_url', true );
	
	echo '<label for="um_change_url">';
	_e( 'Enter a URL if you want to change this post default URL', 'um_lang' );
	echo '</label><br/>';
	echo '<input type="text" id="um_change_url" name="um_change_url" value="' . esc_attr( $url ) . '" size="25" />';
}

function um_save_url_meta( $post_id ) {
	if ( ! isset( $_POST['um_change_url_nonce'] ) ) {
		return;
	}
	if ( ! wp_verify_nonce( $_POST['um_change_url_nonce'], 'um_change_url' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
	}
	if ( ! isset( $_POST['um_change_url'] ) ) {
		return;
	}

	$my_data = sanitize_text_field( $_POST['um_change_url'] );
	update_post_meta( $post_id, 'um_custom_post_url', $my_data );
}
add_action( 'save_post', 'um_save_url_meta' );
?>