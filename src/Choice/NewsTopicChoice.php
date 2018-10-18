<?php

/*
 * Copyright (c) 2018 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0+
 */

namespace HeimrichHannot\ContaoNewsAlertBundle\Choice;

use Contao\System;
use HeimrichHannot\UtilsBundle\Choice\AbstractChoice;

class NewsTopicChoice extends AbstractChoice
{
    /**
     * {@inheritdoc}
     */
    protected function collect()
    {
        $topics = System::getContainer()->get('huh.newsalert.topiccollection')->getAllTopics();

        if (is_array($topics)) {
            return $topics;
        }

        return [];
    }
}
