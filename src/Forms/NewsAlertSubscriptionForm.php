<?php

/*
 * Copyright (c) 2018 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0+
 */

namespace HeimrichHannot\ContaoNewsAlertBundle\Forms;

use Contao\Model;
use Contao\System;
use HeimrichHannot\ContaoNewsAlertBundle\Models\NewsalertRecipientsModel;
use HeimrichHannot\ContaoNewsAlertBundle\Modules\NewsalertSubscribeModule;
use HeimrichHannot\FormHybrid\Form;
use HeimrichHannot\StatusMessages\StatusMessage;

class NewsAlertSubscriptionForm extends Form
{
    protected $noEntity = true;
    protected $strMethod = FORMHYBRID_METHOD_POST;
    protected $strTemplate = 'formhybrid_default';
    protected $strTable = 'tl_newsalert_recipients';
    protected $strModelClass = NewsalertRecipientsModel::class;
    protected $isDuplicateEntityError = false;
    protected $strTopic;
    protected $overridableValues = [];

    public function __construct(NewsalertSubscribeModule $varConfig = null, int $intId = 0)
    {
        $this->overridableValues = $varConfig->getOverwriteableFieldValues();
        parent::__construct($varConfig, $intId);
    }


    protected function compile()
    {
        if (!$this->Template->message) {
            $this->Template->message = StatusMessage::generate($this->objModule->id);
        }
    }

    protected function onSubmitCallback(\DataContainer $dc)
    {
        $strEmail = $dc->getFieldValue('email');
        $strTopic = $dc->getFieldValue('topic');

        $objRecipients = NewsalertRecipientsModel::findBy(
            ['email = ?', 'topic = ?'],
            [$strEmail, $strTopic]
        );
        $confirmed = '';

        if (!$this->arrData['newsalertOptIn'])
        {
            $confirmed = '1';
        }

        if (!$objRecipients) {
            $this->objActiveRecord->email = $dc->getFieldValue('email');
            $this->objActiveRecord->topic = $dc->getFieldValue('topic');
            $this->objActiveRecord->dateAdded = time();
            $this->objActiveRecord->confirmed = $confirmed;
            $this->objActiveRecord->save();
        } else {
            while ($objRecipients->next()) {
                if (!$objRecipients->confirmed) {
                    $this->objActiveRecord = $objRecipients->current();

                    return;
                }
            }
            $this->isDuplicateEntityError = true;
        }
    }

    protected function createSubmission($strModelClass = null)
    {
        $strModelClass = $this->strModelClass;

        return parent::createSubmission($this->strModelClass);
    }

    /**
     * @param \DataContainer           $dc
     * @param NewsalertRecipientsModel $objModel
     */
    protected function afterActivationCallback(\DataContainer $dc, $objModel, $submissionData = null)
    {
        $this->setSessionVariables(true, $this->objActiveRecord->topic, 'in');
        StatusMessage::reset($dc->moduleId);
    }

    protected function afterUnsubscribeCallback(\DataContainer $dc)
    {
        $this->setSessionVariables(true, $this->objActiveRecord->topic, 'out');
        StatusMessage::reset($dc->moduleId);
    }

    protected function setSessionVariables($status, $topic, $opt)
    {
        $session = System::getContainer()->get('session');
        $session->set('contao_newsalert_success', $status);
        $session->set('contao_newsalert_topic', $topic);
        $session->set('contao_newsalert_opt', $opt);
    }

    protected function getFieldValue($strName)
    {
        if (array_key_exists($strName, $this->overridableValues))
        {
            return $this->overridableValues[$strName];
        }
        return parent::getFieldValue($strName);
    }

    /**
     * @return array
     */
    public function getOverridableFieldValues(): array
    {
        return $this->overridableValues;
    }

    /**
     * Add a default value
     *
     * Set value to null to delete a field/value pair
     *
     * @param string $name Field name
     * @param string|int|null $value Field value
     */
    public function setOverridableFieldValue(string $name, $value = null)
    {
        if (!$value)
        {
            unset($this->overridableValues[$name]);
        }
        $this->overridableValues[$name] = $value;
    }

    /**
     * Return the current recipient model
     *
     * @return NewsalertRecipientsModel|Model|null
     */
    protected function findOptInModelInstance()
    {
        $this->objActiveRecord->refresh();
        return $this->objActiveRecord;
    }

}
