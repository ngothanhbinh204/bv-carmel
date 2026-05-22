<?php if (get_field('show_section_diagram') !== false):
	$title          = get_field('diagram_title');
	$subtitle       = get_field('diagram_subtitle');
	$leader         = get_field('diagram_leader');   // single leader: image, degree, name, position
	$members        = get_field('diagram_members');  // repeater: image, degree, name, position
	$org_title      = get_field('diagram_org_title');
	$org_image      = get_field('diagram_org_image');
?>
<section class="section-diagram">
	<div class="container">
		<div class="section-py">
			<div class="content">
				<?php if ($title): ?>
					<h2 class="heading-1 title-heading text-primary-1 block text-center"><?php echo esc_html($title); ?></h2>
				<?php endif; ?>
				<?php if ($subtitle): ?>
					<div class="sub-title">
						<?php echo wp_kses_post($subtitle); ?>
					</div>
				<?php endif; ?>
			</div>

			<?php /* --- Lãnh đạo chính (block-flex) --- */ ?>
			<?php if ($leader): ?>
			<div class="main-box-flex">
				<div class="block-flex">
					<div class="doctor">
						<div class="avatar-doctor">
							<div class="img img-ratio ratio:pt-[247_220] zoom-img">
								<?php if (!empty($leader['image']) && function_exists('get_image_attrachment')): ?>
									<?php echo get_image_attrachment($leader['image'], 'image'); ?>
								<?php endif; ?>
							</div>
						</div>
						<div class="profile">
							<?php if (!empty($leader['degree'])): ?>
								<div class="degree"><?php echo esc_html($leader['degree']); ?></div>
							<?php endif; ?>
							<?php if (!empty($leader['name'])): ?>
								<div class="name"><?php echo esc_html($leader['name']); ?></div>
							<?php endif; ?>
							<?php if (!empty($leader['position'])): ?>
								<div class="position"><?php echo esc_html($leader['position']); ?></div>
							<?php endif; ?>
						</div>
					</div>
				</div>

				<?php /* --- Các thành viên còn lại (block-grid) --- */ ?>
				<?php if ($members):
					$chunks = array_chunk($members, 2);
					foreach ($chunks as $chunk): ?>
					<div class="block-grid">
						<?php foreach ($chunk as $member): ?>
						<div class="doctor">
							<div class="avatar-doctor">
								<div class="img img-ratio ratio:pt-[247_220] zoom-img">
									<?php if (!empty($member['image']) && function_exists('get_image_attrachment')): ?>
										<?php echo get_image_attrachment($member['image'], 'image'); ?>
									<?php endif; ?>
								</div>
							</div>
							<div class="profile">
								<?php if (!empty($member['degree'])): ?>
									<div class="degree"><?php echo esc_html($member['degree']); ?></div>
								<?php endif; ?>
								<?php if (!empty($member['name'])): ?>
									<div class="name"><?php echo esc_html($member['name']); ?></div>
								<?php endif; ?>
								<?php if (!empty($member['position'])): ?>
									<div class="position"><?php echo esc_html($member['position']); ?></div>
								<?php endif; ?>
							</div>
						</div>
						<?php endforeach; ?>
					</div>
					<?php endforeach;
				endif; ?>
			</div>
			<?php endif; ?>

			<?php /* --- Hình ảnh sơ đồ tổ chức --- */ ?>
			<?php if ($org_title): ?>
				<div class="content mt-base">
					<h2 class="heading-1 title-heading text-primary-1 block text-center"><?php echo esc_html($org_title); ?></h2>
				</div>
			<?php endif; ?>
			<?php if ($org_image): ?>
			<div class="block-diagram mt-base">
				<a class="img img-ratio ratio:pt-[940_1336]" href="<?php echo esc_url($org_image['url']); ?>"
					data-fancybox data-fancybox-options='{"infinite":true}'>
					<?php if (function_exists('get_image_attrachment')): ?>
						<?php echo get_image_attrachment($org_image, 'image'); ?>
					<?php endif; ?>
				</a>
			</div>
			<?php endif; ?>
		</div>
	</div>
</section>
<?php endif; ?>
