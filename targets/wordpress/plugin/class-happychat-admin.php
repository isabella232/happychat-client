<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Happychat_Admin {
	private static $_instance = null;
	const VERSION             = '0.1.5';

	/**
	 * Create instance of class
	 * @return Happychat_Admin
	 */
	public static function instance( $file ) {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self( $file );
		}
		return self::$_instance;
	}

	public function __construct( $file ) {
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'admin_menu', array( $this, 'add_menu_item' ) );
		add_filter( 'plugin_action_links_' . plugin_basename( $file ), array( $this, 'add_settings_link' ) );
	}

	public function add_menu_item() {
		add_options_page( 'Settings', 'Happychat', 'edit_posts', 'happychat', array( $this, 'settings_page' ) );
	}

	public function add_settings_link( $links ) {
		$settings_link = '<a href="options-general.php?page=happychat">Settings</a>';
		array_push( $links, $settings_link );
		return $links;
	}

	public function register_settings() {
		add_settings_section( 'happychat_settings', '', null, 'happychat' );
		add_settings_field( 'happychat_user_group', 'User group:', array( $this, 'happychat_user_group_html' ), 'happychat', 'happychat_settings' );
		register_setting( 'happychat', 'happychat_user_group' );
	}

	private function enqueue_scripts() {
		wp_register_script(
			'fallback-ticket',
			plugins_url( 'assets/admin-fallback-ticket.js', __FILE__ ),
			array( 'jquery' ),
			self::VERSION,
			true
		);
		wp_enqueue_script( 'fallback-ticket' );
	}

	public function happychat_user_group_html() {
		$user_group = get_option( 'happychat_user_group' );
		print '<select id="happychat_user_group" name="happychat_user_group">';
		print '<option value="wpcom" ' . selected( $user_group, 'wpcom' ) . '>WordPress.com</option>';
		print '<option value="woo"   ' . selected( $user_group, 'woo' ) . '  >WooCommerce</option>';
		print '<option value="jpop"  ' . selected( $user_group, 'jpop' ) . ' >JPOP</option>';
		print '</select>';
	}

	public function settings_page() {
		wc_get_template(
			'class-happychat-admin-template.php',
			array(),
			'',
			plugin_dir_path( __FILE__ )
		);
	}
}
