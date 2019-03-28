<?php

/*
 * Copyright (c) 2018 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0+
 */

namespace HeimrichHannot\ContaoNewsAlertBundle\EventListener;

use Contao\Database;
use Contao\DataContainer;
use HeimrichHannot\FormHybrid\DC_Hybrid;
use HeimrichHannot\FormHybrid\Form;

class DcaCallbackListener
{
    public function addNewsalertRecipient(DataContainer $dc)
    {
        /* @var $dc DC_Hybrid */
        if ($dc->activeRecord->optOutToken) {
            return;
        }
        $set['optOutToken'] = Form::generateUniqueToken();
        Database::getInstance()->prepare('UPDATE tl_newsalert_recipients %s WHERE id=?')->set($set)->execute($dc->id);
        $dc->setNoEntity(false);
    }
}
