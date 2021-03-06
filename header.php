<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package chirs
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri(); ?>/favicons/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri(); ?>/favicons/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri(); ?>/favicons/favicon-16x16.png">
<link rel="manifest" href="<?php echo get_template_directory_uri(); ?>/favicons/manifest.json">
<link rel="mask-icon" href="<?php echo get_template_directory_uri(); ?>/favicons/safari-pinned-tab.svg" color="#fa9a46">
<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicons/favicon.ico">
<meta name="msapplication-config" content="<?php echo get_template_directory_uri(); ?>/favicons/browserconfig.xml">
<meta name="theme-color" content="#fa9a46">

<meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/img/og-image.jpg">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:description" content="Art Director / Designer">
<meta property="og:title" content="Chris Raimond">
<meta property="og:url" content="http://chrisraimond.com/">

<meta name="robots" content="index, follow">
<meta name="GOOGLEBOT" content="index, follow" />

<link rel="stylesheet" href="https://use.typekit.net/qoy0zcy.css">

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
<div id="page" class="site">