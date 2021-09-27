<?php
/**
* Plugin Name: Whatsapp Install
* Plugin URI: http://
* Description: Esto agregará una barra de bienvenida en la parte superior de su página.
* Version: 1.0
* Author: MAILYS
* Author URI: https://github.com/mailys50/REG003-wordpress-plugin
**/

//Usamos el hook wp_footer que hace referencia a la función dcms_add_footer_whatsapp
add_action('wp_footer','dcms_add_footer_whatsapp');
// TODO Dentro de la función podemos cambiar el valor del número telefónico en la variable $tel, que debe constar sólo de números También podemos enviar un mensaje por defecto en la variable $ms
//formamos el HTML con CSS en línea usando todos los valores de las variables anteriores
function dcms_add_footer_whatsapp(){
	$tel = "+56935558262";
	$ms = urlencode("Para consultas presione aqui");
    
	$url = "https://wa.me/${tel}?text=${ms}";
	$img = 'https://i.ibb.co/JRps0V5/whatsapp-icon.png';
	
	//console. log
	 echo("<script>console.log('PHP: " . $img . "');</script>");


	echo "<div id='float-whatsapp' style='position:fixed;bottom:40px;right:40px;'>";
	echo " <a href=${url} target='_blank'>";
	echo " <img src='${img}' width=60 height=60 />";
	echo " </a>";
	echo "</div>";
}
?>
