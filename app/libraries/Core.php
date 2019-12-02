<?php
    /*
    * App Core Class
    * Create URL & loads core controller
    * URL FORMAT - /controller/method/params
    */
    class Core {
        protected $currentController = 'Pages'; // default page if there is not the requested page of user in my Controllers
        protected $currentMethod = 'index';
        protected $params = [];

        public function __construct(){
            //print_r($this->getUrl());

            $url = $this->getUrl();

            // Look in controllers for first value

            if (file_exists('../app/controllers/' . ucwords($url[0]). '.php')) { //ucwords() converts the first character of each word in a string to uppercase 
                // if exists, set as controller
                $this->currentController = ucwords($url[0]);
                //print_r($url[0]);
                // Unset 0 Index
                unset($url[0]);
            }

            // Require the controller
            require_once '../app/controllers/'. $this->currentController. '.php';

            // Instantiate controller class like $Pages= new Pages; (it run construct function of Pages class)
            $this->currentController = new $this->currentController;

            // check for second part of url
            if (isset($url[1])){
                // check to see if method exists in controller
                if(method_exists($this->currentController, $url[1])){
                    $this->currentMethod = $url[1];
                    // Unset 1 index
                    unset($url[1]);
                }
            }

            // Get params if there is
            $this->params = $url ? array_values($url) : [];

            // call a callback with array of params. pass params to method of controller
            call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
        }

        public function getUrl(){
            if(isset($_GET['url'])){

                $url = rtrim($_GET['url'], '/'); // remove '/' end of url
                $url = filter_var($url, FILTER_SANITIZE_URL);
                $url = explode('/', $url); // convert url to array - seprate in order to '/'
                return $url;
            }
        }
    }