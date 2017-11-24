<?php

/*
 * Copyright (c) 2017 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0+
 */

namespace HeimrichHannot\ContaoNewsAlertBundle\Models;

use HeimrichHannot\Haste\Model\Model;

/**
 * Class NewsalertSendModel.
 *
 * @property int $id
 * @property int $pid
 * @property int $tstamp
 * @property string  $topics
 * @property string  $senddate
 * @property int $count_messages
 */
class NewsalertSendModel extends Model
{
    protected static $strTable = 'tl_newsalert_sent';
}
