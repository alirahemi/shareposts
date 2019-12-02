<?php
    // Load config file
    require_once 'config/config.php';

    // Autolaod Core Libraries
    spl_autoload_register(function($className){
        require_once 'libraries/' . $className . '.php';
    });