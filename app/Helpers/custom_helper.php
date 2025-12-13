<?php 
use CodeIgniter\Config\Services;


if(!function_exists('encode_id')){
    function encode_id($id){
           return rtrim(strtr(base64_encode($id),'+/','-_'),'=');
    }

}
if(!function_exists('decode_id')){
    function decode_id($id){
           return base64_decode(strtr($id,'-_','+/'));
    }

}