<?php
/*
 * Add page to the WP Settings menu
 */
function lwsb_add_admin_menu() { 

	// Setting the global variable
	global $lwsb_settings_page;

	$lwsb_settings_page = add_options_page( 
		'LWS Backend', // Page title
	 	'LWS Backend', // Menu title
	 	'manage_options', // Capability
	 	'lwsb_backend', // Page slug
	 	'lwsb_backend_options_page' // Callback function
	);
}
add_action( 'admin_menu', 'lwsb_add_admin_menu' );


/*
 * Building options page sections and setting fields
 */
function lwsb_settings_init() { 

	register_setting( 'lwsbPage', 'lwsb_settings' );

	/* 
	 * Add page sections 
	 */

	// Add first section, "Button Settings"
	add_settings_section(
		'lwsb_section_btn', 
		__( 'Backend Settings', 'lwsb-plugin' ), 
		'lwsb_section_btn_callback', 
		'lwsbPage'
	);

	/*
	 * Add page setting fields
	 */

	// Hide menu items
	add_settings_field( 
		'lwsb_hide_menus', 
		__( 'Hide Backend-Menus', 'lwsb-plugin' ), 
		'lwsb_hide_menus_render', 
		'lwsbPage', 
		'lwsb_section_btn' 
	);

	// Admin CSS styles
	add_settings_field( 
		'lwsb_admin_css', 
		__( 'Custom Backend CSS', 'lwsb-plugin' ), 
		'lwsb_admin_css_render', 
		'lwsbPage', 
		'lwsb_section_btn' 
	);

}
add_action( 'admin_init', 'lwsb_settings_init' );


/*
 * HTML templates for the single fields
 */

function lwsb_hide_menus_render(  ) { 
	$options = get_option( 'lwsb_settings' ); ?>

	<input type="checkbox" id="admin-hide" name="lwsb_settings[admin-hide]" <?php checked( $options['admin-hide'], 'admin-hide' ); ?> value="admin-hide" />
	<label for="admin-hide"><em><?php _e('Also hide menus for administrators.', 'lwsb-plugin'); ?></em></label><br />

	<hr>

	<input type="checkbox" id="dashboard" name="lwsb_settings[dashboard]" <?php checked( $options['dashboard'], 'dashboard' ); ?> value="dashboard" />
	<label for="dashboard"><?php _e('Dashboard', 'lwsb-plugin'); ?></label><br />

	<input type="checkbox" id="posts" name="lwsb_settings[posts]" <?php checked( $options['posts'], 'posts' ); ?> value="posts" />
	<label for="posts"><?php _e('Posts', 'lwsb-plugin'); ?></label><br />

	<input type="checkbox" id="media" name="lwsb_settings[media]" <?php checked( $options['media'], 'media' ); ?> value="media" />
	<label for="media"><?php _e('Media', 'lwsb-plugin'); ?></label><br />

	<input type="checkbox" id="pages" name="lwsb_settings[pages]" <?php checked( $options['pages'], 'pages' ); ?> value="pages" />
	<label for="pages"><?php _e('Pages', 'lwsb-plugin'); ?></label><br />

	<input type="checkbox" id="comments" name="lwsb_settings[comments]" <?php checked( $options['comments'], 'comments' ); ?> value="comments" />
	<label for="comments"><?php _e('Comments', 'lwsb-plugin'); ?></label><br />

	<input type="checkbox" id="appearence" name="lwsb_settings[appearence]" <?php checked( $options['appearence'], 'appearence' ); ?> value="appearence" />
	<label for="appearence"><?php _e('Appearance', 'lwsb-plugin'); ?></label><br />

	<input type="checkbox" id="plugins" name="lwsb_settings[plugins]" <?php checked( $options['plugins'], 'plugins' ); ?> value="plugins" />
	<label for="plugins"><?php _e('Plugins', 'lwsb-plugin'); ?></label><br />

	<input type="checkbox" id="users" name="lwsb_settings[users]" <?php checked( $options['users'], 'users' ); ?> value="users" />
	<label for="users"><?php _e('Users', 'lwsb-plugin'); ?></label><br />

	<input type="checkbox" id="tools" name="lwsb_settings[tools]" <?php checked( $options['tools'], 'tools' ); ?> value="tools" />
	<label for="tools"><?php _e('Tools', 'lwsb-plugin'); ?></label><br />

	<input type="checkbox" id="settings" name="lwsb_settings[settings]" <?php checked( $options['settings'], 'settings' ); ?> value="settings" />
	<label for="settings"><?php _e('Settings', 'lwsb-plugin'); ?></label><br />

	<h4><?php _e('Additional Active Plugins', 'lwsb-plugin'); ?></h4>

	<!-- Contact Form 7 -->
	<?php if ( is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) { ?>
		<input type="checkbox" id="wpcf7" name="lwsb_settings[wpcf7]" <?php checked( $options['wpcf7'], 'wpcf7' ); ?> value="wpcf7" />
		<label for="wpcf7"><?php _e('Contact Form 7', 'lwsb-plugin'); ?></label><br />
	<?php }; ?>

	<!-- Role Scoper -->
	<?php if ( is_plugin_active( 'role-scoper/role-scoper.php' ) ) { ?>
		<input type="checkbox" id="role-scoper" name="lwsb_settings[role-scoper]" <?php checked( $options['role-scoper'], 'role-scoper' ); ?> value="role-scoper" />
		<label for="role-scoper"><?php _e('Role Scoper', 'lwsb-plugin'); ?></label><br />
	<?php }; ?>

	<!-- BackWPup -->
	<?php if ( is_plugin_active( 'backwpup/backwpup.php' ) ) { ?>
		<input type="checkbox" id="bwpup" name="lwsb_settings[bwpup]" <?php checked( $options['bwpup'], 'bwpup' ); ?> value="bwpup" />
		<label for="bwpup"><?php _e('BackWPup', 'lwsb-plugin'); ?></label><br />
	<?php }; ?>

	<!-- WP Security -->
	<?php if ( is_plugin_active( 'wp-security-scan/index.php' ) ) { ?>
		<input type="checkbox" id="wps" name="lwsb_settings[wps]" <?php checked( $options['wps'], 'wps' ); ?> value="wps" />
		<label for="wps"><?php _e('WP Security (Acunetix WP Security)', 'lwsb-plugin'); ?></label><br />
	<?php }; ?>

	<!-- ALO EasyMail Newsletter -->
	<?php if ( is_plugin_active( 'alo-easymail/alo-easymail.php' ) ) { ?>
		<input type="checkbox" id="aloem" name="lwsb_settings[aloem]" <?php checked( $options['aloem'], 'aloem' ); ?> value="aloem" />
		<label for="aloem"><?php _e('ALO EasyMail Newsletter', 'lwsb-plugin'); ?></label><br />
	<?php }; ?>

	<!-- Advanced Custom Fields -->
	<?php if ( is_plugin_active( 'advanced-custom-fields/acf.php' ) ) { ?>
		<input type="checkbox" id="acf" name="lwsb_settings[acf]" <?php checked( $options['acf'], 'acf' ); ?> value="acf" />
		<label for="acf"><?php _e('Advanced Custom Fields', 'lwsb-plugin'); ?></label><br />
	<?php }; ?>

	<!-- Cart Product Feed -->
	<?php if ( is_plugin_active( 'purple-xmls-google-product-feed-for-woocommerce/cart-product-feed.php' ) ) { ?>
		<input type="checkbox" id="woocpf" name="lwsb_settings[woocpf]" <?php checked( $options['woocpf'], 'woocpf' ); ?> value="woocpf" />
		<label for="woocpf"><?php _e('Cart Product Feed', 'lwsb-plugin'); ?></label><br />
	<?php }; ?>

	<!-- WordPress SEO -->
	<?php if ( is_plugin_active( 'wordpress-seo/wp-seo.php' ) ) { ?>
		<input type="checkbox" id="wpseo" name="lwsb_settings[wpseo]" <?php checked( $options['wpseo'], 'wpseo' ); ?> value="wpseo" />
		<label for="wpseo"><?php _e('WordPress SEO', 'lwsb-plugin'); ?></label><br />
	<?php }; ?>

	<!-- No CAPTCHA reCAPTCHA -->
	<?php if ( is_plugin_active( 'no-captcha-recaptcha/no-captcha-recaptcha.php' ) ) { ?>
		<input type="checkbox" id="ncrc" name="lwsb_settings[ncrc]" <?php checked( $options['ncrc'], 'ncrc' ); ?> value="ncrc" />
		<label for="ncrc"><?php _e('No CAPTCHA reCAPTCHA', 'lwsb-plugin'); ?></label><br />
	<?php }; ?>

	<!-- iThemes Security (formerly Better WP Security) -->
	<?php if ( is_plugin_active( 'better-wp-security/better-wp-security.php' ) ) { ?>
		<input type="checkbox" id="itsec" name="lwsb_settings[itsec]" <?php checked( $options['itsec'], 'itsec' ); ?> value="itsec" />
		<label for="itsec"><?php _e('iThemes Security (formerly Better WP Security)', 'lwsb-plugin'); ?></label><br />
	<?php }; ?>

	<br />
	<p class="description"><em><?php _e('Checked items will be hidden for all non-admins.', 'lwsb-plugin'); ?></em></p>







<?php 
}


function lwsb_admin_css_render(  ) { 
	$options = get_option( 'lwsb_settings' ); 
	$custom_css = $options['lwsb_admin_css']; ?>

	<textarea name="lwsb_settings[lwsb_admin_css]" rows="10" cols="50"><?php if (isset($custom_css)) { echo $custom_css; }; ?></textarea>

	<p class="description"><em><?php _e('Enter some custom CSS for the backend.', 'lwsb-plugin'); ?></em></p>
	
	<?php
}


/*
 * Section callbacks
 */
// Button settings description
function lwsb_section_btn_callback() { 
	echo __( 'Here you can change some settings for the WordPress backend.', 'lwsb-plugin' );
}


/*
 * Building the options page layout
 */
function lwsb_backend_options_page() { ?>

	<div class="wrap">
		<h2><?php _e('LWS Backend Settings', 'lwsb-plugin'); ?></h2>
		<form action='options.php' method='post'>
		
			<?php
			settings_fields( 'lwsbPage' );
			do_settings_sections( 'lwsbPage' );
			submit_button();
			?>
		
		</form>
	</div>
	
	<?php
} ?>