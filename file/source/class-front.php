<?php
require_once(dirname(__FILE__).'/dzs_functions.php');

class DZSzvp_frontend{
    public $frontend_errors = array();
    public $db_skins = array();
    public $db_skin_data = array();
    public $currSkin = 'custom';
    function __construct(){

    }

    public function read_rss($arg, $str_opts){
        $fout = '';
        $entries = simplexml_load_file($arg);
        $namespaces = $entries->getNamespaces(true);
//        print_r($entries);
//        $data = $entries->xpath ('channel/item');

        $in = 0;
        $fout.='<div class="zoomvideogallery auto-init"';

        if($str_opts){
            $fout.=' data-options='."'".$str_opts."'".'';
        }


        $fout.='>';
        $fout.='<div class="feed-items">';
        foreach ($entries->channel->item as $item) {
//    echo $item['url'].'<br>';
//            print_r($item);
//            print_r((string)$item->title);
            $in++;
            $str_type = 'video';

            $str_source = '';
            $str_thumb_url = '';



            $media_group = $item->children($namespaces['media'])->group;
//            $media_content = $item->children($namespaces['media'])->content;

            if(isset($media_group->children($namespaces['media'])->content)){
                $str_source= trim((string)($media_group->children($namespaces['media'])->content->attributes()->url));
            }


//            print_r($media_group->children('media',true)->content->attributes()->url);

            // id="rssplayer'.$in.'"
            $fout.='<div class="zoomvideoplayer " data-source="'.$str_source.'"';


            $fout.='>';


            if(isset($media_group->children($namespaces['media'])->thumbnail)){
                $fout.= '<div class="menu-feed-thumbnail">'.trim((string)($media_group->children($namespaces['media'])->thumbnail->attributes()->url)).'</div>';
            }

            if(isset($item->title)){
                $fout.='<div class="menu-feed-title">'.(string)$item->title.'</div>';
            }

            if(isset($item->description)){
                $fout.='<div class="menu-feed-description">'.(string)$item->description.'</div>';
            }


            $fout.='</div>';


//            foreach($item->attributes() as $lab=>$val){
//                $valo = $val[0];
//                echo $lab.' -> '.$valo;
////                print_r($val);
//            }
        }
        $fout.='</div>';
        $fout.='</div>';
        return $fout;
    }


}

if(!function_exists('__')){
    function __($arg1, $arg2=''){
        return $arg1;
    }
}