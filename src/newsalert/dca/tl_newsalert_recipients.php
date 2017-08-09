<?php

$GLOBALS['TL_DCA']['tl_newsalert_recipients'] = array
(
	'config'   => array
	(
		'dataContainer'     => 'Table',
		'enableVersioning'  => false,
		'onsubmit_callback' => array
		(
			array('HeimrichHannot\Haste\Dca\General', 'setDateAdded'),
		),
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary'			)
		)
	),
	'list'     => array
	(
		'label' => array
		(
			'fields' => array('id'),
			'format' => '%s'
		),
		'sorting'           => array
		(
			'mode'                  => 0,
			'panelLayout'           => 'filter;sort,search,limit'
		),
		'global_operations' => array
		(
		),
		'operations' => array
		(
		)
	),
	'palettes' => array(
		'__selector__' => array(),
		'default' => ''
	),
	'fields'   => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'tstamp' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_newsalert_recipients']['tstamp'],
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'dateAdded' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['MSC']['dateAdded'],
			'sorting'                 => true,
			'flag'                    => 6,
			'eval'                    => array('rgxp'=>'datim', 'doNotCopy' => true),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
	)
);


class tl_newsalert_recipients extends \Backend
{

}
