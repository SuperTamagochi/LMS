<?php

/**
 * Función para mostrar el número de cursos
 *
 * @return int Número de cursos
 */
function lms_plugin_get_courses_count() {
	// Obtener el número de cursos utilizando el contador de publicaciones de WordPress
	$courses_count = wp_count_posts( 'courses' );

	// Devolver el número de cursos publicados
	return $courses_count->publish;
}

/**
 * Función para mostrar el número de lecciones
 *
 * @return int Número de lecciones
 */
function lms_plugin_get_lessons_count() {
	// Obtener el número de lecciones utilizando el contador de publicaciones de WordPress
	$lessons_count = wp_count_posts( 'lessons' );

	// Devolver el número de lecciones publicadas
	return $lessons_count->publish;
}

/**
 * Función para mostrar el número de vídeos
 *
 * @return int Número de vídeos
 */
function lms_plugin_get_videos_count() {
	// Inicializar el contador de vídeos a 0
	$videos_count = 0;

	// Obtener todos los cursos
	$courses = get_posts( array(
		'post_type'   => 'courses',
		'post_status' => 'publish',
		'numberposts' => -1,
	) );

	// Recorrer los cursos y contar el número de vídeos en cada uno
	foreach ( $courses as $course ) {
		$videos_count += get_post_meta( $course->ID, '_lms_plugin_videos_count', true );
	}

	// Devolver el número de vídeos
	return $videos_count;
}

/**
 * Función para mostrar el shortcode que muestra el número de cursos, lecciones y vídeos
 *
 * @param array $atts Atributos del shortcode
 *
 * @return string Número de cursos, lecciones y vídeos
 */
function lms_plugin_stats_shortcode( $atts ) {
	// Obtener los valores predeterminados para los atributos
	$atts = shortcode_atts( array(
		'show_courses' => 'yes',
		'show_lessons' => 'yes',
		'show_videos'  => 'yes',
	), $atts );

	// Inicializar el resultado
	$result = '';

	// Mostrar el número de cursos si se ha habilitado en los atributos del shortcode
	if ( 'yes' === $atts['show_courses'] )
		$result .= sprintf( __( 'Hay %d cursos disponibles.', 'lms-plugin' ), lms_plugin_get_courses_count() );
	}

	// Mostrar el número de lecciones si se ha habilitado en los atributos del shortcode
	if ( 'yes' === $atts['show_lessons'] ) {
		$result .= sprintf( __( 'Hay %d lecciones disponibles.', 'lms-plugin' ), lms_plugin_get_lessons_count() );
	}

	// Mostrar el número de vídeos si se ha habilitado en los atributos del shortcode
	if ( 'yes' === $atts['show_videos'] ) {
		$result .= sprintf( __( 'Hay %d vídeos disponibles.', 'lms-plugin' ), lms_plugin_get_videos_count() );
	}

	// Devolver el resultado
	return $result;
}
add_shortcode( 'lms_stats', 'lms_plugin_stats_shortcode' );
