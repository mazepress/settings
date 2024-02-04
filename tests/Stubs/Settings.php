<?php
/**
 * The Settings stub class file.
 *
 * @package    Mazepress\Settings
 * @subpackage Tests\Stub
 */

namespace Mazepress\Settings\Tests\Stubs;

use Mazepress\Settings\AdminSettings;
use Mazepress\Forms\Field\Fieldset;

/**
 * The Settings test class.
 */
class Settings extends AdminSettings {

	/**
	 * Initiate class.
	 */
	public function __construct() {
		$this->set_slug( 'test' );
		$this->set_title( 'Test' );
		$this->set_description( 'Test Settings' );
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
