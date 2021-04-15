<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
require APPPATH . 'libraries/REST_Controller.php';
class UserController extends CI_Controller {
	function __construct() {
    parent::__construct();
     $this->load->model('webServices/UserModel');
     $this->load->helper('string');
	  $this->load->library('form_validation');
	  //$this->load->library('password');
    }

	
	 
function author_register() {
        $reader = $this->input->post('reader');
		 if($reader == 0){
		$this->form_validation->set_rules('name', 'name', 'required|max_length[255]');
       $this->form_validation->set_rules('email', 'email', 'required|max_length[255]|is_unique[users.email]');
       $this->form_validation->set_rules('password', 'password','required|min_length[6]');
       
		$this->form_validation->set_rules('password_confirmation', 'Confirm Password', 'required|matches[password]');
		if ($this->form_validation->run() == TRUE) {
        $name = $this->input->post('name'); 
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $about = $this->input->post('about');
        $gender = $this->input->post('gender');
        $avatar = $this->input->post('avatar');
        $dob = $this->input->post('dob');
	//	$password = password_hash($password,PASSWORD_DEFAULT);
		
		$email_token = base64_encode($email);
		$reader = $this->input->post('reader');
		$verified = 1;
		$active = 1;
		$approved_at = date("Y-m-d");
               if (!empty($_FILES['avatar']['name'])) {
		$resultArr = array();
		 
			$config['upload_path'] = 'application/assets/uploads/';

		
			 $config['avatar'] = $_FILES['avatar']['name'] ;
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
			
	    	$this->load->library('upload', $config);
		
		$this->upload->initialize($config);
        
        $avatar='avatar';
		if(!$this->upload->do_upload($avatar))
		{
		    
			$resultArr['success'] = false;
			$resultArr['error'] = $this->upload->display_errors();
		}   else    {
		   
			$resArr = $this->upload->data();
			$resultArr['success'] = true;
			$avatar = $resArr['file_name'];
		}
		
		
        }
		
			
				$data = array(
		         'name' => $name,
		         'email' => $email,
				 'reader' => $reader,
		         'password' => $password,
		         'verified' => $verified,
				 'active' => $active,
				 'email_token' => $email_token,
				 'created_at'       => date('Y-m-d H:i:s'),
				  );
		      
		      
				 $user_res = $this->UserModel->user_insert($data);
				 $user_id = $user_res;
				 
			    	$profile_data = array(
		         'user_id' => $user_id,
		         'about' => $about,
		         'dob' => $dob,
		         'gender' => $gender,
		         'created_at'  => date('Y-m-d H:i:s'),
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
		else{
			$error = strip_tags(validation_errors());
            $mess = array(
                "code" => "200",
                "status" => "failure",
                "message" => $error
            );
            print_r(json_encode($mess));
			//echo"Provide email and password.";
           
        }
		
		 }
		 else{
		     	$this->form_validation->set_rules('name', 'name', 'required|max_length[255]');
        $this->form_validation->set_rules('username', 'username', 'required|max_length[255]|is_unique[users.username]');
        $this->form_validation->set_rules('email', 'email', 'required|max_length[255]|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'password', 'required|min_length[6]');
		$this->form_validation->set_rules('password_confirmation', 'Confirm Password', 'required|matches[password]');
		if ($this->form_validation->run() == TRUE) {
        $name = $this->input->post('name');  
        $username = $this->input->post('username'); 
        $lastname = $this->input->post('lastname');  		
		$email = $this->input->post('email');
        $password = $this->input->post('password');
	//	$password = password_hash($password,PASSWORD_DEFAULT);
		$email_token = base64_encode($email);
		$reader = $this->input->post('reader');
		$avatar = $this->input->post('avatar');
		$active = 1;
		$approved_at = date("Y-m-d");
   
		          if (!empty($_FILES['avatar']['name'])) {
		$resultArr = array();
		 
			$config['upload_path'] = 'application/assets/uploads/';

		
			 $config['avatar'] = $_FILES['avatar']['name'] ;
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
			
	    	$this->load->library('upload', $config);
		
		$this->upload->initialize($config);
        
        $avatar='avatar';
		if(!$this->upload->do_upload($avatar))
		{
		    
			$resultArr['success'] = false;
			$resultArr['error'] = $this->upload->display_errors();
		}   else    {
		   
			$resArr = $this->upload->data();
			$resultArr['success'] = true;
			$avatar = $resArr['file_name'];
		}
		
		
        }
			
				$data = array(
		         'name' => $name,
				 'username' => $username,
				 'lastname' => $lastname,
		         'email' => $email,
		         'password' => $password,
		         'email_token' => $email_token,
				 'active' => $active,
				 'approved_at' => $approved_at,
				 'created_at'  => date('Y-m-d H:i:s'),
				 'reader' => $reader
				 
		        );
		      
		      
				 $user_res = $this->UserModel->user_insert($data);
				 $user_id = $user_res;
				
				 $profile_data = array(
		         'user_id' => $user_id,
		         'created_at'  => date('Y-m-d H:i:s'),
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
			else{
			 $error = strip_tags(validation_errors());
            $mess = array(
                "code" => "200",
                "status" => "failure",
                "message" => $error
            );
            print_r(json_encode($mess));
			//echo"Provide email and password.";
           
        }
		
		 }
		     
		}
		
			
		
	
	function reader_register() {
		 
		$this->form_validation->set_rules('name', 'name', 'required|max_length[255]');
        $this->form_validation->set_rules('username', 'username', 'required|max_length[255]|is_unique[users.username]');
        $this->form_validation->set_rules('email', 'email', 'required|max_length[255]|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'password', 'required|min_length[6]|matches[password_confirmation]');
		
	//	if ($this->form_validation->run() == TRUE) {
        $name = $this->input->post('name');  
        $username = $this->input->post('username'); 
        $lastname = $this->input->post('lastname');  		
		$email = $this->input->post('email');
        $password = $this->input->post('password');
	//	$password = password_hash($password,PASSWORD_DEFAULT);
		$email_token = base64_encode($email);
		$reader = $this->input->post('reader');
		$avatar = $this->input->post('avatar');
		$active = 1;
		$approved_at = date("Y-m-d");
   
		          if (!empty($_FILES['avatar']['name'])) {
		$resultArr = array();
		 
			$config['upload_path'] = 'application/assets/uploads/';

		
			 $config['avatar'] = $_FILES['avatar']['name'] ;
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
			
	    	$this->load->library('upload', $config);
		
		$this->upload->initialize($config);
        
        $avatar='avatar';
		if(!$this->upload->do_upload($avatar))
		{
		    
			$resultArr['success'] = false;
			$resultArr['error'] = $this->upload->display_errors();
		}   else    {
		   
			$resArr = $this->upload->data();
			$resultArr['success'] = true;
			$avatar = $resArr['file_name'];
		}
		
		
        }
			
				$data = array(
		         'name' => $name,
				 'username' => $username,
				 'lastname' => $lastname,
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
		         'avatar' => $avatar
				 
		        );
		        
				$profile_res = $this->UserModel->profile_insert($profile_data);
				print_r($profile_res);
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
		//	}
		
		
		
			
		
		}
	     function login_post() {
        // Get the post data
        $email = $this->input->post('email');
        $password = $this->input->post('password');
	//	$password = password_hash($password,PASSWORD_DEFAULT);
      // $hashToStoreInDb = password_hash($_POST['password'], PASSWORD_DEFAULT);
       //$password_encrypted = password_hash($password, PASSWORD_BCRYPT);
        // Validate the post data
        if(!empty($email) && !empty($password)){
            
            // Check if any user exists with the given credentials
            
             $user = $this->UserModel->getRows($email,$password);
			
			
			
            if (! empty($user)) {
				
                print_r(json_encode([
                    'code' => '201',
                    'status' => 'success',
                    'message' => 'User login successful.',
					'data' => $user
					
					
		        ]));
				
				
            } else { 
                print_r(json_encode([
                    'code' => '200',
                    'status' => 'failure',
                    'message' => 'Wrong email or password.'
					
                ]));
            }
           
        }else{
			$error = strip_tags(validation_errors());
            $mess = array(
                "code" => "200",
                "status" => "failure",
                "message" => $error
            );
            print_r(json_encode($mess));
			
           
        }
    }
   
    function get_author_list() {
       
		$res = $this->UserModel->author_list();
		
		if (! empty($res)) {
				 $mess = array(
                    "code" => "201",
                    "status" => "success",
                    "message" => "Data fetch successfully",
                    "data" => $res,
                 );
                 print_r(json_encode($mess));
				
				 }
		
	}
    function get_author() {
		$this->form_validation->set_rules('user_id', 'user_id', 'required');
		if ($this->form_validation->run() == TRUE) {
			$user_id = $this->input->post('user_id');
		$res = $this->UserModel->get_author_profile($user_id);
	
		 if (! empty($res)) {
				 $mess = array(
                    "code" => "201",
                    "status" => "success",
                    "message" => "Data fetch successfully",
                    "data" => $res,
                 );
                 print_r(json_encode($mess));
				
				 }
				  else {
                print_r(json_encode([
                    'code' => '200',
                    'status' => 'failure',
                    'message' => 'Email is not valid.'
                ]));
                }
		}
		else{
			 $error = strip_tags(validation_errors());
            $mess = array(
                "code" => "200",
                "status" => "failure",
                "message" => $error
            );
            print_r(json_encode($mess));
		
        }
		
		
	}
function create_book() {
		 $this->form_validation->set_rules('title', 'title', 'required');
        $this->form_validation->set_rules('book_order', 'book_order', 'required');
        $this->form_validation->set_rules('genre', 'genre', 'required');
        $this->form_validation->set_rules('description', 'description', 'required');
        $this->form_validation->set_rules('status', 'status', 'required');
        $this->form_validation->set_rules('user_id', 'user_id', 'required');
		if ($this->form_validation->run() == TRUE) {
        $title = $this->input->post('title');  
        $book_order = $this->input->post('book_order'); 
        $genre = $this->input->post('genre');  		
		$description = $this->input->post('description');
        $status = $this->input->post('status');
        $user_id = $this->input->post('user_id');
		$slug =  $title;
		if (!empty($_FILES['book_cover']['name'])) {
		
		$resultArr = array();
		 
			$config['upload_path'] = 'application/assets/uploads/';

		
			 $config['book_cover'] = $_FILES['book_cover']['name'] ;
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
			
	    	$this->load->library('upload', $config);
		
		$this->upload->initialize($config);
        
        $book_cover='book_cover';
		if(!$this->upload->do_upload('book_cover'))
		{
		    
			$resultArr['success'] = false;
			$resultArr['error'] = $this->upload->display_errors();
		}   else    {
		   
			$resArr = $this->upload->data();
			$resultArr['success'] = true;
			$book_cover = $resArr['file_name'];
			$data = array(
		         'title' => $title,
				 'book_order' => $book_order,
				 'genre' => $genre,
		         'description' => $description,
				 'status' => $status,
				 'user_id' => $user_id,
				 'slug' => $slug,
				 'created_at'       => date('Y-m-d H:i:s'),
				 'book_cover' => $book_cover
		         );
		        	 $user_res = $this->UserModel->create_book($data);
				if (! empty($user_res)) {
				
                print_r(json_encode([
                    'code' => '201',
                    'status' => 'success',
                    'message' => 'Book Created successfuly.',
					'data' => $user_res
					
					
		        ]));
				
				
            }
            else {
                print_r(json_encode([
                    'code' => '200',
                    'status' => 'failure',
                    'message' => 'Somthing Went Wrong'
                ]));
                }
		}
		 
		
        }
        else{
           print_r(json_encode([
                    'code' => '200',
                    'status' => 'failure',
                    'message' => 'Book Cover field is required'
                ])); 
        }
		}
		else{
			 $error = strip_tags(validation_errors());
            $mess = array(
                "code" => "200",
                "status" => "failure",
                "message" => $error
            );
            print_r(json_encode($mess));
			//echo"Provide email and password.";
           
        }
		
		
			
		
		}
		
	/*	function create_chapter() {
		 
		//	if ($this->form_validation->run() == TRUE) {
        $user_id = $this->input->post('user_id'); 
        //$book_id = $this->input->post('id'); 
        print_r( $user_id);
        $res = $this->UserModel->get_books($user_id);
        print_r($res);
        
            if (empty($res)) {
                
                print_r(json_encode([
                    'code' => '200',
                    'status' => 'failure',
                    'message' => 'you must have a book before attempting to create a chapter.'
					
                ]));
            }
            else{
                
            }
       
       die;
        // echo "<pre>ff"; print_r($book_id); exit();
            $user_books = DB::table('book')
            ->where('user_id', $id)
            ->where('status', 1)
            ->orderBy('title', 'ASC')
            ->get();

            if ($book_id !='') {
            $chap_book = DB::table('book')
            ->where('id', $book_id)
            ->where('status', 1)
            ->get();
            }
		$slug =  $title;
		
		         if (!empty($_FILES['book_cover']['name'])) {
		$resultArr = array();
		 
			$config['upload_path'] = 'application/assets/uploads/';

		
			 $config['book_cover'] = $_FILES['book_cover']['name'] ;
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
			
	    	$this->load->library('upload', $config);
		
		$this->upload->initialize($config);
        
        $book_cover='book_cover';
		if(!$this->upload->do_upload('book_cover'))
		{
		    
			$resultArr['success'] = false;
			$resultArr['error'] = $this->upload->display_errors();
		}   else    {
		   
			$resArr = $this->upload->data();
			$resultArr['success'] = true;
			$book_cover = $resArr['file_name'];
		}
		
		
        }
		
				$data = array(
		         'title' => $title,
				 'book_order' => $book_order,
				 'genre' => $genre,
		         'description' => $description,
				 'status' => $status,
				 'user_id' => $user_id,
				 'slug' => $slug,
				 'book_cover' => $book_cover
		         
				 
		        );
		      
		     print_r($data);
		    
				 $user_res = $this->UserModel->create_book($data);
				if (! empty($user_res)) {
				
                print_r(json_encode([
                    'code' => '201',
                    'status' => 'success',
                    'message' => 'Book Created successfuly.',
					'data' => $user_res
					
					
		        ]));
				
				
            }
				 
		        
			
		//	}
		
		
		
			
		
		}*/
		function create_chapter() {
		        $this->form_validation->set_rules('book_id', 'book_id', 'required');
                $this->form_validation->set_rules('status', 'status', 'required');
                $this->form_validation->set_rules('title', 'title', 'required');
                $this->form_validation->set_rules('chapter_content', 'chapter_content', 'required');
                if ($this->form_validation->run() == TRUE) {
                 $book_id = $this->input->post('book_id'); 
			     $status = $this->input->post('status');
			     $title = $this->input->post('title'); 
			     $chapter_content = $this->input->post('chapter_content'); 
			     
			     $str = $title;    
                 $delimiter = '-';
                 $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
  			     if (!empty($_FILES['chapter_cover']['name'])) {
  			         
        		             $resultArr = array();
        		             $config['upload_path'] = 'application/assets/uploads/';
                             $config['chapter_cover'] = $_FILES['chapter_cover']['name'] ;
                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
        			$this->load->library('upload', $config);
        		     $this->upload->initialize($config);
                     $chapter_cover='chapter_cover';
                		if(!$this->upload->do_upload('chapter_cover'))
                		{
                		    
                			$resultArr['success'] = false;
                			$resultArr['error'] = $this->upload->display_errors();
                		}else{
                		   
                			$resArr = $this->upload->data();
                			$resultArr['success'] = true;
                			$chapter_cover = $resArr['file_name'];
                		}
                		 $res = $this->UserModel->get_books($book_id);
            			 if (empty($res)) {
                              print_r(json_encode([
                                'code' => '200',
                                'status' => 'failure',
                                'message' => 'you must have a book before attempting to create a chapter.'
            					
                            ]));
                        }
                        else{
                            $data = array(
            		         'book_id' => $book_id,
            				 'status' => $status,
            				 'title' => $title,
            		         'chapter_content' => $chapter_content,
            				 'status' => $status,
            				 'slug' => $slug,
            				 'created_at'       => date('Y-m-d H:i:s'),
            				 'chapter_cover' => $chapter_cover
            		        );
            		       
            		         $user_res = $this->UserModel->create_chapter($data);
            		         if (! empty($user_res)) {
            				   print_r(json_encode([
                                'code' => '201',
                                'status' => 'success',
                                'message' => 'Chapter Created successfuly.',
            					'data' => $user_res
            				]));
            		    	}
            		    }
        		
		
                }
			     
            } 
			else{
			 $error = strip_tags(validation_errors());
            $mess = array(
                "code" => "200",
                "status" => "failure",
                "message" => $error
            );
            print_r(json_encode($mess));
		    }    
        
			    
			}
		
			function get_book(){
		    
		    $user_id = $this->input->post('user_id');
		    	$res = $this->UserModel->get_book($user_id);
	
		      if (! empty($res)) {
				 $mess = array(
                    "code" => "201",
                    "status" => "success",
                    "message" => "Data fetch successfully",
                    "data" => $res,
                 );
                 print_r(json_encode($mess));
				
				 }
				  else {
                print_r(json_encode([
                    'code' => '200',
                    'status' => 'failure',
                    'message' => 'Data Not Exist'
                ]));
                }
		    
		}
		
		function save_to_draft(){
		    
		    $book_id = $this->input->post('id');
		    	$res = $this->UserModel->save_to_draft($book_id);
	
		      if (! empty($res)) {
				 $mess = array(
                    "code" => "201",
                    "status" => "success",
                    "message" => "Book Save to Draft Successfully",
                    "data" => $res,
                 );
                 print_r(json_encode($mess));
				
				 }
				  else {
                print_r(json_encode([
                    'code' => '200',
                    'status' => 'failure',
                    'message' => 'Data Not Exist'
                ]));
                }
		    
		}
		
		function get_draft_books(){
		    $user_id = $this->input->post('user_id');
		    $res = $this->UserModel->get_draft_books($user_id);
		       if (! empty($res)) {
				 $mess = array(
                    "code" => "201",
                    "status" => "success",
                    "message" => "Data fetch successfully",
                    "data" => $res,
                 );
                 print_r(json_encode($mess));
				
				 }
				  else {
                print_r(json_encode([
                    'code' => '200',
                    'status' => 'failure',
                    'message' => 'Data Not Exist'
                ]));
                }
		    
		    
		}
		
		function get_chapter(){
		    $book_id = $this->input->post('book_id');
		    $res = $this->UserModel->get_chapter($book_id);
		     if (! empty($res)) {
				 $mess = array(
                    "code" => "201",
                    "status" => "success",
                    "message" => "Data fetch successfully",
                    "data" => $res,
                 );
                 print_r(json_encode($mess));
				
				 }
				  else {
                print_r(json_encode([
                    'code' => '200',
                    'status' => 'failure',
                    'message' => 'Data Not Exist'
                ]));
                }
		    
		    
		    
		    
		}
		function add_comments(){
		    
		    $chapter_id = $this->input->post('chapter_id');  
            $user_id = $this->input->post('user_id'); 
            $user_email = $this->input->post('user_email');  		
	     	$user_name = $this->input->post('user_name');
            $comment = $this->input->post('comment');
            $reply_to = $this->input->post('reply_to');
            $status = $this->input->post('status');
            $approve = $this->input->post('approve');
            	$data = array(
		         'chapter_id' =>$chapter_id,
				 'user_id' => $user_id,
				 'user_email' => $user_email,
		         'user_name' => $user_name,
				 'comment' => $comment,
				 'reply_to' => $reply_to,
				 'status' => $status,
				 'approve' => $approve
		        );
		        $user_res = $this->UserModel->add_comments($data);
				if (! empty($user_res)) {
				
                print_r(json_encode([
                    'code' => '201',
                    'status' => 'success',
                    'message' => 'Comment Added successfuly.',
					'data' => $user_res
					
					
		        ]));
				
				
            }
		        
		    
		}
		function get_comment(){
		    $user_id = $this->input->post('user_id');
		    $res = $this->UserModel->get_comment($user_id);
		     if (! empty($res)) {
				 $mess = array(
                    "code" => "201",
                    "status" => "success",
                    "message" => "Data fetch successfully",
                    "data" => $res,
                 );
                 print_r(json_encode($mess));
				
				 }
				  else {
                print_r(json_encode([
                    'code' => '200',
                    'status' => 'failure',
                    'message' => 'Data Not Exist'
                ]));
                }
		    
		    
		    
		    
		}
		function update_author() {
		 
		$this->form_validation->set_rules('name', 'name', 'required|max_length[255]');
        $this->form_validation->set_rules('email', 'email', 'required|max_length[255]|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'password', 'required|min_length[6]');
		$this->form_validation->set_rules('password_confirmation', 'Confirm Password', 'required|matches[password]');
	//	if ($this->form_validation->run() == TRUE) {
	    
	    $user_id = $this->input->post('user_id');
		$res = $this->UserModel->get_author_profile($user_id);
		if(!empty($res)){
        $name = $this->input->post('name'); 
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $about = $this->input->post('about');
        $gender = $this->input->post('gender');
        $avatar = $this->input->post('avatar');
        $dob = $this->input->post('dob');
	//	$password = password_hash($password,PASSWORD_DEFAULT);
		
		$email_token = base64_encode($email);
		$reader = $this->input->post('reader');
		$verified = 1;
		$active = 1;
		$approved_at = date("Y-m-d");
               if (!empty($_FILES['avatar']['name'])) {
		$resultArr = array();
		 
			$config['upload_path'] = 'application/assets/uploads/';

		
			 $config['avatar'] = $_FILES['avatar']['name'] ;
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
			
	    	$this->load->library('upload', $config);
		
		$this->upload->initialize($config);
        
        $avatar='avatar';
		if(!$this->upload->do_upload($avatar))
		{
		    
			$resultArr['success'] = false;
			$resultArr['error'] = $this->upload->display_errors();
		}   else    {
		   
			$resArr = $this->upload->data();
			$resultArr['success'] = true;
			$avatar = $resArr['file_name'];
		}
		
		
        }
		
			
				$data = array(
		         'name' => $name,
		         'email' => $email,
				 'reader' => $reader,
		         'password' => $password,
		         'verified' => $verified,
				 'active' => $active,
				 'email_token' => $email_token,
				 'updated_at'  => date('Y-m-d H:i:s'),
				 'id'=> $user_id
				  );
		      
		         $user_res = $this->UserModel->update_user($data);
				// $user_res = $this->UserModel->user_insert($data);
				// $user_id = $user_res;
				 print_r($user_id);
			    	$profile_data = array(
		         'user_id' => $user_id,
		         'about' => $about,
		         'dob' => $dob,
		         'gender' => $gender,
		         'updated_at'  => date('Y-m-d H:i:s'),
				 'avatar' => $avatar
				 
		        );
		        
				$profile_res = $this->UserModel->update_profile($profile_data);
				print_r($profile_res);
		        if (! empty($profile_res)) {
                print_r(json_encode([
                    'code' => '201',
                    'status' => 'success',
                    'message' => 'update successfully.'
                ]));
                } 
		//	}
		
		
		
			
		
		}
		
	
		    
		}
		function get_monthlyearning(){
		    
		     $user_id = $this->input->post('user_id');
	         $res = $this->UserModel->get_monthlyearning($user_id);
	          if (! empty($res)) {
				 $mess = array(
                    "code" => "201",
                    "status" => "success",
                    "message" => "Data fetch successfully",
                    "data" => $res,
                 );
                 print_r(json_encode($mess));
				
				 }
	         
	        	
		}
		function bank_details(){
		    
		   
            $user_id = $this->input->post('user_id'); 
            $name = $this->input->post('name');  		
	     	$surname = $this->input->post('surname');
            $bank_name = $this->input->post('bank_name');
            $account_number = $this->input->post('account_number');
            $branch = $this->input->post('branch');
           
            	$data = array(
		         
				 'user_id' => $user_id,
				 'name' => $name,
		         'surname' => $surname,
				 'bank_name' => $bank_name,
				 'account_number' => $account_number,
				 'branch' => $branch
				 
		        );
		        $user_res = $this->UserModel->bank_details($data);
				if (! empty($user_res)) {
				
                print_r(json_encode([
                    'code' => '201',
                    'status' => 'success',
                    'message' => 'Bank Details Added successfuly.',
					'data' => $user_res
					
					
		        ]));
				
				
            }
		        
		    
		}
		function get_bank_details(){
		    
		     $user_id = $this->input->post('user_id');
	         $res = $this->UserModel->get_bank_details($user_id);
	          if (! empty($res)) {
				 $mess = array(
                    "code" => "201",
                    "status" => "success",
                    "message" => "Data fetch successfully",
                    "data" => $res,
                 );
                 print_r(json_encode($mess));
				
				 }
	         
	        	
		}
		function get_payment_details(){
		    
		     $user_id = $this->input->post('user_id');
		     $on_views = $this->input->post('on_views');
	         $res = $this->UserModel->get_payment_details($user_id);
	          if (! empty($res)) {
				 $mess = array(
                    "code" => "201",
                    "status" => "success",
                    "message" => "Data fetch successfully",
                    "data" => $res,
                 );
                 print_r(json_encode($mess));
				
				 }
	         
	        	
		}
		
		function update_reader() {
		 
	     $this->form_validation->set_rules('name', 'name', 'required|max_length[255]');
        $this->form_validation->set_rules('username', 'username', 'required|max_length[255]|is_unique[users.username]');
        $this->form_validation->set_rules('email', 'email', 'required|max_length[255]|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'password', 'required|min_length[6]');
		if ($this->form_validation->run() == TRUE) {
	    
	    $user_id = $this->input->post('user_id');
		$res = $this->UserModel->get_profile($user_id);
	
		if(!empty($res)){
        $name = $this->input->post('name');  
        $username = $this->input->post('username'); 
        $lastname = $this->input->post('lastname');  		
		$email = $this->input->post('email');
        $password = $this->input->post('password');
	//	$password = password_hash($password,PASSWORD_DEFAULT);
		$email_token = base64_encode($email);
		$reader = $this->input->post('reader');
		$avatar = $this->input->post('avatar');
		$active = 1;
		$approved_at = date("Y-m-d");
	//	$password = password_hash($password,PASSWORD_DEFAULT);
		
		$email_token = base64_encode($email);
		$reader = $this->input->post('reader');
		$verified = 1;
		$active = 1;
		$approved_at = date("Y-m-d");
		
               if (!empty($_FILES['avatar']['name'])) {
		$resultArr = array();
		 
			$config['upload_path'] = 'application/assets/uploads/';

		
			 $config['avatar'] = $_FILES['avatar']['name'] ;
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
			
	    	$this->load->library('upload', $config);
		
		$this->upload->initialize($config);
        
        $avatar='avatar';
		if(!$this->upload->do_upload($avatar))
		{
		    
			$resultArr['success'] = false;
			$resultArr['error'] = $this->upload->display_errors();
		}   else    {
		   
			$resArr = $this->upload->data();
			$resultArr['success'] = true;
			$avatar = $resArr['file_name'];
		}
		
		
        }
		
			
				$data = array(
		         'name' => $name,
		         'username' => $username,
		         'lastname' => $lastname,
		         'email' => $email,
				 'reader' => $reader,
		         'password' => $password,
		         'approved_at' => $approved_at,
				 'active' => $active,
				 'email_token' => $email_token,
				 'updated_at'  => date('Y-m-d H:i:s'),
				 'id'=> $user_id
				  );
		    
		         $user_res = $this->UserModel->update_user($data);
		         
				// $user_res = $this->UserModel->user_insert($data);
				// $user_id = $user_res;
				 print_r($user_id);
			    	$profile_data = array(
		         'user_id' => $user_id,
		         'avatar' => $avatar,
		         'dob' => $dob,
		         'updated_at'  => date('Y-m-d H:i:s'),
		         'gender' => $gender
				 
		        );
		        
				$profile_res = $this->UserModel->update_profile($profile_data);
				print_r($profile_res);
		        if (! empty($profile_res)) {
                print_r(json_encode([
                    'code' => '201',
                    'status' => 'success',
                    'message' => 'update successfully.'
                ]));
                } 
		}
		
		
		
			
		
		}
		else{
			 $error = strip_tags(validation_errors());
            $mess = array(
                "code" => "200",
                "status" => "failure",
                "message" => $error
            );
            print_r(json_encode($mess));
			//echo"Provide email and password.";
           
        }
		
	
		    
		}
		function get_author_books(){
		     $user_id = $this->input->post('user_id');
		    
		     $res1 = $this->UserModel->get_author_profile($user_id);
		     if (! empty($res1)) {
				 $mess = array(
                    "code" => "201",
                    "status" => "success",
                    "message" => "Data fetch successfully",
                    "data" => $res1,
                    
                 );
                 print_r(json_encode($mess));
				
				 }
				 $res = $this->UserModel->get_book($user_id);
				 if (! empty($res)) {
				 $mess = array(
                    "code" => "201",
                    "status" => "success",
                    "message" => "Data fetch successfully",
                    "data" => $res,
                    
                 );
                 print_r(json_encode($mess));
				
				 }
		      
		    
		}
		
		
		function newAuthors(){
		    
		    $res = $this->UserModel->newAuthors();
		    	if (! empty($res)) {
				 $mess = array(
                    "code" => "201",
                    "status" => "success",
                    "message" => "Data fetch successfully",
                    "data" => $res,
                 );
                 print_r(json_encode($mess));
				
				 }
		    
		}
		function newRelease(){
		    $res = $this->UserModel->newRelease();
		    	if (! empty($res)) {
				 $mess = array(
                    "code" => "201",
                    "status" => "success",
                    "message" => "Data fetch successfully",
                    "data" => $res,
                 );
                 print_r(json_encode($mess));
				
				 }
		    
		}
		function read_book(){
		    $book_id = $this->input->post('book_id');
		    $res = $this->UserModel->getBookswithAuthorNmae($book_id);
		    
		     if (! empty($res)) {
				 $mess = array(
                    "code" => "201",
                    "status" => "success",
                    "message" => "Data fetch successfully",
                    "data" => $res,
                 );
                 print_r(json_encode($mess));
				
			}
		    $res1 = $this->UserModel->get_chapter($book_id);
		    
		     if (! empty($res1)) {
				 $mess = array(
                    "code" => "201",
                    "status" => "success",
                    "message" => "Data fetch successfully",
                    "data" => $res1,
                 );
                 print_r(json_encode($mess));
				
				 }
				  else {
                print_r(json_encode([
                    'code' => '200',
                    'status' => 'failure',
                    'message' => 'Data Not Exist'
                ]));
                }
		    
		    
		    
		    
		}
		
		function read_chapter(){
		    $book_id = $this->input->post('book_id');
		    $chapter_id = $this->input->post('chapter_id');
		    $res = $this->UserModel->ReadBookChapter($book_id,$chapter_id);
		    if (! empty($res)) {
				 $mess = array(
                    "code" => "201",
                    "status" => "success",
                    "message" => "Data fetch successfully",
                    "data" => $res,
                 );
                 print_r(json_encode($mess));
				
				 }
		}
		function books_view_count(){
		    $loginuserid = $this->input->post('user_id');
		    $id = $this->input->post('book_id');
		    $auhthorId = $this->input->post('auhthorId');
		    if($loginuserid != ''){
		        $session_id = session_id();
		       $res = $this->UserModel->user_books_view_count($id,$loginuserid); 
		       
		       $res = count($res);
		       if($res == 0){
		           $data = array(
		         'session_id' => $session_id,
		         'book_id' => $id,
		         'logged_in_user_id' => $loginuserid,
		         'created_at'       => date('Y-m-d H:i:s'),
		         
				  );
		            $views = $this->UserModel->books_view_insert($data);  
		             if (! empty($views)) {
    				 $mess = array(
                        "code" => "201",
                        "status" => "success",
                        "message" => "Data Insert successfully",
                        "data" => $views,
                     );
                 print_r(json_encode($mess));
				
				 }
				 
				
				 $book_view_count = $this->UserModel->books_view_count($id); 
		        
		         $res = count($book_view_count);
		         $amt = 0.002;
                 $type = 'book';
                 $created_at = date("Y-m-d");
                 $data = array(
		          'user_id' =>  $auhthorId, 
                  'amount' => 0.002, 
                  'type' => $type,
                  'on_views' => $res,
                  'date' => $created_at
		         );
	
                 $views = $this->UserModel->transaction_insert($data); 
                 if(!empty($views)){
                 $user_amount = $this->UserModel->update_user_amount($auhthorId,$amt);
                 $admin_amount = $this->UserModel->update_admin_amount($amt);
                 if($admin_amount){
                    print_r(json_encode([
                    'code' => '200',
                    'status' => 'success',
                    'message' => 'Amount Added'
                ])); 
                 }
                 }
		       }
		       
		       
		       else {
                print_r(json_encode([
                    'code' => '200',
                    'status' => 'failure',
                    'message' => 'Already Added'
                ]));
                }
                
		       
		}
		

		
		    
		}
		
		
		
		
		
		 
		
}
	
