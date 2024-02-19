<?php
/**
 * The BaseSettingsTest class file.
 *
 * @package    Mazepress\Settings
 * @subpackage Tests
 */

namespace Mazepress\Settings\Tests;

use Mazepress\Settings\BaseSettings;
use Mazepress\Settings\Tests\Stubs\Settings;
use WP_Mock\Tools\TestCase;

/**
 * The BaseSettingsTest test class.
 */
class BaseSettingsTest extends TestCase {

	/**
	 * Test class instance method.
	 *
	 * @return void
	 */
	public function test_properties(): void {

		$object = new Settings();

		$this->assertInstanceOf( BaseSettings::class, $object );

		$slig = 'test';
		$this->assertInstanceOf( Settings::class, $object->set_menu_slug( $slig ) );
		$this->assertEquals( $slig, $object->get_menu_slug() );

		$title = 'Test Name';
		$this->assertInstanceOf( Settings::class, $object->set_menu_title( $title ) );
		$this->assertEquals( $title, $object->get_menu_title() );

		$desc = 'Test description';
		$this->assertInstanceOf( Settings::class, $object->set_page_title( $desc ) );
		$this->assertEquals( $desc, $object->get_page_title() );
	}
}
