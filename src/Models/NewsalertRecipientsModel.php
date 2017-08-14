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
 * Class NewsalertRecipientsModel
 *
 * @package HeimrichHannot\ContaoNewsAlertBundle\Models
 *
 * @property integer $id
 * @property integer $tstamp
 * @property string  $email
 * @property string  $topic
 * @property boolean $confirmed
 * @property string  $optInToken
 * @property string  $optOutToken
 * @property string  $dateAdded
 */

class NewsalertRecipientsModel extends Model
{
    protected static $strTable = 'tl_newsalert_recipients';

}