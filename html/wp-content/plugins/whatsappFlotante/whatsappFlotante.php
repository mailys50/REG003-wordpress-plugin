<?php
/**
* Plugin Name: floatWatsapp Install
* Plugin URI: http://
* Description: Esto agregará un icono de floatWatsapp flotante con redirección al floatWatsapp del administrador de la pagina shortcode[MBD_plugin_Watsapp].
* Version: 1.0
* Author: MAILYS
* Author URI: https://github.com/mailys50/REG003-wordpress-plugin


**/
register_activation_hook(__FILE__, 'mbd_form_floatWatsapp_init');
/**
 * Crea la tabla para recoger los datos del formulario
 *
 * @return void
 */
function mbd_form_floatWatsapp_init() 
{
    global $wpdb; // Este objeto global permite acceder a la base de datos de WP
    // Crea la tabla sólo si no existe
    // Utiliza el mismo prefijo del resto de tablas
    $tabla_form_floatWatsapps = $wpdb->prefix . 'form_floatWatsapp';
    // Utiliza el mismo tipo de orden de la base de datos
    $charset_collate = $wpdb->get_charset_collate();
    // Prepara la consulta
    $query = "CREATE TABLE IF NOT EXISTS $tabla_form_floatWatsapps (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        telephone varchar(15) NOT NULL,
        messages varchar(400) NOT NULL,
        aceptacion smallint(4) NOT NULL,
        created_at datetime NOT NULL,
        UNIQUE (id)
        ) $charset_collate;";
    // La función dbDelta permite crear tablas de manera segura se
    // define en el archivo upgrade.php que se incluye a continuación
    include_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($query); // Lanza la consulta para crear la tabla de manera segura
}




add_action("admin_menu", "menu_floatWatsapps");
function menu_floatWatsapps() {
    add_menu_page('Menú floatWatsapp', 
    'floatWatsapp',
    'manage_options',
    'menu__floatWatsapp',
    'mbd_floatWatsapp_form',
    'dashicons-whatsapp',70);
}
/** 
 * Define la función que ejecutará el shortcode
 * De momento sólo pinta un formulario que no hace nada
 * 
 * @return void
 */




function mbd_floatWatsapp_form() 
{
    global $wpdb;
    
    if (!empty($_POST)
    AND$_POST['telephone'] != ''
    AND $_POST['messages']!= ''
  ){
        $tabla_form_floatWatsapps = $wpdb->prefix . 'form_floatWatsapp';
        $telephone = sanitize_text_field($_POST['telephone']);
        $messages = sanitize_text_field( $_POST['messages']);
        $aceptacion = (int)$_POST['aceptacion'];
        $created_at = date('Y-m-d H:i:s');
        $update= $wpdb->update(
            $tabla_form_floatWatsapps ,
            array(
                'telephone' => $telephone,
                'messages' => $messages,
                'aceptacion' => $aceptacion,
                'created_at' => $created_at,
            ),
            array( 'id' => 1 ), 
        );
        if (!$update){
            $wpdb->insert(
                $tabla_form_floatWatsapps ,
                array(
                    'telephone' => $telephone,
                    'messages' => $messages,
                    'aceptacion' => $aceptacion,
                    'created_at' => $created_at,
                )
               
            ); 
        }
        echo "<p class='exito'><b>Tus datos han sido registrados</b>. Gracias 
            por tu interés. En breve contactaré contigo   $update.<p>";
    }
    // Esta función de PHP activa el almacenamiento en búfer de salida (output buffer)
    // Cuando termine el formulario lo imprime con la función ob_get_clean
    // ob_start();
    //agregar item al menú del administrador

        
     ?>
        <form action="<?php get_the_permalink(); ?>" method="post" id="form_floatWatsapp" class="cuestionario">
        <?php wp_nonce_field('graba_floatWatsapp','floatWatsapp'); ?>
        <div class="form-input">
            <label for="telephone">Teléfono</label>
            <input type="text" name="telephone" id="telephone" required>
        </div>
        <div class="form-input">
            <label for='messages'>Mensaje</label>
            <input type="text" name="messages" id="message" >
        </div>
        
        <div class="form-input">
            <label for="aceptacion">La información facilitada se tratará 
            con respeto y admiración.</label>
            <input type="checkbox" id="aceptacion" name="aceptacion"
            value="1" required> Entiendo y acepto las condiciones
        </div>
        <div class="form-input">
            <input type="submit" value="Enviar">
        </div>
    </form>
<?php

  
   
     
    // Devuelve el contenido del buffer de salida
    // return ob_get_clean();
}
// Define el shortcode y lo asocia a una función
add_shortcode('MBD_plugin_whatsapp', 'floatWatsapp_form');

function floatWatsapp_form() {
    global $wpdb;
    $tabla_floatWatsapps = $wpdb->prefix . 'form_floatWatsapp';
    $extracData = $wpdb->get_results("SELECT * FROM $tabla_floatWatsapps");
    foreach ($extracData as $data) {
    $telephone = esc_textarea( $data->$telephone);
    $messages =esc_textarea( $data->$messages); 

    $tel =$telephone;
	$ms = urlencode( $messages);
    
	$url = "https://wa.me/${tel}?text=${ms}";
	$img = 'https://i.ibb.co/JRps0V5/floating_floatWatsapp-icon.png';
	
	// //console. log
	echo("<script>console.log('PHP: " . $img . "');</script>");


	echo "<div id='float-floating_floatWatsapp' style='position:fixed;bottom:40px;right:40px;'>";
	echo " <a href=${url} target='_blank'>";
	echo " <img src='${img}' width=60 height=60 />";
	echo " </a>";
	echo "</div>";
    }
}

	   





?>





