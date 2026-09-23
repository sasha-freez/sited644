<?php

/** @var $modx modX */
if (!$modx = $object->xpdo AND !$object->xpdo instanceof modX) {
    return true;
}

/** @var $options */
switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
    case xPDOTransport::ACTION_UPGRADE:

        /** @var miniShop2 $miniShop2 */
        if (!$miniShop2 = $modx->getService('miniShop2')) {
            $modx->log(modX::LOG_LEVEL_ERROR, '[mspYaCassa] Could not load miniShop2');

            return false;
        }

        if (!property_exists($miniShop2, 'version') || version_compare($miniShop2->version, '2.4.0-beta2', '<')) {
            $modx->log(modX::LOG_LEVEL_ERROR, '[mspYaCassa] You need to upgrade miniShop2');

            return false;
        }

        break;

    case xPDOTransport::ACTION_UNINSTALL:
        break;
}

return true;