<?php

########################################################################
# Extension Manager/Repository config file for ext: "nh_ttnews_events"
#
# Auto generated 03-07-2009 12:40
#
# Manual updates:
# Only the data in the array - anything else is removed by next write.
# "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'News to events',
	'description' => 'Adds basic event characteristics to tt_news. Including participant,seat and application managment.',
	'category' => 'fe',
	'author' => 'Nikolas Hagelstein',
	'author_email' => 'nikolas.hagelstein@gmail.com',
	'shy' => '',
	'dependencies' => 'tt_news',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'alpha',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'author_company' => '',
	'version' => '0.0.0',
	'constraints' => array(
		'depends' => array(
			'tt_news' => '',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:11:{s:9:"ChangeLog";s:4:"6289";s:10:"README.txt";s:4:"ee2d";s:12:"ext_icon.gif";s:4:"1bdc";s:17:"ext_localconf.php";s:4:"0050";s:14:"ext_tables.php";s:4:"92f5";s:14:"ext_tables.sql";s:4:"d337";s:38:"icon_tx_nhttnewsevents_application.gif";s:4:"475a";s:16:"locallang_db.xml";s:4:"eb51";s:7:"tca.php";s:4:"a4ef";s:19:"doc/wizard_form.dat";s:4:"29b9";s:20:"doc/wizard_form.html";s:4:"fab3";}',
);

?>