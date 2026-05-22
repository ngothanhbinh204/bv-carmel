<?php
$post_id = get_the_ID();
$title = get_the_title();
$permalink = get_permalink();
// Icon lấy từ ACF field 'specialty_icon' của CPT chuyen-khoa
$icon = get_field('specialty_icon', $post_id);
?>
<a class="card-outstanding group" href="<?php echo esc_url($permalink); ?>">
	<div class="icon">
		<?php if ($icon && function_exists('get_image_attrachment')): ?>
			<?php echo get_image_attrachment($icon, 'image'); ?>
		<?php else: ?>
			<img src="<?php echo esc_url(get_template_directory_uri() . '/img/outstanding.svg'); ?>" alt="<?php echo esc_attr($title); ?>"/>
		<?php endif; ?>
	</div>
	<div class="content-outstanding">
		<p><?php echo esc_html($title); ?></p>
	</div>
</a>
