<?php

/** @var $modx modX */
if (!$modx = $object->xpdo AND !$object->xpdo instanceof modX) {
    return true;
}

$class = 'mspYaCassaPaymentHandler';
$classHold = 'mspYaCassaPaymentHoldHandler';

/** @var $options */
switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
    case xPDOTransport::ACTION_UPGRADE:

        /** @var miniShop2 $miniShop2 */
        if (!$miniShop2 = $modx->getService('miniShop2')) {
            $modx->log(modX::LOG_LEVEL_ERROR, '[mspYaCassa] Could not load miniShop2 class!');

            return false;
        }
        
        $miniShop2->addService('payment', $class,
            '{core_path}components/mspyacassa/controllers/mspyacassapaymenthandler.class.php');
        $miniShop2->addService('payment', $classHold,
            '{core_path}components/mspyacassa/controllers/mspyacassapaymentholdhandler.class.php');

        $payments = array(
            array(
                'name'       => 'Оплата через Яндекс',
                'properties' => array(
                    'payment.type' => ''
                ),
                'class'      => $class,
            ),
            array(
                'name'       => 'Банковские карты VISA, MasterCard, Maestro',
                'properties' => array(
                    'payment.type' => 'AC'
                ),
                'class'      => $class,
            ),
            array(
                'name'       => 'Альфаклик',
                'properties' => array(
                    'payment.type' => 'AB'
                ),
                'class'      => $class,
            ),
            array(
                'name'       => 'Промсвязьбанк',
                'properties' => array(
                    'payment.type' => 'PB'
                ),
                'class'      => $class,
            ),
            array(
                'name'       => 'Сбербанк Онлайн',
                'properties' => array(
                    'payment.type' => 'SB'
                ),
                'class'      => $class,
            ),
            array(
                'name'       => 'Яндекс.Деньги',
                'properties' => array(
                    'payment.type' => 'PC'
                ),
                'class'      => $class,
            ),
            array(
                'name'       => 'QIWI Wallet',
                'properties' => array(
                    'payment.type' => 'QW'
                ),
                'class'      => $class,
            ),
            array(
                'name'       => 'WebMoney',
                'properties' => array(
                    'payment.type' => 'WM'
                ),
                'class'      => $class,
            ),
            array(
                'name'       => 'Наличными в кассах и терминалах партнеров',
                'properties' => array(
                    'payment.type' => 'GP'
                ),
                'class'      => $class,
            ),
            array(
                'name'       => 'Оплата со счета мобильного телефона',
                'properties' => array(
                    'payment.type' => 'MC'
                ),
                'class'      => $class,
            ),

            array(
                'name'       => 'Банковские карты VISA, MasterCard, Maestro (холдирование)',
                'properties' => array(
                    'payment.type' => 'AC'
                ),
                'class'      => $classHold,
            ),

        );

        foreach ($payments as $row) {
            $properties = json_encode($row['properties'], JSON_UNESCAPED_UNICODE);

            /** @var xPDOObject|msPayment $payment */
            if (!$payment = $modx->getObject('msPayment', array(
                'class'      => $row['class'],
                'properties' => $properties
            ))
            ) {
                $payment = $modx->newObject('msPayment');
                $payment->fromArray(array_merge(array(
                    'properties' => $properties,
                    'active'     => 0
                ), $row));
                $payment->save();
            }
        }


        
        break;

    case xPDOTransport::ACTION_UNINSTALL:

        /** @var miniShop2 $miniShop2 */
        if (!$miniShop2 = $modx->getService('miniShop2')) {
            $modx->log(modX::LOG_LEVEL_ERROR, '[mspYaCassa] Could not load miniShop2 class!');

            return false;
        }
        $miniShop2->removeService('payment', $class);
        $modx->removeCollection('msPayment', array('class' => $class));

        $miniShop2->removeService('payment', $classHold);
        $modx->removeCollection('msPayment', array('class' => $classHold));

        break;

}
return true;

