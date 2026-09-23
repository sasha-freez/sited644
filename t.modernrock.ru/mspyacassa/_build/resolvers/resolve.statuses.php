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
            $modx->log(modX::LOG_LEVEL_ERROR, '[mspYaCassa] Could not load miniShop2 class!');

            return false;
        }

        $lang = $modx->getOption('manager_language') == 'en' ? 1 : 0;

        /* msOrderStatus */
        $statuses = array(
            '21' => array(
                'name'            => !$lang ? 'На удержании' : 'On hold',
                'description'     => 'on hold',
                'color'           => 'FF9900',
                'email_user'      => 1,
                'email_manager'   => 1,
                'subject_user'    => '[[%mspyacassa_email_subject_onhold_user]]',
                'subject_manager' => '[[%ms2_email_subject_new_manager]]',
                'body_user'       => 'tpl.msEmail.onhold.user',
                'body_manager'    => 'tpl.msEmail.onhold.manager',
                'final'           => 0
            ),
            '22' => array(
                'name'            => !$lang ? 'К списанию' : 'Write off',
                'description'     => 'write off',
                'color'           => 'FF0000',
                'email_user'      => 0,
                'email_manager'   => 0,
                'subject_user'    => '',
                'subject_manager' => '',
                'body_user'       => '',
                'body_manager'    => '',
                'final'           => 0
            ),
            '24' => array(
                'name'            => !$lang ? 'К отмене' : 'To cancel',
                'description'     => 'to cancel',
                'color'           => 'FF6600',
                'email_user'      => 0,
                'email_manager'   => 0,
                'subject_user'    => '',
                'subject_manager' => '',
                'body_user'       => '',
                'body_manager'    => '',
                'final'           => 0
            )
        );

        foreach ($statuses as $id => $v) {

            if (!$status = $modx->getCount('msOrderStatus', array('description' => $v['description']))) {
                $status = $modx->newObject('msOrderStatus', array_merge(array(
                    'editable' => 1,
                    'active'   => 0,
                    'fixed'    => 1,
                    'rank'     => $modx->getCount('msOrderStatus')
                ), $v));
                $status->set('id', $id);
                /* @var modChunk $chunk */
                if (!empty($v['body_user'])) {
                    if ($chunk = $modx->getObject('modChunk', array('name' => $v['body_user']))) {
                        $status->set('body_user', $chunk->get('id'));
                    }
                }
                if (!empty($v['body_manager'])) {
                    if ($chunk = $modx->getObject('modChunk', array('name' => $v['body_manager']))) {
                        $status->set('body_manager', $chunk->get('id'));
                    }
                }
                $status->save();
            }
        }


        $ids = array(1, 21, 22, 2, 3, 24, 4);
        $table = $modx->getTableName('msOrderStatus');

        $sql = "SELECT id FROM {$table} WHERE ";
        $sql .= " (id IN (" . implode(',', $ids) . ") )";
        $sql .= " ORDER BY FIELD(id, " . implode(',', $ids) . ") ASC ";
        if ($stmt = $modx->prepare($sql) AND $stmt->execute()) {
            $ids = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
            $sql = '';
            foreach ($ids as $k => $id) {
                $sql .= "UPDATE {$table} SET `rank` = '{$k}' WHERE (`id` = {$id});";
            }
            $sql .= "ALTER TABLE {$table} ORDER BY `rank` ASC;";
            $modx->exec($sql);
        }

        break;
    case
    xPDOTransport::ACTION_UNINSTALL:
        break;
}

return true;