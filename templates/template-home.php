<?php
/**
 * Template Name: Trang chủ
 */

get_header();
?>

<?php
	get_template_part('template-parts/home/section', 'pagebanner');
	get_template_part('template-parts/home/section', 'intro');
	get_template_part('template-parts/home/section', 'value');
	get_template_part('template-parts/home/section', 'doctor');
	get_template_part('template-parts/home/section', 'outstanding');
	get_template_part('template-parts/home/section', 'device');
	get_template_part('template-parts/home/section', 'service');
	get_template_part('template-parts/home/section', 'procedure');
	get_template_part('template-parts/home/section', 'new');
	?>

<?php
get_footer();
?>