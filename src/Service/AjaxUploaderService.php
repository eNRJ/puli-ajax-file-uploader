<?php

namespace Enrj\Service;

use Enrj\UploadHandler;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Created by PhpStorm.
 * User: jlepeltier
 * Date: 08/08/2016
 * Time: 10:20
 */
class AjaxUploaderService implements LoggerAwareInterface
{
    /**
     * @var LoggerInterface
     */
    protected $logger = null;

    /**
     * @var ParameterBag
     */
    protected $config;

    /**
     * Sets a logger instance on the object.
     *
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __construct($config = [])
    {
        $this->config = new ParameterBag($config);
    }

    public function upload($parameters)
    {
        $this->config->add($parameters);
        if (false !== $upload_dir = $this->config->get('upload_dir', false)) {
            $fs = new Filesystem();
            try {
                $fs->mkdir($upload_dir);
            } catch (IOExceptionInterface $e) {
                $this->logger->critical(sprintf("An error occurred while creating your directory at : %s", $e->getPath()));
            }
        }

        $options = [
            'param_name' => 'ajax_file_form',
            'image_versions' => array_merge($this->config->get('image_versions', []), ['' => ['auto_orient' => true]]),
        ];
        foreach (['accept_file_types', 'max_file_size', 'upload_dir', 'upload_url'] as $option) {
            if (false !== $value = $this->config->get($option, false)) {
                $options[$option] = $value;
            }
        }

        new UploadHandler($options, true, $this->config->get('error_messages', []));
    }
}