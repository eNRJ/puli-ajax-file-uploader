<?php
/**
 * Created by PhpStorm.
 * User: jyhotchouliong
 * Date: 07/06/2016
 * Time: 15:56.
 */

namespace Enrj\Provider;

use Enrj\Service\AjaxUploaderService;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class AjaxUploaderServiceProvider implements ServiceProviderInterface
{
    /**
     * @param Container $container
     */
    public function register(Container $container)
    {
        $container['ajax_uploader'] = function ($container) {
            $service = new AjaxUploaderService($container['ajax_uploader.config']);
            $service->setLogger($container['logger']);
            
            return $service;
        };
    }
}
