<?php namespace Wit;
// 启用 Composer 自动加载。
require_once __DIR__.'/../vendor/autoload.php';

// 启用 WitPact。
(new Pact)->sign();

// 进入 WordPress 设置脚本。
require_once ABSPATH.'wp-settings.php';
