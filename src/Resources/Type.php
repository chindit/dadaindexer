<?php
declare(strict_types=1);

namespace Dada\Resources;

use Dada\Entity\File;

class Type
{
    private static $images = array('image/gif', 'image/jpeg', 'image/png', 'image/psd', 'image/bmp', 'image/tiff', 'image/jp2', 'image/iff', 'image/vnd.wap.wbmp', 'image/xbm', 'image/vnd.microsoft.icon');
    private static $video = array('video/1d-interleaved-parityfec','video/3gpp','video/3gpp2','video/3gpp-tt','video/BMPEG','video/BT656','video/CelB','video/DV','video/encaprtp','video/example','video/H261','video/H263','video/H263-1998','video/H263-2000','video/H264','video/H264-RCDO','video/H264-SVC','video/iso.segment','video/JPEG','video/jpeg2000','video/mj2','video/MP1S','video/MP2P','video/MP2T','video/mp4','video/MP4V-ES','video/MPV','video/mpeg4-generic','video/nv','video/ogg','video/pointer','video/quicktime','video/raptorfec','video/rtp-enc-aescm128','video/rtploopback','video/rtx','video/SMPTE292M','video/ulpfec','video/vc1','video/vnd.CCTV','video/vnd.dece.hd','video/vnd.dece.mobile','video/vnd.dece-mp4','video/vnd.dece.pd','video/vnd.dece.sd','video/vnd.dece.video','video/vnd.directv-mpeg','video/vnd.directv.mpeg-tts','video/vnd.dlna.mpeg-tts','video/vnd.dvb.file','video/vnd.fvt','video/vnd.hns.video','video/vnd.iptvforum.1dparityfec-1010','video/vnd.iptvforum.1dparityfec-2005','video/vnd.iptvforum.2dparityfec-1010','video/vnd.iptvforum.2dparityfec-2005','video/vnd.iptvforum.ttsavc','video/vnd.iptvforum.ttsmpeg2','video/vnd.motorola.video','video/vnd.motorola.videop','video/vnd-mpegurl','video/vnd.ms-playready.media.pyv','video/vnd.nokia.interleaved-multimedia','video/vnd.nokia.videovoip','video/vnd.objectvideo','video/vnd.radgamettools.bink','video/vnd.radgamettools.smacker','video/vnd.sealed.mpeg1','video/vnd.sealed.mpeg4','video/vnd.sealed-swf','video/vnd.sealedmedia.softseal-mov','video/vnd.uvvu-mp4','video/vnd-vivo');
    private static $ebooks = array('application/zip','application/epub+zip','application/x-mobipocket-ebook','application/x-mobipocket','application/pdf','application/x-rar');

    public static function getType(string $mime)
    {
        if (in_array($mime, self::$images)) {
            return File::PICTURE;
        } elseif (in_array($mime, self::$video)) {
            return File::VIDEO;
        } elseif (in_array($mime, self::$ebooks)) {
            return File::EBOOK;
        } else {
            return File::OTHER;
        }
    }
}