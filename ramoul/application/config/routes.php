<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


$route['api/Register'] = '/webServices/UserController/author_register';
$route['api/readerRegister'] = '/webServices/UserController/reader_register';
$route['api/login_post'] = '/webServices/UserController/login_post';
$route['api/get_author'] = '/webServices/UserController/get_author';
$route['api/create_book'] = '/webServices/UserController/create_book';
$route['api/get_book'] = '/webServices/UserController/get_book';
$route['api/create_chapter'] = '/webServices/UserController/create_chapter';
$route['api/get_chapter'] = '/webServices/UserController/get_chapter';
$route['api/add_comments'] = '/webServices/UserController/add_comments';
$route['api/get_comment'] = '/webServices/UserController/get_comment';
$route['api/update_author'] = '/webServices/UserController/update_author';
$route['api/get_monthlyearning'] = '/webServices/UserController/get_monthlyearning';
$route['api/bank_details'] = '/webServices/UserController/bank_details';
$route['api/get_bank_details'] = '/webServices/UserController/get_bank_details';
$route['api/get_payment_details'] = '/webServices/UserController/get_payment_details';
$route['api/update_reader'] = '/webServices/UserController/update_reader';

$route['api/get_author_list'] = '/webServices/UserController/get_author_list';
$route['api/get_author_books'] = '/webServices/UserController/get_author_books';
$route['api/newAuthors'] = '/webServices/UserController/newAuthors';
$route['api/newRelease'] = '/webServices/UserController/newRelease';
$route['api/read_book'] = '/webServices/UserController/read_book';
$route['api/read_chapter'] = '/webServices/UserController/read_chapter';
$route['api/save_to_draft'] = '/webServices/UserController/save_to_draft';
$route['api/get_draft_books'] = '/webServices/UserController/get_draft_books';
$route['api/books_view_count'] = '/webServices/UserController/books_view_count';










