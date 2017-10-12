<?php

class SimpleMailWidget extends WP_Widget
{
	public function __construct()
	{
		// Set base values for the widget
		parent::__construct(
			'SimpleMailWidget',
			'SimpleMail Widget',
			array('description' => 'A widget that displays SimpleMail contact form')
		);
		add_action('widgets_init', array($this, 'register'));
	}

	public function register() {
		register_widget('SimpleMailWidget');
	}

	public function widget($args, $instance) {
		global $sm;
		$sm->getForm();
	}
}
