<?php
declare(strict_types=1);

class ImageFactory
{
    public static function create(string $directory, string $filename) 
    {
        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($fileInfo, $filename);
        finfo_close($fileInfo);
        switch ($mime) {
            case 'image/jpeg':
                return imagecreatefromjpeg($directory . $filename);
            case 'image/png':
                return imagecreatefrompng($directory . $filename);
            case 'image/vnd.wap.wbmp':
                return imagecreatefromwbmp($directory . $filename);
            case 'image/gif':
                return imagecreatefromgif($directory . $filename);
            case 'image/xbm':
                return imagecreatefromxbm($directory . $filename);
            default:
                exit('FATAL ERROR : Unsupported image type: '. $mime);
                break;
        }
    }
}