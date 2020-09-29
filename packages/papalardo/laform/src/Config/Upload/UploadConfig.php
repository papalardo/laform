<?php

namespace Papalardo\Laform\Config\Upload;

use Papalardo\Laform\Interfaces\Config\Upload\IUploadConfig;

class UploadConfig implements IUploadConfig
{
    public $csrfToken;
    
    public $directory;

    public $endpoint;

    public function __construct() {
        $this->csrfToken = csrf_token();
    }

    public static function make() {
        return app(get_called_class());
    }

    public function setCsrfToken(string $csrfToken) : IUploadConfig
    {
        $this->csrfToken = $csrfToken;
        return $this;
    }
    
    public function setDirectory(string $directory) : IUploadConfig
    {
        $this->directory = $directory;
        return $this;
    }

    public function setEndpoint(string $endpoint) : IUploadConfig
    {
        $this->endpoint = $endpoint;
        return $this;
    }

    public function getCsrfToken() : String
    {
        return $this->csrfToken;
    }
    
    public function getDirectory() : ?String
    {
        return $this->directory;
    }

    public function getEndpoint(): String
     {
        return $this->endpoint;
    }
}
