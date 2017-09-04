<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2017 Heimrich & Hannot GmbH
 *
 * @author  Thomas Körner <t.koerner@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */


namespace HeimrichHannot\ContaoNewsAlertBundle\Models;

class NewsModel extends \Contao\NewsModel
{
    /**
     * Returns published news, where no newsalert was sent (or newsalert should be send again.
     * Checks if there are published news with activated newsalert, where newsalert sent is not set (to 1).
     * @param array $arrOptions
     *
     * @return \Contao\Model\Collection|\Contao\NewsModel|NewsModel[]|null
     */
    public static function findUnsentPublished(array $arrOptions = [])
    {
        $t = static::$strTable;

        $arrColumns = ["$t.newsalert_activate = 1 AND $t.newsalert_sent = 0"];

        if (isset($arrOptions['ignoreFePreview']) || !BE_USER_LOGGED_IN) {
            $time         = \Date::floorToMinute();
            $arrColumns[] = "($t.start='' OR $t.start<='$time') AND ($t.stop='' OR $t.stop>'" . ($time + 60) . "') AND $t.published='1'";
        }

        return static::findBy($arrColumns, null, $arrOptions);
    }

}