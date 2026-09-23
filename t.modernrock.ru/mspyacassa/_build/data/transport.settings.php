<?php

$settings = array();

$tmp = array(

    'process_receipt' => array(
        'xtype' => 'combo-boolean',
        'value' => true,
        'area'  => 'mspyacassa_main',
    ),
    'receipt_tax' => array(
        'xtype' => 'numberfield',
        'value' => '1',
        'area'  => 'mspyacassa_main',
    ),

    'payment_url'        => array(
        'xtype' => 'textfield',
        'value' => 'https://money.yandex.ru/eshop.xml',
        'area'  => 'mspyacassa_main',
    ),
    'payment_test_url'   => array(
        'xtype' => 'textfield',
        'value' => 'https://demomoney.yandex.ru/eshop.xml',
        'area'  => 'mspyacassa_main',
    ),
    'operation_url'      => array(
        'xtype' => 'textfield',
        'value' => 'https://penelope.yamoney.ru:443/webservice/mws/api/',
        'area'  => 'mspyacassa_main',
    ),
    'operation_test_url' => array(
        'xtype' => 'textfield',
        'value' => 'https://penelope-demo.yamoney.ru:8083/webservice/mws/api/',
        'area'  => 'mspyacassa_main',
    ),

    'payment_password'        => array(
        'xtype' => 'textfield',
        'value' => '',
        'area'  => 'mspyacassa_main',
    ),
    'payment_success_id'      => array(
        'xtype' => 'numberfield',
        'value' => 1,
        'area'  => 'mspyacassa_main',
    ),
    'payment_failure_id'      => array(
        'xtype' => 'numberfield',
        'value' => 1,
        'area'  => 'mspyacassa_main',
    ),
    'payment_default_id'      => array(
        'xtype' => 'numberfield',
        'value' => 1,
        'area'  => 'mspyacassa_main',
    ),
    'payment_test_mode'       => array(
        'xtype' => 'combo-boolean',
        'value' => true,
        'area'  => 'mspyacassa_main',
    ),
    'payment_show_log'        => array(
        'xtype' => 'combo-boolean',
        'value' => false,
        'area'  => 'mspyacassa_main',
    ),
    'payment_check_hash'      => array(
        'xtype' => 'combo-boolean',
        'value' => true,
        'area'  => 'mspyacassa_main',
    ),

    'payment_shop_id' => array(
        'xtype' => 'textfield',
        'value' => '',
        'area'  => 'mspyacassa_base',
    ),
    'payment_sc_id'   => array(
        'xtype' => 'textfield',
        'value' => '',
        'area'  => 'mspyacassa_base',
    ),


    'hold_payment_shop_id'         => array(
        'xtype' => 'textfield',
        'value' => '',
        'area'  => 'mspyacassa_hold',
    ),
    'hold_payment_sc_id'           => array(
        'xtype' => 'textfield',
        'value' => '',
        'area'  => 'mspyacassa_hold',
    ),
    'hold_mws_cert_password' => array(
        'xtype' => 'textfield',
        'value' => '',
        'area'  => 'mspyacassa_hold',
    ),
    'hold_mws_cert'          => array(
        'xtype' => 'textfield',
        'value' => '{core_path}components/mspyacassa/elements/mws/shop.cer',
        'area'  => 'mspyacassa_hold',
    ),
    'hold_mws_private_key'   => array(
        'xtype' => 'textfield',
        'value' => '{core_path}components/mspyacassa/elements/mws/private.key',
        'area'  => 'mspyacassa_hold',
    ),


);

foreach ($tmp as $k => $v) {
    /* @var modSystemSetting $setting */
    $setting = $modx->newObject('modSystemSetting');
    $setting->fromArray(array_merge(
        array(
            'key'       => 'mspyacassa_' . $k,
            'namespace' => PKG_NAME_LOWER,
        ), $v
    ), '', true, true);

    $settings[] = $setting;
}

unset($tmp);
return $settings;
