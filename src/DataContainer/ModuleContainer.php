<?php

namespace HeimrichHannot\ContaoNewsAlertBundle\DataContainer;

use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use HeimrichHannot\ContaoNewsAlertBundle\Components\NewsTopicCollection;

class ModuleContainer
{
    public function __construct(
        private NewsTopicCollection $newsTopicCollection
    )
    {
    }

    #[AsCallback(table: 'tl_module', target: 'fields.newsalertSourceSelection.options')]
    public function onFieldsNewsalertSourceSelectionOptions()
    {
        return $this->newsTopicCollection->getAllSourcesList();
    }

    #[AsCallback(table: 'tl_module', target: 'fields.newsalertOverwriteTopic.options')]
    public function getAllTopics()
    {
        return $this->newsTopicCollection->getAllTopics();
    }
}