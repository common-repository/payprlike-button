<?php

class PayPRLike {

	private static $initiated = false;

	public static function init() {
		if (!self::$initiated) {
			self::init_hooks();
		}
	}

	public static function init_hooks() {

		self::$initiated = true;
		
		add_action('wp_enqueue_scripts', array('PayPRLike', 'load_resources'));
	}

	public static function plugin_activation() {
		if (version_compare($GLOBALS['wp_version'], PAYPRLIKE__MINIMUM_WP_VERSION, '<')) {
			load_plugin_textdomain('payprlike');

			$message = '<strong>' . sprintf(esc_html__('PayPRLike %s requires WordPress %s or higher.', 'payprlike'), PAYPRLIKE_VERSION, PAYPRLIKE__MINIMUM_WP_VERSION) . '</strong> ' . sprintf(__('Please <a href="%1$s">upgrade WordPress</a> to a current version.', 'payprlike'), 'https://codex.wordpress.org/Upgrading_WordPress');

			PayPRLike::bail_on_activation($message);
		}
	}

	public static function plugin_deactivation() {
		delete_option('payprlike_options');
	}
	
	public static function load_resources() {	
		wp_enqueue_style( 'payprlike', PAYPRLIKE__PLUGIN_URL . '/_inc/pplike.css' );
		wp_enqueue_script( 'jquery-ui-dialog' );
		wp_enqueue_script( 'payprlike', PAYPRLIKE__PLUGIN_URL . '/_inc/pplike.js', array( 'jquery' ), '1.0.0', true );
		
	}
	
	private static function bail_on_activation($message, $deactivate = true) {
		?>
		<!doctype html>
		<html>
		<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<style>
		* {
			text-align: center;
			margin: 0;
			padding: 0;
			font-family: "Lucida Grande",Verdana,Arial,"Bitstream Vera Sans",sans-serif;
		}
		p {
			margin-top: 1em;
			font-size: 18px;
		}
		</style>
		<body>
		<p><?php echo $message; ?></p>
		</body>
		</html>
		<?php
		if ($deactivate) {
			$plugins = get_option('active_plugins');
			$payprlike = plugin_basename(PAYPRLIKE__PLUGIN_DIR . 'payprlike.php');
			$update = false;
			foreach ($plugins as $i => $plugin) {
				if ($plugin === $payprlike) {
					$plugins[$i] = false;
					$update = true;
				}
			}

			if ($update) {
				update_option('active_plugins', array_filter($plugins));
			}
		}
		exit;
	}

}