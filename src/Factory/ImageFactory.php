<?php
declare(strict_types=1);

namespace Dada\Factory;

/**
 * Class ImageFactory
 * @package Dada\Factory
 */
class ImageFactory
{
    /**
     * Return a correct image resource for input filename
     * @param string $filename
     * @return null|resource
     */
    public static function create(string $filename)
    {
        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($fileInfo, $filename);
        finfo_close($fileInfo);

        switch ($mime) {
            case 'image/jpeg':
                return imagecreatefromjpeg($filename);
            case 'image/png':
                return imagecreatefrompng($filename);
            case 'image/vnd.wap.wbmp':
                return imagecreatefromwbmp($filename);
            case 'image/gif':
                return imagecreatefromgif($filename);
            case 'image/xbm':
                return imagecreatefromxbm($filename);
            default:
                return null;
        }
    }
}