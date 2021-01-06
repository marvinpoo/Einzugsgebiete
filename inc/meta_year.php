<?php

class Rational_Meta_Box {
	private $screens = array(
		'brw_type',
	);
	private $fields = array(
		array(
			'id' => '2015',
			'label' => '2015',
			'type' => 'number',
		),
		array(
			'id' => '2016',
			'label' => '2016',
			'type' => 'number',
		),
		array(
			'id' => '2017',
			'label' => '2017',
			'type' => 'number',
		),
		array(
			'id' => '2018',
			'label' => '2018',
			'type' => 'number',
		),
		array(
			'id' => '2019',
			'label' => '2019',
			'type' => 'number',
		),
		array(
			'id' => '2020',
			'label' => '2020',
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
				'bodenrichtwerte',
				__( 'Bodenrichtwerte', 'cpt-brw_year' ),
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
		wp_nonce_field( 'bodenrichtwerte_data', 'bodenrichtwerte_nonce' );
		echo 'Hier die Bodenrichtwerte für diese Zone angeben.';
		$this->generate_fields( $post );
	}

	/**
	 * Generates the field's HTML for the meta box.
	 */
	public function generate_fields( $post ) {
		$output = '';
		foreach ( $this->fields as $field ) {
			$label = '<label for="' . $field['id'] . '">' . $field['label'] . '</label>';
			$db_value = get_post_meta( $post->ID, 'bodenrichtwerte_' . $field['id'], true );
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
		if ( ! isset( $_POST['bodenrichtwerte_nonce'] ) )
			return $post_id;

		$nonce = $_POST['bodenrichtwerte_nonce'];
		if ( !wp_verify_nonce( $nonce, 'bodenrichtwerte_data' ) )
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
				update_post_meta( $post_id, 'bodenrichtwerte_' . $field['id'], $_POST[ $field['id'] ] );
			} else if ( $field['type'] === 'checkbox' ) {
				update_post_meta( $post_id, 'bodenrichtwerte_' . $field['id'], '0' );
			}
		}
	}
}
new Rational_Meta_Box;

?>
