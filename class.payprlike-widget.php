<?php

/**
 * @package PayPRLike
 */
class PayPRLike_Widget extends WP_Widget {

	function __construct() {
		load_plugin_textdomain('payprlike');

		parent::__construct(
				'payprlike_widget', __('PayPRLike', 'payprlike'), array('description' => __('Create PayPRLike Button', 'payprlike'))
		);

		if (is_active_widget(false, false, $this->id_base)) {
			add_action('wp_head', array($this, 'css'));
		}
	}

	function css() {
		?>

		<style type="text/css">

		</style>

		<?php
	}

	function form($instance) {
		if ($instance) {
			$title = $instance['title'];
		} else {
			$title = __('PayPRLike', 'payprlike');
		}
		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Box title:', 'payprlike'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>

		<?php
	}

	function update($new_instance, $old_instance) {
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}

	function widget($args, $instance) {
		$options = get_option('payprlike_options');
		
		if ($options != '') {
			$username = $options['api_username'];
			$aligment = $options['button_aligment'];
		}

		echo $args['before_widget'];
		if (!empty($instance['title'])) {
			echo $args['before_title'];
			echo esc_html($instance['title']);
			echo $args['after_title'];
		}
		?>

		<div class="payprlike-box">
		    <div id="payprlike" name="<?php echo (isset($username)) ? $username : ''; ?>" style="text-align: <?php echo (isset($aligment)) ? $aligment : 'inherit';?>;"><a href="#" style="display: inline-block;">PayPRLike</a></div>
		</div>

		<?php
		echo $args['after_widget'];
	}

}

function payprlike_register_widgets() {
	register_widget('PayPRLike_Widget');
}

add_action('widgets_init', 'payprlike_register_widgets');
