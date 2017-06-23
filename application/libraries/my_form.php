<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class My_form {
    
    var $datafield = array();
    private $form_name;
    private $style="lg";
    private $w_label="2";
    private $w_field="9";
    private $is_search=false;
    
    function __construct() {
        $this->CI = & get_instance();
    }
    
    function set($data, $name='my_form'){
        $this->datafield=$data;
        $this->form_name=$name;
    }
    function set_value($value = array()){
        if($value=='' || count($value)<1){
            return;
        }
        foreach ($value as $key => $val){
            $this->datafield[$key]['value'] = $val;
        }
    }
    function render_form($action='', $button = TRUE, $floating = TRUE){
        if($action==''){
            $action = base_url().$this->CI->router->fetch_class()."/insert";
        }else if($action=='edit'){
            $action = base_url().$this->CI->router->fetch_class()."/update";
        }
        $ret='
            <form id="'.$this->form_name.'" method="post" action="'.$action.'" class="form form-validate'.(boolval($floating)?' floating-label':'').'" novalidate="novalidate">
                <div class="card">
                    <div class="card-body">';
        foreach($this->datafield as $key => $val){
            $ret.=$this->get_element($key, $val);
        }
        $ret.='
                    </div><!--end .card-body -->
        ';
        if($button){
            $ret.='
                    <div class="card-actionbar">
                        <div class="card-actionbar-row">
                            <button type="submit" class="btn btn-raised btn-primary ink-reaction">Simpan</button>&nbsp;
                            <a href="'. base_url().$this->CI->router->fetch_class().'" role="button" class="btn btn-raised ink-reaction btn-default">Batal</a>
                        </div>
                    </div>
            ';
        }
        $ret.='
                </div><!--end .card -->
            </form>';
        
        return $ret;
    }
    function get_elements_search(){
        $this->w_label = '3';
        $this->w_field = '8';
        $this->is_search = true;
        return $this->get_elements();
    }
    function get_elements(){
        $ret='';
        foreach($this->datafield as $key => $val){
            $ret.=$this->get_element($key, $val);
        }
        return $ret;
    }
    private function get_element($id, $element = array()){
        if($element['type'] == 'hidden'){
            return '<input type="hidden" name="'.$id.'" value="'.$element['value'].'" id="input-'.$id.'">';
        }
        $is_numeric = false;
        $ret='';
        $pattern="";
        $pattern_msg="";
        $element['format']=isset($element['format'])?strtolower($element['format']):"text";
        $element['value']=isset($element['value'])?$element['value']:'';
        if(empty($element['pattern'])){
            switch ($element['format']){
                case 'an':
                case 'ans':
                case 'text':
                    $pattern_msg = "Isian yang diperbolehkan adalah alfabet dan angka.";
                    break;
                case 'n':
                case 'num':
                case 'numeric':
                    $is_numeric = true;
                    $pattern = "^[0-9\-\+\.]+$";
                    $pattern_msg = "Isian yang diperbolehkan hanya angka.";
                    break;
                case 'date':
                    $pattern = "^[0-9\-]+$";
                    $pattern_msg = "Format tanggal = YYYY-MM-DD.";
                    break;
                default:
                    break;                
            }
        }else{
            $pattern = $element['pattern'];
        }
        $placeholder="";
        if(!empty($element['placeholder'])){
            $placeholder = $element['placeholder'];
        }
        $js="";
        $ret.='
            <div class="form-group">
        ';
        switch($element['type']){
            case 'select':
            case 'select2':
                $ret.='<select class="form-control select2" id="input-'.$id.'" '.((isset($element['readonly'])&&$element['readonly']==true)?'disabled ':'').' name="'.$id.'" '.((isset($element['required'])&&$element['required']==true && !$this->is_search)?' required ':'').'>'.($this->is_search?'<option>ALL</option>':'<option></option>').'';
                if(isset($element['data'])){
                    foreach($element['data'] as $k => $v){
                        if(is_array($v) && count($v)>0){
                            $ret.= '<optgroup label="'.$k.'">';
                            foreach($v as $kk => $vv){
                                $ret.= '<option value="'.$kk.'"'.(set_value($id, $element['value'])==$k?' selected="selected"':'').'>'.$vv.'</option>';
                            }
                            $ret.= '</optgroup>';
                        }else{
                            $ret.= '<option value="'.$k.'"'.(set_value($id, $element['value'])==$k?' selected="selected"':'').'>'.$v.'</option>';
                        }
                    }
                }
                $ret.='
                    </select>
                ';
                
                break;
            case 'radio':
                break;
            case 'textarea':
                $ret.='
                    <textarea class="form-control" id="input-'.$id.'" name="'.$id.'" rows="5"'.((isset($element['readonly'])&&$element['readonly']==true)?' readonly':'').''.(isset($element['minLength'])?' data-rule-minlength="'.$element['minLength'].'"':'').''.(isset($element['maxLength'])?' maxlength="'.$element['maxLength'].'"':'').''.
                    ((isset($element['required'])&&$element['required']==true && !$this->is_search)?' required ':'')
                    .'>'.(set_value($id, $element['value'])).'</textarea>';
                break;
            case 'hidden':
                $ret.='<input type="hidden" id="input-'.$id.'" name="'.$id.'" '.(isset($element['value'])?' value="'.(set_value($id, $element['value'])).'"':'').' />';
                break;
            case 'checkbox':
                $ret.='<div class="checkbox checkbox-styled"><label><input type="checkbox" id="input-'.$id.'" name="'.$id.'" value="1"'.(boolval(set_value($id, $element['value']))?' checked="checked"':'').'><span>'.ucwords(isset($element['label'])?$element['label']:'').'</span></label></div>';
                break;
            case 'date':
                $ret.='
                
                <div class="input-group date date-picker" id="input-'.$id.'">
                    <div class="input-group-content">
                        <input type="text" class="form-control" name="'.$id.'"'.((isset($element['required'])&&$element['required']==true && !$this->is_search)?' required ':'').' value="'.(set_value($id, $element['value'])).'">
                        <label></label>
                    </div>
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
                ';
                break;
            case 'datemask':
                $ret.='
                    <input type="text"  class="form-control date-mask" id="input-'.$id.'" name="'.$id.'" '.((isset($element['readonly'])&&$element['readonly']==true)?' readonly="readonly"':'').''.(isset($element['minLength'])?' data-rule-minlength="'.$element['minLength'].'"':'').''.(isset($element['maxLength'])?' maxlength="'.$element['maxLength'].'"':'').''.(isset($element['min'])?' data-rule-min="'.$element['min'].'"':'').''.(isset($element['max'])?' data-rule-max="'.$element['max'].'"':'').''.((isset($element['required'])&&$element['required']==true && !$this->is_search)?' required ':'').' value="'.(set_value($id, $element['value'])).'"'.(!$this->is_search && !empty($pattern)?' pattern="'.$pattern.'" ':'').' />';
                break;
            case 'time':
                $ret.='
                <div class="input-group">
                    <input type="text" class="form-control timepicker time-picker" id="input-'.$id.'" name="'.$id.'"'.((isset($element['required'])&&$element['required']==true && !$this->is_search)?' required ':'').' value="'.(set_value($id, $element['value'])).'">
                    <span class="input-group-btn">
                    <button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>
                    </span>
                </div>
                ';
                break;
            case 'daterange':
                $ret.='
                    <div class="input-daterange input-group date-range" id="input-'.$id.'">
                        <div class="input-group-content">
                            <input type="text" class="form-control" name="'.$id.'1" />
                            <label for="input-'.$id.'">'. ucwords(isset($element['label'])?$element['label']:'').''.((isset($element['required'])&&$element['required']==true && !$this->is_search)?' <span class="danger">*</span>':'').'</label>
                        </div>
                        <span class="input-group-addon">s.d.</span>
                        <div class="input-group-content">
                            <input type="text" class="form-control" name="'.$id.'2" />
                            <div class="form-control-line"></div>
                        </div>
                    </div>
                ';
                break;
            case 'timemask':
                $ret.='
                    <input type="text"  class="form-control time-mask" id="input-'.$id.'" name="'.$id.'" '.((isset($element['readonly'])&&$element['readonly']==true)?' readonly="readonly"':'').''.(isset($element['minLength'])?' data-rule-minlength="'.$element['minLength'].'"':'').''.(isset($element['maxLength'])?' maxlength="'.$element['maxLength'].'"':'').''.(isset($element['min'])?' data-rule-min="'.$element['min'].'"':'').''.(isset($element['max'])?' data-rule-max="'.$element['max'].'"':'').''.((isset($element['required'])&&$element['required']==true && !$this->is_search)?' required ':'').' value="'.(set_value($id, $element['value'])).'"'.(!$this->is_search && !empty($pattern)?' pattern="'.$pattern.'" ':'').' />';
                break;
            case 'datetime':
                $ret.='
                <div class="input-group date datetime-picker" data-date-format="yyyy-mm-dd hh:ii">
                    <input type="text" size="16" readonly class="form-control" id="input-'.$id.'" name="'.$id.'"'.((isset($element['required'])&&$element['required']==true && !$this->is_search)?' required ':'').' value="'.(set_value($id, $element['value'])).'">
                    <span class="input-group-btn">
                    <button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
                    </span>
                </div>
                ';
                break;
            default:
                $ret.='
                    <input type="'.$element['type'].'" '
                    . ''.(isset($element['mask'])?'data-inputmask="'.$element['mask'].'"':'').' '
                    . ''.'class="form-control'.($is_numeric?' number-mask':'').'" id="input-'.$id.'" name="'.$id.'" '.((isset($element['readonly'])&&$element['readonly']==true)?' readonly':'').''.(isset($element['minLength'])?' data-rule-minlength="'.$element['minLength'].'"':'').''.(isset($element['maxLength'])?' maxlength="'.$element['maxLength'].'"':'').''.(isset($element['min'])?' data-rule-min="'.$element['min'].'"':'').''.(isset($element['max'])?' data-rule-max="'.$element['max'].'"':'').''.((isset($element['required'])&&$element['required']==true && !$this->is_search)?' required':'').' value="'.(set_value($id, $element['value'])).'"'.(!$this->is_search && !empty($pattern)?' pattern="'.$pattern.'"':'').' />';
                break;
        }
        if($element['type']!='daterange'){
            $ret.='
            <label for="input-'.$id.'">'. ucwords(isset($element['label'])?$element['label']:'').''.((isset($element['required'])&&$element['required']==true && !$this->is_search)?' <span class="danger">*</span>':'').'</label>
            ';
        }
        if(isset($element['help']) && !empty($element['help'])){
            $ret.='
            <p class="help-block">'.$element['help'].'</p>
            ';
        }
        $ret.='
            </div>';
        
        return $ret;
    }
}


/* End of file my_form.php */
/* Location: ./system/application/libraries/my_form.php */