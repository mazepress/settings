<?php
/**
 * The Settings stub class file.
 *
 * @package    Mazepress\Settings
 * @subpackage Tests\Stub
 */

namespace Mazepress\Settings\Tests\Stubs;

use Mazepress\Settings\BaseSettings;
use Mazepress\Forms\Field\Fieldset;

/**
 * The Settings test class.
 */
class Settings extends BaseSettings {

	/**
	 * Initiate class.
	 */
	public function __construct() {
		$this->set_menu_slug( 'test' );
		$this->set_menu_title( 'Test' );
		$this->set_page_title( 'Test Settings' );
	}

	/**
	 * Get the fieldsets.
	 *
	 * @return Fieldset[]
	 */
	public function get_fieldsets(): array {
		$fieldsets = array();
		return $fieldsets;
	}
}
