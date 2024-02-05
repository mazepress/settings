<?php
/**
 * The BaseSettings class file.
 *
 * @package Mazepress\Settings
 */

declare(strict_types=1);

namespace Mazepress\Settings;

use Mazepress\Forms\Field\Fieldset;
use Mazepress\Forms\Field\BaseField;

/**
 * The BaseSettings class.
 */
abstract class BaseSettings {

	/**
	 * The menu slug.
	 *
	 * @var string $menu_slug
	 */
	private $menu_slug;

	/**
	 * The menu title.
	 *
	 * @var string $menu_title
	 */
	private $menu_title;

	/**
	 * The page title.
	 *
	 * @var string $page_title
	 */
	private $page_title;

	/**
	 * Get the fieldsets.
	 *
	 * @return Fieldset[]
	 */
	abstract public function get_fieldsets(): array;

	/**
	 * Render the settings page.
	 *
	 * @phpcs:disable WordPress.Security.EscapeOutput
	 * @phpcs:disable WordPress.Security.NonceVerification
	 *
	 * @return void
	 */
	public function render_page(): void {

		$active    = ( ! empty( $_GET['tab'] ) ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : '';
		$fieldsets = $this->get_fieldsets();

		if ( ! empty( $fieldsets ) && empty( $active ) ) {
			$active = array_key_first( $fieldsets );
		}

		echo '<div class="wrap"><h1>' . esc_html( get_admin_page_title() ) . '</h1>';
		echo '<nav class="nav-tab-wrapper wp-clearfix">';

		array_walk(
			$fieldsets,
			function ( Fieldset $fieldset ) use ( $active ) {
				$class = ( $fieldset->get_slug() === $active ) ? ' nav-tab-active' : '';
				$href  = wp_sprintf( '?page=%1$s&tab=%2$s', $this->get_menu_slug(), $fieldset->get_slug() );
				echo wp_sprintf(
					'<a class="nav-tab %1$s" href="%2$s">%3$s</a>',
					esc_attr( $class ),
					esc_attr( $href ),
					esc_html( $fieldset->get_title() )
				);
			}
		);

		echo '</nav>';
		echo '<form method="post" enctype="multipart/form-data" action="options.php">';

		$field = wp_sprintf( '%1$s_%2$s', $this->get_menu_slug(), $active );

		settings_fields( $field );
		do_settings_sections( $field );
		submit_button();

		echo '</form>';
	}

	/**
	 * Register settings options.
	 *
	 * @return void
	 */
	public function render_section(): void {

		$fieldsets = $this->get_fieldsets();

		array_walk(
			$fieldsets,
			function ( Fieldset $fieldset ) {

				$page    = wp_sprintf( '%1$s_%2$s', $this->get_menu_slug(), $fieldset->get_slug() );
				$section = wp_sprintf( '%1$s_settings_%2$s', $this->get_menu_slug(), $fieldset->get_slug() );

				register_setting( $page, $section );

				add_settings_section(
					$section,
					$fieldset->get_description(),
					'__return_false',
					$page
				);

				$fields = $fieldset->get_fields();

				array_walk(
					$fields,
					function ( BaseField $field ) use ( $page, $section ) {

						$field_name = $field->get_name();
						$post_fix   = '';

						if ( ! empty( $field_name ) && false !== strpos( $field_name, '[]', -2 ) ) {
							$field_name = \str_replace( '[]', '', $field_name );
							$post_fix   = '[]';
						}

						$field->set_name( wp_sprintf( '%1$s[%2$s]%3$s', $section, $field_name, $post_fix ) );

						add_settings_field(
							$field->get_name(),
							$field->get_label(),
							array( $this, 'render_field' ),
							$page,
							$section,
							array( 'field' => $field )
						);
					}
				);
			}
		);
	}

	/**
	 * Render the form fields.
	 *
	 * @param array<mixed> $args The field.
	 *
	 * @return void
	 */
	public function render_field( array $args ): void {

		if ( ! empty( $args['field'] ) && $args['field'] instanceof BaseField ) {

			$args['field']->render();

			if ( ! empty( $args['field']->get_description() ) ) {
				echo wp_sprintf(
					'<p class="form-info-text">%1$s</p>',
					esc_html( $args['field']->get_description() )
				);
			}
		}
	}

	/**
	 * Get the settings options
	 *
	 * @param string $fieldset The field fieldset.
	 *
	 * @return array<mixed>
	 */
	public function get_options( string $fieldset ): array {

		$options = array();

		if ( empty( $fieldset ) ) {
			return $options;
		}

		$settings = get_option( wp_sprintf( '%1$s_settings_%2$s', $this->get_menu_slug(), $fieldset ) );

		if ( is_array( $settings ) ) {
			$options = $settings;
		}

		return $options;
	}

	/**
	 * Get the settings option
	 *
	 * @param string $fieldset The field fieldset.
	 * @param string $field The field name.
	 *
	 * @return mixed
	 */
	public function get_option( string $fieldset, string $field ) {

		$value = null;

		if ( empty( $fieldset ) || empty( $field ) ) {
			return $value;
		}

		$options = $this->get_options( $fieldset );

		if ( array_key_exists( $field, $options ) ) {
			$value = $options[ $field ];
		}

		return $value;
	}

	/**
	 * Get menu slug.
	 *
	 * @return string
	 */
	public function get_menu_slug(): string {
		return $this->menu_slug;
	}

	/**
	 * Set menu slug.
	 *
	 * @param String $menu_slug The menu slug.
	 *
	 * @return self
	 */
	public function set_menu_slug( string $menu_slug ): self {
		$this->menu_slug = $menu_slug;
		return $this;
	}

	/**
	 * Get menu title.
	 *
	 * @return string
	 */
	public function get_menu_title(): string {
		return $this->menu_title;
	}

	/**
	 * Set menu title.
	 *
	 * @param String $menu_title The menu title.
	 *
	 * @return self
	 */
	public function set_menu_title( string $menu_title ): self {
		$this->menu_title = $menu_title;
		return $this;
	}

	/**
	 * Get page title.
	 *
	 * @return string
	 */
	public function get_page_title(): string {
		return $this->page_title;
	}

	/**
	 * Set page title.
	 *
	 * @param String $page_title The page_title.
	 *
	 * @return self
	 */
	public function set_page_title( string $page_title ): self {
		$this->page_title = $page_title;
		return $this;
	}
}
