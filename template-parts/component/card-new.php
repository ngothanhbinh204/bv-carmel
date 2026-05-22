<?php
$post_id = get_the_ID();
$title = get_the_title();
$permalink = get_permalink();
$date = get_the_date('d/m/Y');
$excerpt = get_the_excerpt();
$image = function_exists('get_image_post') ? get_image_post($post_id, 'image') : get_the_post_thumbnail($post_id, 'full', array('class' => 'lozad'));
?>
<a class="card-new group" href="<?php echo esc_url($permalink); ?>">
	<div class="img img-ratio ratio:pt-[220_440] zoom-img">
		<?php echo $image; ?>
	</div>
	<div class="content-new">
		<div class="date"><span><?php echo esc_html($date); ?></span></div>
		<div class="content">
			<div class="title-new"><?php echo esc_html($title); ?></div>
			<div class="desc-new">
				<p><?php echo esc_html($excerpt); ?></p>
			</div>
		</div>
		<button class="btn btn-primary btn-icon"><span>Xem chi tiết</span>
			<div class="icon is-secondary"></div>
		</button>
	</div>
</a>
