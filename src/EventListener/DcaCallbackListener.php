<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2018 Heimrich & Hannot GmbH
 *
 * @author  Thomas Körner <t.koerner@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */


namespace HeimrichHannot\ContaoNewsAlertBundle\EventListener;


use Contao\Database;
use Contao\DC_Table;
use HeimrichHannot\FormHybrid\Form;

class DcaCallbackListener
{
    public function addNewsalertRecipient(DC_Table &$dc)
    {
        if ($dc->activeRecord->optOutToken)
        {
            return;
        }
        $set['optOutToken'] =  Form::generateUniqueToken();
        Database::getInstance()->prepare("UPDATE tl_newsalert_recipients %s WHERE id=?")->set($set)->execute($dc->id);
    }
}