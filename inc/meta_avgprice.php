<?php

class avgprice_meta_box {
	private $screens = array(
		'bezirk_type', 'ot_type',
	);
	private $fields = array(
		array(
			'id' => 'avgeth',
			'label' => 'Hauskauf',
			'type' => 'number',
		),
		array(
			'id' => 'avgetw',
			'label' => 'Eigentumswohnung',
			'type' => 'number',
		),
		array(
			'id' => 'avgmw',
			'label' => 'Mietwohnung',
			'type' => 'number',
		),
	);

	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_post' ) );
	}

	public function add_meta_boxes() {
		foreach ( $this->screens as $screen ) {
			add_meta_box(
				'avgprices',
				__( 'Durchschnittspreise pro m²', 'cpt-avgprices' ),
				array( $this, 'add_meta_box_callback' ),
				$screen,
				'advanced',
				'default',
				array(
        	'__block_editor_compatible_meta_box' => true,
    		)
			);
		}
	}

	/**
	 * Generates the HTML for the meta box
	 *
	 * @param object $post WordPress post object
	 */
	public function add_meta_box_callback( $post ) {
		wp_nonce_field( 'avgprices_data', 'avgprices_nonce' );
		echo 'Hier können die aktuellen Durchschnittspreise pro m² für den jeweiligen Bezirk/Ortsteil angegeben werden.';
		$this->generate_fields( $post );
	}

	/**
	 * Generates the field's HTML for the meta box.
	 */
	public function generate_fields( $post ) {
		$output = '';
		foreach ( $this->fields as $field ) {
			$label = '<label for="' . $field['id'] . '">' . $field['label'] . '</label>';
			$db_value = get_post_meta( $post->ID, 'avgprices_' . $field['id'], true );
			switch ( $field['type'] ) {
				default:
					$input = sprintf(
						'<input %s id="%s" name="%s" type="%s" value="%s">',
						$field['type'] !== 'color' ? 'class="regular-text"' : '',
						$field['id'],
						$field['id'],
						$field['type'],
						$db_value
					);
			}
			$output .= $this->row_format( $label, $input );
		}
		echo '<table class="form-table"><tbody>' . $output . '</tbody></table>';
	}

	/**
	 * Generates the HTML for table rows.
	 */
	public function row_format( $label, $input ) {
		return sprintf(
			'<tr><th scope="row">%s</th><td>%s</td></tr>',
			$label,
			$input
		);
	}
	/**
	 * Hooks into WordPress' save_post function
	 */
	public function save_post( $post_id ) {
		if ( ! isset( $_POST['avgprices_nonce'] ) )
			return $post_id;

		$nonce = $_POST['avgprices_nonce'];
		if ( !wp_verify_nonce( $nonce, 'avgprices_data' ) )
			return $post_id;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;

		foreach ( $this->fields as $field ) {
			if ( isset( $_POST[ $field['id'] ] ) ) {
				switch ( $field['type'] ) {
					case 'email':
						$_POST[ $field['id'] ] = sanitize_email( $_POST[ $field['id'] ] );
						break;
					case 'text':
						$_POST[ $field['id'] ] = sanitize_text_field( $_POST[ $field['id'] ] );
						break;
				}
				update_post_meta( $post_id, 'avgprices_' . $field['id'], $_POST[ $field['id'] ] );
			} else if ( $field['type'] === 'checkbox' ) {
				update_post_meta( $post_id, 'avgprices_' . $field['id'], '0' );
			}
		}
	}
}
new avgprice_meta_box;

?>
