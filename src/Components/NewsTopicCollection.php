<?php

/*
 * Copyright (c) 2018 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0+
 */

namespace HeimrichHannot\ContaoNewsAlertBundle\Components;

use Contao\NewsModel;
use HeimrichHannot\NewsBundle\News;

class NewsTopicCollection
{
    /**
     * @var NewsTopicSourceInterface[]
     */
    private $topicSources = [];
    /**
     * @var array
     */
    private $topicCache;

    /**
     * @param NewsTopicSourceInterface $topicSource
     */
    public function addTopicSource(NewsTopicSourceInterface $topicSource)
    {
        $this->topicSources[$topicSource->getAlias()] = $topicSource;
        $this->topicCache = [];
    }

    /**
     * Return topic source by alias.
     *
     * @param string $strAlias
     *
     * @return NewsTopicSourceInterface|null
     */
    public function getTopicSource(string $strAlias)
    {
        if (isset($this->topicSources[$strAlias])) {
            return $this->topicSources[$strAlias];
        }

        return null;
    }

    /**
     * Return all topics by news item.
     *
     * @param NewsModel $objItem
     * @param array|null $allowedSources Array of source aliases or null
     *
     * @return array
     */
    public function getTopicsByItem(NewsModel $objItem, array $allowedSources = null)
    {
        $arrTopics = [];
        /*
         * @var NewsTopicSourceInterface $source
         */
        foreach ($this->topicSources as $alias => $source) {
            if ($allowedSources && !in_array($alias, $allowedSources))
            {
                continue;
            }
            $arrTopics = array_merge($arrTopics, $source->getTopicsByItem($objItem));
        }
        $arrTopics = array_unique($arrTopics, SORT_REGULAR);

        return $arrTopics;
    }

    public function getTopicsBySource(string $alias)
    {
        $source = $this->getTopicSource($alias);
        if (!$source)
        {
            return [];
        }
        return $source->getTopics();
    }

    public function getAllSourcesList()
    {
        return array_keys($this->topicSources);
    }

    /**
     * Returns a list of all available topics.
     *
     * @return array
     */
    public function getAllTopics()
    {
        if (empty($this->topicCache)) {
            $this->createTopicCache();
        }
        return $this->topicCache;
    }

    protected function createTopicCache()
    {
        $topics = [];
        /*
         * @var NewsTopicSourceInterface
         */
        foreach ($this->topicSources as $source) {
            $srcTopics = $source->getTopics();
            $topics = array_merge($srcTopics, $topics);
        }
        $topics = array_unique($topics, SORT_REGULAR);
        sort($topics);
        $this->topicCache = $topics;
    }
}
