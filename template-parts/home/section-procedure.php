<?php if (get_field('show_section_procedure') !== false): 
	$title = get_field('procedure_title');
	$form_title = get_field('procedure_form_title');
	$form_image = get_field('procedure_form_image');
	$contact_form = get_field('procedure_contact_form'); // Trả về WP_Post của WPCF7
?>
<section class="section-procedure">
	<div class="section-py">
		<div class="container">
			<?php if ($title): ?>
				<h2 class="title-heading text-primary-1 heading-1 block text-center"><?php echo esc_html($title); ?></h2>
			<?php endif; ?>
			<div class="block-flex row">
				<div class="col-lg-4">
					<div class="list-step">
						<ul>
							<?php if (have_rows('procedure_steps')): ?>
								<?php while (have_rows('procedure_steps')): the_row(); 
									$step_label = get_sub_field('step_label'); // VD: Bước 1
									$step_desc = get_sub_field('step_description');
								?>
								<li>
									<div class="step"><span><?php echo esc_html($step_label); ?></span></div>
									<div class="desc">
										<div><?php echo wp_kses_post($step_desc); ?></div>
									</div>
								</li>
								<?php endwhile; ?>
							<?php endif; ?>
						</ul>
					</div>
				</div>
				<div class="col-lg-8">
					<div class="box-grid mt-base">
						<div class="img img-ratio ratio:pt-[556_440] zoom-img">
							<?php if ($form_image && function_exists('get_image_attrachment')) echo get_image_attrachment($form_image, 'image'); ?>
						</div>
						<div class="form-group">
							<?php if ($form_title): ?>
								<h3 class="title-form text-primary-1 mb-6"><?php echo esc_html($form_title); ?></h3>
							<?php endif; ?>
							
							<?php 
							// Hiển thị shortcode của CF7 nếu Admin đã chọn form
							if ($contact_form) {
								echo do_shortcode('[contact-form-7 id="' . esc_attr($contact_form->ID) . '"]');
							} else {
								echo '<p>Vui lòng chọn Contact Form trong admin.</p>';
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>
