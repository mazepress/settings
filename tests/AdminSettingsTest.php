<?php
/**
 * The AdminSettingsTest test class file.
 *
 * @package    Mazepress\Settings
 * @subpackage Tests
 */

namespace Mazepress\Settings\Tests;

use WP_Mock\Tools\TestCase;
use Mazepress\Settings\AdminSettings;
use Mazepress\Settings\Tests\Stubs\Settings;

/**
 * The AdminSettingsTest test class.
 */
class AdminSettingsTest extends TestCase {

	/**
	 * Test class instance method.
	 *
	 * @return void
	 */
	public function test_properties(): void {

		$object = new Settings();

		$this->assertInstanceOf( AdminSettings::class, $object );

		$slig = 'test';
		$this->assertInstanceOf( Settings::class, $object->set_slug( $slig ) );
		$this->assertEquals( $slig, $object->get_slug() );

		$title = 'Test Name';
		$this->assertInstanceOf( Settings::class, $object->set_title( $title ) );
		$this->assertEquals( $title, $object->get_title() );

		$desc = 'Test description';
		$this->assertInstanceOf( Settings::class, $object->set_description( $desc ) );
		$this->assertEquals( $desc, $object->get_description() );
	}
}
