<?php

namespace HeimrichHannot\ContaoNewsAlertBundle\DataContainer;

use Contao\DataContainer;
use Contao\StringUtil;
use HeimrichHannot\ContaoNewsAlertBundle\Components\NewsTopicCollection;

class NewsalertRecipientsContainer
{
    public function __construct(private NewsTopicCollection $topicCollection)
    {
    }

    public function onFieldsTopicOptions(DataContainer $dc): array
    {
        $sourcesList = StringUtil::deserialize($dc->newsalertSourceSelection, true);
        if (empty($sourcesList))
        {
            return $this->topicCollection->getAllTopics();
        }
        $topics = [];
        foreach ($sourcesList as $alias)
        {
            $topics = array_merge($topics, $this->topicCollection->getTopicsBySource($alias));
        }
        return $topics;
    }
}