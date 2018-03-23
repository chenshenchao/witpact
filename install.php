<?php

/**
 * 复制目录。
 * 
 * @param string $source: 源目录路径。
 * @param string $target: 目标目录路径。
 */
function copy_directory($source, $target) {
    $handle = opendir($source);
    if (!is_dir($target)) mkdir($target);
    while (false !== ($name = readdir($handle))) {
        if ('.' == $name or '..' == $name) continue;
        $sourcePath = $source.DIRECTORY_SEPARATOR.$name;
        $targetPath = $target.DIRECTORY_SEPARATOR.$name;
        if (is_file($sourcePath)) copy($sourcePath, $targetPath);
        else copy_directory($sourcePath, $targetPath);
    }
    closedir($handle);
}

/**
 * 删除目录。
 * 
 * @param string $directory: 目录路径。
 */
function remove_directory($directory) {
    $handle = opendir($directory);
    while (false !== ($name = readdir($handle))) {
        if ('.' == $name or '..' == $name) continue;
        $path = $directory.DIRECTORY_SEPARATOR.$name;
        if (is_file($path)) unlink($path);
        else remove_directory($path);
    }
    closedir($handle);
    rmdir($directory);
}

/**
 * 从 WordPress 官网下载盐。
 * 
 */
function download_salt() {
    $content = file_get_contents('https://api.wordpress.org/secret-key/1.1/salt');
    preg_match_all('/define\s*\(\'([A-Z_]+)\'\s*,\s*\'(.*?)\'/', $content, $matches);
    $map = array_combine($matches[1], $matches[2]);
    foreach ($map as $name => $value) {
        $item = "$name='$value'".PHP_EOL;
        file_put_contents('.env', $item, FILE_APPEND);
    }
}

// 安装
$assetPath = __DIR__.DIRECTORY_SEPARATOR.'asset';
echo 'install project.'.PHP_EOL;
echo "copy {$assetPath}.".PHP_EOL;
copy_directory($assetPath, __DIR__);
remove_directory($assetPath);
download_salt();
