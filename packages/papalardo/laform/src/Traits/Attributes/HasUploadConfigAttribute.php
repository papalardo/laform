<?php

namespace Papalardo\Laform\Traits\Attributes;

trait HasUploadConfigAttribute
{
    public $serverConfig;

    public $useApi = false;

    public function setUploadConfig(\Papalardo\Laform\Interfaces\Config\Upload\IUploadConfig $serverConfig)
    {
        $this->useApi = true;

        $this->serverConfig = [
            'csrfToken' => $serverConfig->getCsrfToken(),
            'dir' => $serverConfig->getDirectory(),
            'endpoint' => $serverConfig->getEndpoint(),
        ];

        return $this;
    }
}
