<?php
/*
Plugin Name: Valhalla CF 
Plugin URI: https://github.com/pierreamgabriel/valhalla-cf
Description: A responsive contact form with Google Maps and CAPTCHA. It's simple but effective, and you can customize labels and messages in the WordPress Customizer.
Version: 1.0
Author: Pierre Gabriel
License: GPL

=====================================================================================
Copyright (C) 2020 Pierre Gabriel

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
=====================================================================================
*/

// Enqueue scripts

function valhalla_cf_scripts() {
    $plugin_url = plugin_dir_url( __FILE__ );
    wp_enqueue_style( 'style',  $plugin_url . "css/style.css" );
	wp_enqueue_style( 'bootstrap',  $plugin_url . "css/bootstrap.css" );
	wp_enqueue_script('bootstrap-js', $plugin_url . "js/bootstrap.js", array('jquery'), '4.5.3', true);
}
add_action( 'wp_enqueue_scripts', 'valhalla_cf_scripts' );

function valhalla_cf_send_mail() {

// Response messages

$captcha_error   = esc_html__( get_theme_mod( 'valhalla_cf_captcha_message', 'The answer you entered for the CAPTCHA was not correct.' ) );   
$missing_content = esc_html__( get_theme_mod( 'valhalla_cf_information_message', 'Please supply all information.' ) );
$message_unsent  = esc_html__( get_theme_mod( 'valhalla_cf_message_error', 'Message was not sent. Try Again.' ) );
$message_sent    = esc_html__( get_theme_mod( 'valhalla_cf_success_message', 'Thanks! Your message has been sent.' ) );

$captcha_solution = sanitize_text_field( $_POST[ "solution" ] );
$captcha_user = sanitize_text_field( $_POST[ "message_capctha" ] );   

// If the submit button is pressed, start the functions

if ( isset( $_POST[ 'submitted' ] ) ) {

// Sanitize form values

$name    = sanitize_text_field( $_POST[ "message_name" ] );
$email   = sanitize_email( $_POST[ "message_email" ] );
$phone   = sanitize_text_field( $_POST[ "message_phone" ] );
$subject_2 = sanitize_text_field( $_POST[ "message_subject" ] );
$message = sanitize_textarea_field( $_POST[ "message_text" ] );

if( empty( $name ) || empty( $message ) || empty( $email ) ) {
echo '<div class="container valhalla_cf_error" style="color:';
echo esc_attr( get_theme_mod( 'valhalla_cf_error_color', 'red') );
echo '">';
echo $missing_content;
echo '</div>';
} else {
if( $_POST[ 'solution' ] != $_POST[ 'message_capctha' ] ) {
echo '<div class="container valhalla_cf_error" style="color:';
echo esc_attr( get_theme_mod( 'valhalla_cf_error_color', 'red') );
echo '">';
echo $captcha_error;
echo '</div>';
}
else {

// Get the email ready to be sent

$to = get_option( 'admin_email' );
$subject = $subject_2;
$headers[] = 'Reply-To: ' . $email . "\r\n";
$body = "\n\nName: $name \n\nEmail: $email \n\nPhone: $phone \n\nSubject: $subject_2 \n\nMessage: $message";

// If the email has been processed for sending, display a success message

if ( wp_mail( $to, $subject, $body, $headers ) ) {
echo '<div class="container valhalla_cf_success" style="color:';
echo esc_attr( get_theme_mod( "valhalla_cf_success_color", "green") );
echo '">';
echo $message_sent;
echo '</div>';
} else {
echo '<div class="container valhalla_cf_error" style="color:';
echo esc_attr( get_theme_mod( 'valhalla_cf_error_color', 'red') );
echo '">';
echo $message_unsent;
echo '</div>';
}
}
}
}
}

// Contact form code

function valhalla_cf_html_code() {
?>
<?php
$captcha_number1 = rand(1, 9);
$captcha_number2 = rand(1, 9);
$captcha_numbers = $captcha_number1 + $captcha_number2;
?>
<div class="container valhalla_cf_form">
<div class="row">
	
<?php if( get_theme_mod('valhalla_cf_map_display', true) == true ) : ?>	
<div class="col-md valhalla_cf_map mb-3">
<div class="mapouter">
<div class="gmap_canvas">
<iframe width="100%" height="100%" id="gmap_canvas" src="https://maps.google.com/maps?q=<?php echo esc_attr( get_theme_mod( 'valhalla_cf_map_address', '1600+Amphitheatre+Parkway+Mountain+View+CA' ) ); ?>&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
</div>
</div>
</div>
<?php endif; ?>

<div class="col-md">
<form action="<?php esc_url( $_SERVER[ 'REQUEST_URI' ] ) ?>" method="post">
	
<div class="form-row form-group">
<div class="col">
<label class="valhalla_cf_label" style="color: <?php echo esc_attr( get_theme_mod( 'valhalla_cf_labels_color', '#000') ); ?>">
<?php echo esc_html__( get_theme_mod( 'valhalla_cf_name_label', 'Name' ) ); ?>*</label>
<input type="text" class="form-control" name="message_name" value="<?php echo isset( $_POST[ "message_name" ] ) ? esc_attr( $_POST[ "message_name" ] ) : ''; ?>">
</div>
<div class="col">
<label class="valhalla_cf_label form-label" style="color: <?php echo esc_attr( get_theme_mod( 'valhalla_cf_labels_color', '#000') ); ?>">
<?php echo esc_html__( get_theme_mod( 'valhalla_cf_email_label', 'Email' ) ); ?>*</label>
<input type="email" class="form-control" name="message_email" value="<?php echo isset( $_POST[ "message_email" ] ) ? esc_attr( $_POST[ "message_email" ] ) : ''; ?>">
</div>
</div>

<div class="form-row form-group">
<div class="col">
<label class="valhalla_cf_label" style="color: <?php echo esc_attr( get_theme_mod( 'valhalla_cf_labels_color', '#000') ); ?>">
<?php echo esc_html__( get_theme_mod( 'valhalla_cf_phone_label', 'Phone' ) ); ?></label>
<input type="tel" class="form-control" name="message_phone" value="<?php echo isset( $_POST[ "message_phone" ] ) ? esc_attr( $_POST[ "message_phone" ] ) : ''; ?>">
</div>
<div class="col">
<label class="valhalla_cf_label form-label" style="color: <?php echo esc_attr( get_theme_mod( 'valhalla_cf_labels_color', '#000') ); ?>">
<?php echo esc_html__( get_theme_mod( 'valhalla_cf_subject_label', 'Subject' ) ); ?></label>
<input type="text" class="form-control" name="message_subject" value="<?php echo isset( $_POST[ "message_subject" ] ) ? esc_attr( $_POST[ "message_subject" ] ) : ''; ?>">
</div>
</div>

<div class="form-row form-group">
<div class="col">
<label class="valhalla_cf_label" style="color: <?php echo esc_attr( get_theme_mod( 'valhalla_cf_labels_color', '#000') ); ?>">
<?php echo esc_html__( get_theme_mod( 'valhalla_cf_message_label', 'Message' ) ); ?>*</label>
<textarea class="form-control" rows="10" name="message_text"><?php echo isset( $_POST[ "message_text" ] ) ? esc_attr( $_POST[ "message_text" ] ) : ''; ?></textarea>
</div>
</div>

<div class="form-row form-group">
<div class="col">
<label class="valhalla_cf_label" style="color: <?php echo esc_attr( get_theme_mod( 'valhalla_cf_labels_color', '#000') ); ?>">
<?php echo esc_html__( get_theme_mod( 'valhalla_cf_captcha_label', 'I\'m not a robot' ) ); echo esc_html(':*&nbsp;&nbsp;'); echo esc_html($captcha_number1); echo esc_html('&nbsp;+&nbsp;'); echo esc_html($captcha_number2); echo esc_html('&nbsp;='); ?></label>
<input type="text" class="form-control valhalla_cf_captcha_field" name="message_capctha">
<input type="hidden" name="solution" value="<?php echo $captcha_numbers; ?>">
</div>
</div>

<div class="form-row form-group">
<div class="col">
<input type="hidden" name="submitted" value="1">
<button type="submit" class="btn <?php echo esc_attr( get_theme_mod( 'valhalla_cf_submit_style', 'btn-secondary' ) ); ?> valhalla_cf_submit_button mb-2">
<?php echo esc_html__( get_theme_mod( 'valhalla_cf_submit_label', 'Submit Message') ); ?></button>
</div>
</div>

</form>
</div>
	
</div>
</div>
<?php
}

// Customizer function

function valhalla_cf_customize_register( $wp_customize ) {

// Customizer panel

$wp_customize->add_panel('valhalla_cf_panel',array(
    'title'=>'Valhalla CF',
));	

// Customizer sections

$wp_customize->add_section( 'valhalla_cf_map' , array(
	'title'             => 'Google Maps',
	'panel'=>'valhalla_cf_panel'
) );

$wp_customize->add_section( 'valhalla_cf_labels' , array(
	'title'             => 'Labels and messages',
	'panel'=>'valhalla_cf_panel'
) );
	
$wp_customize->add_section( 'valhalla_cf_colors' , array(
	'title'             => 'Colors',
	'panel'=>'valhalla_cf_panel'
) );	
		
// Customizer settings

$wp_customize->add_setting( 'valhalla_cf_map_display' , array(
	'default'       => true,
	'type'          => 'theme_mod',
	'transport'     => 'refresh',
) );
$wp_customize->add_control( 'valhalla_cf_map_display_control', array(
	'label'      => 'Display Google Maps',
	'section'    => 'valhalla_cf_map',
	'settings'   => 'valhalla_cf_map_display',
	'type'       => 'checkbox',
) );
	
$wp_customize->add_setting( 'valhalla_cf_map_address' , array(
	'default'       => '1600+Amphitheatre+Parkway+Mountain+View+CA',
	'type'          => 'theme_mod',
	'transport'     => 'refresh',
) );
$wp_customize->add_control( 'valhalla_cf_map_address_control', array(
	'label'      => 'Google Maps address',
	'description'=> 'Type a location or an address without space and with a + sign between the words. For example, 1600+Amphitheatre+Parkway+Mountain+View+CA.',
	'section'    => 'valhalla_cf_map',
	'settings'   => 'valhalla_cf_map_address',
	'type'       => 'text',
) );
		
$wp_customize->add_setting( 'valhalla_cf_name_label' , array(
	'default'       => 'Name',
	'type'          => 'theme_mod',
	'transport'     => 'refresh',
) );
$wp_customize->add_control( 'valhalla_cf_name_label_control', array(
	'label'      => 'Name field label',
	'section'    => 'valhalla_cf_labels',
	'settings'   => 'valhalla_cf_name_label',
	'type'       => 'text',
) );
		
$wp_customize->add_setting( 'valhalla_cf_email_label' , array(
	'default'       => 'Email',
	'type'          => 'theme_mod',
	'transport'     => 'refresh',
) );
$wp_customize->add_control( 'valhalla_cf_email_label_control', array(
	'label'      => 'Email field label',
	'section'    => 'valhalla_cf_labels',
	'settings'   => 'valhalla_cf_email_label',
	'type'       => 'text',
) );
		
$wp_customize->add_setting( 'valhalla_cf_phone_label' , array(
	'default'       => 'Phone',
	'type'          => 'theme_mod',
	'transport'     => 'refresh',
) );
$wp_customize->add_control( 'valhalla_cf_phone_label_control', array(
	'label'      => 'Phone field label',
	'section'    => 'valhalla_cf_labels',
	'settings'   => 'valhalla_cf_phone_label',
	'type'       => 'text',
) );
		
$wp_customize->add_setting( 'valhalla_cf_subject_label' , array(
	'default'       => 'Subject',
	'type'          => 'theme_mod',
	'transport'     => 'refresh',
) );
$wp_customize->add_control( 'valhalla_cf_subject_label_control', array(
	'label'      => 'Subject field label',
	'section'    => 'valhalla_cf_labels',
	'settings'   => 'valhalla_cf_subject_label',
	'type'       => 'text',
) );
		
$wp_customize->add_setting( 'valhalla_cf_message_label' , array(
	'default'       => 'Message',
	'type'          => 'theme_mod',
	'transport'     => 'refresh',
) );
$wp_customize->add_control( 'valhalla_cf_message_label_control', array(
	'label'      => 'Message field label',
	'section'    => 'valhalla_cf_labels',
	'settings'   => 'valhalla_cf_message_label',
	'type'       => 'text',
) );
		
$wp_customize->add_setting( 'valhalla_cf_captcha_label' , array(
	'default'       => 'I\'m not a robot',
	'type'          => 'theme_mod',
	'transport'     => 'refresh',
) );
$wp_customize->add_control( 'valhalla_cf_captcha_label_control', array(
	'label'      => 'Captcha field label',
	'section'    => 'valhalla_cf_labels',
	'settings'   => 'valhalla_cf_captcha_label',
	'type'       => 'text',
) );

$wp_customize->add_setting( 'valhalla_cf_submit_label' , array(
	'default'       => 'Submit Message',
	'type'          => 'theme_mod',
	'transport'     => 'refresh',
) );
$wp_customize->add_control( 'valhalla_cf_submit_label_control', array(
	'label'      => 'Submit button text',
	'section'    => 'valhalla_cf_labels',
	'settings'   => 'valhalla_cf_submit_label',
	'type'       => 'text',
) );
		
$wp_customize->add_setting( 'valhalla_cf_captcha_message' , array(
	'default'       => 'The answer you entered for the CAPTCHA was not correct.',
	'type'          => 'theme_mod',
	'transport'     => 'refresh',
) );
$wp_customize->add_control( 'valhalla_cf_captcha_message_control', array(
	'label'      => 'CAPTCHA message',
	'section'    => 'valhalla_cf_labels',
	'settings'   => 'valhalla_cf_captcha_message',
	'type'       => 'text',
) );
		
$wp_customize->add_setting( 'valhalla_cf_information_message' , array(
	'default'       => 'Please supply all information.',
	'type'          => 'theme_mod',
	'transport'     => 'refresh',
) );
$wp_customize->add_control( 'valhalla_cf_information_message_control', array(
	'label'      => 'Missing information message',
	'section'    => 'valhalla_cf_labels',
	'settings'   => 'valhalla_cf_information_message',
	'type'       => 'text',
) );
		
$wp_customize->add_setting( 'valhalla_cf_message_error' , array(
	'default'       => 'Message was not sent. Try Again.',
	'type'          => 'theme_mod',
	'transport'     => 'refresh',
) );
$wp_customize->add_control( 'valhalla_cf_message_error_control', array(
	'label'      => 'Message not sent',
	'section'    => 'valhalla_cf_labels',
	'settings'   => 'valhalla_cf_message_error',
	'type'       => 'text',
) );
		
$wp_customize->add_setting( 'valhalla_cf_success_message' , array(
	'default'       => 'Thanks! Your message has been sent.',
	'type'          => 'theme_mod',
	'transport'     => 'refresh',
) );
$wp_customize->add_control( 'valhalla_cf_success_message_control', array(
	'label'      => 'Success message',
	'section'    => 'valhalla_cf_labels',
	'settings'   => 'valhalla_cf_success_message',
	'type'       => 'text',
) );
	
$wp_customize->add_setting( 'valhalla_cf_labels_color' , array(
	'default'       => '000',
	'type'          => 'theme_mod',
	'transport'     => 'refresh',
) );
$wp_customize->add_control( 'valhalla_cf_labels_color_control', array(
	'label'      => 'Labels color',
	'section'    => 'valhalla_cf_colors',
	'settings'   => 'valhalla_cf_labels_color',
	'type'       => 'color',
) );
		
$wp_customize->add_setting( 'valhalla_cf_success_color' , array(
	'type'          => 'theme_mod',
	'transport'     => 'refresh',
) );
$wp_customize->add_control( 'valhalla_cf_success_color_control', array(
	'label'      => 'Success message color',
	'section'    => 'valhalla_cf_colors',
	'settings'   => 'valhalla_cf_success_color',
	'type'       => 'color',
) );
		
$wp_customize->add_setting( 'valhalla_cf_error_color' , array(
	'type'          => 'theme_mod',
	'transport'     => 'refresh',
) );
$wp_customize->add_control( 'valhalla_cf_error_color_control', array(
	'label'      => 'Error message color',
	'section'    => 'valhalla_cf_colors',
	'settings'   => 'valhalla_cf_error_color',
	'type'       => 'color',
) );
		
$wp_customize->add_setting( 'valhalla_cf_submit_style' , array(
	'type'          => 'theme_mod',
	'transport'     => 'refresh',
) );
$wp_customize->add_control( 'valhalla_cf_submit_style_control', array(
	'label'      => 'Submit button style',
	'section'    => 'valhalla_cf_colors',
	'settings'   => 'valhalla_cf_submit_style',
	'type'       => 'select',
        'choices'    => array( 
        'btn-primary' => 'Primary',
		'btn-secondary' => 'Secondary',
		'btn-success' => 'Success',
		'btn-danger' => 'Danger',
		'btn-warning' => 'Warning',
		'btn-info' => 'Info',
		'btn-light' => 'Light',
		'btn-dark' => 'Dark',
        ),
) );	
		
}
add_action( 'customize_register', 'valhalla_cf_customize_register' );

// Shortcode

function valhalla_cf_shortcode() {
ob_start();
valhalla_cf_send_mail();
valhalla_cf_html_code();
return ob_get_clean();
}
add_shortcode( 'valhalla-cf', 'valhalla_cf_shortcode' );