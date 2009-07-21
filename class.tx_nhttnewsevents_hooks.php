<?php
require_once(t3lib_extMgm::extPath('nh_ttnews_events') .
	'pi1/class.tx_nhttnewsevents_pi1.php');

class tx_nhttnewsevents_hooks {
	public function processSelectConfHook($pObj, $selectConf) {
		$selectConf['where'] .= ' AND tt_news.tx_nhttnewsevents_hide_in_list=0';
		return $selectConf;
	}

	public function extraItemMarkerProcessor($markerArray, $row, $lConf, $pObj) {
		if ($pObj->config['code'] != 'SINGLE')
			return $markerArray;

		$tsConf = array();
		$tsConf['10'] = 'COA_INT';
		$tsConf['10.']['10'] = 'USER';
		$tsConf['10.']['10.'] = $pObj->conf['tx_nhttnews_events_pi1.'];

		$pluginOutput =
			$pObj->cObj->cObjGetSingle($tsConf['10'], $tsConf['10.']);

		$markerArray['###NEWS_CONTENT###'] .=  $pluginOutput;

//		$args = func_get_args();
//		t3lib_div::debug($args);
		return $markerArray;
	}
}
?>