<?php ?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" id="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" />
	<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-5HJMH3WM');</script>
<!-- End Google Tag Manager -->
	<?php wp_head(); ?>
</head>
<body ontouchstart <?php body_class(); ?>>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5HJMH3WM"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<?php wp_body_open(); ?>
<div class="space-box relative<?php if( get_theme_mod('mercury_boxed_layout') ) { ?> enabled<?php } ?>">

<!-- Header Start -->

<?php
	$header_style = get_theme_mod('mercury_header_style');

	if ($header_style == 2) {
		get_template_part( '/theme-parts/header/style-2' );
	} else {
		get_template_part( '/theme-parts/header/style-1' );
	}
?>

<div class="space-header-search-block fixed">
	<div class="space-header-search-block-ins absolute">
		<?php get_search_form(); ?>
	</div>
	<div class="space-close-icon desktop-search-close-button absolute">
		<div class="to-right absolute"></div>
		<div class="to-left absolute"></div>
	</div>
</div>

<!-- Header End -->