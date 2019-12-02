<?php
    class Pages extends Controller {
        public function __construct() {
        }

        public function index(){
            // defalut method of web

            $data = [
                'title' => 'SharePosts',
                'description' => 'Simple Social Network built on the TraversyMVC PHP Framework'
            ];

            $this->view('pages/index', $data);
        }

        public function about(){
            $data = [
                'title' => 'About US',
                'description' => 'App to share posts to other Users'
            ];
            $this->view('pages/about', $data);
        }
    }