<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (function_exists('date_default_timezone_set')) {
    date_default_timezone_set('Asia/Jakarta');
}
if(!function_exists('_get_status_komplain')){
    function _get_status_komplain($status=''){
        return ($status=='1')?'<span class="label label-sm label-success">TERJAWAB</span>':'<span class="label label-sm label-danger">BARU</span>';
    }
}
if(!function_exists('_get_status')){
    function _get_status($status=''){
        return ($status=='1')?'<span class="label label-sm label-success">AKTIF</span>':'<span class="label label-sm label-danger">NON AKTIF</span>';
    }
}
if(!function_exists('_get_status_pending')){
    function _get_status_pending($status=''){
        if($status=='0'){
            return '<span class="label label-sm label-danger">PENDING VALIDASI</span>';
        }else if($status=='1'){
            return '<span class="label label-sm label-success">VALID</span>';
        }else if($status=='2'){
            return '<span class="label label-sm label-warning">DIBATALKAN</span>';
        }else{
            return '';
        }
    }
}
if(!function_exists('_get_status_pending_transfer')){
    function _get_status_pending_transfer($status=''){
        if($status=='0'){
            return '<span class="label label-sm label-danger">PENDING</span>';
        }else if($status=='1'){
            return '<span class="label label-sm label-success">SUDAH TRF</span>';
        }else if($status=='2'){
            return '<span class="label label-sm label-warning">DIBATALKAN</span>';
        }else{
            return '';
        }
    }
}
if(!function_exists('_get_action_button_pickup')){
    function _get_action_button_pickup($param='', $sppb, $status='', $class_name='', $role_add='', $role_edit='', $role_delete='', $role_print=''){
        $ret='<div class="btn-group">
                <a class="btn btn-default btn-xs" href="'.base_url().$class_name.'/detail/'.$param.'"><i class="glyphicon glyphicon-eye-open"></i> Detail</a>';
            if((boolval($role_add) && $status=='0') || (boolval($role_edit) && ($status=='0' || $status=='1')) || 
                    (boolval($role_delete) && ($status=='0' || $status=='1')) || (boolval($role_print) && $status=='1')){
                $ret.= '
                <a class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" href="#">&nbsp;<span class="caret"></span></a>
                <ul class="btn-xs dropdown-menu" role="menu">
                ';
                if($status=='0'){
                    $ret.=(boolval($role_add)?'<li><a href="'.base_url().$class_name.'/add/'.$param.'"><i class="fa fa-truck"></i> Pickup</a></li>':'');
                }
                if($status=='0' || $status=='1'){
                    $ret.=(boolval($role_edit) ?'<li><a href="'.base_url().$class_name.'/validasi/'.$param.'"><i class="glyphicon glyphicon-check"></i> Validasi Pickup</a></li>':'');
                    $ret.=(boolval($role_edit) ?'<li><a href="'.base_url().$class_name.'/edit/'.$param.'"><i class="glyphicon glyphicon-pencil"></i> Edit Booking CN</a></li>':'');
                    $ret.=(boolval($role_delete) ?'<li><a href="'.base_url().$class_name.'/delete/'.$param.'" onClick="return confirm(\'Apakah Anda yakin ingin membatalkan booking?\');"><i class="glyphicon glyphicon-trash"></i> Batalkan / Void</a></li>':'');
                }
                if($status=='1'){
                    $ret.=(boolval($role_print) ?'<li><a href="'.base_url().$class_name.'/sppb/'.$sppb.'" target="_blank"><i class="glyphicon glyphicon-print"></i> Print SPPB</a></li>':'');
                }
                $ret.='</ul>';
            }
        $ret.='
            </div>';
        return $ret;
    }
}
if(!function_exists('_get_singkat_nominal')){
    function _get_singkat_nominal($nom){
        if($nom>=1000000000000){
            $nom = $nom/1000000000000;
            $singkat = number_format($nom,2,',','.')."T";
        }else if($nom>=1000000000){
            $nom = $nom/1000000000;
            $singkat = number_format($nom,2,',','.')."M";
        }else if($nom>=1000000){
            $nom = $nom/1000000;
            $singkat = number_format($nom,2,',','.')."Jt";
        }else{
            $singkat = number_format($nom,2,',','.');
        }
        return $singkat;
    }
}
if(!function_exists('_get_yesno')){
    function _get_yesno($type=''){
        return ($type=='1')?'<span class="label label-sm label-success">IYA</span>':'<span class="label label-sm label-danger">TIDAK</span>';
    }
}
if(!function_exists('_var_dump')){
    /*
     * Get value from given array by key return '' if key not exist
     * param @array array
     * param @key given key
     * return String value
     */
    function _var_dump($obj, $withDump = FALSE){
        if ($withDump)
            var_dump($obj);
        
        echo "<pre>";
        print_r($obj);
        echo "</pre>";
    }
}
if(!function_exists('_format_uang')){
    function _format_uang($str){
        return number_format($str, 2);
    }
}
if(!function_exists('_format_angka')){
    function _format_angka($str){
        return number_format($str);
    }
}
if(!function_exists('_format_tgl')){
    function _format_tgl($str){
        if($str==""){
            return $str;
        }
        $date = explode(' ', $str);
        if(count($date)>1){
            $jam = $date[1];
            $t = explode('-', $date[0]);
            $tgl = $t[2].'-'.$t[1].'-'.$t[0];
            $ret = $tgl. ' '.$jam;
        }else{
            $t = explode('-', $date[0]);
            $ret = $t[2].'-'.$t[1].'-'.$t[0];
        }
        
        return $ret;
    }
}
if(!function_exists('_padleft')){
    function _padleft($str, $len, $chr = '0'){
        return str_pad($str, $len, $chr, STR_PAD_LEFT);
    }
}
if(!function_exists('_padright')){
    function _padright($str, $len, $chr = ' '){
        return str_pad($str, $len, $chr, STR_PAD_RIGHT);
    }
}
if (!function_exists('_encode_uri_component')) {
    function _encode_uri_component($str) {
        $revert = array('%21' => '!', '%2A' => '*', '%27' => "'", '%28' => '(', '%29' => ')');
        return strtr(rawurlencode($str), $revert);
    }
}
if(!function_exists('_generate_password')){
    function _generatePassword($length = 9, $add_dashes = false, $available_sets = 'lud'){
	$sets = array();
	if(strpos($available_sets, 'l') !== false)
		$sets[] = 'abcdefghjkmnpqrstuvwxyz';
	if(strpos($available_sets, 'u') !== false)
		$sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
	if(strpos($available_sets, 'd') !== false)
		$sets[] = '23456789';
	if(strpos($available_sets, 's') !== false)
		$sets[] = '!@#$%&*?';
	$all = '';
	$password = '';
	foreach($sets as $set){
            $password .= $set[array_rand(str_split($set))];
            $all .= $set;
	}
	$all = str_split($all);
	for($i = 0; $i < $length - count($sets); $i++)
            $password .= $all[array_rand($all)];
	$password = str_shuffle($password);
	if(!$add_dashes)
            return $password;
	$dash_len = floor(sqrt($length));
	$dash_str = '';
	while(strlen($password) > $dash_len){
            $dash_str .= substr($password, 0, $dash_len) . '-';
            $password = substr($password, $dash_len);
	}
	$dash_str .= $password;
        
	return $dash_str;
    }
}

if ( !function_exists('_array2Object') ){
    function _array2Object($arr){
        $enc = json_encode($arr);
        $dec = json_decode($enc);
        return $dec;
    }    
}

if ( !function_exists('_object2Array') ){
    function _object2Array($obj){
        $enc = json_encode($obj);
        $dec = json_decode($enc, true);
        return $dec;
    }    
}