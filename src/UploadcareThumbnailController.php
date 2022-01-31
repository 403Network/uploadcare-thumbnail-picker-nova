<?php

namespace FourZeroThree\UploadcareThumbnailPickerNova;

use Uploadcare\Api;
use Uploadcare\Conversion\VideoEncodingRequest;

class UploadcareThumbnailController
{
    protected $api;

    public function getApi()
    {
        if (!$this->api) {
            $config = \Uploadcare\Configuration::create(config('services.uploadcare.public_key'), config('services.uploadcare.secret_key'));
            $this->api = new \Uploadcare\Api($config);
        }
        return $this->api;
    }
    public function thumb($uuid)
    {
        $api = $this->getApi();
        $api->conversion()->convertVideo(
            $uuid,
            (new VideoEncodingRequest())
                ->setQuality(null)
                ->setThumbs(50),
        );
    }
}
