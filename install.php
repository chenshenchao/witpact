<?php

use Composer\Util\Filesystem;

$filesystem = new Filesystem;
$accessPath = __DIR__.'/access';
$publicPath = __DIR__.'/public';
echo 'install project.'.PHP_EOL;
echo "copy {$accessPath} to {$publicPath}.".PHP_EOL;
$filesystem->copy($accessPath, $publicPath);
$filesystem->removeDirectory($accessPath);