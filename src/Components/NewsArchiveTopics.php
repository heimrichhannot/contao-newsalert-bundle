<?php

/*
 * Copyright (c) 2018 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0+
 */

namespace HeimrichHannot\ContaoNewsAlertBundle\Components;

use Contao\NewsArchiveModel;

class NewsArchiveTopics implements NewsTopicSourceInterface
{
    /**
     * Returns the alias of the topic source, e.g. category, tag, collection,...
     *
     * Can be the database column in tl_news.
     * Should be unique.
     *
     * @return string
     */
    public static function getAlias(): string
    {
        return 'archive';
    }

    /**
     * Return all available topics.
     *
     * @return array
     */
    public static function getTopics(): array
    {
        $objArchives = NewsArchiveModel::findAll();
        $arrArchives = [];
        while ($objArchives->next()) {
            $arrArchives[] = $objArchives->title;
        }

        return $arrArchives;
    }

    /**
     * Returns topics by news item.
     *
     * @param $objItem NewsModel
     *
     * @return array
     */
    public static function getTopicsByItem($objItem): array
    {
        $strArchive = NewsArchiveModel::findById($objItem->pid)->title;

        return [$strArchive];
    }
}
