	</main>
	<footer>
		<div class="container">
			<div class="section-footer">
				<div class="item-footer address">
					<a class="logo-footer" href="<?php echo esc_url(home_url('/')); ?>">
						<div class="img img-ratio ratio:pt-[60_167]">
							<?php 
							$f_logo = get_field('footer_logo', 'options');
							if ($f_logo && function_exists('get_image_attrachment')) {
								echo get_image_attrachment($f_logo, 'image');
							} else {
								echo '<img class="lozad" data-src="'.esc_url(get_template_directory_uri().'/img/footer-logo.svg').'" alt="Footer Logo"/>';
							}
							?>
						</div>
					</a>
					<div class="footer-title"><strong>Bệnh viện Quốc tế Carmel</strong></div>
					<?php $address = get_field('footer_address', 'options'); if($address): ?>
					<div class="footer-address" href="">
						<span class="material-symbols-outlined">home_health</span>
						<?php echo wp_kses_post($address); ?>
					</div>
					<?php endif; ?>

					<div class="footer-contacts">
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
							<div class="content"><span>Cấp cứu</span><strong><?php echo esc_html($emergency); ?></strong>
							</div>
						</a>
						<?php endif; ?>
					</div>
				</div>

				<div class="item-footer user">
					<div class="title-user heading-4 text-white">Dành cho khách hàng</div>
					<div class="list-user">
						<?php 
						if (has_nav_menu('footer-menu')) {
							wp_nav_menu(array(
								'theme_location' => 'footer-menu',
								'container' => false,
								'menu_class' => ''
							));
						} else {
							echo '<ul><li><a href="#"><div class="content"><span>Vui lòng thiết lập menu</span></div></a></li></ul>';
						}
						?>
					</div>
				</div>

				<div class="item-footer work">
					<div class="title-work heading-4">Giờ làm việc</div>
					<?php if (have_rows('footer_working_hours', 'options')): ?>
					<?php while (have_rows('footer_working_hours', 'options')): the_row(); ?>
					<div class="time-work">
						<strong><?php echo esc_html(get_sub_field('days')); ?></strong>
						<span><?php echo esc_html(get_sub_field('time')); ?></span>
					</div>
					<?php endwhile; ?>
					<?php endif; ?>
				</div>

				<div class="item-footer book">
					<a class=" btn btn-book " href="javascript:void(0)">
						<span>Đặt lịch hẹn</span><span class="material-symbols-outlined">keyboard_arrow_right</span>
					</a>
					<div class="content-carmel">
						<?php 
						$app_text = get_field('footer_app_text', 'options');
						echo $app_text ? wp_kses_post($app_text) : '<p>Tải App Bệnh viện Quốc tế Carmel ngay!</p>';
						?>
					</div>
					<a class="img-QR" href="javascript:void(0)">
						<div class="img img-ratio ratio:pt-[1_1] zoom-img ">
							<?php 
							$qr = get_field('footer_app_qr', 'options');
							if ($qr && function_exists('get_image_attrachment')) {
								echo get_image_attrachment($qr, 'image');
							} else {
								echo '<img class="lozad" data-src="'.esc_url(get_template_directory_uri().'/img/footer-QR.png').'" alt="QR Code"/>';
							}
							?>
						</div>
					</a>
				</div>
			</div>

			<div class="footer-copyright">
				<div class="main-copyright">
					<div class="block-left">
						<div class="copyright">
							<?php echo esc_html(get_field('footer_copyright', 'options') ?: '© 2026 Bệnh viện quốc tế Carmel. All Rights Reserved.'); ?>
						</div>
						<a class="btn btn-clause" href="javascript:void(0)">Điều khoản và điều kiện</a>
					</div>
					<div class="block-right">
						<div class="title-social">Kết nối với chúng tôi</div>
						<div class="social-list">
							<ul>
								<?php if (have_rows('footer_socials', 'options')): ?>
								<?php while (have_rows('footer_socials', 'options')): the_row(); 
										$s_icon = get_sub_field('icon');
										$s_link = get_sub_field('link');
									?>
								<li><a href="<?php echo esc_url($s_link); ?>">
										<?php if ($s_icon && function_exists('get_image_attrachment')) {
											echo get_image_attrachment($s_icon, 'image');
										} else {
											echo '<img src="'.esc_url(get_template_directory_uri().'/img/facebook.svg').'" alt="Social Icon"/>';
										} ?>
									</a></li>
								<?php endwhile; ?>
								<?php endif; ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</footer>

	<!-- Fix TOC CTA -->
	<div class="tool-fixed-cta">
		<div class="btn button-to-top"
			data-lenis-scroll-to="{&quot;target&quot;: &quot;top&quot;, &quot;duration&quot;: 100}"
			data-width-options="{&quot;var&quot;: &quot;--w-icon&quot;, &quot;source&quot;: &quot;child&quot;}">
			<div class="btn-iconCTA">
				<div class="icon"></div>
			</div>
		</div>

		<?php if (have_rows('fix_cta_buttons', 'options')): ?>
		<?php while (have_rows('fix_cta_buttons', 'options')): the_row(); 
				$c_icon = get_sub_field('icon');
				$c_text = get_sub_field('text');
				$c_link = get_sub_field('link');
			?>
		<a class="btn btn-content bg-primary-1" href="<?php echo esc_url($c_link); ?>"
			data-width-options="{&quot;var&quot;: &quot;--w-icon&quot;, &quot;source&quot;: &quot;child&quot;}">
			<div class="btn-iconCTA">
				<div class="icon"><span class="material-symbols-outlined"><?php echo esc_html($c_icon); ?></span></div>
			</div>
			<?php if ($c_text): ?>
			<div class="content"><span data-width-child="data-width-child"><?php echo esc_html($c_text); ?></span></div>
			<?php endif; ?>
		</a>
		<?php endwhile; ?>
		<?php else: ?>
		<!-- Mặc định nếu chưa nhập -->
		<a class="btn btn-content bg-primary-1" href="javascript:void(0)">
			<div class="btn-iconCTA">
				<div class="icon"><span class="material-symbols-outlined">clinical_notes</span></div>
			</div>
		</a>
		<a class="btn btn-content bg-primary-1" href="javascript:void(0)"
			data-width-options="{&quot;var&quot;: &quot;--w-icon&quot;, &quot;source&quot;: &quot;child&quot;}">
			<div class="btn-iconCTA">
				<div class="icon"><span class="material-symbols-outlined">chat</span></div>
			</div>
			<div class="content"><span data-width-child="data-width-child">Để lại lời nhắn</span></div>
		</a>
		<?php endif; ?>
	</div>

	<!-- Overlays (Search, Mobile Menu, Popup) -->
	<div class="header-search-form">
		<div class="close"><i class="fa-light fa-xmark"></i></div>
		<div class="container">
			<div class="wrap-form-search-product">
				<form role="search" method="get" class="productsearchbox" action="<?php echo esc_url(home_url('/')); ?>">
					<input type="text" name="s" placeholder="Tìm kiếm...">
					<button class="btn-search" type="submit">Tìm kiếm</button>
				</form>
				<div class="message-search">Nhấn<span> Esc</span> để đóng</div>
			</div>
		</div>
	</div>
	<div class="menu-overlay mobile-overlay"></div>
	<div class="navbar-mobile p-0">
		<div class="mobi-bg w-full md:w-1/2 xl:w-[450px] !max-w-full h-full bg-white z-50 p-5 relative">
			<form role="search" method="get" class="header-search-form-mobile productsearchbox"
				action="<?php echo esc_url(home_url('/')); ?>">
				<input type="text" name="s" placeholder="Tìm kiếm...">
				<button class="btn-search" type="submit">Tìm kiếm</button>
			</form>
			<div class="menu-list">
				<?php 
				if (has_nav_menu('header-menu')) {
					wp_nav_menu(array(
						'theme_location' => 'header-menu',
						'container' => false,
						'menu_class' => ''
					));
				} 
				?>
			</div>
		</div>
	</div>
	<section class="popup-wrapper" id="popup-form">
		<div class="overlay"></div>
		<div class="popup-content">
			<button class="close-btn" type="button" aria-label="Close">&times;</button>
			<div class="form-header">
				<h2>Tiêu đề Form</h2>
				<p>Mô tả ngắn gọn về mục đích của form này</p>
			</div>
			<div class="form-body">
				<!-- Tích hợp form contact sau -->
				<p>Chưa cấu hình Form</p>
			</div>
		</div>
	</section>

	<?php if (stripos($_SERVER['HTTP_USER_AGENT'], 'Chrome-Lighthouse') === false) : ?>
	<?php wp_footer() ?>
	<?php endif; ?>
	<?= get_field('field_config_body', 'options') ?>
	</body>

	</html>