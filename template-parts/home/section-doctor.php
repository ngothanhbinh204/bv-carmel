<?php if (get_field('show_section_doctor') !== false): 
	$title = get_field('doctor_title');
	$desc = get_field('doctor_description');
	$btn = get_field('doctor_button');
	$list_doctor = get_field('list_doctor'); // Relationship field - trả về mảng các post object
?>
<section class="section-doctor">
	<div class="section-py">
		<div class="container">
			<div class="flex-column gap-5">
				<?php if ($title): ?>
				<h2 class="title-heading heading-1 text-primary-1 block text-center"><?php echo esc_html($title); ?>
				</h2>
				<?php endif; ?>
				<?php if ($desc): ?>
				<div class="sub-title">
					<div><?php echo wp_kses_post($desc); ?></div>
				</div>
				<?php endif; ?>
			</div>
			<div class="block-swiper">
				<div class="swiper-column-auto auto-4-column" data-id-swiper="doctor">
					<div class="swiper">
						<div class="swiper-wrapper">
							<?php if ($list_doctor): ?>
							<?php foreach ($list_doctor as $post): 
									setup_postdata($post);
								?>
							<div class="swiper-slide">
								<?php get_template_part('template-parts/component/card', 'doctor'); ?>
							</div>
							<?php endforeach; ?>
							<?php wp_reset_postdata(); ?>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<div class="button-swiper">
					<div class="btn-swiper btn-prev btn-swiper-primary" data-id-swiper="doctor">
						<div class="icon"></div>
					</div>
					<div class="btn-swiper btn-next btn-swiper-primary" data-id-swiper="doctor">
						<div class="icon"></div>
					</div>
				</div>
			</div>

			<?php if ($btn): ?>
			<div class="block-button">
				<a class="btn btn-primary btn-icon" href="<?php echo esc_url($btn['url']); ?>">
					<span><?php echo esc_html($btn['title']); ?></span>
					<div class="icon is-secondary"></div>
				</a>
			</div>
			<?php endif; ?>
		</div>
	</div>
</section>
<?php endif; ?>