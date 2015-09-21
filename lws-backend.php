<?php
/*
Plugin Name: LWS Backend
Plugin URI: https://github.com/LWS-Web/LWS-Backend
Description: Customize the WordPress backend.
Author: Mo
Version: 1.0.3
Author URI: -
License: GPLv2
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/* Table of contents

- Remove dashboard widgets.
- Change the dashboard footer text.
- Custom dashboard styles.
- Add custom CSS to backend.
- Hide admin-menu items.


/*
 * Include the admin options page
 */
if ( is_admin() ) {
	include_once( dirname( __FILE__ ) . '/admin/lwsbe-admin-page.php' );
}


/**
 * Change the link of the login-logo.
 **/
function lws_login_logo_url() {
    return 'http://www.lws-werbung.de/';
}
add_filter( 'login_headerurl', 'lws_login_logo_url' );

/**
 * Change the title of the login-logo link.
 **/
function lws_login_logo_url_title() {
    return 'LWS WERBUNG - Agentur für Werbung, Grafik, Webdesign';
}
add_filter( 'login_headertitle', 'lws_login_logo_url_title' );

/**
 * Remove the login-shake effect.
 **/
function lws_remove_login_shake() {
	remove_action('login_head', 'wp_shake_js', 12);
}
add_action('login_head', 'lws_remove_login_shake');

/**
 * Change the login-form.
 **/
function lws_login_form() { 
	$dir = plugin_dir_url( __FILE__ ); ?>

	<style type="text/css">

		#login {
		    width: 100%;
		    max-width: 350px;
		}

		/* Login heading / logo */
        .login h1 a {
            background-image: url(<?php echo $dir; ?>/img/logo.png);
            background-size: auto;
            -webkit-background-size: auto;
            width: 100%;
        }

        .login form {
        	background: transparent;
		    box-shadow: none;
        }

        .login label { color: #000000; }

		.login input { box-shadow: none; }

        .g-recaptcha { 
        	margin-bottom: 1em;
        }

        p.forgetmenot { line-height: 35px; }

        p.submit #wp-submit {
		    border: 0;
		    text-transform: uppercase;
		    box-shadow: none;
		    height: 35px;
		    font-weight: bold;
		}

        p#nav, p#backtoblog { text-align: center; }

        p#nav a { font-weight: bold; }

	</style>

<?php }
add_action( 'login_enqueue_scripts', 'lws_login_form' );


/**
 * Remove dashboard widgets.
 **/
function lws_remove_dashboard_widgets() {
	global $wp_meta_boxes;

	/* remove incoming links metabox */
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
	/* remove drafts metabox */
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
	/* remove comments metabox */
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
	/* remove WP news */
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
}
add_action('wp_dashboard_setup', 'lws_remove_dashboard_widgets' );


/**
 * Change the dashboard footer text.
 **/
function lws_footer_admin () {
    echo '<span id="footer-thankyou"><a href="http://www.lws-werbung.de/" target="_blank">LWS Werbung</a> powered by <a href="https://wordpress.org/" target="_blank">WordPress</a></span>';
}
add_filter('admin_footer_text', 'lws_footer_admin');


/**
 * Custom dashboard styles.
 **/
function lws_custom_css() {
	$dir = plugin_dir_url( __FILE__ ); ?>

	<?php
	// Get all admin options
    $lwsb_option = get_option( 'lwsb_settings' );

    // Get custom CSS
    $custom_css = $lwsb_option['lwsb_admin_css']; 
    ?>

	<style type="text/css">
		/* Remove adminbar WP logo */
		#wp-admin-bar-wp-logo {display:none;}

		/* Remove adminbar comments link */
		#wp-admin-bar-comments {display:none;}

		<?php // Display custom CSS if there is something
		if (isset($custom_css)) { echo $custom_css; }; ?>

	</style>
<?php }
add_action('admin_head', 'lws_custom_css');


/**
 * Remove menu pages.
 **/
function lws_remove_menus(){

	// Get all admin options
    $lwsb_option = get_option( 'lwsb_settings' );

    // Admin hide?
    $admin_hide = $lwsb_option['admin-hide'];

    $dashboard_hide = $lwsb_option['dashboard'];
    $posts_hide = $lwsb_option['posts'];
    $media_hide = $lwsb_option['media'];
    $pages_hide = $lwsb_option['pages'];
    $comments_hide = $lwsb_option['comments'];
    $appearance_hide = $lwsb_option['appearence'];
    $plugins_hide = $lwsb_option['plugins'];
    $users_hide = $lwsb_option['users'];
    $tools_hide = $lwsb_option['tools'];
    $settings_hide = $lwsb_option['settings'];
    $wpcf7_hide = $lwsb_option['wpcf7'];
    $role_scoper_hide = $lwsb_option['role-scoper'];
    $bwpup_hide = $lwsb_option['bwpup'];
    $wps_hide = $lwsb_option['wps'];
    $aloem_hide = $lwsb_option['aloem'];
    $acf_hide = $lwsb_option['acf'];
    $woocpf_hide = $lwsb_option['woocpf'];
    $wpseo_hide = $lwsb_option['wpseo'];
    $ncrc_hide = $lwsb_option['ncrc'];
    $itsec_hide = $lwsb_option['itsec'];
    $wplis_hide = $lwsb_option['wplis'];
    $sumome_hide = $lwsb_option['sumome'];
    $gadwp_hide = $lwsb_option['gadwp'];
    $ywcwl_hide = $lwsb_option['ywcwl'];

    //Admin hide?

    //Get current user details
    $user = wp_get_current_user();

    //Get all user roles
    if (isset($admin_hide)) { //If is checked
      $allowed_roles = array('administrator', 'editor',  'author', 'contributor', 'subscriber' );
    } else { // If is NOT checked
      $allowed_roles = array('editor', 'author', 'contributor', 'subscriber');
    }

    //START array_intersect
    if( array_intersect($allowed_roles, $user->roles ) ) {

		//Dashboard
  			if (isset($dashboard_hide)) { remove_menu_page( 'index.php' ); }
		//Posts
  		  	if (isset($posts_hide)) { remove_menu_page( 'edit.php' ); }
		//Media
  		  	if (isset($media_hide)) { remove_menu_page( 'upload.php' ); }
		//Pages
  		  	if (isset($pages_hide)) { remove_menu_page( 'edit.php?post_type=page' ); }
  	  	//Comments
  		  	if (isset($comments_hide)) { remove_menu_page( 'edit-comments.php' ); }
  	  	//Appearance
  		  	if (isset($appearance_hide)) { remove_menu_page( 'themes.php' ); }
  	  	//Plugins
  		  	if (isset($plugins_hide)) { remove_menu_page( 'plugins.php' ); }
  	  	//Users
  		  	if (isset($users_hide)) { remove_menu_page( 'users.php' ); }
		//Tools
  		  	if (isset($tools_hide)) { remove_menu_page( 'tools.php' ); }
  	  	//Settings
  		  	if (isset($settings_hide)) { remove_menu_page( 'options-general.php' ); }
        
  	  	//Remove ContactForm7 Plugin Menu
  		  	if (isset($wpcf7_hide)) { remove_menu_page( 'wpcf7' ); }
      	//Remove RoleScoper Plugin Menus
	        if (isset($role_scoper_hide)) { 
	          remove_menu_page( 'rs-options' );
	          remove_menu_page( 'rs-general_roles' );
	          remove_menu_page( 'rs-post-restrictions' );
	        }
      	//Remove BackWPup Plugin Menu
        	if (isset($bwpup_hide)) { remove_menu_page( 'backwpup' ); }
      	//Remove WP Security Plugin Menu
        	if (isset($wps_hide)) { remove_menu_page( 'wps_' ); }

        //Remove ALO EasyMail Newsletter 
        	if (isset($aloem_hide)) { remove_menu_page( 'edit.php?post_type=newsletter' ); }
        //Remove Advanced Custom Fields 
        	if (isset($acf_hide)) { remove_menu_page( 'edit.php?post_type=acf' ); }
        //Remove Cart Product Feed 
        	if (isset($woocpf_hide)) { remove_menu_page( 'cart-product-feed-admin' ); }
        //Remove WordPress SEO
        	if (isset($wpseo_hide)) { remove_menu_page( 'wpseo_dashboard' ); }
        //Remove Stealth Login Page
        	if (isset($ncrc_hide)) { remove_menu_page( 'ncr-config' ); }
        //Remove iThemes Security (formerly Better WP Security)
        	if (isset($itsec_hide)) { remove_menu_page( 'itsec' ); }
        //Remove WP Lister for Ebay
          if (isset($wplis_hide)) { remove_menu_page( 'wplister' ); }
        //Remove SumoMe
          if (isset($sumome_hide)) { remove_menu_page( 'options-general.php?page=sumome' ); }
        //Remove Google Analytics Dashboard for WP
          if (isset($gadwp_hide)) { remove_menu_page( 'gadash_settings' ); }

    }//END array_intersect

}
add_action( 'admin_menu', 'lws_remove_menus', 9999 );