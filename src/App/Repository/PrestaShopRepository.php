<?php

namespace Prestainfra\PsInstanceCreator\App\Repository;

final class PrestaShopRepository
{
    public function getDefaultEnvVars(): array
    {
        return [
            'GIT_REPOSITORY' => 'https://github.com/PrestaShop/PrestaShop.git',
            'GIT_BRANCH' => 'develop',
            'PS_STEP' => 'all',
            'PS_LANGUAGE' => 'fr',
            'PS_ALL_LANGUAGES' => '0',
            'PS_TIMEZONE' => 'Europe/Paris',
            'PS_BASE_URI' => '/',
            'PS_DOMAIN' => 'localhost',
            'PS_FIXTURES' => '1',
            'PS_REWRITE_ENGINE' => '1',
            'PS_DEV_MODE' => '1',
            'PS_HOST_MODE' => '0',
            'PS_DEMO_MODE' => '0',
            'PS_AUTO_INSTALL' => '1',
            'PS_LICENCE' => '0',
            'PS_ENABLE_SSL' => '0',
            'PS_DB_SERVER' => getenv('PS_DB_SERVER'),
            'PS_DB_USER' => getenv('PS_DB_SERVER'),
            'PS_DB_PASSWD' => getenv('PS_DB_PASSWD'),
            'PS_DB_NAME' => '',
            'PS_DB_CLEAR' => '0',
            'PS_DB_CREATE' => '1',
            'PS_DB_PREFIX' => 'dev_',
            'PS_DB_ENGINE' => 'InnoDB',
            'PS_DB_PORT' => '3306',
            'PS_SHOP_NAME' => 'PsLocalInfra',
            'PS_SHOP_ACTIVITY' => '0',
            'PS_SHOP_COUNTRY' => 'FR',
            'PS_SHOP_THEME' => '',
            'PS_ADMIN_FIRSTNAME' => 'AdminFirstName',
            'PS_ADMIN_LASTNAME' => 'AdminLastName',
            'PS_ADMIN_PASSWORD' => 'AdminPassWord',
            'PS_ADMIN_EMAIL' => 'admin@prestalocalinfra.fr',
        ];
    }
}