<?php
namespace WPML\PB\Elementor\LanguageSwitcher;

use Elementor\Controls_Manager;

class Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'wpml-language-switcher';
	}

	public function get_title() {
		return __( 'WPML Language Switcher', 'sitepress' );
	}

	public function get_icon() {
		return 'fa fa-globe';
	}

	public function get_categories() {
		return [ 'general' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'sitepress' ),
				'type' => Controls_Manager::SECTION,
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'style',
			[
				'label' => __('Language switcher style', 'sitepress'),
				'type' => Controls_Manager::SELECT,
				'default' => 'horizontal-list',
				'options' => [
					'horizontal-list' => __('Horizontal List', 'sitepress'),
					'vertical-list' => __('Vertical List', 'sitepress'),
					'dropdown' => __('Dropdown', 'sitepress'),
					'dropdown-click' => __('Dropdown Click', 'sitepress'),
				],
			]
		);

		$this->add_control(
			'align_items',
			[
				'label' => __('Align', 'sitepress'),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'left',
				'options' => [
					'left' => [
						'title' => __('Left', 'sitepress'),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __('Center', 'sitepress'),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __('Right', 'sitepress'),
						'icon' => 'fa fa-align-right',
					],
				],
			]
		);

		$this->add_control(
			'display_flag',
			[
				'label' => __('Display Flag', 'sitepress'),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'skip_missing',
			[
				'label' => __('Skip missing', 'sitepress'),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 1,
				'default' => 0,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'native_language_name',
			[
				'label' => __('Native language name', 'sitepress'),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'language_name_current_language',
			[
				'label' => __('Language name in current language', 'sitepress'),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->end_controls_section();


	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$languages = apply_filters('wpml_active_languages', NULL, array('skip_missing' => $settings['skip_missing']));

		/* Assuming $settings['style'] = 'dropdown' for testing purpose.
		Using WPML CSS classes names instead of writing custom CSS from scratch?! */

		$this->add_render_attribute(
			'wpml-ls',
			[
				'class' => ['wpml-ls wpml-ls-legacy-dropdown js-wpml-ls-legacy-dropdown '],
			]
		);

		if (!empty($languages)) {

			echo '<div ' . $this->get_render_attribute_string('wpml-ls') . '><ul>';

			foreach ($languages as $language) {

				echo ($language['active']) ? '<li tabindex="0" class="wpml-ls-current-language wpml-ls-item-legacy-dropdown wpml-ls-item">' : '<li class="wpml-ls-item">';
				echo ($language['active']) ? '<a href="' . $language['url'] . '" class="js-wpml-ls-item-toggle wpml-ls-item-toggle">' : '<a href="' . $language['url'] . '" class="wpml-ls-link">';
				echo $settings['native_language_name'] ? '<span class="wpml-ls-native">' . $language['native_name'] . '</span>' : '';
				echo '</a>';

				echo '</li>';
			}
			echo '</ul></div>';
		}

	}
}