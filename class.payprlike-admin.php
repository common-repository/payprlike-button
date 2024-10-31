<?php

class PayPRLike_Admin {

	private static $initiated = false;

	public static function init() {
		if (!self::$initiated) {
			self::init_hooks();
		}
	}

	public static function init_hooks() {

		self::$initiated = true;

		add_action('admin_menu', array('PayPRLike_Admin', 'admin_menu'), 5);
	}

	public static function admin_menu() {
		$hook = add_options_page(__('PayPRLike', 'payprlike'), __('PayPRLike Button', 'payprlike'), 'manage_options', 'payprlike-options', array('PayPRLike_Admin', 'display_configuration_page'));

		if (version_compare($GLOBALS['wp_version'], PAYPRLIKE__MINIMUM_WP_VERSION, '>=')) {
			add_action("load-$hook", array('PayPRLike_Admin', 'admin_help'));
		}
	}

	public static function admin_head() {
		if (!current_user_can('manage_options'))
			return;
	}

	public static function admin_help() {
		
	}

	public static function display_configuration_page() {

		if (isset($_POST['payprlike_form_submitted'])) {

			$hidden_field = esc_html($_POST['payprlike_form_submitted']);

			if ($hidden_field == 'YES') {

				$payprlike_username = esc_html($_POST['payprlike_username']);
				$button_aligment = esc_html($_POST['button_aligment']);
				$options['api_username'] = $payprlike_username;
				$options['button_aligment'] = $button_aligment;

				update_option('payprlike_options', $options);
				$message = '<div id="message" class="updated fade"><p><strong>' . __('Settings saved.', 'payprlike') . '</strong></p></div>'; 
			}
		}

		$options = get_option('payprlike_options');

		if ($options != '') {

			$payprlike_username = $options['api_username'];
			$button_aligment = $options['button_aligment'];
		}
		require( PAYPRLIKE__PLUGIN_DIR . 'views/options-page-wrapper.php' );
	}

}