<?php
namespace WPML\PB\Elementor\LanguageSwitcher;

class LanguageSwitcherFactory implements IWPML_Backend_Action_Loader
{

	public function create()
	{
		return new LanguageSwitcher();
	}
}