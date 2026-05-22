<?php
$post_id = get_the_ID();
$name = get_the_title();
$permalink = get_permalink();
$excerpt = get_the_excerpt();

// Chuyên khoa (nếu có lưu ở ACF, hoặc lấy term nếu là taxonomy. Ở đây giả định dùng field ACF 'doctor_specialty_name')
$specialty = get_field('doctor_specialty_name', $post_id);

$image = function_exists('get_image_post') ? get_image_post($post_id, 'image') : get_the_post_thumbnail($post_id, 'full', array('class' => 'lozad'));
?>
<a class="card-doctor group" href="<?php echo esc_url($permalink); ?>">
	<div class="img img-ratio ratio:pt-[360_320] zoom-img">
		<?php echo $image; ?>
	</div>
	<div class="profile">
		<div class="profile-name">
			<div class="name"><?php echo esc_html($name); ?></div>
			<?php if ($specialty): ?>
			<div class="specialty"><?php echo esc_html($specialty); ?></div>
			<?php endif; ?>
		</div>
		<div class="sub-content">
			<p><?php echo esc_html($excerpt); ?></p>
			<button class="btn btn-card"><span>Tìm hiểu thêm</span><span
					class="material-symbols-outlined">keyboard_arrow_right</span>
			</button>
		</div>
	</div>
</a>