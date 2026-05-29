<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link
		href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap"
		rel="stylesheet">

	<?php if (stripos($_SERVER['HTTP_USER_AGENT'], 'Chrome-Lighthouse') === false) : ?>
	<?php endif; ?>
	<?php wp_head(); ?>
	<?= get_field('field_config_head', 'options') ?>
</head>

<body <?php body_class(get_field('add_class_body', get_the_ID())); ?>
	data-aos-options="{&quot;duration&quot;: 1000, &quot;once&quot;: true, &quot;offset&quot;: &quot;getVw(50, 120)&quot;}"
	data-lenis-options="{&quot;duration&quot;: 1.5, &quot;smoothWheel&quot;: true}" data-lenis-restore-scroll="true">
	<script>
	if ('scrollRestoration' in history) history.scrollRestoration = 'manual';
	</script>
	<header>
		<div class="container-fluid">
			<div class="section-header">
				<a class="header-logo" href="<?php echo esc_url(home_url('/')); ?>">
					<div class="img-logo">
						<div class="img img-ratio ratio:pt-[70_195] ">
							<?php 
							$logo = get_field('header_logo', 'options');
							if ($logo && function_exists('get_image_attrachment')) {
								echo get_image_attrachment($logo, 'image');
							} else {
								echo '<img class="lozad" data-src="'.esc_url(get_template_directory_uri().'/img/logo.svg').'" alt="Logo"/>';
							}
							?>
						</div>
					</div>
				</a>
				<div class="header-main">
					<div class="header-contact">
						<?php $hotline = get_field('header_hotline', 'options'); if($hotline): ?>
						<a class="item-contact phone-contact"
							href="tel:<?php echo esc_attr(str_replace(' ', '', $hotline)); ?>">
							<div class="icon"><span class="material-symbols-outlined">phone_in_talk</span></div>
							<div class="content"><span>Hotline</span><strong><?php echo esc_html($hotline); ?></strong>
							</div>
						</a>
						<?php endif; ?>

						<?php $advise = get_field('header_advise', 'options'); if($advise): ?>
						<a class="item-contact advise-contact"
							href="tel:<?php echo esc_attr(str_replace(' ', '', $advise)); ?>">
							<div class="icon"><span class="material-symbols-outlined">support_agent</span></div>
							<div class="content"><span>Tổng đài</span><strong><?php echo esc_html($advise); ?></strong>
							</div>
						</a>
						<?php endif; ?>

						<?php $emergency = get_field('header_emergency', 'options'); if($emergency): ?>
						<a class="item-contact emergency-contact"
							href="tel:<?php echo esc_attr(str_replace(' ', '', $emergency)); ?>">
							<div class="icon"><span class="material-symbols-outlined">ambulance</span></div>
							<div class="content"><span>Cấp
									cứu</span><strong><?php echo esc_html($emergency); ?></strong></div>
						</a>
						<?php endif; ?>
					</div>
					<div class="header-menuList">
						<div class="header-menu">
							<?php 
							if (has_nav_menu('header-menu')) {
								wp_nav_menu(array(
									'theme_location' => 'header-menu',
									'container' => false,
									'menu_class' => ''
								));
							} else {
								echo '<ul><li><a href="#">Vui lòng chọn menu trong admin</a></li></ul>';
							}
							?>
						</div>
						<div class="header-button">
							<!-- <div class="header-lang">
								<?php if (function_exists('wpml_add_language_selector')) do_action('wpml_add_language_selector'); ?>
							</div> -->
							<div class="header-lang">
								<ul>
									<li class="wpml-ls-item wpml-ls-current-language"><a><span
												class="wpml-ls-native">VN</span></a></li>
									<li class="wpml-ls-item"><a><span class="wpml-ls-native">VN</span></a></li>
								</ul>
							</div>
							<div class="header-search">
								<p>Tìm kiếm</p>
								<div class="icon"><span class="material-symbols-outlined">search</span></div>
							</div>
							<div class="header-mobile">
								<div class="header-hamburger">
									<div class="wrap"><span></span><span></span><span></span></div>
									<div id="pulseMe">
										<div class="bar left"></div>
										<div class="bar top"></div>
										<div class="bar right"></div>
										<div class="bar bottom"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>
	<main>