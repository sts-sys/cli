<?php
namespace sts\cli;

class FileSystemHelper
{
    public static function deleteDirectory(string $dir): void
    {
        if (!file_exists($dir)) {
            return;
        }

        $items = array_diff(scandir($dir), ['.', '..']);
        foreach ($items as $item) {
            $path = "$dir/$item";
            is_dir($path) ? self::deleteDirectory($path) : unlink($path);
        }
        rmdir($dir);
    }
}
