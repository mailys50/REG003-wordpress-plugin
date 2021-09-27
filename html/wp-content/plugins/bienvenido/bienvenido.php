<?php
/**
* Plugin Name: Welcome Top Bar
* Plugin URI: http://
* Description: Esto agregará una barra de bienvenida en la parte superior de su página.
* Version: 1.0
* Author: MAILYS
* Author URI: https://github.com/mailys50/REG003-wordpress-plugin
**/

//TODO:Add bar after the opening body(Agregar barra después del cuerpo de apertura)

add_action('wp_body_open', 'tb_head');

// TODO:get user orwebsitename (obtener usuario o nombre de sitio web)

function get_user_or_websitename()
{
    //is user logged in(El usuario ha iniciado sesión,  get_bloginfo('name')(obtener información del blog ('nombre'))
    if( !is_user_logged_in() )
    {
        return 'to ' . get_bloginfo('name');
    }
    else
    {
        $current_user = wp_get_current_user();
        return $current_user -> user_login;
    }
}

function tb_head()
{
    echo '<h3 class="tb">Welcome ' . get_user_or_websitename() .  '</h3>';
}

//TODO:Add CSS to the top bar(Agrega CSS a la barra superior)'wp_print_styles'
add_action('wp_print_styles', 'tb_css'); 

function tb_css()
{
    echo '
        <style>
        h3.tb {color: #fff; margin: 0; padding: 30px; text-align: center; background: pink}
        </style>
    ';
}

add_action('wp_footer','dcms_add_footer_whatsapp');

function dcms_add_footer_whatsapp(){
	$tel = "+56935558262";
	$ms = urlencode("Para consultas presione aqui");

	$url = "https://wa.me/${tel}?text=${ms}";
	$img = get_stylesheet_directory_uri().'https://i.ibb.co/xF15xPN/whatsapp-logo-11.png
    ';
	echo "<div id='float-whatsapp' style='position:fixed;bottom:40px;right:40px;'>";
	echo " <a href=${url} target='_blank'>";
	echo " <img src='${img}' width=60 height=60 />";
	echo " </a>";
	echo "</div>";
}
?>