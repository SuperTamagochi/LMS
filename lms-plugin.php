<?php
/*
 * Plugin Name: LMS Plugin
 * Plugin URI:  https://ejemplo.com/lms-plugin
 * Description: Este plugin agrega un Custom post type para un sistema de gestión del aprendizaje (LMS) y permite a los usuarios marcar los cursos y lecciones como completados y/o favoritos. También incluye shortcodes para mostrar el número de cursos, lecciones y videos y para mostrar un listado de las diez lecciones del curso al final de cada lección.
 * Version:     1.0
 * Author:      Tu nombre
 * Author URI:  https://tu-sitio-web.com
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: lms-plugin
 * Domain Path: /languages
 */

// Evitar el acceso directo a este archivo
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Función para registrar el Custom post type para los cursos
 */
function lms_plugin_register_cpt_courses() {

	$labels = array(
		'name'                  => _x( 'Cursos', 'Post Type General Name', 'lms-plugin' ),
		'singular_name'         => _x( 'Curso', 'Post Type Singular Name', 'lms-plugin' ),
		'menu_name'             => __( 'Cursos', 'lms-plugin' ),
		'name_admin_bar'        => __( 'Curso', 'lms-plugin' ),
		'archives'              => __( 'Archivo de cursos', 'lms-plugin' ),
		'attributes'            => __( 'Atributos del curso', 'lms-plugin' ),
		'parent_item_colon'     => __( 'Curso padre:', 'lms-plugin' ),
		'all_items'             => __( 'Todos los cursos', 'lms-plugin' ),
		'add_new_item'          => __( 'Añadir nuevo curso', 'lms-plugin' ),
		'add_new'               => __( 'Añadir nuevo', 'lms-plugin' ),
		'new_item'              => __( 'Nuevo curso', 'lms-plugin' ),
		'edit_item'             => __( 'Editar curso', 'lms-plugin' ),
		'update_item'           => __( 'Actualizar curso', 'lms-plugin' ),
		'view_item'             => __( 'Ver curso', 'lms-plugin' ),
		'view_items'            => __( 'Ver cursos', 'lms-plugin' ),
		'search_items'          => __( 'Buscar cursos', 'lms-plugin' ),
		'not_found'             => __( 'No se han encontrado cursos', 'lms-plugin' ),
		'not_found_in_trash'    => __( 'No se han encontrado cursos en la papelera', 'lms-plugin' ),
		'featured_image'        => __( 'Imagen destacada', 'lms-plugin' ),
		'set_featured_image'    => __( 'Establecer imagen destacada', 'lms-plugin' ),
		'remove_featured_image' => __( 'Eliminar imagen destacada', 'lms-plugin' ),
		'use_featured_image'    => __( 'Usar como imagen destacada', 'lms-plugin' ),
		'insert_into_item'      => __( 'Insertar en el curso', 'lms-plugin' ),
		'uploaded_to_this_item' => __( 'Subido a este curso', 'lms-plugin' ),
		'items_list'            => __( 'Lista de cursos',
		'items_list_navigation' => __( 'Navegación de la lista de cursos', 'lms-plugin' ),
		'filter_items_list'     => __( 'Filtrar lista de cursos', 'lms-plugin' ),
	);
	$args = array(
		'label'                 => __( 'Curso', 'lms-plugin' ),
		'description'           => __( 'Cursos para el sistema de gestión del aprendizaje (LMS)', 'lms-plugin' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields' ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-welcome-learn-more',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'show_in_rest'          => true,
	);
	register_post_type( 'courses', $args );

}
add_action( 'init', 'lms_plugin_register_cpt_courses', 0 );

/**
 * Función para registrar el Custom post type para las lecciones
 */
function lms_plugin_register_cpt_lessons() {

	$labels = array(
		'name'                  => _x( 'Lecciones', 'Post Type General Name', 'lms-plugin' ),
		'singular_name'         => _x( 'Lección', 'Post Type Singular Name', 'lms-plugin' ),
		'menu_name'             => __( 'Lecciones', 'lms-plugin' ),
		'name_admin_bar'        => __( 'Lección', 'lms-plugin' ),
		'archives'              => __( 'Archivo de lecciones', 'lms-plugin' ),
		'attributes'            => __( 'Atributos de la lección', 'lms-plugin' ),
		'parent_item_colon'     => __( 'Lección padre:', 'lms-plugin' ),
		'all_items'             => __( 'Todas las lecciones', 'lms-plugin' ),
		'add_new_item'          => __( 'Añadir nueva lección', 'lms-plugin' ),
		'add_new'               => __( 'Añadir nueva', 'lms-plugin' ),
		'new_item'              => __( 'Nueva lección', 'lms-plugin' ),
		'edit_item'             => __( 'Editar lección', 'lms-plugin' ),
		'update_item'           => __( 'Actualizar lección', 'lms-plugin' ),
		'view_item'             => __( 'Ver lección', 'lms-plugin' ),
		'view_items'            => __( 'Ver lecciones', 'lms-plugin' ),
		'search_items'          => __( 'Buscar lecciones', 'lms-plugin' ),
		'not_found'             => __( 'No se han encontrado lecciones', 'lms-plugin' ),
		'not_found_in_trash'    => __( 'No se han encontrado lecciones en la papelera', 'lms-plugin' ),
		'featured_image'        => __( 'Imagen destacada', 'lms-plugin' ),
		'set_featured_image'    => __( 'Establecer imagen destacada', 'lms-plugin' ),
		'remove_featured_image' => __( 'Eliminar imagen destacada', 'lms-plugin' ),
		'use_featured_image'    => __( 'Usar como imagen destacada', 'lms-plugin' ),
		'insert_into_item'      => __( 'Insertar en la lección', 'lms-plugin' ),
		'uploaded_to_this_item' => __( 'Subido a esta lección', 'lms-plugin' ),
		'items_list'            => __( 'Lista de lecciones', 'lms-plugin' ),
		'items_list_navigation' => __( 'Navegación de la lista de lecciones', 'lms-plugin' ),
		'filter_items_list'     => __( 'Filtrar lista de lecciones', 'lms-plugin' ),
	);
	$args = array(
		'label'                 => __( 'Lección', 'lms-plugin' ),
		'description'           => __( 'Lecciones para el sistema de gestión del aprendizaje (LMS)', 'lms-plugin' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields' ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-welcome-learn-more',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'show_in_rest'          => true,
		'rest_base'             => 'lessons',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
		'template'              => array(
			array( 'lms/lesson' ),
		),
		'template_lock'         => 'all',
	);
	register_post_type( 'lessons', $args );

}
add_action( 'init', 'lms_plugin_register_cpt_lessons', 0 );

/**
 * Función para registrar los custom fields para marcar los cursos y lecciones como completados y/o favoritos
 */
function lms_plugin_register_custom_fields() {

	// Agregar custom field para marcar los cursos como completados
	acf_add_local_field_group( array(
		'key'                   => 'group_lms_completed_courses',
		'title'                 => __( 'Completado', 'lms-plugin' ),
		'fields'                => array(
			array(
				'key'               => 'field_lms_completed_courses',
				'label'             => __( 'Completado', 'lms-plugin' ),
				'name'              => 'lms_completed_courses',
				'type'              => 'true_false',
				'instructions'      => __( 'Marca esta opción si has completado este curso', 'lms-plugin' ),
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'message'           => __( 'Curso completado', 'lms-plugin' ),
				'default_value'     => 0,
				'ui'                => 1,
				'ui_on_text'        => __( 'Sí', 'lms-plugin' ),
				'ui_off_text'       => __( 'No', 'lms-plugin' ),
			),
		),
		'location'              => array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'courses',
				),
			),
		),
		'menu_order'            => 0,
		'position'              => 'side',
		'style'                 => 'default',
		'label_placement'       => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen'        => '',
		'active'                => true,
		'description'           => '',
	) );

	// Agregar custom field para marcar las lecciones como comple
				),
		'template_lock'         => 'all',
	);
	register_post_type( 'lessons', $args );

}
add_action( 'init', 'lms_plugin_register_cpt_lessons', 0 );

/**
 * Función para registrar los custom fields para marcar los cursos y lecciones como completados y/o favoritos
 */
function lms_plugin_register_custom_fields() {

	// Agregar custom field para marcar los cursos como completados
	acf_add_local_field_group( array(
		'key'                   => 'group_lms_completed_courses',
		'title'                 => __( 'Completado', 'lms-plugin' ),
		'fields'                => array(
			array(
				'key'               => 'field_lms_completed_courses',
				'label'             => __( 'Completado', 'lms-plugin' ),
				'name'              => 'lms_completed_courses',
				'type'              => 'true_false',
				'instructions'      => __( 'Marca esta opción si has completado este curso', 'lms-plugin' ),
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'message'           => __( 'Curso completado', 'lms-plugin' ),
				'default_value'     => 0,
				'ui'                => 1,
				'ui_on_text'        => __( 'Sí', 'lms-plugin' ),
				'ui_off_text'       => __( 'No', 'lms-plugin' ),
			),
		),
		'location'              => array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'courses',
				),
			),
		),
		'menu_order'            => 0,
		'position'              => 'side',
		'style'                 => 'default',
		'label_placement'       => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen'        => '',
		'active'                => true,
		'description'           => '',
	) );

	// Agregar custom field para marcar las lecciones como completadas
	acf_add_local_field_group( array(
		'key'                   => 'group_lms_completed_lessons',
		'title'                 => __( 'Completado', 'lms-plugin' ),
		'fields'                => array(
			array(
				'key'               => 'field_lms_completed_lessons',
				'label'             => __( 'Completado', 'lms-plugin' ),
				'name'              => 'lms_completed_lessons',
				'type'              => 'true_false',
				'instructions'      => __( 'Marca esta opción si has completado esta lección', 'lms-plugin' ),
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width
				),
				'message'           => __( 'Lección completada', 'lms-plugin' ),
				'default_value'     => 0,
				'ui'                => 1,
				'ui_on_text'        => __( 'Sí', 'lms-plugin' ),
				'ui_off_text'       => __( 'No', 'lms-plugin' ),
			),
		),
		'location'              => array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'lessons',
				),
			),
		),
		'menu_order'            => 0,
		'position'              => 'side',
		'style'                 => 'default',
		'label_placement'       => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen'        => '',
		'active'                => true,
		'description'           => '',
	) );

	// Agregar custom field para marcar los cursos como favoritos
	acf_add_local_field_group( array(
		'key'                   => 'group_lms_favorite_courses',
		'title'                 => __( 'Favorito', 'lms-plugin' ),
		'fields'                => array(
			array(
				'key'               => 'field_lms_favorite_courses',
				'label'             => __( 'Favorito', 'lms-plugin' ),
				'name'              => 'lms_favorite_courses',
				'type'              => 'true_false',
				'instructions'      => __( 'Marca esta opción si quieres añadir este curso a tus favoritos', 'lms-plugin' ),
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'message'           => __( 'Curso favorito', 'lms-plugin' ),
				'default_value'     => 0,
				'ui'                => 1,
				'ui_on_text'        => __( 'Sí', 'lms-plugin' ),
				'ui_off_text'       => __( 'No', 'lms-plugin' ),
			),
		),
		'location'              => array(
			array(
				array(
				
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'courses',
				),
			),
		),
		'menu_order'            => 0,
		'position'              => 'side',
		'style'                 => 'default',
		'label_placement'       => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen'        => '',
		'active'                => true,
		'description'           => '',
	) );

}
add_action( 'acf/init', 'lms_plugin_register_custom_fields' );

/**
 * Shortcode para mostrar el número de cursos, lecciones y vídeos
 */
function lms_plugin_shortcode_stats( $atts ) {
	$a = shortcode_atts( array(
		'format' => '%c cursos, %l lecciones y %v vídeos',
	), $atts );

	$courses = wp_count_posts( 'courses' );
	$lessons = wp_count_posts( 'lessons' );
	$videos  = wp_count_posts( 'videos' );

	return str_replace( array( '%c', '%l', '%v' ), array( $courses->publish, $lessons->publish, $videos->publish ), $a['format'] );
}
add_shortcode( 'lms_stats', 'lms_plugin_shortcode_stats' );

/**
 * Shortcode para mostrar el listado de lecciones de un curso
 */
function lms_plugin_shortcode_lesson_list( $atts ) {
	$a = shortcode_atts( array(
		'format' => '<li>%t</li>',
	), $atts );

	global $post;
	$lessons = get_posts( array(
		'post_type'      => 'lessons',
		'posts_per_page' => -1,
		'post_parent'    => $post->ID,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
	) );

	$output = '';
	foreach ( $lessons as $lesson ) {
		$output .= str_replace( '%t', $lesson->post_title, $a['format'] );
	}

	return $output;
}
add_shortcode( 'lms_lesson_list', 'lms_plugin_shortcode_lesson_list' );

require_once plugin_dir_path( FILE ) . 'includes/custom-fields.php';
require_once plugin_dir_path( FILE ) . 'includes/custom-post-types.php';
require_once plugin_dir_path( FILE ) . 'includes/lms-plugin-lessons-list.php';
require_once plugin_dir_path( FILE ) . 'includes/lms-plugin-stats.php';
require_once plugin_dir_path( FILE ) . 'includes/lms-plugin-user-meta.php';
require_once plugin_dir_path( FILE ) . 'includes/shortcodes.php';