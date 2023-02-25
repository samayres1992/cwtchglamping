<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitcc0768b79631018e68299018fb72638a
{
    public static $files = array (
        '0e6d7bf4a5811bfa5cf40c5ccd6fae6a' => __DIR__ . '/..' . '/symfony/polyfill-mbstring/bootstrap.php',
        'a4a119a56e50fbb293281d9a48007e0e' => __DIR__ . '/..' . '/symfony/polyfill-php80/bootstrap.php',
        '6e3fae29631ef280660b3cdad06f25a8' => __DIR__ . '/..' . '/symfony/deprecation-contracts/function.php',
        'a1105708a18b76903365ca1c4aa61b02' => __DIR__ . '/..' . '/symfony/translation/Resources/functions.php',
        '01d2e30272f02cf7b14a56bf3ce516f6' => __DIR__ . '/../..' . '/includes/functions.php',
        '3f33cbc765b9b42b4a69c662650298a0' => __DIR__ . '/../..' . '/includes/rnb-template-hooks.php',
        '249ffd6ec9dac9a14483446ee7dc8bdb' => __DIR__ . '/../..' . '/includes/rnb-template-functions.php',
        '65da335e6def2c49910fff3234ec0c06' => __DIR__ . '/../..' . '/includes/rnb-data-provider.php',
        'f96d2fe0fe14b747118c4f51f40c5086' => __DIR__ . '/../..' . '/includes/rnb-arrange-data.php',
        '1670bf9970926a3cf653d7f5c53bf3ff' => __DIR__ . '/../..' . '/includes/rnb-core-functions.php',
        'b5bd990a9adb6ae738c5f60ab7c83ec4' => __DIR__ . '/../..' . '/includes/rnb-global-functions.php',
        'cdccd9ddfb2d3142265fb114c9e0e80d' => __DIR__ . '/../..' . '/includes/rnb-quote-functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Polyfill\\Php80\\' => 23,
            'Symfony\\Polyfill\\Mbstring\\' => 26,
            'Symfony\\Contracts\\Translation\\' => 30,
            'Symfony\\Component\\Translation\\' => 30,
        ),
        'C' => 
        array (
            'Carbon\\' => 7,
        ),
        'B' => 
        array (
            'Bayfront\\ArrayHelpers\\' => 22,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Polyfill\\Php80\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-php80',
        ),
        'Symfony\\Polyfill\\Mbstring\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-mbstring',
        ),
        'Symfony\\Contracts\\Translation\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/translation-contracts',
        ),
        'Symfony\\Component\\Translation\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/translation',
        ),
        'Carbon\\' => 
        array (
            0 => __DIR__ . '/..' . '/nesbot/carbon/src/Carbon',
        ),
        'Bayfront\\ArrayHelpers\\' => 
        array (
            0 => __DIR__ . '/..' . '/bayfrontmedia/php-array-helpers/src',
        ),
    );

    public static $classMap = array (
        'Attribute' => __DIR__ . '/..' . '/symfony/polyfill-php80/Resources/stubs/Attribute.php',
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'PhpToken' => __DIR__ . '/..' . '/symfony/polyfill-php80/Resources/stubs/PhpToken.php',
        'REDQ_RnB\\ADMIN\\Admin_Page' => __DIR__ . '/../..' . '/includes/admin/class-rnb-admin-page.php',
        'REDQ_RnB\\ADMIN\\Generator' => __DIR__ . '/../..' . '/includes/admin/class-rnb-generator.php',
        'REDQ_RnB\\ADMIN\\Global_Settings' => __DIR__ . '/../..' . '/includes/admin/class-rnb-global-settings.php',
        'REDQ_RnB\\ADMIN\\Meta_Boxes' => __DIR__ . '/../..' . '/includes/admin/class-rnb-meta-boxes.php',
        'REDQ_RnB\\ADMIN\\Save_Meta' => __DIR__ . '/../..' . '/includes/admin/class-rnb-save-meta.php',
        'REDQ_RnB\\ADMIN\\Term_Meta_Icon' => __DIR__ . '/../..' . '/includes/admin/class-rnb-term-meta-icon.php',
        'REDQ_RnB\\ADMIN\\Term_Meta_Image' => __DIR__ . '/../..' . '/includes/admin/class-rnb-term-meta-image.php',
        'REDQ_RnB\\ADMIN\\Term_Meta_Select' => __DIR__ . '/../..' . '/includes/admin/class-rnb-term-meta-select.php',
        'REDQ_RnB\\ADMIN\\Term_Meta_Text' => __DIR__ . '/../..' . '/includes/admin/class-rnb-term-meta-text.php',
        'REDQ_RnB\\Ajax' => __DIR__ . '/../..' . '/includes/class-rnb-ajax.php',
        'REDQ_RnB\\Assets' => __DIR__ . '/../..' . '/includes/class-rnb-assets.php',
        'REDQ_RnB\\Booking_Manager' => __DIR__ . '/../..' . '/includes/class-booking-manager.php',
        'REDQ_RnB\\Control_Color' => __DIR__ . '/../..' . '/includes/class-rnb-color-control.php',
        'REDQ_RnB\\Handle_Cart' => __DIR__ . '/../..' . '/includes/class-rnb-product-cart.php',
        'REDQ_RnB\\Handle_Email' => __DIR__ . '/../..' . '/includes/class-rnb-email.php',
        'REDQ_RnB\\Handle_Order' => __DIR__ . '/../..' . '/includes/class-rnb-orders.php',
        'REDQ_RnB\\Handle_RFQ' => __DIR__ . '/../..' . '/includes/class-rnb-rfq.php',
        'REDQ_RnB\\INTEGRATION\\Full_Calendar' => __DIR__ . '/../..' . '/includes/integrations/class-full-calendar-integration.php',
        'REDQ_RnB\\INTEGRATION\\Google_Calendar' => __DIR__ . '/../..' . '/includes/integrations/class-google-calendar-integration.php',
        'REDQ_RnB\\Init' => __DIR__ . '/../..' . '/includes/class-rnb-init.php',
        'REDQ_RnB\\Installer' => __DIR__ . '/../..' . '/includes/class-rnb-Installer.php',
        'REDQ_RnB\\Modify_Hook' => __DIR__ . '/../..' . '/includes/rnb-modify-hook.php',
        'REDQ_RnB\\Tabs' => __DIR__ . '/../..' . '/includes/class-rnb-tabs.php',
        'REDQ_RnB\\Traits\\Admin_Trait' => __DIR__ . '/../..' . '/includes/Traits/Admin_Trait.php',
        'REDQ_RnB\\Traits\\Assets_Trait' => __DIR__ . '/../..' . '/includes/Traits/Assets_Trait.php',
        'REDQ_RnB\\Traits\\Cost_Trait' => __DIR__ . '/../..' . '/includes/Traits/Cost_Trait.php',
        'REDQ_RnB\\Traits\\Data_Trait' => __DIR__ . '/../..' . '/includes/Traits/Data_Trait.php',
        'REDQ_RnB\\Traits\\Error_Trait' => __DIR__ . '/../..' . '/includes/Traits/Error_Trait.php',
        'REDQ_RnB\\Traits\\Form_Trait' => __DIR__ . '/../..' . '/includes/Traits/Form_Trait.php',
        'REDQ_RnB\\Traits\\Legacy_Trait' => __DIR__ . '/../..' . '/includes/Traits/Legacy_Trait.php',
        'REDQ_RnB\\Traits\\Period_Trait' => __DIR__ . '/../..' . '/includes/Traits/Period_Trait.php',
        'Stringable' => __DIR__ . '/..' . '/symfony/polyfill-php80/Resources/stubs/Stringable.php',
        'UnhandledMatchError' => __DIR__ . '/..' . '/symfony/polyfill-php80/Resources/stubs/UnhandledMatchError.php',
        'ValueError' => __DIR__ . '/..' . '/symfony/polyfill-php80/Resources/stubs/ValueError.php',
        'WC_Product_Redq_Rental' => __DIR__ . '/../..' . '/includes/class-redq-product-redq_rental.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitcc0768b79631018e68299018fb72638a::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitcc0768b79631018e68299018fb72638a::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitcc0768b79631018e68299018fb72638a::$classMap;

        }, null, ClassLoader::class);
    }
}
