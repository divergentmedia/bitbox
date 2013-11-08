<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

//
//  Basic401Auth
//  Version 0.1
//  Coded by Nathan Koch on 12-23-2008
//  Just add 
//
//      $this->load->library('basic401auth');
//      $this->Basic401Auth->require_login() 
//
//  anywhere you need basic authentication

class Basic401Auth
{

    function __construct()
    {
        $this->ci =& get_instance();
    }

    function headers_401()
    {

        $user = $this->ci->config->item('admin_user');
        $password = $this->ci->config->item('admin_pw');

        if ( !isset($_SERVER['PHP_AUTH_USER']) )
        {
            header('WWW-Authenticate: Basic realm="BitDrop"');
            header('HTTP/1.0 401 Unauthorized');
            echo("Please enter a valid username and password");
            exit();        
        }
        else if ( ($_SERVER['PHP_AUTH_USER'] == $user) && ($_SERVER['PHP_AUTH_PW'] == $password) )
        {
            return true;
        }
        else
        {
            header('WWW-Authenticate: Basic realm="BitDrop"');
            header('HTTP/1.0 401 Unauthorized');
            echo("Please enter a valid username and password");
            exit();        
        }
    }

    function require_login()
    {
        $logged_in = $this->ci->session->userdata('logged_in');
        if ( $logged_in != TRUE)
        {
            $this->headers_401();
            $this->ci->session->set_userdata( array('logged_in' => TRUE) );
        }
    }
}

?> 