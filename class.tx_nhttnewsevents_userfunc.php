<?php
require_once(t3lib_extMgm::extPath('pagepath', 'class.tx_pagepath_api.php'));
class tx_nhttnewsevents_userfunc {

	public function displayDetailLink($pArray, $pObj) {
		preg_match('/pages_([0-9]*)/'  , $pArray['row']['tx_nhttnewsevents_detail_pid'], $matches);

		if (!(int)$matches[1])
			return;

		$pagePath =
			tx_pagepath_api::getPagePath($matches[1], array('tx_ttnews[tt_news]' => $pArray['row']['uid']));

		return '<a target="_blank" href="' . $pagePath .'">' . $pagePath . '</a>';
	}

}
?>