<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2017 Heimrich & Hannot GmbH
 *
 * @author  Thomas Körner <t.koerner@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */


namespace HeimrichHannot\ContaoNewsAlertBundle\EventListener\DataContainer;


use Contao\DataContainer;
use Symfony\Component\DependencyInjection\ContainerInterface;

class NewsalertListener
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public static function generateNewsHeadlineLabel($row, $label, DataContainer $dc, array $args)
    {
//        $this->container->get('')->
//        $args[1] = '<a href="do=news&table=tl_content&id="'.$row["pid"].'">'.$args[1].'</a>';
//        return $args;
    }

    public static function generateEntryParentUrl($row, $href, $label, $title, $icon, $attributes)
    {
        $href = 'do=news&table=tl_content&id=1982';

        return '<a href=""></a>';
    }

}