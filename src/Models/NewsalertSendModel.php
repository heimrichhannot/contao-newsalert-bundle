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


use HeimrichHannot\Haste\Model\Model;

/**
 * Class NewsalertSendModel
 *
 * @property integer $id
 * @property integer $pid
 * @property integer $tstamp
 * @property string $topics
 * @property string $senddate
 * @property integer $count_messages
 *
 * @package HeimrichHannot\ContaoNewsAlertBundle\Models
 */
class NewsalertSendModel extends Model
{
    protected static $strTable = 'tl_newsalert_sent';
}