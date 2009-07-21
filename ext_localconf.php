<?php
if (!defined ('TYPO3_MODE')) {
 	die ('Access denied.');
}
t3lib_extMgm::addUserTSConfig('
	options.saveDocNew.tx_nhttnewsevents_application=1
');

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['tt_news']['selectConfHook'][] =
	'EXT:nh_ttnews_events/class.tx_nhttnewsevents_hooks.php:&tx_nhttnewsevents_hooks';

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['tt_news']['extraItemMarkerHook'][] =
	'EXT:nh_ttnews_events/class.tx_nhttnewsevents_hooks.php:&tx_nhttnewsevents_hooks';
?>