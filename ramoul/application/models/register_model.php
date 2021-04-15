<?php
class UserModel extends CI_Model{
function __construct() {
parent::__construct();
}
/** USER **/
function insert($data){

 return $this->db->insert('users', $data);
}
function getRows($email,$password){
$query = $this->db->get_where('user', array('email' => $email,'password' => $password));
$res = $query->result_array();
 return $res;
}
function getRowsByEmail($email){
$query = $this->db->get_where('user', array('email' => $email));
$res = $query->result_array();
 return $res;
}
/** RESTARANT **/
function insert_restaurants_detail($data){

 return $this->db->insert('restaurants_detail', $data);
}
function restaurant_list(){
$query = $this->db->get('restaurants_detail');
$res = $query->result_array();
 return $res;
}
function get_restaurants_detail($email){
$query = $this->db->get_where('user', array('email' => $email));
$res = $query->result_array();
 return $res;
}
function getRestaurantsByEmail($email){
$query = $this->db->get_where('restaurants_detail', array('email' => $email));
$res = $query->result_array();
 return $res;
}
/** PRODUCTS **/
function get_product(){
$query = $this->db->get('products');
$res = $query->result_array();
 return $res;
}
/** CART **/
function insert_cart($data){

 return $this->db->insert('cart', $data);
}
function update_cart($data){
	$user_id = $data['user_id'];
	$product_id = $data['product_id'];
    $this->db->where('user_id', $user_id);
    $this->db->where('product_id', $product_id);
    
   return $this->db->update('cart', $data);
}
function getRowsByUid($user_id){
$query = $this->db->get_where('cart', array('user_id' => $user_id));
$res = $query->result_array();
 return $res;
}
function getCartByUidPid($user_id,$product_id){
$query = $this->db->get_where('cart', array('user_id' => $user_id,'product_id' => $product_id));
$res = $query->result_array();
 return $res;
}

function getUserByUid($user_id){
$query = $this->db->get_where('user', array('id' => $user_id));
$res = $query->result_array();
 return $res;
}

function post_proceed_to_pay($data){

 return $this->db->insert('proceed_to_pay', $data);
}

function post_order_history($data){

 return $this->db->insert('order_history', $data);
}
function deleteCartByUid($cart_id){

 return $this->db->delete('cart',array('cart_id'=>$cart_id));
}
function get_product_id($cart_id){
 $query = $this->db->get_where('cart',array('id'=>$cart_id));
 $res = $query->result_array();
 return $res; 
 
}

function restaurant_id($restaurant_id){
$query = $this->db->get_where('cart', array('restaurant_id' => $restaurant_id));
$res = $query->result_array();
 return $res;
}
}
?>