<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function block_slug_check_values( $post_ID, $post_after, $post_before ) {
	
	$slug    = get_post_field( 'post_name', $post_ID );
	$slug_2  = get_post_meta( $post_ID, '_wp_old_slug', true );

	if ( ! empty( $slug_2 ) && current_user_can( 'manage_options' ) ) {
		if ( $slug !== $slug_2 ) {
			delete_post_meta( $post_ID, '_wp_old_slug' );
			$arg =  array(
				'ID'        => $post_ID,
				'post_name' => $slug_2,
				);
			$result = wp_update_post( $arg );
			
			delete_post_meta( $post_ID, '_wp_old_slug' );
			add_post_meta( $post_ID, '_wp_old_slug', $slug_2 );
		}
	}
	
	if ( $slug !== $slug_2 ) {
		
		$to      = 'j.conti@joseconti.com';
		$subject = 'El Slug ha cambiado';
		$body    = 'Post ID:' . $post_ID . '<br />';
		$body   .= 'Slug After: ' . $slug . '<br />';
		$body   .= 'Slug Before:' . $slug_2 . '<br />';
		$body   .= '$result:' . $result . '<br />';
		$headers = array('Content-Type: text/html; charset=UTF-8');

		wp_mail( $to, $subject, $body, $headers );

	}
}

add_action( 'post_updated', 'block_slug_check_values', 10, 3 );
