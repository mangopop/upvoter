<?php

require_once __DIR__ . "/../vendor/autoload.php";

ActiveRecord\Config::initialize(function($cfg)
    {
        //$cfg->set_model_directory('model');
        $cfg->set_connections(array(
                'development' => 'mysql://root:123@127.0.0.1/upvoter'));
    });