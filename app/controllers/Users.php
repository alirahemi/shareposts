<?php
    class Users extends Controller{
        public function __construct()
        {
            $this->userModel = $this->model('User');
        }

        public function register(){
            // Check for post
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // Process form

                // Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                // Init data
                $data = [
                    'name' => trim($_POST['name']),
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'confirm_password' => trim($_POST['confirm_password']),
                    'name_err' => '',
                    'email_err' => '',
                    'password_err' => '',
                    'confirm_password_err' => ''
                ];

                // Validate Data
                if(empty($data['name'])){
                    $data['name_err'] = 'Please enter name';
                }

                if(empty($data['email'])){
                    $data['email_err'] = 'Please enter email';
                } else{
                    // check email
                    if($this->userModel->findUserByEmail($data['email'])){
                        $data['email_err'] = 'Email is already taken';
                    }
                }

                if(empty($data['password'])){
                    $data['password_err'] = 'Please enter password';
                } elseif(strlen($data['password'])<6){
                    $data['password_err'] = 'Please must be at least 6 characters';
                }

                if(empty($data['confirm_password'])){
                    $data['confirm_password_err'] = 'Please confirm password';
                } else {
                    if($data['password'] != $data['confirm_password'] ) {
                        $data['confirm_password_err'] = 'Password does not match';
                    }
                }

                // make sure errors are empty
                if(empty($data['name_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])){
                    //Validated
                    
                    // Hash Password
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                    // register User
                    if($this->userModel->register($data)){
                        redirect('users/login');
                    }else{
                        die('something went wrong');
                    }
                } else {
                    // Load view with error
                    $this->view('users/register', $data);
                }

            } else {
                // init data
                $data = [
                    'name' => '',
                    'email' => '',
                    'password' => '',
                    'confirm_password' => '',
                    'name_err' => '',
                    'email_err' => '',
                    'password_err' => '',
                    'confirm_password_err' => ''
                ];

                // load view
                $this->view('users/register', $data);
            }
        }

        public function login(){
            // Check for post
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // Process form

                // Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                 // Init data
                 $data = [
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'email_err' => '',
                    'password_err' => ''
                ];

                // Validate Data
                if(empty($data['email'])){
                    $data['email_err'] = 'Please enter email';
                }

                if(empty($data['password'])){
                    $data['password_err'] = 'Please enter password';
                }

                // Check user/email
                if($this->userModel->findUserByEmail($data['email'])){
                    // User Found
                } else {
                    if(empty($data['email'])){
                        $data['email_err'] = 'Please enter email';
                    } else {
                        // User not found
                    $data['email_err'] = 'No user found';
                    }
                }

                // make sure errors are empty
                if(empty($data['email_err']) && empty($data['password_err'])){
                    //Validated
                    // Check and set logged in user
                    $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                    if($loggedInUser){
                        // Create Session
                        die('LOGIN SUCCESS');
                    } else {
                        $data['password_err'] = 'Password incorrect';
                        $this->view('users/login', $data);
                    }

                } else {
                    // Load view with error
                    $this->view('users/login', $data);
                }

            } else {
                // init data
                $data = [
                    'email' => '',
                    'password' => '',
                    'email_err' => '',
                    'password_err' => ''
                ];

                // load view
                $this->view('users/login', $data);
            }
        }
    }