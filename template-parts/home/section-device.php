<?php if (get_field('show_section_device') !== false): 
	// Do cấu trúc slide phức tạp có cả ảnh và text tab, 
	// ở đây giả định dùng repeater 'device_slides' để render đồng bộ
?>
<section class="section-device">
	<div class="section-pt">
		<div class="container">
			<div class="block-grid">
				<div class="swiper-left">
					<div class="swiper-img">
						<div class="swiper">
							<div class="swiper-wrapper">
								<?php if (have_rows('device_slides')): ?>
									<?php while (have_rows('device_slides')): the_row(); 
										$img = get_sub_field('image');
									?>
									<div class="swiper-slide">
										<div class="img img-ratio ratio:pt-[581_720] rounded-6 zoom-img">
											<?php if ($img && function_exists('get_image_attrachment')) echo get_image_attrachment($img, 'image'); ?>
										</div>
									</div>
									<?php endwhile; ?>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
				<div class="swiper-right">
					<div class="swiper-content">
						<div class="swiper">
							<div class="swiper-wrapper">
								<?php if (have_rows('device_slides')): ?>
									<?php while (have_rows('device_slides')): the_row(); 
										$title = get_sub_field('title');
										$content = get_sub_field('content'); // WYSIWYG
									?>
									<div class="swiper-slide">
										<?php if ($title): ?>
											<h2 class="title-heading text-primary-1 heading-1 block mb-6"><?php echo nl2br(esc_html($title)); ?></h2>
										<?php endif; ?>
										<div class="content-detail">
											<?php echo wp_kses_post($content); ?>
										</div>
									</div>
									<?php endwhile; ?>
								<?php endif; ?>
							</div>
						</div>
					</div>
					<!-- Có thể render thumb slide ở đây tương tự -->
				</div>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>
