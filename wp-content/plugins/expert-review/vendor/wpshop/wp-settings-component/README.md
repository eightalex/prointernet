## Example of a provider

```php

namespace BlankAdvanced\PluginNamespace;

use Wpshop\SettingApi\OptionField\Checkbox;
use Wpshop\SettingApi\OptionField\Color;
use Wpshop\SettingApi\OptionField\Editor;
use Wpshop\SettingApi\OptionField\Email;
use Wpshop\SettingApi\OptionField\File;
use Wpshop\SettingApi\OptionField\MultiCheckbox;
use Wpshop\SettingApi\OptionField\MultiSelect;
use Wpshop\SettingApi\OptionField\Number;
use Wpshop\SettingApi\OptionField\Password;
use Wpshop\SettingApi\OptionField\Radio;
use Wpshop\SettingApi\OptionField\RawHtml;
use Wpshop\SettingApi\OptionField\Select;
use Wpshop\SettingApi\OptionField\Text;
use Wpshop\SettingApi\OptionField\Textarea;
use Wpshop\SettingApi\OptionStorage\DefaultOptionStorage;
use Wpshop\SettingApi\Section\Section;
use Wpshop\SettingApi\SettingsProviderInterface;
use Wpshop\SettingApi\SettingsPage\TabSettingsPage;

class SettingsProvider implements SettingsProviderInterface {

	const SECTION_BASE     = 'blank_plugin_base';
	const SECTION_ADVANCED = 'blank_plugin_advanced';

	/**
	 * @inheritDoc
	 */
	public function getSettingsSubmenu() {

		$baseOptions = PluginContainer::get( PluginOptions::class );

		$submenu = new TabSettingsPage(
			__( 'Blank Plugin Settings', Plugin::TEXT_DOMAIN ),
			__( 'Blank Plugin', Plugin::TEXT_DOMAIN ),
			'delete_posts',
			'blank-plugin-setting'
		);

		$submenu->addSection( $section = new Section(
			self::SECTION_BASE,
			__( 'Basic Settings', Plugin::TEXT_DOMAIN ),
			PluginOptions::class
		) );

		$section
//			->setDescription( __( 'Description of Basic Settings', Plugin::TEXT_DOMAIN ) )
			->setRenderCallback( function ( $args ) {
				printf( '<hr><p>%s</p><hr>', __( 'Description of Basic Settings', Plugin::TEXT_DOMAIN ) );
			} );

		$section->addField( $field = new Text( 'license' ) );
		$field
			->setLabel( __( 'License', Plugin::TEXT_DOMAIN ) )
			->setPlaceholder( $baseOptions->license ? '*****' : __( 'enter license key', Plugin::TEXT_DOMAIN ) )
			->setValue( $baseOptions->show_license_key ? null : '' )
			->setSanitizeCallback( function ( $value ) use ( $baseOptions ) {
				if ( $value && current_user_can( 'administrator' ) ) {
					$baseOptions->license = $value;
					$baseOptions->save();
				}

				return null;
			} )
		;

		$section->addField( $field = new Checkbox( 'show_license_key' ) );
		$field
			->setLabel( __( 'Show License', Plugin::TEXT_DOMAIN ) )
			->setDescription( __( 'Show license key in input', Plugin::TEXT_DOMAIN ) )
			->setEnabled( current_user_can( 'administrator' ) )
		;

		$section->addField( $field = new RawHtml( 'info' ) );
		$field->setRenderCallback( function () {
			echo '<button class="button button-primary">Произвольный конктен</button>';
		} );

		$section->addField( $field = new Text( 'text_val' ) );
		$field
			->setLabel( __( 'Text Input', Plugin::TEXT_DOMAIN ) )
			->setDescription( __( 'Text input description', Plugin::TEXT_DOMAIN ) )
			->setDefault( 'Title' )
			->setPlaceholder( 'placeholder' )
			->setSanitizeCallback( 'intval' )
		;

		$section->addField( $field = new Password( 'password' ) );
		$field
			->setLabel( __( 'Password', Plugin::TEXT_DOMAIN ) )
			->setDescription( __( 'Password description', Plugin::TEXT_DOMAIN ) )
			->setPlaceholder( 'placeholder' )
		;

		$section->addField( $field = new Number( 'number' ) );
		$field
			->setLabel( __( 'Number', Plugin::TEXT_DOMAIN ) )
			->setDescription( __( 'Number description', Plugin::TEXT_DOMAIN ) )
			->setPlaceholder( '100' )
		;

		$section->addField( $field = new Email( 'email' ) );
		$field
			->setLabel( __( 'Email', Plugin::TEXT_DOMAIN ) )
			->setDescription( __( 'Email description', Plugin::TEXT_DOMAIN ) )
			->setSanitizeCallback( 'sanitize_email' )
		;

		$section->addField( $field = new Textarea( 'textarea' ) );
		$field
			->setLabel( __( 'Textarea', Plugin::TEXT_DOMAIN ) )
			->setDescription( __( 'Textarea description', Plugin::TEXT_DOMAIN ) )
		;

		$section->addField( $field = new Checkbox( 'check' ) );
		$field
			->setLabel( __( 'Checkbox', Plugin::TEXT_DOMAIN ) )
			->setDescription( __( 'Checkbox description', Plugin::TEXT_DOMAIN ) )
		;

		$section->addField( $field = new MultiCheckbox( 'multi_check' ) );
		$field
			->setLabel( __( 'Multi Checkbox', Plugin::TEXT_DOMAIN ) )
			->setDescription( __( 'Multi Checkbox description', Plugin::TEXT_DOMAIN ) )
			->setOptions( [
				'one' => 'One',
				'two' => 'Two',
			] )
		;

		$section->addField( $field = new Radio( 'radio' ) );
		$field
			->setLabel( __( 'Radio', Plugin::TEXT_DOMAIN ) )
			->setDescription( __( 'Radio description', Plugin::TEXT_DOMAIN ) )
			->setOptions( [
				'one' => 'One',
				'two' => 'Two',
			] )
		;

		$section->addField( $field = new Select( 'select' ) );
		$field
			->setLabel( __( 'Simple Select', Plugin::TEXT_DOMAIN ) )
			->setDescription( __( 'Simple select description', Plugin::TEXT_DOMAIN ) )
			->setEmptyOption( __( '-- select value --', Plugin::TEXT_DOMAIN ) )
			->setOptions( [
				'one' => 'One',
				'two' => 'Two',
			] )
		;

		$section->addField( $field = new Select( 'select_opt_group' ) );
		$field
			->setLabel( __( 'Select With Opt Groups', Plugin::TEXT_DOMAIN ) )
			->setDescription( __( 'Select option groups description', Plugin::TEXT_DOMAIN ) )
			->setOptions( [
				'group_1' => [
					'label'   => 'Group One',
					'options' => [
						'one' => 'One',
						'two' => 'Two',
					],
				],
				'group_2' => [
					'label'   => 'Group Two',
					'options' => [
						'three' => 'Three',
						'four'  => 'Four',
					],
				],
			] )
		;

		$section->addField( $field = new MultiSelect( 'multiselect_opt_group' ) );
		$field
			->setLabel( __( 'Multi Select With Opt Groups', Plugin::TEXT_DOMAIN ) )
			->setDescription( __( 'Multiselect option groups description', Plugin::TEXT_DOMAIN ) )
			->setOptions( [
				'group_1' => [
					'label'   => 'Multi Select Group One',
					'options' => [
						'one' => 'One',
						'two' => 'Two',
					],
				],
				'group_2' => [
					'label'   => 'Multi Select Group Two',
					'options' => [
						'three' => 'Three',
						'four'  => 'Four',
						'five'  => 'Five',
					],
				],
			] )
		;


		$submenu->addSection( $section = new Section(
			self::SECTION_ADVANCED,
			__( 'Advanced Settings', Plugin::TEXT_DOMAIN ),
			new DefaultOptionStorage( self::SECTION_ADVANCED )
		) );
		$section->setDescription( __( 'Description of Additional Settings', Plugin::TEXT_DOMAIN ) );

		$section->addField( $field = new Color( 'color' ) );
		$field
			->setLabel( __( 'Color', Plugin::TEXT_DOMAIN ) )
			->setDescription( __( 'Color description', Plugin::TEXT_DOMAIN ) )
			->setDefault( '#ffffff' )
		;

		$section->addField( $field = new Editor( 'editor' ) );
		$field
			->setLabel( __( 'Editor', Plugin::TEXT_DOMAIN ) )
			->setDescription( __( 'Editor description', Plugin::TEXT_DOMAIN ) )
		;

		$section->addField( $field = new File( 'file' ) );
		$field
			->setLabel( __( 'File', Plugin::TEXT_DOMAIN ) )
			->setDescription( __( 'File description', Plugin::TEXT_DOMAIN ) )
			->setButtonLabel( __( 'Choose an Image', Plugin::TEXT_DOMAIN ) )
		;

		return $submenu;
	}
}


```
