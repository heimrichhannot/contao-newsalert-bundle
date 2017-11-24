<?php

/*
 * Copyright (c) 2017 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0+
 */

namespace HeimrichHannot\ContaoNewsAlertBundle\Models;

use HeimrichHannot\Haste\Model\Model;

/**
 * Class NewsalertRecipientsModel.
 *
 *
 * @property int $id
 * @property int $tstamp
 * @property string  $email
 * @property string  $topic
 * @property bool $confirmed
 * @property string  $optInToken
 * @property string  $optOutToken
 * @property string  $dateAdded
 */
class NewsalertRecipientsModel extends Model
{
    protected static $strTable = 'tl_newsalert_recipients';
}
