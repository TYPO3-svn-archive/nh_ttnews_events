<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}
include_once(t3lib_extMgm::extPath($_EXTKEY) . 'class.tx_nhttnewsevents_userfunc.php');

t3lib_extMgm::addStaticFile($_EXTKEY, 'pi1/static', 'News to events');

$TCA['tx_nhttnewsevents_application'] = array (
	'ctrl' => array (
		'title' => 'LLL:EXT:nh_ttnews_events/locallang_db.xml:tx_nhttnewsevents_application',
		'label' => 'uid',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY crdate',
		'delete' => 'deleted',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'tca.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'icon_tx_nhttnewsevents_application.gif'
	)
);

$tempColumns = array (
	'tx_nhttnewsevents_hide_in_list' => array (
		'exclude' => 0,
		'l10n_mode' => 'exclude',
		'label' =>
			'LLL:EXT:nh_ttnews_events/locallang_db.xml:tt_news.tx_nhttnewsevents_hide_in_list',
		'config' => array (
			'type' => 'check'
		)
	),
	'tx_nhttnewsevents_start' => array (
		'exclude' => 0,
		'l10n_mode' => 'exclude',
		'label' => 'LLL:EXT:nh_ttnews_events/locallang_db.xml:tt_news.tx_nhttnewsevents_start',
		'config' => array (
			'type' => 'input',
			'size' => '12',
			'max' => '20',
			'eval' => 'datetime',
			'checkbox' => '0',
			'default' => '0'
		)
	),
	'tx_nhttnewsevents_end' => array (
		'exclude' => 0,
		'l10n_mode' => 'exclude',
		'label' => 'LLL:EXT:nh_ttnews_events/locallang_db.xml:tt_news.tx_nhttnewsevents_end',
		'config' => array (
			'type' => 'input',
			'size' => '12',
			'max' => '20',
			'eval' => 'datetime',
			'checkbox' => '0',
			'default' => '0'
		)
	),
	'tx_nhttnewsevents_enable_application' => array (
		'exclude' => 0,
		'l10n_mode' => 'exclude',
		'label' =>
			'LLL:EXT:nh_ttnews_events/locallang_db.xml:tt_news.tx_nhttnewsevents_enable_application',
		'config' => array (
			'type' => 'check'
		)
	),
	'tx_nhttnewsevents_application_until' => array (
		'exclude' => 0,
		'l10n_mode' => 'exclude',
		'label' => 'LLL:EXT:nh_ttnews_events/locallang_db.xml:tt_news.tx_nhttnewsevents_application_until',
		'config' => array (
			'type' => 'input',
			'size' => '12',
			'max' => '20',
			'eval' => 'datetime',
			'checkbox' => '0',
			'default' => '0'
		)
	),
	'tx_nhttnewsevents_organizer_email' => array (
		'exclude' => 0,
		'l10n_mode' => 'exclude',
		'label' =>
			'LLL:EXT:nh_ttnews_events/locallang_db.xml:tt_news.tx_nhttnewsevents_organizer_email',
		'config' => array (
			'type' => 'input',
			'size' => '30'
		)
	),
	'tx_nhttnewsevents_max_attendees' => array (
		'exclude' => 0,
		'l10n_mode' => 'exclude',
		'label' =>
			'LLL:EXT:nh_ttnews_events/locallang_db.xml:tt_news.tx_nhttnewsevents_max_attendees',
		'config' => array (
			'type' => 'input',
			'size' => '4',
			'max' => '4',
			'eval' => 'int',
			'checkbox' => '0',
			'range' => array (
				'upper' => '1000',
				'lower' => '-1'
			),
			'default' => 0
		)
	),
	'tx_nhttnewsevents_max_attendees_application' => array (
		'exclude' => 0,
		'l10n_mode' => 'exclude',
		'label' =>
			'LLL:EXT:nh_ttnews_events/locallang_db.xml:tt_news.tx_nhttnewsevents_max_attendees_application',
		'config' => array (
			'type' => 'input',
			'size' => '4',
			'max' => '4',
			'eval' => 'int',
			'checkbox' => '0',
			'range' => array (
				'upper' => '1000',
				'lower' => '-1'
			),
			'default' => 0
		)
	),
	'tx_nhttnewsevents_left_openings_warning_limit' => array (
		'exclude' => 0,
		'l10n_mode' => 'exclude',
		'label' =>
			'LLL:EXT:nh_ttnews_events/locallang_db.xml:tt_news.tx_nhttnewsevents_left_openings_warning_limit',
		'config' => array (
			'type' => 'input',
			'size' => '4',
			'max' => '4',
			'eval' => 'int',
			'checkbox' => '0',
			'range'=> array (
				'upper' => '1000',
				'lower' => '-1'
			),
			'default' => 0
		)
	),
	'tx_nhttnewsevents_detail_pid' => array (
		'exclude' => 0,
		'l10n_mode' => 'exclude',
		'label' => 'LLL:EXT:nh_ttnews_events/locallang_db.xml:tt_news.tx_nhttnewsevents_detail_pid',
		'config' => array (
			'type' => 'group',
			'internal_type' => 'db',
			'allowed' => 'pages',
			'size' => 1,
			'minitems' => 0,
			'maxitems' => 1
		)
	),
	'tx_nhttnewsevents_export' => array (
		'displayCond' => 'REC:NEW:false',
		'exclude' => 0,
		'l10n_mode' => 'exclude',
		'label' => 'LLL:EXT:nh_ttnews_events/locallang_db.xml:tt_news.tx_nhttnewsevents_export',
		'config' => array (
			'type' => 'check'
		)
	),
	'tx_nhttnewsevents_detail_link' => array (
		'displayCond' => 'REC:NEW:false',
		'exclude' => 0,
		'l10n_mode' => 'exclude',
		'label' => 'LLL:EXT:nh_ttnews_events/locallang_db.xml:tt_news.tx_nhttnewsevents_detail_link',
		'config' => array (
			'type' => 'user',
			'userFunc' => 'tx_nhttnewsevents_userfunc->displayDetailLink'
		)
	)
);


t3lib_div::loadTCA('tt_news');
t3lib_extMgm::addTCAcolumns('tt_news', $tempColumns,1);
t3lib_extMgm::addToAllTCAtypes('tt_news',
	'--div--;LLL:EXT:nh_ttnews_events/locallang_db.xml:tx_nhttnewsevents_application.ttnews_uid,' .
	'tx_nhttnewsevents_hide_in_list;;;;1-1-1,tx_nhttnewsevents_start, tx_nhttnewsevents_end,' .
	'tx_nhttnewsevents_detail_pid, tx_nhttnewsevents_enable_application;;;;1-1-1,' .
	'tx_nhttnewsevents_application_until,' .
	'tx_nhttnewsevents_organizer_email, tx_nhttnewsevents_max_attendees,' .
	'tx_nhttnewsevents_max_attendees_application, tx_nhttnewsevents_left_openings_warning_limit, ' .
	'tx_nhttnewsevents_export, tx_nhttnewsevents_detail_link');

?>