<?php

define('USER_AUTH', 'USER_AUTH_KPSI');

class Userauth {

    private $_error_string;
    private $_timeout;
    private $_off_is_called;
    private $CI;

    function __construct() {
        $this->_off_is_called = true;
        $this->_timeout = 7200;

        $this->CI = & get_instance();
    }

    function logout() {
//        $this->CI->session->sess_destroy();
//        $this->CI->nativesession->destroy();
        $this->CI->session->unset_userdata(USER_AUTH);
        $this->CI->nativesession->delete(USER_AUTH);
    }

    function is_logged() {
        if (!empty($this->CI->nativesession->get(USER_AUTH))) {
            return true;
        } else {
            $this->logout();
            return false;
        }
    }

    function is_page($page='') {
        if (empty($page)) {
            $page = $this->CI->router->fetch_class();
        }
        if($this->CI->router->fetch_method()=='error_page'){
            return true;
        }
        $sess_data = $this->CI->nativesession->get(USER_AUTH);
        $hak = $sess_data['role'];
        
        return isset($hak[$page]);
    }

    function is_hak($method = '', $page = '') {
        $ret = true;
        if (empty($method)) {
            $method = $this->CI->router->fetch_method();
        }
        if (empty($page)) {
            $page = $this->CI->router->fetch_class();
        }
        if($method=='error_page'){
            return true;
        }
        $sess_data = $this->CI->nativesession->get(USER_AUTH);
        $hak = $sess_data['role'];
//        echo"<pre>";print_r(array($page, $method));echo"</pre>";
        switch ($method) {
            case "add":
            case "create":
                $ret = boolval($hak[$page]['add']);
                break;
            case "edit":
            case "update":
                $ret = boolval($hak[$page]['edit']);
                break;
            case "delete":
            case "hapus":
                $ret = boolval($hak[$page]['delete']);
                break;
            case "export":
            case "export_all":
                $ret = boolval($hak[$page]['export']);
                break;
            case "print":
            case "print_all":
                $ret = boolval($hak[$page]['print']);
                break;
            default :
                $ret = true;
                break;
        }
        return $ret;
    }

    function get_error_string() {
        return $this->_error_string;
    }
}