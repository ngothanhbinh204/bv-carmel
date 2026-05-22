<?php if (get_field('show_section_pagebanner') !== false): 
	$banner_items = get_field('home_banner_items');
?>
<section class="section-PageBanner">
	<!-- ... HTML gốc cho phần Banner (được tích hợp với ACF nếu cần thiết) ... -->
	<!-- Do giới hạn nội dung, tôi giữ lại cấu trúc cơ bản và bạn có thể thay thế tĩnh thành động sau -->
	<div class="swiper-column-auto auto-1-column" data-id-swiper="" data-swiper-options="{&quot;slidesPerView&quot;: &quot;auto&quot;, &quot;spaceBetween&quot;: 0, &quot;loop&quot;: false, &quot;effect&quot;: &quot;fade&quot;, &quot;fadeEffect&quot;: { &quot;crossFade&quot;: true }}">
		<div class="swiper">
			<div class="swiper-wrapper">
				<?php if (have_rows('home_banner_sliders')): ?>
					<?php while (have_rows('home_banner_sliders')): the_row(); 
						$image = get_sub_field('image');
					?>
					<div class="swiper-slide">
						<div class="img img-parallax ratio:pt-[640_1920] " data-gsap-options="{&quot;type&quot;: &quot;img-parallax-percent&quot;, &quot;yPercent&quot;: 10}">
							<?php if ($image && function_exists('get_image_attrachment')) echo get_image_attrachment($image, 'image'); ?>
						</div>
					</div>
					<?php endwhile; ?>
				<?php endif; ?>
			</div>
		</div>
		<!-- Nút điều hướng nhanh -->
		<div class="button-swiper-banner">
			<div class="container">
				<div class="main-content">
					<?php if (have_rows('home_banner_quick_links')): ?>
						<?php while (have_rows('home_banner_quick_links')): the_row(); 
							$icon = get_sub_field('icon');
							$title = get_sub_field('title');
							$link = get_sub_field('link');
						?>
						<a class="item-banner" href="<?php echo $link ? esc_url($link['url']) : '#'; ?>">
							<div class="item-img">
								<?php if ($icon && function_exists('get_image_attrachment')) echo get_image_attrachment($icon, 'image'); ?>
							</div>
							<div class="item-content"><span><?php echo esc_html($title); ?></span></div>
						</a>
						<?php endwhile; ?>
					<?php endif; ?>
				</div>
				<div class="main-swiper">
					<div class="btn-swiper btn-prev btn-swiper-primary" data-id-swiper="">
						<div class="icon"></div>
					</div>
					<div class="pagination-main">
						<div class="swiper-pagination"></div>
					</div>
					<div class="btn-swiper btn-next btn-swiper-primary" data-id-swiper="">
						<div class="icon"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>
