<?php
	
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function block_slug_add_metabox() {

	$id            = 'block_slug';
	$title         = 'Block Slug';
	$callback      = 'block_slug_metabox';
	$screen        = null;
	$context       = 'side';
	$priority      = 'default';
	$callback_args = null;
	
	add_meta_box( $id, $title, $callback, $screen, $context, $priority, $callback_args );

}
add_action( 'add_meta_boxes', 'block_slug_add_metabox' );

function block_slug_metabox( $post ) {
	//global $post;
	
	$values = get_post_custom( $post->ID );
	$check  = isset( $values['block_slug_metabox_check'] ) ? esc_attr( $values['block_slug_metabox_check'][0] ) : '';
	
	?>
	<input type="checkbox" id="block_slug_metabox_check" name="block_slug_metabox_check" <?php checked( $check, 'on' ); ?> />
	<label for="block_slug_metabox_check"><?php _e( 'Check this if you want to protect the Slug', 'block-slug' ); ?></label>
	<?php
	wp_nonce_field( 'block_slug_meta_box_nonce', 'block_slug_meta_box_nonce' );
}

add_action( 'save_post', 'cd_meta_box_save' );

function cd_meta_box_save( $post_id ) {
	// Bail if we're doing an auto save
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! isset( $_POST['block_slug_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['block_slug_meta_box_nonce'], 'block_slug_meta_box_nonce' ) ) {
		return;
	}
	
	if ( ! current_user_can( 'edit_post' ) ) {
		return;
	}
	
	$check = isset( $_POST['block_slug_metabox_check'] ) && $_POST['block_slug_metabox_check'] ? 'on' : 'off';
	update_post_meta( $post_id, 'block_slug_metabox_check', $check );
}
