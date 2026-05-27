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
		'has_archive' => false,
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
		'has_archive' => 'dich-vu',
		'rewrite' => array('slug' => 'goi-kham', 'with_front' => false),
		'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
		'menu_icon' => 'dashicons-clipboard',
		'show_in_rest' => true,
	));

	// Danh mục dịch vụ / gói khám
	register_taxonomy('danh-muc-dich-vu', array('dich-vu'), array(
		'labels' => array(
			'name' => 'Danh mục dịch vụ',
			'singular_name' => 'Danh mục dịch vụ',
			'search_items' => 'Tìm danh mục dịch vụ',
			'all_items' => 'Tất cả danh mục dịch vụ',
			'parent_item' => 'Danh mục cha',
			'parent_item_colon' => 'Danh mục cha:',
			'edit_item' => 'Sửa danh mục dịch vụ',
			'update_item' => 'Cập nhật danh mục dịch vụ',
			'add_new_item' => 'Thêm danh mục dịch vụ mới',
			'new_item_name' => 'Tên danh mục dịch vụ mới',
			'menu_name' => 'Danh mục dịch vụ',
		),
		'public' => true,
		'hierarchical' => true,
		'show_ui' => true,
		'show_admin_column' => true,
		'show_in_rest' => true,
		'rewrite' => array('slug' => 'dich-vu', 'with_front' => false, 'hierarchical' => true),
	));

	// Chủ đề dịch vụ (dùng cho filter-right)
	register_taxonomy('chu-de-dich-vu', array('dich-vu'), array(
		'labels' => array(
			'name' => 'Chủ đề dịch vụ',
			'singular_name' => 'Chủ đề dịch vụ',
			'search_items' => 'Tìm chủ đề dịch vụ',
			'all_items' => 'Tất cả chủ đề dịch vụ',
			'edit_item' => 'Sửa chủ đề dịch vụ',
			'update_item' => 'Cập nhật chủ đề dịch vụ',
			'add_new_item' => 'Thêm chủ đề dịch vụ mới',
			'new_item_name' => 'Tên chủ đề dịch vụ mới',
			'menu_name' => 'Chủ đề dịch vụ',
		),
		'public' => true,
		'hierarchical' => true,
		'show_ui' => true,
		'show_admin_column' => true,
		'show_in_rest' => true,
		'rewrite' => array('slug' => 'chu-de-dich-vu', 'with_front' => false, 'hierarchical' => true),
	));
}
add_action('init', 'carmel_register_custom_post_types');