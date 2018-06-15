<?php
/**
 * Copyright (c) 2018 Heimrich & Hannot GmbH
 *
 * @author  Rico Kaltofen <r.kaltofen@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

namespace HeimrichHannot\ContaoNewsAlertBundle\Choice;


use Contao\System;
use HeimrichHannot\UtilsBundle\Choice\AbstractChoice;

class NewsTopicChoice extends AbstractChoice
{
    /**
     * @inheritDoc
     */
    protected function collect()
    {
        $topics = System::getContainer()->get('huh.newsalert.topiccollection')->getAllTopics();

        if(is_array($topics))
        {
            return $topics;
        }

        return [];
    }
}