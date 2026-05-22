<?php if (get_field('show_section_mission') !== false):
	$bg_image    = get_field('mission_bg_image');
	$bg_src      = $bg_image ? $bg_image['url'] : get_template_directory_uri() . '/img/mission-banner.png';
	$decore      = get_field('mission_decore_image');
	$title       = get_field('mission_title');
	$subtitle    = get_field('mission_subtitle');
	$description = get_field('mission_description');
	$items       = get_field('mission_items'); // repeater: label + content
?>
<section class="section-mission" data-bg-options='{"src":"<?php echo esc_url($bg_src); ?>"}'>
	<div class="section-py">
		<div class="container">
			<div class="block-grid">
				<div class="box-left">
					<div class="content">
						<?php if ($title): ?>
							<h1 class="heading-1 text-primary-1 title-mission"><?php echo esc_html($title); ?></h1>
						<?php endif; ?>
						<?php if ($subtitle): ?>
							<div class="sub-content">
								<p><?php echo esc_html($subtitle); ?></p>
							</div>
						<?php endif; ?>
					</div>
					<?php if ($description): ?>
						<div class="main-content">
							<?php echo wp_kses_post($description); ?>
						</div>
					<?php endif; ?>
				</div>
				<div class="box-right">
					<?php if ($items): ?>
						<?php foreach ($items as $item): ?>
						<div class="item">
							<div class="title"><?php echo esc_html($item['label']); ?></div>
							<div class="sub-content">
								<?php echo wp_kses_post($item['content']); ?>
							</div>
						</div>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
	<?php if ($decore && function_exists('get_image_attrachment')): ?>
		<div class="decore"><?php echo get_image_attrachment($decore, 'image'); ?></div>
	<?php else: ?>
		<div class="decore"><img src="<?php echo esc_url(get_template_directory_uri() . '/img/icon-mission.png'); ?>" alt="decore"></div>
	<?php endif; ?>
</section>
<?php endif; ?>
