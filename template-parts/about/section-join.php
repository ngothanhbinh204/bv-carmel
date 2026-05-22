<?php if (get_field('show_section_join') !== false):
	$image    = get_field('join_image');
	$title    = get_field('join_title');
	$subtitle = get_field('join_subtitle');
	$button   = get_field('join_button');
?>
<section class="section-join">
	<div class="section-pb">
		<div class="container">
			<div class="img img-ratio ratio:pt-[540_1400] zoom-img rounded-8 -lg:h-[30dvh]">
				<?php if ($image && function_exists('get_image_attrachment')): ?>
					<?php echo get_image_attrachment($image, 'image'); ?>
				<?php else: ?>
					<img class="lozad" data-src="<?php echo esc_url(get_template_directory_uri() . '/img/join-banner.jpg'); ?>" alt="Gia nhập đội ngũ Carmel"/>
				<?php endif; ?>
				<div class="main-content">
					<?php if ($title): ?>
						<h2 class="heading-1 text-white"><?php echo esc_html($title); ?></h2>
					<?php endif; ?>
					<?php if ($subtitle): ?>
						<div class="sub-content">
							<?php echo wp_kses_post($subtitle); ?>
						</div>
					<?php endif; ?>
					<?php if ($button): ?>
						<a class="btn btn-green" href="<?php echo esc_url($button['url']); ?>">
							<span><?php echo esc_html($button['title']); ?></span>
							<span class="material-symbols-outlined">keyboard_arrow_right</span>
						</a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>
