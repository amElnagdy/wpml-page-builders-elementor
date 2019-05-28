<?php
namespace WPML\PB\Elementor\LanguageSwitcher;

final class LanguageSwitcher {

	private static $_instance = null;

	public static function instance() {

		if (is_null(self::$_instance)) {
			self::$_instance = new self();
		}
		return self::$_instance;

	}

	public function __construct() {

//		add_action( 'plugins_loaded', [ $this, 'init' ] );

		$this -> init();

	}

	public function init() {

		add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
		// Register Widget Styles
		add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'widget_styles' ] );


	}

	public function init_widgets() {

		// Include Widget files
		require_once('widget/class-wpml-elementor-language-switcher-widget.php');

		// Register widget
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new LanguageSwitcherWidget() );

	}

	public function widget_styles() {

		wp_register_style('language-switcher', plugins_url('assets/language-switcher.css', __FILE__));
	}

}

LanguageSwitcher::instance();