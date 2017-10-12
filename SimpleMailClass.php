<?php

/**
 * Class SimpleMail
 * A SM wrapper class
 */
class SimpleMail
{

	/**
	 * @var null - WP Database object
	 */
	public $db = null;


	/**
	 * @var null|SimpleMailReporter - Messages reporter class
	 */
	public $reporter = null;


	/**
	 * @var null|SimpleMailConfig - The instance of SimpleMailConfig class
	 */
	public $config = null;


	/**
	 * @var null|SimpleMailSanitizer - Sanitizer instance
	 */
	public $sanitizer = null;


	/**
	 * @var null|SimpleMailProcessor - Controller instance
	 */
	public $processor = null;


	/**
	 * @var array - Allowed user roles for saving configs of this plugin
	 */
	public $allowedAdminRoles = array(
		'administrator'
	);


	/**
	 * SimpleMail constructor
	 *
	 * 1. Let's make the WPDB class local available.
	 * 2. Create error reporter instance.
	 * 3. Create an instance of the sanitizer class.
	 * 4. Get the SM config class instance.
	 * 5. Create our processor class.
	 *
	 */
	public function __construct()
	{
		global $wpdb;
		$this->db = $wpdb;
		$this->reporter = new SimpleMailReporter();
		$this->sanitizer = new SimpleMailSanitizer();
		$this->config = new SimpleMailConfig($this);
		$this->processor = new SimpleMailProcessor($this);
	}


	/**
	 * Initialize SimpleMail plugin
	 *
	 * Register variables, session, language on init.
	 * Add our frontend SM includes as required.
	 * Regiester our install & uninstall methods.
	 * Create SM admin menu in WP admin section.
	 * Add our SM admin includes like styles, javascript libraries etc.
	 * Add an action link on the plugins page
	 */
	public function init($file)
	{
		$this->config->pluginFile = $file;
		add_action('init', array($this->processor, 'init'));

		// Admin only stuff
		register_activation_hook($this->config->pluginFile, array($this->processor, 'install'));
		register_uninstall_hook($this->config->pluginFile, 'SimpleMailProcessor::uninstall');
		add_action('admin_menu', array($this->processor, 'createAdminMenu'));
		add_action('admin_head', array($this->processor, 'addSmAdminHeader'));
		add_filter('plugin_action_links', array($this->processor, 'editActionLinks'), 10, 2);
	}


	/**
	 * A simple wrapper method, outputs the return of the
	 * processor method for rendering our frontend form.
	 *
	 */
	public function getForm() {
		$obj = get_queried_object();
		if($this->config->displayFormOnPageId && $this->config->displayFormOnPageId != $obj->ID) { return; }
		echo $this->processor->renderForm();
	}

}