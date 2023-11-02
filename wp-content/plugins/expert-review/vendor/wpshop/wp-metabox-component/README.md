## Подключение метабоксов
Сначала нужно подключить библиотеку:
* добавляем в `composer.json`:
```json
    "repositories": [
        {
            "type": "vcs",
            "url": "git@github.com:zverush/wp-metabox-component.git"
        }
    ],
```
* и выполняем команду
```sh
composer require wpshop/wp-metabox-component
```
После этого надо зарегистрировать необходимые зависимости компонента, для этого идем в файл `core/container.php` (если это тема) или в `config/container.php` (если это плагин)
и добавляем строчку
```php
//...
$container->register( new \Wpshop\MetaBox\MetaBoxManagerProvider() );
//...
```

Далее в файле нужно подключить компонент 
* если это тема, то в файле`core/init.php`:
```php
//...
theme_container()->get( \Wpshop\MetaBox\MetaBoxManager::class )->init();
//...
```
либо в основном файле плагина:
```php
PluginContainer::get( \Wpshop\MetaBox\MetaBoxManager::class )->init();
```
Теперь наша библиотеку готова к использованию.

Чтоб добавить метабоксы нужно создать класс, который будет реализовывать интерфейс `Wpshop\MetaBox\Provider\MetaBoxProviderInterface`

Его также необходимо зарегистрировать в контейнере
```php
        MetaBoxProvider::class       => function ( $c ) {
            return new MetaBoxProvider( $c[ SimpleMetaBoxContainer::class ] );
        },
```
И прописать в конфиге, чтоб метабокс менеджер смог его найти:
```php
    //...
    'metabox_providers' => [
        MetaBoxProvider::class,
    ],
    //...
```

#### Пример:
```php
<?php

namespace Wpshop\TheTheme;

use Wpshop\MetaBox\Form\Element\Button;
use Wpshop\MetaBox\Form\Element\Checkbox;
use Wpshop\MetaBox\Form\Element\ColorPicker;
use Wpshop\MetaBox\Form\Element\Email;
use Wpshop\MetaBox\Form\Element\MediaFile;
use Wpshop\MetaBox\Form\Element\MultiCheckbox;
use Wpshop\MetaBox\Form\Element\Number;
use Wpshop\MetaBox\Form\Element\Select;
use Wpshop\MetaBox\Form\Element\Text;
use Wpshop\MetaBox\Form\Element\Textarea;
use Wpshop\MetaBox\Form\Render\FormColorPicker;
use Wpshop\MetaBox\Form\Render\FormMediaFile;
use Wpshop\MetaBox\MetaBoxContainer\SimpleMetaBoxContainer;
use Wpshop\MetaBox\MetaBoxManager;
use Wpshop\MetaBox\Provider\MetaBoxProviderInterface;
use Wpshop\MetaBox\Provider\ScriptProviderInterface;
use Wpshop\MetaBox\Provider\StyleProviderInterface;

class MetaBoxProvider implements
    MetaBoxProviderInterface,
    ScriptProviderInterface,
    StyleProviderInterface {

    const RESOURCE_VERSION = false;

    /**
     * @var SimpleMetaBoxContainer
     */
    protected $metaBoxPrototype;

    /**
     * MetaBoxProvider constructor.
     *
     * @param SimpleMetaBoxContainer $metaBoxPrototype
     */
    public function __construct( SimpleMetaBoxContainer $metaBoxPrototype ) {
        $this->metaBoxPrototype = $metaBoxPrototype;
    }

    /**
     * @param MetaBoxManager $manager
     *
     * @return void
     */
    public function initMetaBoxes( MetaBoxManager $manager ) {
        $manager->addMetaBox( $box = clone $this->metaBoxPrototype );
        $box
            ->setId( 'meta_box_1' )
            ->setTitle( 'Test Meta Box' )
            ->setScreen( 'page' )
        ;

        $box->addElement( $element = new Text( 'el_1' ) );
        $element
            ->setLabel( 'Text Input' )
            ->setTitle( 'Text Input' )
            ->setValue( 'default value' )
            ->setDescription( 'description of text input' )
        ;

        $box->addElement( $element = new Textarea( 'textarea_1' ) );
        $element
            ->setTitle( 'Textarea' )
            ->setLabel( 'Textarea' )
            ->setAttribute( 'style', 'width:100%' )
            ->setAttribute( 'rows', 5 )
            ->setDescription( 'Description of textarea' )
        ;

        $box->addElement( $element = new Checkbox( 'checkbox_1' ) );
        $element
            ->setLabel( 'Checkbox 1' )
            ->setTitle( 'Checkbox Title' )
            ->setDescription( 'checkbox description' )
        ;

        $box->addElement( $element = new MultiCheckbox( 'multi_checkbox_1' ) );
        $element
            ->setLabel( 'Multi Checkbox' )
            ->setDescription( 'description of multi checkbox' )
            ->setValueOptions( [
                'apple'  => 'Apple',
                'orange' => 'Orange',
                'lemon'  => 'Lemon',
            ] )
        ;

        $box->addElement( $element = new Number( 'number_1' ) );
        $element
            ->setLabel( 'Number' )
            ->setDescription( 'description of number' )
            ->setValue( 15 )
            ->setMin( 10 )
            ->setMax( 20 )
            ->setStep( 5 )
            ->setAfterFieldInfo('px')
        ;

        $box->addElement( $element = new Email( 'email_1' ) );
        $element
            ->setLabel( 'Email' )
            ->setDescription( 'description of email' )
        ;

        $box->addElement( $element = new Select( 'select_1' ) );
        $element
            ->setLabel( 'Select' )
            ->setDescription( 'description of select' )
            ->setEmptyOption( '-- select an item --' )
            ->setValueOptions( [
                'one' => 'One',
                'two' => 'Two',
            ] )
        ;

        $box->addElement( $element = new Select( 'select_2' ) );
        $element
            ->setLabel( 'Select With Option Group' )
            ->setDescription( 'description of select option groups' )
            ->setValueOptions( [
                [
                    'label'   => 'Group 1',
                    'options' => [
                        'one' => 'One',
                        'two' => 'Two',
                    ],
                ],
                [
                    'label'   => 'Group 2',
                    'options' => [
                        'one' => 'One',
                        'two' => 'Two',
                    ],
                ],
            ] )
        ;

        $box->addElement( $element = new Button( 'button' ) );
        $element
            ->setLabel( 'Simple button' )
            ->setTitle( 'Button Content' )
            ->setDescription( 'description of button' )
        ;

        $box->addElement( $element = new ColorPicker( 'color_1' ) );
        $element
            ->setLabel( 'Color 1' )
            ->setDescription( 'description of color' )
        ;

        $box->addElement( $element = new MediaFile( 'media_file' ) );
        $element
            ->setLabel( 'Media File' )
            ->setTitle( 'File' )
            ->setDescription( 'description of media file' )
        ;
    }

    /**
     * @inheritDoc
     */
    public function enqueueScripts() {
        add_action( 'current_screen', function () {
            if ( \get_current_screen()->post_type !== 'page' ) {
                return;
            }
            $this->_enqueueScripts();
        } );
    }

    protected function _enqueueScripts() {
        add_action( 'admin_enqueue_scripts', function () {
            wp_enqueue_script( THEME_NAME . '-admin-scripts', get_template_directory_uri() . '/resources/js/theme/admin.js', [ 'jquery' ], self::RESOURCE_VERSION, true );

            // color picker deps
            wp_enqueue_script( 'wp-color-picker', 'jquery' );
            FormColorPicker::registerInlineScript( 'wp-color-picker' );

            // media file deps
            wp_enqueue_media();
            FormMediaFile::registerInlineScript();
        } );
    }

    public function enqueueStyles() {
        add_action( 'current_screen', function () {
            if ( \get_current_screen()->post_type !== 'page' ) {
                return;
            }
            $this->_enqueueStyles();
        } );
    }

    protected function _enqueueStyles() {
        // color picker deps
        wp_enqueue_style( 'wp-color-picker' );
    }
}
```
В приведенном выше примере испльзуется продвинутая фича - реализован интерфейс `Wpshop\MetaBox\Provider\ScriptProviderInterface`.
Это позволяет нам добавлять необходимые для работы метабоксов собственные скрипты. 
Таким же способом можно добавить собсвенные стили реализуя интерфейс `Wpshop\MetaBox\Provider\StyleProviderInterface`
