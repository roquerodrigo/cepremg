<?php

namespace App\Controllers;

use Slim\Container;

class Controller
{
    protected $container;
    protected $view;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->view = $this->container->view;
    }
}