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
use WP_Mock;
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

	/**
	 * Test get_options method.
	 *
	 * @return void
	 */
	public function test_get_options(): void {

		$object  = new Settings();
		$options = array(
			'istrue' => true,
		);

		WP_Mock::userFunction(
			'wp_sprintf',
			array(
				'args' => array(
					'%1$s_settings_%2$s',
					'test',
					'testkey',
				),
			)
		)->andReturn( 'test_settings_testkey' );

		WP_Mock::userFunction(
			'get_option',
			array(
				'args' => array(
					'test_settings_testkey',
				),
			)
		)->andReturn( $options );

		$this->assertEmpty( $object->get_options( '' ) );
		$this->assertIsArray( $object->get_options( 'testkey' ) );
		$this->assertEquals( $options, $object->get_options( 'testkey' ) );
	}

	/**
	 * Test get_option method.
	 *
	 * @return void
	 */
	public function test_get_option(): void {

		$object  = new Settings();
		$options = array(
			'baseval' => '123',
		);

		WP_Mock::userFunction(
			'wp_sprintf',
			array(
				'args' => array(
					'%1$s_settings_%2$s',
					'test',
					'testkey',
				),
			)
		)->andReturn( 'test_settings_testkey' );

		WP_Mock::userFunction(
			'get_option',
			array(
				'args' => array(
					'test_settings_testkey',
				),
			)
		)->andReturn( $options );

		$this->assertEmpty( $object->get_option( '', '' ) );
		$this->assertEquals( '123', $object->get_option( 'testkey', 'baseval' ) );
	}
}
