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

function create_book($data){

 return $this->db->insert('book', $data);
}
function getRows($email,$password){
$where = "email='$email' AND password='$password'";
$query = $this->db->get_where('users',$where);
$res = $query->result_array();
 return $res;
}

/*
function get_books($user_id){
	
    $this->db->where('user_id', $user_id);
    $this->db->where('status', 1);
    $this->db->order_by('title', 'asc');
    $query = $this->db->get('book');
    return  $res = $query->result_array(); 
  
}*/
function get_books($book_id){
    $query = $this->db->get_where('book', array('id' => $book_id));
    $res = $query->result_array();
    return $res;
}
function create_chapter($data){

 return $this->db->insert('Chapter', $data);
}
function get_book($user_id){
$query = $this->db->get_where('book', array('user_id' => $user_id));
$res = $query->result_array();
 return $res;
}
function get_chapter($book_id){
$query = $this->db->get_where('Chapter', array('book_id' => $book_id));
$res = $query->result_array();
 return $res;
}
function add_comments($data){

 return $this->db->insert('comments', $data);
}
function get_comment($user_id){
$query = $this->db->get_where('comments', array('user_id' => $user_id));
$res = $query->result_array();
 return $res;
}
function update_user($data){
  $id  = $data['id'];  
 $this->db->where('id', $id);
 return $this->db->update('users', $data);
 
}
function update_profile($data){
    $id  = $data['user_id'];
$this->db->where('user_id', $id);
 return $this->db->update('profiles', $data);
}
function get_profile($user_id){
$query = $this->db->get_where('profiles', array('user_id' => $user_id));
$res = $query->result_array();
 return $res;
}
function get_monthlyearning($user_id){
$this->db->select("CONCAT(MONTH(date),'-',YEAR(date)) AS monthyear, SUM(amount) AS amount");
$this->db->select('admin_id, user_id, amount','type','on_views','date','cron');
$this->db->from('transaction');
$this->db->where('user_id',$user_id);
$this->db->where('on_views !=',0);
$this->db->group_by("monthyear","DESC");
$qwer = $this->db->get();
return $res = $qwer->result();
   
}
function bank_details($data){

 return $this->db->insert('bank_details', $data);
}
function get_bank_details($user_id){
$query = $this->db->get_where('bank_details', array('user_id' => $user_id));
$res = $query->result_array();
 return $res;
}
function get_payment_details($user_id){
    /*
$query = $this->db->get_where('transaction', array('user_id' => $user_id,'on_views' => '0'));
$res = $query->result_array();*/
$query = $this->db->select('transaction.*,users.*')
    ->from('transaction')
    ->join('users', 'transaction.user_id = users.id', 'left')
    ->where_in('transaction.user_id', $user_id)
    ->where_in('transaction.on_views', 0)
    ->get();
    return $query->result_array();
 return $res;
}
function author_list(){
$query = $this->db->select('users.*,profiles.*')
    ->from('users')
    ->join('profiles', 'users.id = profiles.user_id', 'left')
    ->where_in('users.reader',0)
    ->get();    
    $res = $query->result_array();
    return $res;
}
function get_author_profile($user_id){
    $query = $this->db->select('users.*,profiles.*')
    ->from('users')
    ->join('profiles', 'users.id = profiles.user_id', 'left')
    ->where_in('profiles.user_id', $user_id)
    ->where_in('users.reader',0)
    ->get();    
    $res = $query->result_array();
    return $res;

}
function newAuthors(){
$query = $this->db->select('users.*,profiles.user_id,profiles.avatar')
    ->from('users')
    ->join('profiles', 'users.id = profiles.user_id', 'left')
    ->where_in('active','1')
    ->where_in('users.reader',0)
    ->order_by('created_at','DESC')
    ->limit(10)
    ->get();    
    $res = $query->result_array();
    return $res;
}

function newRelease(){
$query = $this->db->select('book.id as id, book.title, book.book_cover,book.user_id,users.name,users.verified, users.active,COUNT(Chapter.id) as total_chapter')
    ->from('book')
    ->join('users', 'users.id = book.user_id', 'left')
    ->join('Chapter', 'Chapter.book_id = book.id', 'left')
    ->where_in('book.status','1')
    ->where_in('users.verified',1)
    ->where_in('users.active',1)
    ->order_by('book.id','DESC')
    ->group_by('book.id')
    ->having('total_chapter >=',20)
    ->limit(15)
    ->get();    
    $res = $query->result_array();
    
    return $res;
}
function getBookswithAuthorNmae($book_id){
    $query = $this->db->select('users.name,book.*')
    ->from('book')
    ->join('users', 'users.id = book.user_id', 'left')
    ->where_in('book.id',$book_id)
    ->get();    
    $res = $query->result_array();
    return $res;

}
function ReadBookChapter($book_id,$chapter_id){
    $query = $this->db->get_where('Chapter', array('book_id' => $book_id,'id' => $chapter_id));
    $res = $query->result_array();
    return $res;
    
}
function save_to_draft($book_id){
  
    $this->db->set('status', '0', FALSE);        
    $where = array('id' =>$book_id);
    $this->db->where($where);
    return $this->db->update('book');
 
}
function get_draft_books($user_id){
    $query = $this->db->get_where('book', array('user_id' => $user_id,'status' => '0'));
    $res = $query->result_array();
    return $res;
    
}

function user_books_view_count($id,$loginuserid){
     $query = $this->db->get_where('books_view_count', array('book_id' => $id,'logged_in_user_id' => $loginuserid));
     
     $res = $query->result_array();
     return $res;
}

function books_view_count($id){
     $query = $this->db->get_where('books_view_count', array('book_id' => $id));
     $res = $query->result_array();
     return $res;
}
 function books_view_insert($data){

 return $this->db->insert('books_view_count', $data);
}
function transaction_insert($data){
 
 return $this->db->insert('transaction', $data);
}
function update_user_amount($auhthorId,$amt){
    $this->db->set('amount', 'amount+0.002', FALSE);
    $where = array('id' =>$auhthorId);
    $this->db->where($where);
    return $this->db->update('users');
 
}
function update_admin_amount($amt){
    $this->db->set('amount', 'amount+0.002', FALSE);
    $where = array('admin' =>1);
    $this->db->where($where);
    return $this->db->update('users');
 
}
}
?>