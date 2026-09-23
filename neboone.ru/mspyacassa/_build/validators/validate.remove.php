<?php

/** @var $modx modX */
if (!$modx = $object->xpdo AND !$object->xpdo instanceof modX) {
    return true;
}

/** @var $options */
switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
    case xPDOTransport::ACTION_UPGRADE:

        if ($modx->getOption('ms2_payment_ya_password', null)) {
            $path = MODX_CORE_PATH . 'components/minishop2/custom/payment/mspyacassa.class.php';
            /* does exist */
            if (file_exists($path)) {
                @ unlink($path);
                $modx->log(modX::LOG_LEVEL_ERROR, '[mspYaCassa] Remove old files');
            }

            $modx->removeCollection('msPayment', array('class:IN' => array('mspyacassa', 'mspyacassahold')));
        }

        break;

    case xPDOTransport::ACTION_UNINSTALL:
        break;
}

return true;