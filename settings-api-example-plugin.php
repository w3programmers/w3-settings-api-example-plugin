<?php 
/* 
Plugin Name: W3 Settings API example Plugin 
Plugin URI: https://github.com/w3programmers/w3-settings-api-example-plugin
Description: A complete and practical example of use of the Settings API 
Author: Masud Alam 
Author URI: http://w3programmers.com 
*/        


//Add a menu for our option page 
add_action('admin_menu','w3_myplugin_add_page'); 

function w3_myplugin_add_page() {
        add_menu_page(
        'My Plugin',
        'My Plugin', 
        'manage_options',
        'w3-myplugin',
        'w3_myplugin_option_page',
        'dashicons-schedule',
        3
    ); 
}        
// Draw the option page 

function w3_myplugin_option_page() { 
?>
<div class="wrap">      
<?php 
//settings_errors(); 
print_r(get_settings_errors());
?>
<h2>My plugin</h2> 
<form action="options.php" method="post">
<?php 
settings_fields('w3_myplugin_options');
do_settings_sections('w3-myplugin');
submit_button();
?>
</form>  
</div>
<?php 
}
// Register and define the settings 
add_action('admin_init', 'w3_myplugin_admin_init'); 
function w3_myplugin_admin_init(){
    register_setting( 'w3_myplugin_options', 'w3_myplugin_options','w3_myplugin_validate_options');
    add_settings_section( 'w3_myplugin_main', 'My Plugin Settings','w3_myplugin_section_text', 'w3-myplugin' );    
    add_settings_field( 'w3_myplugin_country', 'Enter Your Country Name','w3_myplugin_setting_input', 'w3-myplugin', 'w3_myplugin_main' ); 
}

// Draw the section header 
function w3_myplugin_section_text() {
    echo '<p> Enter your settings here. </p>'; 
}

// Display and fill the form field 
function w3_myplugin_setting_input() {   
    // get option 'country' value from the database    
    $options = get_option('w3_myplugin_options' );
    $country = $options['country'];    
    // echo the field    
    echo "<input id='country' name='w3_myplugin_options[country]'  type='text' value='$country' />"; 
}


// Validate user input (we want text only) 
function w3_myplugin_validate_options($input) {
    $valid = array();    
    $valid['country'] = preg_replace('/[^a-zA-Z]/','',$input['country'] );
    if( $valid['country'] != $input['country'] ){
        add_settings_error('w3_myplugin_country','w3_myplugin_texterror','Incorrect value entered!','error');
    }
    return $valid; 
}
?>