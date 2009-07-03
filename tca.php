<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_nhttnewsevents_application'] = array (
	'ctrl' => $TCA['tx_nhttnewsevents_application']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'forename,surname,email,institution,comment,attendance,ttnews_uid'
	),
	'feInterface' => $TCA['tx_nhttnewsevents_application']['feInterface'],
	'columns' => array (
		'forename' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:nh_ttnews_events/locallang_db.xml:tx_nhttnewsevents_application.forename',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',
			)
		),
		'surname' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:nh_ttnews_events/locallang_db.xml:tx_nhttnewsevents_application.surname',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',
			)
		),
		'email' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:nh_ttnews_events/locallang_db.xml:tx_nhttnewsevents_application.email',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',
			)
		),
		'institution' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:nh_ttnews_events/locallang_db.xml:tx_nhttnewsevents_application.institution',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',
			)
		),
		'comment' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:nh_ttnews_events/locallang_db.xml:tx_nhttnewsevents_application.comment',		
			'config' => array (
				'type' => 'text',
				'cols' => '30',	
				'rows' => '5',
			)
		),
		'attendance' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:nh_ttnews_events/locallang_db.xml:tx_nhttnewsevents_application.attendance',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',
			)
		),
		'ttnews_uid' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:nh_ttnews_events/locallang_db.xml:tx_nhttnewsevents_application.ttnews_uid',		
			'config' => array (
				'type' => 'select',	
				'foreign_table' => 'tt_news',	
				'foreign_table_where' => 'ORDER BY tt_news.uid',	
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'forename;;;;1-1-1, surname, email, institution, comment, attendance, ttnews_uid')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);
?>