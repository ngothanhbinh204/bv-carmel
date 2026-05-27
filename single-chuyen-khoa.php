<?php
get_header();

?>
<section class="section-normalBanner">
	<div class="img img-ratio ratio:pt-[640_1920] zoom-img">
		<?php echo get_image_post(get_the_ID(), 'image'); ?>
	</div>
</section>

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
<?php get_template_part('template-parts/chuyen-khoa/section', 'detail'); ?>

<?php get_footer(); ?>