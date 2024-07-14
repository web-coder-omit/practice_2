<?php 
/**
*Plugin Name:QR-code pratice
*Plugin URI: https://www.webcoderomit.com
*Description:Advances code about QR-code.
*Version: 1.0.0
*Author: Md. Omit Hasan
*Author URI: https://omithasan.com
*License: GPLv2 or Later
*Text Domain: qrcode
*Domain Path:/langurages/
*/
// Languages file loaded
function qrcode_langurages_file(){
    load_plugin_textdomain( 'qrcode',false, dirname(__FILE__)."/Languages");
}
add_action("plugins_loaded","qrcode_langurages_file");

function qrcode_post_content($content){
    $post_link = get_permalink();
    $width = get_option('qrcode_width');
    $height = get_option('qrcode_height');

    $qrcode_size = apply_filters( 'qrcode_dimantions',"{$width}x{$height}" );
    $qrcode_link = sprintf('https://api.qrserver.com/v1/create-qr-code/?size=%s&ecc=L&qzone=1&data=%s',$qrcode_size,$post_link);
    $content .= sprintf("<img src='%s'/>",$qrcode_link);
    return $content;
}
add_filter( 'the_content','qrcode_post_content');


function qrcode_admin_access(){
    add_settings_section("qrcode_height",__("QR code height","qrcode"),"qrcode_height_function",'general');
    add_settings_section("qrcode_width",__("QR code width","qrcode"),"qrcode_width_function",'general');
    register_setting('general','qrcode_height');
    register_setting('general','qrcode_width');
}
function qrcode_height_function(){
    $height = get_option( 'qrcode_height');
    printf("<input type='text' id='%s' name='%s' value='%s' />",'qrcode_height','qrcode_height',$height);
};

function qrcode_width_function(){
    $width = get_option( 'qrcode_width');
    printf("<input type='text' id='%s' name='%s' value='%s' />",'qrcode_width','qrcode_width',$width);
}

add_action("admin_init",'qrcode_admin_access');











?>
