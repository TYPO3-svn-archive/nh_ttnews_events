<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}
$TCA['tx_nhttnewsevents_application'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:nh_ttnews_events/locallang_db.xml:tx_nhttnewsevents_application',		
		'label'     => 'uid',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY crdate',	
		'delete' => 'deleted',	
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_nhttnewsevents_application.gif',
	),
);

$tempColumns = array (
	'tx_nhttnewsevents_hide_in_list' => array (		
		'exclude' => 0,		
		'label' => 'LLL:EXT:nh_ttnews_events/locallang_db.xml:tt_news.tx_nhttnewsevents_hide_in_list',		
		'config' => array (
			'type' => 'check',
		)
	),
	'tx_nhttnewsevents_enable_application' => array (		
		'exclude' => 0,		
		'label' => 'LLL:EXT:nh_ttnews_events/locallang_db.xml:tt_news.tx_nhttnewsevents_enable_application',		
		'config' => array (
			'type' => 'check',
		)
	),
	'tx_nhttnewsevents_organizer_email' => array (		
		'exclude' => 0,		
		'label' => 'LLL:EXT:nh_ttnews_events/locallang_db.xml:tt_news.tx_nhttnewsevents_organizer_email',		
		'config' => array (
			'type' => 'input',	
			'size' => '30',
		)
	),
	'tx_nhttnewsevents_max_attendees' => array (		
		'exclude' => 0,		
		'label' => 'LLL:EXT:nh_ttnews_events/locallang_db.xml:tt_news.tx_nhttnewsevents_max_attendees',		
		'config' => array (
			'type'     => 'input',
			'size'     => '4',
			'max'      => '4',
			'eval'     => 'int',
			'checkbox' => '0',
			'range'    => array (
				'upper' => '1000',
				'lower' => '10'
			),
			'default' => 0
		)
	),
	'tx_nhttnewsevents_max_attendees_application' => array (		
		'exclude' => 0,		
		'label' => 'LLL:EXT:nh_ttnews_events/locallang_db.xml:tt_news.tx_nhttnewsevents_max_attendees_application',		
		'config' => array (
			'type'     => 'input',
			'size'     => '4',
			'max'      => '4',
			'eval'     => 'int',
			'checkbox' => '0',
			'range'    => array (
				'upper' => '1000',
				'lower' => '10'
			),
			'default' => 0
		)
	),
	'tx_nhttnewsevents_left_openings_warning_limit' => array (		
		'exclude' => 0,		
		'label' => 'LLL:EXT:nh_ttnews_events/locallang_db.xml:tt_news.tx_nhttnewsevents_left_openings_warning_limit',		
		'config' => array (
			'type'     => 'input',
			'size'     => '4',
			'max'      => '4',
			'eval'     => 'int',
			'checkbox' => '0',
			'range'    => array (
				'upper' => '1000',
				'lower' => '10'
			),
			'default' => 0
		)
	),
);


t3lib_div::loadTCA('tt_news');
t3lib_extMgm::addTCAcolumns('tt_news',$tempColumns,1);
t3lib_extMgm::addToAllTCAtypes('tt_news','tx_nhttnewsevents_hide_in_list;;;;1-1-1, tx_nhttnewsevents_enable_application, tx_nhttnewsevents_organizer_email, tx_nhttnewsevents_max_attendees, tx_nhttnewsevents_max_attendees_application, tx_nhttnewsevents_left_openings_warning_limit');
?>