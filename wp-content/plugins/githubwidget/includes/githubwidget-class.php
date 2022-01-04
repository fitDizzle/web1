<?php

/**
 * Adds Foo_Widget widget.
 */
class Github_Api_Widget extends WP_Widget
{

	/**
	 * Register widget with WordPress.
	 */
	function __construct()
	{
		parent::__construct(
			'githubapi_widget', // Base ID
			esc_html__('Github Widget', 'ghw_domain'), // Name
			array('description' => esc_html__('Widget to display github profile information.', 'ghw-domain'),) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */

	public function widget($args, $instance)
	{
		echo $args['before_widget']; // whatever you'd like to display before widget (<div>, etc)

		// PHP API CALL
		function get_git_api()
		{
			$url = 'https://api.github.com/users/fitDizzle';
			$arguments = array(
				'method' => 'GET',
			);

			$response = wp_remote_get($url, $arguments);

			if (is_wp_error($response)) {
				$error_message = $response->get_error_message();
				echo 'Something went wrong: $error_message';
			}
			print_r(json_decode($response['body']));
			print_r(json_decode($response['body'])->id);
			print_r(json_decode($response['body'])->login);
			print_r(json_decode($response['body'])->following_url);
			print_r(json_decode($response['body'])->avatar_url);

			// $data =	var_export(wp_remote_retrieve_body($response));
		}

		// CHECK FOR WIDGET DATA AND SET DEFAULT
		if (!empty($instance['title'])) {
			echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
		}

		// Widget Content On_decode(utput
		$datatorender = get_git_api();
		// echo $datatorender = 'login';

		echo $args['after_widget']; // whatever you'd like to display after widget (<div>, etc)
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form($instance)
	{
		$githubusername = !empty($instance['title']) ? $instance['title'] : esc_html__('Github Widget', 'ghw_domain');

		$itemtofetchfromgithubapi = !empty($instance['channel']) ? $instance['channel'] : esc_html__('techguyweb', 'ghw_domain');

		$layout = !empty($instance['layout']) ? $instance['layout'] : esc_html__('default', 'ghw_domain');
?>



		<!-- Title -->
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
				<?php esc_attr_e('Title:', 'ghw_domain'); ?>
			</label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
		</p>

		<!-- Channel -->
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('channel')); ?>">
				<?php esc_attr_e('Channel:', 'ghw_domain'); ?>
			</label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('channel')); ?>" name="<?php echo esc_attr($this->get_field_name('channel')); ?>" type="text" value="<?php echo esc_attr($channel); ?>">
		</p>

		<!-- LAYOUT -->
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('layout')); ?>">
				<?php esc_attr_e('Layout:', 'ghw_domain'); ?>
			</label>

			<select class="widefat" id="<?php echo esc_attr($this->get_field_id('layout')); ?>" name="<?php echo esc_attr($this->get_field_name('layout')); ?>">
				<option value="default" <?php echo ($layout == 'default') ? 'selected' : ''; ?>>Default</option>
				<option value="full" <?php echo ($layout == 'full') ? 'selected' : ''; ?>>Full</option>
			</select>
		</p>
<?php
	}


	// UPDATE FORM DATA / WIDGET DATA //

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */


	public function update($new_instance, $old_instance)
	{
		$instance = array();

		$instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';

		$instance['channel'] = (!empty($new_instance['channel'])) ? sanitize_text_field($new_instance['channel']) : '';

		$instance['layout'] = (!empty($new_instance['layout'])) ? sanitize_text_field($new_instance['layout']) : '';

		return $instance;
	}
} // class Foo_Widget