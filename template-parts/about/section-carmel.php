<?php if (get_field('show_section_carmel') !== false):
	$bg_image = get_field('carmel_bg_image');
	$bg_src   = $bg_image ? $bg_image['url'] : '';
	$letters  = get_field('carmel_letters'); // repeater: letter (text)
	$values   = get_field('carmel_values');  // repeater: title + content
?>
<section class="section-carmel">
	<div class="img img-ratio ratio:pt-[850_1920]"<?php if ($bg_src): ?> data-bg-options='{"src":"<?php echo esc_url($bg_src); ?>"}'<?php endif; ?>>
		<?php if ($bg_src && function_exists('get_image_attrachment')): ?>
			<?php echo get_image_attrachment($bg_image, 'image'); ?>
		<?php endif; ?>
		<div class="main-content">
			<div class="container">
				<div class="wrap-padding">
					<div class="block-banner-text">
						<?php if ($letters): ?>
							<?php foreach ($letters as $row): ?>
								<strong><?php echo esc_html($row['letter']); ?></strong>
							<?php endforeach; ?>
						<?php else: ?>
							<!-- Mặc định nếu chưa nhập -->
							<strong>C</strong><strong>A</strong><strong>R</strong><strong>M</strong><strong>E</strong><strong>l</strong>
						<?php endif; ?>
					</div>
					<div class="block-line"><img src="<?php echo esc_url(get_template_directory_uri() . '/img/line.svg'); ?>" alt="line"></div>
					<div class="block-content">
						<?php if ($values): ?>
							<?php foreach ($values as $val): ?>
							<div class="item-content">
								<div class="title"><?php echo esc_html($val['title']); ?></div>
								<div class="sub-content">
									<?php echo wp_kses_post($val['content']); ?>
								</div>
							</div>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>
