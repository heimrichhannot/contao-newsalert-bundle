<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2017 Heimrich & Hannot GmbH
 *
 * @author  Thomas Körner <t.koerner@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

namespace HeimrichHannot\ContaoNewsAlertBundle\Modules;

use HeimrichHannot\ContaoNewsAlertBundle\Forms\NewsAlertSubscriptionForm;
use HeimrichHannot\FormHybrid\FormConfiguration;
use HeimrichHannot\FormHybrid\FormHelper;
use HeimrichHannot\FormHybrid\FormSession;
use HeimrichHannot\FrontendEdit\ReaderForm;
use Patchwork\Utf8;

class NewsalertSubscribeModule extends \Module
{
    const MODULE_NAME = 'contao-newsalert-subscribe';
    const TABLE = 'tl_newsalert_recipients';

    protected $strTemplate = 'mod_newsalert_subscribe';
    protected $strWrapperId    = 'newsalert_subscribe_';
    protected $strWrapperClass = 'newsalert_subscribe';
    protected $arrSubmitCallbacks = [];

    /**
     * Parse the template
     *
     * @return string
     */
    public function generate()
    {
        if (TL_MODE == 'BE')
        {
            /** @var BackendTemplate|object $objTemplate */
            $objTemplate = new \BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### ' . Utf8::strtoupper($GLOBALS['TL_LANG']['FMD'][static::MODULE_NAME][0]) . ' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;
            return $objTemplate->parse();
        }

        \DataContainer::loadDataContainer(static::TABLE);
        \System::loadLanguageFile(static::TABLE);

        $this->strWrapperId .= $this->id;

        return parent::generate();
    }


    /**
     * Compile the current element
     */
    protected function compile()
    {
        $this->Template->headline     = $this->headline;
        $this->Template->hl           = $this->hl;
        $this->Template->wrapperClass = $this->strWrapperClass;
        $this->Template->wrapperId    = $this->strWrapperId;

        $this->Template->inColumn = $this->strColumn;

        if ($this->Template->headline == '')
        {
            $this->Template->headline = $this->headline;
        }

        if ($this->Template->hl == '')
        {
            $this->Template->hl = $this->hl;
        }

        if (!empty($this->classes) && is_array($this->classes))
        {
            $this->Template->class .= ' ' . implode(' ', $this->classes);
        }

        $this->formHybridDataContainer = static::TABLE;
        $this->formHybridAsync = "1";


//        'formHybridOptInSuccessMessage,formHybridOptInNotification,formHybridOptInConfirmedProperty'


        if ($this->newsalertOptIn && $this->newsalertOptIn == 1)
        {
            $this->formHybridAddOptIn = 1;
            $this->formHybridOptInConfirmedProperty = 'confirmed';
        }

        $this->formHybridEditable = ['email', 'topic'];

        $objForm = new NewsAlertSubscriptionForm($this);
        $this->Template->form = $objForm->generate();
    }
}