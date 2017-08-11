<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2017 Heimrich & Hannot GmbH
 *
 * @author  Thomas Körner <t.koerner@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

namespace HeimrichHannot\ContaoNewsAlertBundle\Forms;

use HeimrichHannot\ContaoNewsAlertBundle\Models\NewsalertRecipientsModel;
use HeimrichHannot\FormHybrid\Form;

class NewsAlertSubscriptionForm extends Form
{
    protected $noEntity = true;
    protected $strMethod = FORMHYBRID_METHOD_POST;
    protected $strTemplate = 'formhybrid_default';
    protected $strTable = 'tl_newsalert_recipients';
    protected $strModelClass = NewsalertRecipientsModel::class;

    protected function compile()
    {

    }

    protected function onSubmitCallback(\DataContainer $dc)
    {
        $this->objActiveRecord->email = $dc->getFieldValue('email');
        $this->objActiveRecord->topic = $dc->getFieldValue('topic');
        $this->objActiveRecord->confirmed = 0;
        $this->objActiveRecord->save();
    }

    protected function createSubmission($strModelClass = null)
    {
        $strModelClass = $this->strModelClass;
        return parent::createSubmission($this->strModelClass);
    }


}