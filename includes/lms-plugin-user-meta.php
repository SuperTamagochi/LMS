<?php

/**
 * Clase para gestionar la marcación de cursos y lecciones como completados y/o favoritos por parte de los usuarios
 */
class LMS_Plugin_User_Meta {

	/**
	 * Constructor de la clase
	 */
	public function __construct() {
		// Añadir la acción para guardar la marcación de cursos y lecciones como completados y/o favoritos
		add_action( 'wp_ajax_lms_plugin_save_user_meta', array( $this, 'save_user_meta' ) );
	}

	/**
	 * Función para guardar la marcación de cursos y lecciones como completados y/o favoritos
	 */
	public function save_user_meta() {
		// Verificar el nonce
		check_ajax_referer( 'lms_plugin_save_user_meta', 'nonce' );

		// Verificar el permiso
		if ( ! current_user_can( 'edit_posts' ) ) {
			wp_send_json_error();
		}

		// Obtener los datos enviados por AJAX
		$post_id   = isset( $_POST['post_id'] ) ? intval( $_POST['post_id'] ) : 0;
		$post_type = isset( $_POST['post_type'] ) ? sanitize_key( $_POST['post_type'] ) : '';
		$completed = isset( $_POST['completed'] ) ? (bool) $_POST['completed'] : false;
		$favorite  = isset( $_POST['favorite'] ) ? (bool) $_POST['favorite'] : false;

		// Obtener el ID del usuario actual
		$user_id = get_current_user_id();

		// Verificar si el usuario ya ha marcado el curso o la lección como completado o favorito
		$user_meta = get_user_meta( $user_id, '_lms_plugin_user_meta', true );
		if ( empty( $user_meta ) ) {
			$user_meta = array();
		}

		// Verificar si se ha marcado el curso o la lección como completado o favorito
		if ( $completed || $favorite ) {
			// Añadir el curso o la lección al array de cursos o lecciones marcados como completados o favoritos
			$user_meta[ $post_type ][ $post_id ] = array(
				'completed' => $completed,
				'favorite'  => $favorite,
			);
		} else {
			// Eliminar el curso o la lección del array de cursos o lecciones marcados como completados o favoritos
			unset( $user_meta[ $post_type ][ $post_id ] );
		}

		// Guardar los datos de marcación de cursos y lecciones como completados y/o favoritos en la base de datos
		update_user_meta( $user_id, '_lms_plugin_user_meta', $user_meta );

		// Enviar una respuesta JSON
		wp_send_json_success();
	}

}

new LMS_Plugin_User_Meta();


