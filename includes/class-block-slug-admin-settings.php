<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'Block_Slug_Admin_Settings', false ) ) {
	return new Block_Slug_Admin_Settings();
}


/**
 * Block_Slug_Admin_Settings Class.
 */
class Block_Slug_Admin_Settings {

	/**
	 * Permalink settings.
	 *
	 * @var array
	 */
	private $options = array();

	/**
	 * Hook in tabs.
	 */
	public function __construct() {
		$this->settings_init();
		$this->settings_save();
	}
	
	private function block_slug_get_options() {
		$saved_options = (array) get_option( 'block_slug_options', array() );
		$options       = wp_parse_args(
			array_filter( $saved_options ), array(
				'active_block_slug' => __( 'active-block-slug', 'block-slug' ),
			)
		);
	
		if ( $saved_options !== $options ) {
			update_option( 'block_slug_options', $options );
		}
	
		$options['active_block_slug'] = sanitize_text_field( $options['active_block_slug'] );
	
		return $options;
	}
	/**
	 * Init our settings.
	 */
	public function settings_init() {
		add_settings_section( 'block-slug', __( 'Block Slug', 'block-slug' ), array( $this, 'settings' ), 'permalink' );
	}
	
	public function activate_global_block_slug() {
	?>
	<input name="block-slug-activate" id="block-slug-activate" type="checkbox" value="1" <?php checked( '1' === get_option( 'block-slug-activate' ) ); ?> />
	<?php
	}

	/**
	 * Show the settings.
	 */
	public function settings() {
		/* translators: %s: Home URL */
	echo wp_kses_post( wpautop( __( 'Settings for Block Slug', 'block-slug' ) ) );

		?>
		<table class="form-table block-slug-settings">
			<tbody>
				<tr>
					<th scope="row"><?php esc_html_e( 'Activate Block Slug', 'block-slug' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php esc_html_e( 'Activate Block Slug', 'block-slug' ); ?></span></legend>
							<label for="block-slug-activate">
								<input name="block-slug-activate" id="block-slug-activate" type="checkbox" value="1" <?php checked( '1' === get_option( 'block-slug-activate' ) ); ?> />
								<?php esc_html_e( 'Allow only admins to edit Slugs', 'block-slug' ); ?>
							</label>
						</fieldset>
					</td>
				</tr>
			</tbody>
		</table>
		<?php
		wp_nonce_field( 'block-slug', 'block-slug-nonce' );
	}

	/**
	 * Save the settings.
	 */
	public function settings_save() {
		if ( ! is_admin() ) {
			return;
		}

		// We need to save the options ourselves; settings api does not trigger save for the permalinks page.
		if ( isset( $_POST['block-slug-nonce'] ) && wp_verify_nonce( wp_unslash( $_POST['block-slug-nonce'] ), 'block-slug' ) ) {
			if ( isset( $_POST['block-slug-activate'] ) ) {
				update_option( 'block-slug-activate', $_POST['block-slug-activate'] );
			} else {
				delete_option( 'block-slug-activate' );
			}
		}
	}
}
return new Block_Slug_Admin_Settings();
