<?php
function carmel_register_custom_post_types() {
	// Chuyên khoa (Specialty)
	register_post_type('chuyen-khoa', array(
		'labels' => array(
			'name' => 'Chuyên khoa',
			'singular_name' => 'Chuyên khoa',
			'add_new' => 'Thêm chuyên khoa',
			'add_new_item' => 'Thêm chuyên khoa mới',
			'edit_item' => 'Sửa chuyên khoa',
			'new_item' => 'Chuyên khoa mới',
			'view_item' => 'Xem chuyên khoa',
			'search_items' => 'Tìm kiếm chuyên khoa',
			'not_found' => 'Không tìm thấy chuyên khoa nào',
			'not_found_in_trash' => 'Không có chuyên khoa trong thùng rác',
		),
		'public' => true,
		'has_archive' => true,
		'rewrite' => array('slug' => 'chuyen-khoa'),
		'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
		'menu_icon' => 'dashicons-networking',
		'show_in_rest' => true,
	));

	// Bác sĩ (Doctor)
	register_post_type('bac-si', array(
		'labels' => array(
			'name' => 'Bác sĩ',
			'singular_name' => 'Bác sĩ',
			'add_new' => 'Thêm bác sĩ',
			'add_new_item' => 'Thêm bác sĩ mới',
			'edit_item' => 'Sửa bác sĩ',
			'new_item' => 'Bác sĩ mới',
			'view_item' => 'Xem bác sĩ',
			'search_items' => 'Tìm kiếm bác sĩ',
			'not_found' => 'Không tìm thấy bác sĩ nào',
			'not_found_in_trash' => 'Không có bác sĩ trong thùng rác',
		),
		'public' => true,
		'has_archive' => true,
		'rewrite' => array('slug' => 'bac-si'),
		'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
		'menu_icon' => 'dashicons-businessman',
		'show_in_rest' => true,
	));

	// Dịch vụ (Service)
	register_post_type('dich-vu', array(
		'labels' => array(
			'name' => 'Dịch vụ',
			'singular_name' => 'Dịch vụ',
			'add_new' => 'Thêm dịch vụ',
			'add_new_item' => 'Thêm dịch vụ mới',
			'edit_item' => 'Sửa dịch vụ',
			'new_item' => 'Dịch vụ mới',
			'view_item' => 'Xem dịch vụ',
			'search_items' => 'Tìm kiếm dịch vụ',
			'not_found' => 'Không tìm thấy dịch vụ nào',
			'not_found_in_trash' => 'Không có dịch vụ trong thùng rác',
		),
		'public' => true,
		'has_archive' => true,
		'rewrite' => array('slug' => 'dich-vu'),
		'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
		'menu_icon' => 'dashicons-clipboard',
		'show_in_rest' => true,
	));
}
add_action('init', 'carmel_register_custom_post_types');