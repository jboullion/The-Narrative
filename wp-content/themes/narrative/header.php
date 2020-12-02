<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo('charset'); ?>" />	
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<!-- https://favicon.io/favicon-generator/?t=S&ff=Audiowide&fs=100&fc=%23FFF&b=rounded&bc=%23111 -->
		<link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-touch-icon.png">
		<link rel="icon" type="image/png" sizes="32x32" href="/favicons/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="16x16" href="/favicons/favicon-16x16.png">
		<link rel="manifest" href="/favicons/site.webmanifest">
		<link rel="mask-icon" href="/favicons/safari-pinned-tab.svg" color="#111111">
		<meta name="msapplication-TileColor" content="#111111">
		<meta name="theme-color" content="#111111">

		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
		<?php get_template_part('templates/common/header'); ?>
		<?php //get_template_part('templates/common/navigation'); ?>