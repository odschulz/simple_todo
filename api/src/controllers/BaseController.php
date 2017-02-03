<?php

namespace Controllers;

abstract class BaseController {

    /**
     * @var \Slim\App
     */
    protected $application;

    /**
     * BaseController constructor.
     *
     * @param \Slim\App $app
     */
    public function __construct(\Slim\App $app, $db) {
        $this->app = $app;
        $this->db = $db;
        $this->defineRoutes();
    }

    /**
     * Define routes for this controller.
     */
    abstract protected function defineRoutes();

}
