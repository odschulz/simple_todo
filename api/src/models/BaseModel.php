<?php

namespace Models;

abstract class BaseModel {
    
    public function __construct(\Slim\App $app, \DB\SimpleDbWrapper $db) {
        $this->app = $app;
        $this->db = $db;
    }

}
