<?php

/**
 * Función para añadir los campos personalizados para los cursos
 */
function lms_plugin_add_custom_fields_for_courses() {
	// Añadir campo personalizado para la duración del curso
	add_meta_box(
		'lms_plugin_duration',
		__( 'Duración del curso', 'lms-plugin' ),
		'lms_plugin_duration_callback',
		'course',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'lms_plugin_add_custom_fields_for_courses' );

/**
 * Función de callback para mostrar el campo personalizado de la duración del curso
 *
 * @param WP_Post $post La instancia del objeto WP_Post que se está editando.
 */
function lms_plugin_duration_callback( $post ) {
	wp_nonce_field( basename( __FILE__ ), 'lms_plugin_duration_nonce' );
	$duration = get_post_meta( $post->ID, '_lms_plugin_duration', true );
	echo '<label for="lms_plugin_duration">' . __( 'Ingrese la duración del curso en horas:', 'lms-plugin' ) . '</label> ';
	echo '<input type="number" id="lms_plugin_duration" name="lms_plugin_duration" value="' . esc_attr( $duration ) . '" min="1" step="1" style="width: 100%">';
}

/**
 * Función para guardar el valor del campo personalizado de la duración del curso
 *
 * @param int $post_id El ID del post que se está guardando.
 */
function lms_plugin_save_custom_fields_for_courses( $post_id ) {
	// Comprobar si se ha realizado una autenticación noce y si el usuario tiene permisos para editar el post
	if ( ! isset( $_POST['lms_plugin_duration_nonce'] ) || ! wp_verify_nonce( $_POST['lms_plugin_duration_nonce'], basename( __FILE__ ) ) || ! current_user_can( 'edit_post', $post_id ) ) {
	return;
}
	// Guardar el valor del campo personalizado de la duración del curso
	$duration = isset( $_POST['lms_plugin_duration'] ) ? intval( $_POST['lms_plugin_duration'] ) : '';
	update_post_meta( $post_id, '_lms_plugin_duration', $duration );
}
add_action( 'save_post_course', 'lms_plugin_save_custom_fields_for_courses' );

/**
 * Función para añadir los campos personalizados para las lecciones
 */
function lms_plugin_add_custom_fields_for_lessons() {
	// Añadir campo personalizado para la duración de la lección
	add_meta_box(
		'lms_plugin_duration',
		__( 'Duración de la lección', 'lms-plugin' ),
		'lms_plugin_duration_callback',
		'lesson',
		'normal',
		'high'
	);
	// Añadir campo personalizado para el curso al que pertenece la lección
	add_meta_box(
		'lms_plugin_course',
		__( 'Curso al que pertenece la lección', 'lms-plugin' ),
		'lms_plugin_course_callback',
		'lesson',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'lms_plugin_add_custom_fields_for_lessons' );

/**
 * Función de callback para mostrar el campo personalizado de la duración de la lección
 *
 * @param WP_Post $post La instancia del objeto WP_Post que se está editando.
 */
function lms_plugin_duration_callback( $post ) {
	wp_nonce_field( basename( __FILE__ ), 'lms_plugin_duration_nonce' );
	$duration = get_post_meta( $post->ID, '_lms_plugin_duration', true );
	echo '<label for="lms_plugin_duration">' . __( 'Ingrese la duración de la lección en minutos:', 'lms-plugin' ) . '</label> ';
	echo '<input type="number" id="lms_plugin_duration" name="lms_plugin_duration" value="' . esc_attr( $duration ) . '" size="25" />';
}

/**
 * Función de callback para mostrar el campo personalizado del curso al que pertenece la lección
 *
 * @param WP_Post $post La instancia del objeto WP_Post que se está editando.
 */
function lms_plugin_course_callback( $post ) {
	$courses = get_posts( array(
		'post_type'      => 'course',
		'posts_per_page' => -1,
	) );
	$selected_course = get_post_meta( $post->ID, '_lms_plugin_course', true );
	echo '<label for="lms_plugin_course">' . __( 'Seleccione el curso al que pertenece la lección:', 'lms-plugin' ) . '</label> ';
	echo '<select id="lms_plugin_course" name="lms_plugin_course">';
	echo '<option value="">' . __( 'Ninguno', 'lms-plugin' ) . '</option>';
	foreach ( $courses as $course ) {
		echo '<option value="' . esc_attr( $course->ID ) . '" ' . selected( $selected_course, $course->ID, false ) . '>' . esc_html( $course->post_title ) . '</option>';
	}
	echo '</select>';
}

/**
 * Guardar los campos personalizados cuando se guarda el curso o la lección
 *
 * @param int      $post_id El ID del post que se está guardando.
 * @param WP_Post $post    La instancia del objeto WP_Post que se está guardando.
 */
function lms_plugin_save_custom_fields( $post_id, $post ) {
	if ( ! isset( $_POST['lms_plugin_duration_nonce'] ) || ! wp_verify_nonce( $_POST['lms_plugin_duration_nonce'], basename( __FILE__ ) ) || ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	if ( isset( $_POST['lms_plugin_duration'] ) ) {
		update_post_meta( $post_id, '_lms_plugin_duration', sanitize_text_field( $_POST['lms_plugin_duration'] ) );
	}
	if ( isset( $_POST['lms_plugin_course'] ) ) {
		update_post_meta( $post_id, '_lms_plugin_course', absint( $_POST['lms_plugin_course'] ) );
	}
}

new LMS_Plugin_Custom_Fields();