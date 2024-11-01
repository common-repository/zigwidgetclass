<?php
/*
Plugin Name: ZigWidgetClass
Plugin URI: https://www.zigpress.com/plugins/zigwidgetclass/
Description: Lets you add a custom class to each widget instance.
Version: 1.0
Author: ZigPress
Requires at least: 4.0
Tested up to: 5.4
Requires PHP: 5.3
Author URI: https://www.zigpress.com/
License: GPLv2
*/


/*
Copyright (c) 2011-2020 ZigPress

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
Foundation Inc, 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
*/


# DEFINE PLUGIN


if (!class_exists('zigwidgetclass')) {


	class zigwidgetclass
	{


		public $plugin_folder;
		public $plugin_path;


		public function __construct() {
			$this->plugin_folder = plugin_dir_url( __FILE__ );
			$this->plugin_path = str_replace('plugin.php', 'zigwidgetclass.php', __FILE__);
			global $wp_version;
			add_action('plugins_loaded', array($this, 'action_plugins_loaded'));
			add_action('admin_enqueue_scripts', array($this, 'action_admin_enqueue_scripts'));
			add_action('admin_menu', array($this, 'action_admin_menu'));
			add_filter('widget_form_callback', array($this, 'filter_widget_form_callback'), 10, 2);
			add_filter('widget_update_callback', array($this, 'filter_widget_update_callback'), 10, 2);
			add_filter('dynamic_sidebar_params', array($this, 'filter_dynamic_sidebar_params'));
			add_filter('plugin_row_meta', array($this, 'filter_plugin_row_meta'), 10, 2 );
			/* That which can be added without discussion, can be removed without discussion. */
			remove_filter('the_title', 'capital_P_dangit', 11);
			remove_filter('the_content', 'capital_P_dangit', 11);
			remove_filter('comment_text', 'capital_P_dangit', 31);
		}


		public function autodeactivate($requirement) {
			if (!function_exists( 'get_plugins')) require_once(ABSPATH . 'wp-admin/includes/plugin.php');
			$plugin = plugin_basename($this->plugin_path);
			$plugindata = get_plugin_data($this->plugin_path, false);
			if (is_plugin_active($plugin)) {
				delete_option('zigpluginsafe');
				deactivate_plugins($plugin);
				wp_die($plugindata['Name'] . ' requires ' . $requirement . ' and has been deactivated. <a href="' . admin_url('plugins.php') . '">Click here to go back.</a>');
			}
		}


		/* ACTIONS */


		public function action_plugins_loaded() {
			global $wp_version;
			if (version_compare(phpversion(), '5.3.0', '<')) $this->autodeactivate('PHP 5.3.0');
			if (version_compare($wp_version, '4.0', '<')) $this->autodeactivate('WordPress 4.0');
		}


		public function action_admin_enqueue_scripts() {
			wp_enqueue_style('zigwidgetclassadmin', $this->plugin_folder . 'css/admin.css', false, date('Ymd'));
		}


		public function action_admin_menu() {
			add_options_page('ZigWidgetClass', 'ZigWidgetClass', 'manage_options', 'zigwidgetclass-options', array($this, 'admin_page_options'));
		}


		/* FILTERS */


		function filter_widget_form_callback($instance, $widget) {
			# show the input for entering the classes
			if (!isset($instance['zigclass'])) $instance['zigclass'] = null;
			?>
			<p class="zigwidgetclass-control-wrap">
			<label for='widget-<?php echo $widget->id_base?>-<?php echo $widget->number?>-zigclass'>CSS Classes:</label>
			<input class='widefat' type='text' name='widget-<?php echo $widget->id_base?>[<?php echo $widget->number?>][zigclass]' id='widget-<?php echo $widget->id_base?>-<?php echo $widget->number?>-zigclass' value='<?php echo $instance['zigclass']?>'/>
			<a class="credit" href="https://www.zigpress.com/plugins/zigwidgetclass/" target="_blank">ZigWidgetClass plugin by ZigPress</a>
			</p><!--/.zigwidgetclass-control-wrap-->
			<?php
			return $instance;
		}


		function filter_widget_update_callback($instance, $new_instance) {
			# make sure the classes entered get saved along with the rest of the widget options
			$instance['zigclass'] = $new_instance['zigclass'];
			return $instance;
		}


		function filter_dynamic_sidebar_params($params) {
			global $wp_registered_widgets;
			$widget_id = $params[0]['widget_id'];
			$widget = $wp_registered_widgets[$widget_id];

			# We're looking for the option_name (in wp_options) of where this widget's data is stored
			# Default location
			if (!($ouroptionname = $widget['callback'][0]->option_name)) {
				# Alternate location of option name if widget logic installed
				if (!($ouroptionname = $widget['callback_wl_redirect'][0]->option_name)) {
					# Alternate location of option name if widget context installed
					$ouroptionname = $widget['callback_original_wc'][0]->option_name;
				}
			}
			$option_name = get_option($ouroptionname);

			# within the option, we're looking for the data for the right widget number
			# that's where we'll find the zigclass value if it exists
			$number = $widget['params'][0]['number'];
			if (isset($option_name[$number]['zigclass']) && !empty($option_name[$number]['zigclass'])) {
				# add our class to the start of the existing class declaration
				$params[0]['before_widget'] = preg_replace('/class="/', "class=\"{$option_name[$number]['zigclass']} ", $params[0]['before_widget'], 1);
			} else {
				# No zigclass found - but if we're using wp page widget, there could be one elsewhere

				# WP Page Widget plugin fix
				# If another plugin also uses this function name then you've got bigger problems than adding a class to a widget...
				if (function_exists('pw_filter_widget_display_instance')) {
					global $post;
					$ouroptionname = 'widget_' . $post->ID . '_' . $widget['callback'][0]->id_base;
					# did we find a wp page widget option for this post
					if ($option_name = get_option($ouroptionname)) {
						$number = $widget['params'][0]['number'];
						if (isset($option_name[$number]['zigclass']) && !empty($option_name[$number]['zigclass'])) {
							$params[0]['before_widget'] = preg_replace('/class="/', "class=\"{$option_name[$number]['zigclass']} ", $params[0]['before_widget'], 1);
						}
					}
				}
			}
			return $params;
		}


		public function filter_plugin_row_meta($links, $file) {
			$plugin = plugin_basename(__FILE__);
			$newlinks = array(
				'<a target="_blank" href="https://www.zigpress.com/donations/">Donate</a>',
				'<a href="' . get_admin_url() . 'options-general.php?page=zigwidgetclass-options">Information</a>',
			);
			if ($file == $plugin) return array_merge($links, $newlinks);
			return $links;
		}


		# ADMIN CONTENT


		public function admin_page_options() {
			if (!current_user_can('manage_options')) { wp_die('You are not allowed to do this.'); }
			?>
			<div class="wrap zigwidgetclass-admin">
			<h2>ZigWidgetClass - Information</h2>
			<div class="wrap-left">
			<div class="col-pad">
			<p>ZigWidgetClass adds a free text field labelled 'CSS Classes' to each widget control form on your widget admin page. Enter a CSS class name in the box and it will be added to the classes that WordPress applies to that widget instance. To add multiple classes, simply separate them with a space.</p>
			<p>It has been tested and verified to work with the <a href="https://wordpress.org/plugins/widget-logic/" target="_blank">Widget Logic</a> plugin, the <a href="https://wordpress.org/plugins/widget-context/" target="_blank">Widget Context</a> plugin, the <a href="https://wordpress.org/plugins/wp-page-widget/" target="_blank">WP Page Widget</a> plugin and the <a href="https://wordpress.org/plugins/display-widgets/" target="_blank">Display Widgets</a> plugin. If you have problems getting it to work with one of those plugins, make sure you are using the latest version(s).</p>
			<p>It only works with widgets that were created by properly using WordPress's <a href="http://codex.wordpress.org/Widgets_API" target="_blank">Widgets API</a>. If it appears not to work on a certain widget, that widget probably breaks the API rules somehow. </p>
			<p>Also, if you have trouble getting it to work with the WP Page Widget plugin, you should create and save each page widget first, before adding the CSS class, then save again.</p>
			<p>If you still have trouble using ZigWidgetClass, post a comment on the plugin's <a href="https://www.zigpress.com/plugins/zigwidgetclass/" target="_blank">home page.</a> Requests for support or new features will be prioritised if accompanied by a donation.</p>
			</div><!--col-pad-->
			</div><!--wrap-left-->
			<div class="wrap-right">
			<table class="widefat donate" cellspacing="0">
			<thead>
			<tr><th>Support this plugin!</th></tr>
			</thead>
			<tr><td>
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
			<input type="hidden" name="cmd" value="_s-xclick">
			<input type="hidden" name="hosted_button_id" value="GT252NPAFY8NN">
			<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
			<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
			</form>
			<p>If you find ZigWidgetClass useful, please keep it free and actively developed by making a donation.</p>
			<p>Suggested donation: &euro;10 or an amount of your choice. Just click the Donate button. Thanks!</p>
			</td></tr>
			</table>
			<table class="widefat donate" cellspacing="0">
			<thead>
			<tr><th><img class="icon floatRight" src="<?php echo $this->plugin_folder?>images/favicon-16x16.png" alt="Yes" title="Yes" />Brought to you by ZigPress</th></tr>
			</thead>
			<tr><td>
			<p><a href="https://www.zigpress.com/">ZigPress</a> is engaged in WordPress consultancy, solutions and research. We have also released a number of free plugins to support the WordPress community.</p>
			<p><a target="_blank" href="https://www.zigpress.com/plugins/zigwidgetclass/">ZigWidgetClass home page</a></p>
			<p><a target="_blank" href="https://www.zigpress.com/wordpress-plugins/">Other ZigPress plugins</a></p>
			<p><a target="_blank" href="https://www.facebook.com/zigpress">ZigPress on Facebook</a></p>
			<p><a target="_blank" href="https://twitter.com/ZigPress">ZigPress on Twitter</a></p>
			</td></tr>
			</table>
			</div><!--wrap-right-->
			<div class="clearer">&nbsp;</div>
			</div><!--/wrap-->
			<?php
		}


		public function is_classicpress() {
			return function_exists('classicpress_version');
		}


	} # END OF CLASS


} else {
	wp_die('Namespace clash! Class zigwidgetclass already declared.');
}


# INSTANTIATE PLUGIN


$zigwidgetclass = new zigwidgetclass();


# EOF
