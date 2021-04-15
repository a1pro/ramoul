<?php
class UserModel extends CI_Model{
function __construct() {
parent::__construct();
}
/** USER **/
function user_insert($data){

 $this->db->insert('users', $data);
 $insert_id = $this->db->insert_id();
 return  $insert_id;
}
function profile_insert($data){

 return $this->db->insert('profiles', $data);
}
function getRows($email,$password){
$query = $this->db->get_where('users', array('email' => $email,'password' => $password));
$res = $query->result_array();
 return $res;
}

}
?>