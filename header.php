<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php
    wp_head();
    ?>
    <title><?php bloginfo('title');?></title>
</head>
<body class='<?php body_class(); ?>'>
<div class="container">
<header>
    <h1 class="company_title">
        <?php bloginfo('title');?>
    </h1>
    <div class="banner">
        <img src="https://placehold.co/1000x400" alt="">
    </div>
</header>