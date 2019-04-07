<?php
namespace App\Services;

use FFMpeg;
use FFMpeg\Format\Video\X264;
use FFMpeg\Coordinate\Dimension;
use App\Constants;

class compressionService
{
    private $media;
    private $format;
    private $details;
    private $X, $Y;

    private function waterMark()
    {
        return Constants::watermark();
    } //file path for the water mark image

    public function __construct()
    {

    }

    private function  storage($path = '') 
    { 
        return '/public/'.$path;
    }

    public function init($fqFilePath, $location = 'cloud')
    {
        $path = $fqFilePath;
        $this->media = $location === 'cloud'? FFMpeg::fromDisk('ext0')->open($path) : null;
        $this->media = $location === 'local'? FFMpeg::open($path) : null;
        return $this->media !== null;
    }

    public function setFormat($format = 'X264')
    {
        switch ($format) {
            case 'X264':
                $this->format = new X264();
                return true;
                break;
            
            default:
                $this->format = new X264();
                return true;
                break;
        }
        return false;
    }

    public function resize(int $X, int $Y) //e.g. 1280 x 640
    {
        $this->X =  $this->media->getStreams()->first()->get('width');
        $this->Y = $this->media->getStreams()->first()->get('height');
        $ratio = ($this->X / $this->Y);
        $height = $X/$ratio;
        $width = $X;

        $this->media->addFilter(function ($filters){
            $filters->resize(new \FFMpeg\Coordinate\Dimension($height, $width));
        });

        $this->X = $width;
        $this->Y = $height;
    }

    public function setBitrate($bitrate)
    {
        $bitrate = (int) $bitrate;
        if(!isset($this->format) ) {
            if (!$this->setFormat() || $bitrate < 1 ) {
                return false;
            }
        }
        $this->format->setKiloBitrate($bitrate);
    }

    public function handleAudio($codec ='aac', $bitrate='64')
    {
        $codec = $codec === 'dolby' ? 'mp3' : $codec;
         if(!isset($this->format) ) {
            if (!$this->setFormat() || (int) $bitrate < 1 ) {
                return false;
            }
        }
        $this->format->setAudioCodec($codec)->setAudioChannels(2)->setAudioKiloBitrate($bitrate);
        $defSampleRate = $theSampleRate = $this->media->getStreams()->audios()->first()->get('sample_rate');
        if($theSampleRate >32000){$defSampleRate = $theSampleRate/2;}
        $sampleRate = $this->getSampleRate($defSampleRate);
        $this->media->addFilter(['-ar', $sampleRate]);
    }

    private function getSampleRate($default)
    {
        $arr = [48000, 44100, 24000, 22050];
        if ($default === 48000 || $default>46000) {
            return 48000;
        }
         if ( $default<46000 && $default>32000) {
            return 44100;
        }
         if ($default<32000 && $default>23000) {
            return 24000;
        }
         if ( $default<23000) {
            return 22050;
        }
        return $default;
    }

    public function addWaterMark()
    {
        $waterMarkX = 129;
        $waterMarkY = 31;


    }
}