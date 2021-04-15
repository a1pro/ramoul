

<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
require APPPATH . 'libraries/REST_Controller.php';
class UserController extends CI_Controller {
	function __construct() {
    parent::__construct();
     $this->load->model('webServices/UserModel');
     $this->load->helper('string');
    }
    function author_register() {
		print_R('hello');
        die;
		$this->form_validation->set_rules('name', 'name', 'required|max_length[255]');
        $this->form_validation->set_rules('email', 'email', 'required|max_length[255]|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'password', 'required|min_length[6]|matches[password_confirmation]');
        
		if ($this->form_validation->run() == TRUE) {
        $name = $this->input->post('name'); 
        $email = $this->input->post('email');
        $rpassword = $this->input->post('password');
		$password = $this->password->hash({$rpassword});
		$email_token = base64_encode($email);
		$reader = $this->input->post('reader');
		$verified = 1;
		$active = 1;
		$approved_at = date("Y-m-d");
   
		
			
				$data = array(
		         'name' => $name,
		         'email' => $email,
		         'password' => $password,
		         'email_token' => $email_token,
				 'active' => $active,
				 'approved_at' => $approved_at,
				 'reader' => $reader
				 
		        );
				
				 $user_res = $this->UserModel->user_insert($data);
				 $user_id = $user_res;
				 
				$profile_data = array(
		         'user_id' => $user_id,
		         'about' => $about,
		         'dob' => $dob,
		         'gender' => $gender,
				 'avatar' => $avatar
				 
		        );
				$profile_res = $this->UserModel->profile_insert($profile_data);
		        if (! empty($profile_res)) {
                print_r(json_encode([
                    'code' => '201',
                    'status' => 'success',
                    'message' => 'Register successfully.'
                ]));
                } else {
                print_r(json_encode([
                    'code' => '200',
                    'status' => 'failure',
                    'message' => 'You are not register.'
                ]));
                }
			}
		
		
		
			
		
		}

	
	 

		
		

		}
