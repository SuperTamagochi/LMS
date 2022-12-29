<?php

/**
 * Función para mostrar el listado de las diez lecciones del curso al final de cada lección
 *
 * @param int $lesson_id ID de la lección
 *
 * @return string Listado de lecciones
 */
function lms_plugin_display_lessons_list( $lesson_id ) {
	// Obtener el ID del curso al que pertenece la lección
	$course_id = get_post_meta( $lesson_id, '_lms_plugin_course_id', true );

	// Obtener la lista de lecciones del curso
	$lessons = get_posts( array(
		'post_type'   => 'lessons',
		'post_status' => 'publish',
		'numberposts' => 10,
		'meta_query'  => array(
			array(
				'key'     => '_lms_plugin_course_id',
				'value'   => $course_id,
				'compare' => '=',
			),
		),
	) );

	// Crear el listado de lecciones
	$lessons_list = '<ul>';
	foreach ( $lessons as $lesson ) {
		$lessons_list .= '<li><a href="' . get_permalink( $lesson ) . '">' . get_the_title( $lesson ) . '</a></li>';
	}
	$lessons_list .= '</ul>';

	// Devolver el listado de lecciones
	return $lessons_list;
}
