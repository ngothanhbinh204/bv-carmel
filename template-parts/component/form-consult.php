<?php
/**
 * Component: Form Tư vấn Sidebar (dùng chung)
 * Tái sử dụng trong: service detail, post detail
 * Field đọc từ Theme Settings (option)
 */

$consult_heading        = get_field('service_consult_heading', 'option');
$consult_form_shortcode = get_field('service_consult_form_shortcode', 'option');
$hotline_label          = get_field('service_hotline_label', 'option');
$hotline_number         = get_field('service_hotline_number', 'option');

if (!$consult_heading) $consult_heading = 'Để lại thông tin tư vấn';
if (!$hotline_label)   $hotline_label   = 'Liên hệ Bộ phận Kinh doanh:';
if (!$hotline_number)  $hotline_number  = '0977 851 818';
?>
<div class="info-sidebar" data-lenis-prevent>
	<div class="sidebar-inner">
		<div class="form-consult">
			<h3 class="form-heading"><?php echo esc_html($consult_heading); ?></h3>
			<?php if ($consult_form_shortcode) : ?>
				<?php echo do_shortcode($consult_form_shortcode); ?>
			<?php endif; ?>
			<?php if ($hotline_number) : ?>
			<a class="contact-hotline mt-6"
				href="tel:<?php echo esc_attr(preg_replace('/\D+/', '', $hotline_number)); ?>">
				<div class="hotline-icon"><span class="material-symbols-outlined">phone_in_talk</span></div>
				<div class="hotline-text">
					<span><?php echo esc_html($hotline_label); ?></span>
					<strong><?php echo esc_html($hotline_number); ?></strong>
				</div>
			</a>
			<?php endif; ?>
		</div>
	</div>
</div>
