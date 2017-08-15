<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2017 Heimrich & Hannot GmbH
 *
 * @author  Thomas Körner <t.koerner@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */


namespace HeimrichHannot\ContaoNewsAlertBundle\Components;


use Contao\NewsModel;
use HeimrichHannot\NewsBundle\News;

class NewsTopicCollection
{
    private $topicSources = [];
    private $topicCache;

    protected function createTopicCache ()
    {
        $topics = [];
        /**
         * @var $source NewsTopicSourceInterface
         */
        foreach ($this->topicSources as $source)
        {
            $topics = array_merge($source->getTopics(), $topics);
        }
        $topics = array_unique($topics, SORT_REGULAR);
        sort($topics);
        $this->topicCache = $topics;
    }

    /**
     * @param NewsTopicSourceInterface $topicSource
     */
    public function addTopicSource (NewsTopicSourceInterface $topicSource)
    {
        $this->topicSources[$topicSource->getAlias()] = $topicSource;
        $this->topicCache = [];
    }

    /**
     * Return topic source by alias
     * @param string $strAlias
     *
     * @return NewsTopicSourceInterface|null
     */
    public function getTopicSource(string $strAlias)
    {
        if(isset($this->topicSources[$strAlias]))
        {
            return $this->topicSources[$strAlias];
        }
        return null;
    }

    /**
     * Return all topics by news item
     *
     * @param NewsModel $objItem
     *
     * @return array
     */
    public function getTopicsByItem($objItem)
    {
        $arrTopics = [];
        /**
         * @var NewsTopicSourceInterface $source
         */
        foreach ($this->topicSources as $source)
        {
            $arrTopics = array_merge($arrTopics, $source->getTopicsByItem($objItem));
        }
        $arrTopics = array_unique($arrTopics, SORT_REGULAR);
        return $arrTopics;
    }

    /**
     * Returns a list of all available topics
     *
     * @return array
     */
    public function getAllTopics()
    {
        if (empty($this->topicCache))
        {
            $this->createTopicCache();
        }
        return $this->topicCache;
    }
}