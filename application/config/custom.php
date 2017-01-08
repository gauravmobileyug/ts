<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Base Site URL
|--------------------------------------------------------------------------
|
| URL to your CodeIgniter root. Typically this will be your base URL,
| WITH a trailing slash:
|
|	http://example.com/
|
| WARNING: You MUST set this value!
|
| If it is not set, then CodeIgniter will try guess the protocol and path
| your installation, but due to security concerns the hostname will be set
| to $_SERVER['SERVER_ADDR'] if available, or localhost otherwise.
| The auto-detection mechanism exists only for convenience during
| development and MUST NOT be used in production!
|
| If you need to allow multiple domains, remember that this file is still
| a PHP script and you can easily do that on your own.
|
*/
date_default_timezone_set('Asia/Kolkata');

$config['hr_uploads_dir'] 		= 'uploads/hr/';
$config['otheractivity'] 		= 'uploads/otheractivity/';


$config['employee_uploads_dir'] 		= 'uploads/employee/';
$config['employee_pic_dir'] 			= $config['employee_uploads_dir'] .'profile_pics';
$config['employee_documents'] 			= $config['employee_uploads_dir'] .'documents';
$config['employee_salary_slips'] 		= $config['employee_uploads_dir'] .'salary_slips';




