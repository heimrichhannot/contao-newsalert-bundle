<?php

/*
 * Copyright (c) 2017 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0+
 */

namespace HeimrichHannot\ContaoNewsAlertBundle\Components;

interface NewsTopicSourceInterface
{
    /**
     * Returns the alias of the topic source, e.g. category, tag, collection,...
     *
     * Can be the database column in tl_news.
     * Should be unique.
     *
     * @return string
     */
    public static function getAlias();

    /**
     * Return all available topics.
     *
     * @return array
     */
    public static function getTopics();

    /**
     * Returns topics by news item.
     *
     * @param $objItem \NewsModel
     *
     * @return array
     */
    public static function getTopicsByItem($objItem);
}
