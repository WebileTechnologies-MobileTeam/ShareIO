<?php
require_once(dirname(__FILE__).'/dzs_functions.php');

class DZSzvp_Builder{
    public $frontend_errors = array();
    public $db_skins = array();
    public $db_skin_data = array();
    public $currSkin = 'custom';
    function __construct(){
        
        
        if(isset($_GET['skin'])==false || $_GET['skin']==''){
            $this->currSkin = 'custom';
        }else{
            $this->currSkin = $_GET['skin'];
        }
        
        
        $db_skins_aux = file_get_contents('db/db_skins.txt');
        
        if($db_skins_aux == ''){
            $this->db_skins = array();
        }else{
            $this->db_skins = unserialize($db_skins_aux);
        }
        
        $db_skin_data_aux = '';
        if(file_exists('db/skin-'.$this->currSkin.'.txt')){
            $db_skin_data_aux = file_get_contents('db/skin-'.$this->currSkin.'.txt');
        }
        
        
        if($db_skin_data_aux == ''){
            $this->db_skin_data = array();
        }else{
            $this->db_skin_data = unserialize($db_skin_data_aux);
        }
        
//        print_r($this->db_skin_data);
        
        
        if(isset($_POST['builder_skin_name']) && $_POST['builder_skin_name']!=''){
            $this->post_receive_new_skin();
        }
        
        if(isset($_POST['action']) && $_POST['action']=='dzszvp_saveskin'){
            $this->post_save_skin();
        }
    }
    
    
    function post_save_skin(){
        
        if(is_dir(dirname(__FILE__).'/db') == false){
            mkdir(dirname(__FILE__).'/db', 0755, true);
        }
        
        $this->currSkin = $_POST['currSkin'];
        
        $file = (dirname(__FILE__)).'/db/skin-'.$this->currSkin.'.txt';
        
        
        parse_str($_POST['postdata'], $auxarray);
        
//        print_r($auxarray);
        
        
        
        $mainarray_s = serialize($auxarray);
        $fp = file_put_contents($file, $mainarray_s);
//        echo $file.' '.$mainarray_s;
        
        if($fp){
            echo 'success - file saved';
        }else{
            echo 'error - file not saved';
            if (is_writable($file)===false) {
                echo ' file not writable';
            }
        }
        
        
        
        $filejs = (dirname(__FILE__)).'/db/skins.js';
        
        $aux = $_POST['canvasstring'];
        $aux = str_replace(array("\r","\r\n","\n"),'',$aux);
        $aux = str_replace(array("'", 'ui-draggable-handle', 'ui-draggable','builder-align-top-right','builder-align-top-left','builder-align-bottom-right','builder-align-bottom-left'),'',$aux);
        
        $str_var = "'skin-".$this->currSkin."':'".$aux."'";
        $str_filejs = '';
        
        if(file_exists($filejs)){
            
            $auxfile = file_get_contents($filejs);
            if(strpos($auxfile, "'skin-".$this->currSkin."':")!==false){
                $pat = "/'skin-".$this->currSkin."':'.*?'/";
                $str_filejs = preg_replace($pat,$str_var,$auxfile);
            }else{
                $str_filejs = str_replace(array("};/*end*/"),','.$str_var."};/*end*/",$auxfile);
                
                
            }
            
            
        }else{
            $str_filejs = 'window.dzszvp_custom_skins = {'.$str_var.'};/*end*/';
        }
        
        
        $filejs_write_confirmer = file_put_contents($filejs, $str_filejs);
        
        
        
        
        $filecss = (dirname(__FILE__)).'/db/skins.css';
        
        $aux = $_POST['canvasstylestring'];
//        $aux = str_replace(array("\r","\r\n","\n"),'',$aux);
        $aux = str_replace(array('.dzszvp-builder-con--canvas-area'),'.zoomvideoplayer.skin-'.$this->currSkin.'.dzszvp-inited',$aux);
        
        $str_var = '/* skin-'.$this->currSkin.' BEGIN */'.$aux.'/* skin-'.$this->currSkin.' END */';
//        $str_var = "'skin-".$this->currSkin."':'".$aux."'";
        $str_filecss = '';
        
        if(file_exists($filecss)){
            
            $auxfile = file_get_contents($filecss);
            if(strpos($auxfile, "skin-".$this->currSkin." BEGIN")!==false){
                $pat = "/\/\* skin-".$this->currSkin." BEGIN \*\/.*?\/\* skin-".$this->currSkin." END \*\//";
                $str_filecss = preg_replace($pat,$str_var,$auxfile);
            }else{
                if(strpos($auxfile, "*endfilecss*")!==false){
                    $str_filecss = str_replace(array("/*endfilecss*/"),' '.$str_var."/*endfilecss*/",$auxfile);
                }else{
                    $str_filecss = ''.$str_var.'/*endfilecss*/';
                }
                
                
                
            }
            
            
        }else{
            $str_filecss = ''.$str_var.'/*endfilecss*/';
        }
        
        
        $filecss_write_confirmer = file_put_contents($filecss, $str_filecss);
        
        
        die();
    }
    function post_receive_new_skin(){
        
        
        //custom is the default custom skin
        if ($_POST['builder_skin_name']=='custom' || in_array($_POST['builder_skin_name'], $this->db_skins)) {
            array_push($this->frontend_errors, '<div class="error">skin already exists</div>');
            return;
        }
        
//        print_r($this->db_skins);
        
        array_push($this->db_skins, $_POST['builder_skin_name']);
        $file = (dirname(__FILE__)).'/db/db_skins.txt';
        
        $current = serialize($this->db_skins);
        
        $fp = null;
        if(file_exists($file)){
            
            $fp = file_put_contents($file, $current);
        }else{
            if(is_dir(dirname(__FILE__).'/db') == false){
                mkdir(dirname(__FILE__).'/db', 0755, true);
            }
            $fp = fopen($file,"wb");
            fwrite($fp,$current);
            fclose($fp);
        }
        
        
        if($fp){
            
        }else{
            
            array_push($this->frontend_errors, '<div class="error">file not saved</div>');
        }
//        die();
    }
    
    
    
    function generate_layer_item($pargs = array()) {

        $margs = array(
            'position_type' => 'absolute',
            'index' => '0',
            'width' => 'auto',
            'height' => 'auto',
            'top' => '0',
            'right' => 'auto',
            'bottom' => 'auto',
            'left' => '0',
            'margin_top' => '0',
            'margin_right' => '0',
            'margin_bottom' => '0',
            'margin_left' => '0',
            'href' => '',
            'border' => '0',
            'background_color' => '#ffffff',
            'hover_color' => '',
            'class' => 'rect',
            'nodename' => 'SPAN',
            'type' => 'rect',
            'animation_brake' => '',
            'font_size' => '12',
            'text_align' => 'left',
            'color' => '#ffffff',
//            'opacity' => '1',
            'text' => '',
            'font_size' => '12',
            'builder_align' => 'builder-align-top-left',
            
            'extra_classes' => '',
        );

        $margs = array_merge($margs, $pargs);

        $struct_item = '';


        $struct_item = '<div class="builder-layer"><div class="builder-layer--head">'
                . '<input type="hidden" name="bars['.$margs['index'].'][class]" value="'.$margs['class'].'"/>'
                . '<input type="hidden" name="bars['.$margs['index'].'][nodename]" value="'.$margs['nodename'].'"/>'
                . '<input type="hidden" name="bars['.$margs['index'].'][href]" value="'.$margs['href'].'"/>'
                . '<textarea class="hidden" name="bars['.$margs['index'].'][innerhtml]" >'.$margs['innerhtml'].'</textarea>'
                . '<span class="the-title">'.$margs['class'].'</span><span class="sortable-handle-con"><span class="sortable-handle"></span></span>'
                . '</div>';
        
        $struct_item.='<div class="builder-layer--inside">';

        $struct_item.= '<div class="dzs-tabs skin-box">';
            
            if($margs['type']=='text'){
                $struct_item.='<div class="setting type-text">
<textarea class="builder-field with-tinymce" name="bars['.$margs['index'].'][text]">'.$margs['text'].'</textarea>
</div>';
            }
        $struct_item.='<div class="dzs-tab-tobe">
            <div class="tab-menu with-tooltip">
            Position
            </div>
            <div class="tab-content">
            <div class="setting">
            <div class="setting-label">Type</div>';
            $lab = 'position_type';
            $struct_item.=DZSHelpers::generate_select('bars['.$margs['index'].']['.$lab.']', array('options' => array('absolute','relative'), 'class' => 'styleme builder-field', 'seekval' => $margs[$lab]));
            
            $struct_item.='</div>
            <div class="one-half">
            <div class="setting">
            <div class="setting-label">Width</div>
            <input class="builder-field" type="text" name="bars[' . $margs['index'] . '][width]" value="'.$margs['width'].'">
                </div>
                </div>
            <div class="one-half">
            <div class="setting">
            <div class="setting-label">Height</div>
            <input class="builder-field" type="text" name="bars[' . $margs['index'] . '][height]" value="'.$margs['height'].'">
                </div>
                </div>
    <div class="clear"></div>


            <hr>
            <div class="layer-section">
            <input class="builder-field" type="hidden" name="bars[' . $margs['index'] . '][builder_align]" value="'.$margs['builder_align'].'">
            ';
            
            $struct_item.='<div class="builder-align-selector ';
            
            if($margs['builder_align']=='builder-align-top-left'){
                $struct_item.=' active';
            }
            
            
            $struct_item.='" data-val="builder-align-top-left" style="position:absolute; top:25px; left:25px; ">
            <div class="builder-align-selector--icon">
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 width="27.875px" height="27.846px" viewBox="10.18 54.904 27.875 27.846" enable-background="new 10.18 54.904 27.875 27.846"
	 xml:space="preserve">
<g id="Layer_2">
	<rect x="10.18" y="54.904" opacity="0.5" enable-background="new    " width="3" height="27.846"/>
	<rect x="13.18" y="54.904" opacity="0.5" enable-background="new    " width="24.875" height="3"/>
	<rect x="10.18" y="54.904" opacity="0.5" enable-background="new    " width="3" height="12"/>
	<rect x="13.18" y="54.904" opacity="0.5" enable-background="new    " width="8" height="3"/>
</g>
<g id="Layer_3">
</g>
<circle opacity="0.5" fill="#150B00" cx="27.267" cy="71.846" r="6.788"/>
</svg>

</div>
            </div>';
            
            $struct_item.='<div class="builder-align-selector ';
            
            if($margs['builder_align']=='builder-align-top-right'){
                $struct_item.=' active';
            }
            
            
            $struct_item.='" data-val="builder-align-top-right" style="position:absolute; top:25px; right:25px; ">
            <div class="builder-align-selector--icon">
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 width="27.875px" height="27.846px" viewBox="10.18 54.904 27.875 27.846" enable-background="new 10.18 54.904 27.875 27.846"
	 xml:space="preserve">
<g id="Layer_2">
	<rect x="10.194" y="54.89" opacity="0.5" enable-background="new    " width="27.847" height="3"/>
	<rect x="35.041" y="57.89" opacity="0.5" enable-background="new    " width="3" height="24.875"/>
	<rect x="26.041" y="54.89" opacity="0.5" enable-background="new    " width="12" height="3"/>
	<rect x="35.041" y="57.89" opacity="0.5" enable-background="new    " width="3" height="8"/>
</g>
<g id="Layer_3">
</g>
<circle opacity="0.5" fill="#150B00" cx="21.099" cy="71.976" r="6.788"/>
</svg>

</div>
            </div>';
            
            $struct_item.='<div class="builder-align-selector ';
            
            if($margs['builder_align']=='builder-align-bottom-right'){
                $struct_item.=' active';
            }
            
            
            $struct_item.='" data-val="builder-align-bottom-right" style="position:absolute; bottom:5px; right:25px; ">
            <div class="builder-align-selector--icon">
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 width="27.875px" height="27.846px" viewBox="10.18 54.904 27.875 27.846" enable-background="new 10.18 54.904 27.875 27.846"
	 xml:space="preserve">
<g id="Layer_2">
	<rect x="35.054" y="54.904" opacity="0.5" enable-background="new    " width="3" height="27.847"/>
	<rect x="10.179" y="79.75" opacity="0.5" enable-background="new    " width="24.875" height="3"/>
	<rect x="35.054" y="70.75" opacity="0.5" enable-background="new    " width="3" height="12"/>
	<rect x="27.054" y="79.75" opacity="0.5" enable-background="new    " width="8" height="3"/>
</g>
<g id="Layer_3">
</g>
<circle opacity="0.5" fill="#150B00" cx="20.968" cy="65.808" r="6.788"/>
</svg>

</div>
            </div>';
            
            $struct_item.='<div class="builder-align-selector ';
            
            if($margs['builder_align']=='builder-align-bottom-left'){
                $struct_item.=' active';
            }
            
            
            $struct_item.='" data-val="builder-align-bottom-left" style="position:absolute; bottom:5px; left:25px; ">
            <div class="builder-align-selector--icon">
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 width="27.875px" height="27.846px" viewBox="10.18 54.904 27.875 27.846" enable-background="new 10.18 54.904 27.875 27.846"
	 xml:space="preserve">
<g id="Layer_2">
	<rect x="10.194" y="79.767" opacity="0.5" enable-background="new    " width="27.847" height="3"/>
	<rect x="10.194" y="54.892" opacity="0.5" enable-background="new    " width="3" height="24.875"/>
	<rect x="10.194" y="79.767" opacity="0.5" enable-background="new    " width="12" height="3"/>
	<rect x="10.194" y="71.767" opacity="0.5" enable-background="new    " width="3" height="8"/>
</g>
<g id="Layer_3">
</g>
<circle opacity="0.5" fill="#150B00" cx="27.137" cy="65.68" r="6.788"/>
</svg>


</div>
            </div>';
            
            
            $struct_item.='<div class="one-half" style="float:none; margin: 0 auto;">
            <div class="setting">
            <div class="setting-label">Top</div>
            <input class="builder-field" type="text" name="bars[' . $margs['index'] . '][top]" value="'.$margs['top'].'">
                </div>
                </div>
    <div class="clear"></div>

            <div class="one-half">
            <div class="setting">
            <div class="setting-label">Left</div>
            <input class="builder-field" type="text" name="bars[' . $margs['index'] . '][left]" value="'.$margs['left'].'">
                </div>
                </div>
            <div class="one-half">
            <div class="setting">
            <div class="setting-label">Right</div>
            <input class="builder-field" type="text" name="bars[' . $margs['index'] . '][right]" value="'.$margs['right'].'">
                </div>
                </div>
    <div class="clear"></div>

            <div class="one-half" style="float:none; margin: 0 auto;">
            <div class="setting">
            <div class="setting-label">Bottom</div>
            <input class="builder-field" type="text" name="bars[' . $margs['index'] . '][bottom]" value="'.$margs['bottom'].'">
                </div>
                </div>
    <div class="clear"></div>
</div>
            <hr>
            <div class="one-half" style="float:none; margin: 0 auto;">
            <div class="setting">
            <div class="setting-label">Margin Top</div>
            <input class="builder-field" type="text" name="bars[' . $margs['index'] . '][margin_top]" value="'.$margs['margin_top'].'">
                </div>
                </div>
    <div class="clear"></div>
            <div class="one-half">
            <div class="setting">
            <div class="setting-label">Margin Left</div>
            <input class="builder-field" type="text" name="bars[' . $margs['index'] . '][margin_left]" value="'.$margs['margin_left'].'">
                </div>
                </div>
            <div class="one-half">
            <div class="setting">
            <div class="setting-label">Margin Right</div>
            <input class="builder-field" type="text" name="bars[' . $margs['index'] . '][margin_right]" value="'.$margs['margin_right'].'">
                </div>
                </div>
    <div class="clear"></div>

            <div class="one-half" style="float:none; margin: 0 auto;">
            <div class="setting">
            <div class="setting-label">Margin Bottom</div>
            <input class="builder-field" type="text" name="bars[' . $margs['index'] . '][margin_bottom]" value="'.$margs['margin_bottom'].'">
                </div>
                </div>
    <div class="clear"></div>
            <hr>
            <div class="setting">
            <div class="setting-label">Width is equal to remaining space</div>';
            
            $lab = 'design_set_width_to_fit';
            $struct_item.=DZSHelpers::generate_select('bars['.$margs['index'].']['.$lab.']', array('options' => array('off','on'), 'class' => 'styleme builder-field', 'seekval' => $margs[$lab]));
                $struct_item.='
                    </div>
            <div class="setting">
            <div class="setting-label">Automatically calculate right position</div>';
            
            $lab = 'absolute_right_calculate';
            $struct_item.=DZSHelpers::generate_select('bars['.$margs['index'].']['.$lab.']', array('options' => array('off','on'), 'class' => 'styleme builder-field', 'seekval' => $margs[$lab]));
                $struct_item.='
                    </div>
                    

            </div>


        </div>

            <div class="dzs-tab-tobe">
                <div class="tab-menu with-tooltip">
                Styling
                </div>
                <div class="tab-content tab-content-styling">
                <div class="setting ">
            <div class="setting-label">Main Color</div>
            <input class="builder-field with-colorpicker" type="text" name="bars[' . $margs['index'] . '][background_color]" value="'.$margs['background_color'].'"><span class="picker-con picker-left"><span class="the-icon"></span><span class="picker"></span></span>
                </div>
                <div class="setting ">
            <div class="setting-label">Hover Color</div>
            <input class="builder-field with-colorpicker" type="text" name="bars[' . $margs['index'] . '][hover_color]" value="'.$margs['hover_color'].'"><span class="picker-con picker-left"><span class="the-icon"></span><span class="picker"></span></span>
                </div>
                
                <div class="setting">
            <div class="setting-label">Font Size</div>
            <input class="builder-field" type="text" name="bars[' . $margs['index'] . '][font_size]" value="'.$margs['font_size'].'">
                <div class="jqueryui-slider for-fontsize"></div>
                </div>
                <div class="setting ">
                    <div class="setting-label">Extra Classes</div>
                    <input class="builder-field" type="text" name="bars[' . $margs['index'] . '][extra_classes]" value="'.$margs['extra_classes'].'">
                </div>
                ';
                
                
//            
//                <div class="setting">
//            <div class="setting-label">Border</div>
//            <input class="builder-field" type="text" name="bars[' . $margs['index'] . '][border]" value="'.$margs['border'].'">
//                </div>
//                <div class="setting">
//                <div class="setting-label">Opacity</div>
//            <input class="builder-field" type="text" name="bars[' . $margs['index'] . '][opacity]" value="'.$margs['opacity'].'">
//                </div>
//                <div class="setting type-rect">
//            <div class="setting-label">Border Radius</div>
//            <input class="builder-field" type="text" name="bars[' . $margs['index'] . '][border_radius]" value="'.$margs['border_radius'].'">
//                </div>
//                <!--
//            <div class="setting type-text">
//            <div class="setting-label">Text Align</div>
                
                
//            $lab = 'text_align';
//            $struct_item.=DZSHelpers::generate_select('bars['.$margs['index'].']['.$lab.']', array('options' => array('left','center','right'), 'class' => 'styleme builder-field', 'seekval' => $margs[$lab]));
            
                //</div>
//-->
                
            $struct_item.='
                <br>
                </div>
            </div>
            

        </div>';
        
        $struct_item.='<a href="#" class="builder-layer--btn-delete">Delete Item</a>';
        $struct_item.='</div>';
        $struct_item.='</div>';
        return $struct_item;
    }
    
    
}

if(!function_exists('__')){
    function __($arg1, $arg2=''){
        return $arg1;
    }
}