<?php
    // Load config file
    require_once 'config/config.php';

    // Load Helpers
    require_once 'helpers/url_helpers.php';

    // Autolaod Core Libraries
    spl_autoload_register(function($className){
        require_once 'libraries/' . $className . '.php';
    });