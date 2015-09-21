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

	// Hide default menu items
	add_settings_field( 
		'lwsb_hide_menus', 
		__( 'Hide Default Menus', 'lwsb-plugin' ), 
		'lwsb_hide_menus_render', 
		'lwsbPage', 
		'lwsb_section_btn' 
	);

	// Hide 3rd party plugins
	add_settings_field( 
		'lwsb_hide_plugin_menus', 
		__( 'Hide Plugin Menus', 'lwsb-plugin' ), 
		'lwsb_hide_plugin_menus_render', 
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

<?php 
}


function lwsb_hide_plugin_menus_render(  ) { 

	$plugins = get_plugins();

	foreach ($plugins as $plugin_path => $plugin) {


		// We split the plugin path
		$path = parse_url($plugin_path, PHP_URL_PATH);
		$segments = explode('/', rtrim($path, '/'));

		// Get the plugin directory and filename
		$plugin_dir = $segments[0];
		$plugin_file = $segments[1];

		$plugin_name = $plugin['Name'];
		$plugin_version = $plugin['Version'];

		if ( is_plugin_active( $plugin_path ) ) { 

			$options = get_option( 'lwsb_settings' );
			
			if ($plugin_dir != 'lws-backend') {
			?>

				<input type="checkbox" id="<?php echo $plugin_dir; ?>" name="lwsb_settings[<?php echo $plugin_dir; ?>]" <?php checked( $options[$plugin_dir], $plugin_dir ); ?> value="<?php echo $plugin_dir; ?>" />
				<label for="<?php echo $plugin_dir; ?>"><?php echo $plugin_name; ?></label> <code><?php echo $plugin_dir; ?></code><br />
			
		<?php } // END is is not lws-backend

		}// END if plugin is active

	}// END foreach

?>

	<br />
	<p class="description"><em><?php _e('Checked items will be hidden for all non-admins.', 'lwsb-plugin'); ?></em></p>

<?php }//END lwsb_hide_plugin_menus_render


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