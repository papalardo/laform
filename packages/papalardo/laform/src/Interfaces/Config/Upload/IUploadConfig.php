<?php

namespace Papalardo\Laform\Interfaces\Config\Upload;

interface IUploadConfig
{
    public function setCsrfToken(string $token) : IUploadConfig;
    
    public function setDirectory(string $directory) : IUploadConfig;

    public function setEndpoint(string $endpoint) : IUploadConfig;

    public function getCsrfToken() : String;
    
    public function getDirectory() : ?String;

    public function getEndpoint() : String;
}
