<?php
$post_id = get_the_ID();
$title = get_the_title();
$permalink = get_permalink();
$excerpt = get_the_excerpt();
$subtitle = get_field('tag_name', $post_id);
$image = function_exists('get_image_post') ? get_image_post($post_id, 'image') : get_the_post_thumbnail($post_id, 'full', array('class' => 'lozad'));

if (!$subtitle) {
	$subtitle = get_field('service_subtitle', $post_id);
}

if (!$subtitle) {
	$terms = get_the_terms($post_id, 'danh-muc-dich-vu');
	if (!is_wp_error($terms) && !empty($terms)) {
		$subtitle = $terms[0]->name;
	}
}
?>
<a class="card-service group" href="<?php echo esc_url($permalink); ?>">
	<div class="img img-ratio ratio:pt-[293_440] zoom-img">
		<?php echo $image; ?>
	</div>
	<div class="body-service">
		<div class="content">
			<?php if ($title): ?>
			<div class="title"><?php echo esc_html($title); ?></div>
			<?php endif; ?>
			<?php if ($subtitle): ?>
			<div class="sub"><?php echo esc_html($subtitle); ?></div>
			<?php endif; ?>
			<div class="divider"></div>
			<?php if ($excerpt): ?>
			<div class="desc">
				<p><?php echo esc_html($excerpt); ?></p>
			</div>
			<?php endif; ?>
		</div>
		<button class="btn btn-primary btn-icon" type="button"><span>Xem chi tiết</span>
			<div class="icon is-secondary"></div>
		</button>
	</div>
</a>