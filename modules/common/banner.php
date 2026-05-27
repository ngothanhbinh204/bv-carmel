<?php
/**
 * Module dùng chung: Banner + Breadcrumb
 * Gọi từ tất cả các trang qua: get_template_part('modules/common/banner')
 *
 * Logic lấy banner:
 * - Nếu trang là taxonomy archive: lấy theo `taxonomy_termId`
 * - Nếu là page/post thông thường: lấy theo `get_the_ID()`
 * - Field `banner_select_page` (Post Object, trỏ CPT `banner`) do function-field.php đăng ký
 */

// --- Xác định ID context để lấy field ---
$queried = get_queried_object();
if ($queried instanceof WP_Term) {
	$context_id = $queried->taxonomy . '_' . $queried->term_id;
} else {
	$context_id = get_the_ID();
}

$banners = get_field('banner_select_page', $context_id);

// Backward compatibility: field name cu trong project dang de tieng Viet.
if (!$banners) {
	$banners = get_field('Chọn banner hiển thị', $context_id);
}
?>

<?php if ($banners) : ?>
<?php foreach ($banners as $banner_post) :
		$banner_id = is_object($banner_post) ? $banner_post->ID : (int) $banner_post;
		$banner_image = get_field('banner_image', $banner_id);
		$banner_post_image = function_exists('get_image_post') ? get_image_post($banner_id, 'image') : '';
	?>
<section class="section-normalBanner">
	<div class="img img-ratio ratio:pt-[640_1920] zoom-img">
		<?php if ($banner_image && function_exists('get_image_attrachment')) :
				echo get_image_attrachment($banner_image, 'image');
			elseif ($banner_post_image) :
				echo $banner_post_image;
			else : ?>
		<img class="lozad" data-src="<?php echo esc_url(get_template_directory_uri() . '/img/default-banner.jpg'); ?>"
			alt="<?php echo esc_attr(get_the_title()); ?>" />
		<?php endif; ?>
	</div>
</section>
<?php endforeach; ?>
<?php endif; ?>

<section class="global-breadcrumb">
	<div class="container">
		<nav class="rank-math-breadcrumb" aria-label="breadcrumbs">
			<?php if (function_exists('rank_math_the_breadcrumbs')) :
				rank_math_the_breadcrumbs();
			else : ?>
			<p>
				<a href="<?php echo esc_url(home_url('/')); ?>">Trang chủ</a>
				<span class="separator"> |</span>
				<span class="last"><?php echo esc_html(get_the_title()); ?></span>
			</p>
			<?php endif; ?>
		</nav>
	</div>
</section>