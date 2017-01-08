<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
require_once dirname(__FILE__) . '/html2pdf/vendor/autoload.php';

class Custompdf extends HTML2PDF
{
    function __construct()
    {
        parent::__construct();
    }
}