<?php
    class Pages extends Controller {
        public function __construct() {
        }

        public function index(){
            // defalut method of web

            $data = [
                'title' => 'welcome'
            ];

            $this->view('pages/index', $data);
        }

        public function about(){
            $data = [
                'title' => 'About US'
            ];
            $this->view('pages/about', $data);
        }
    }