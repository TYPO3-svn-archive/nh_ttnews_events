<?php
class tx_nhttnewsevents_userfunc {

	public function displayDetailLink($pArray, $pObj) {
		preg_match('/pages_([0-9]*)/'  , $pArray['row']['tx_nhttnewsevents_detail_pid'], $matches);

		if (!(int)$matches[1])
			return;

		$url = 'http://' . $_SERVER['SERVER_NAME'] . '/index.php?id=' .
			$matches[1] . '&amp;tx_ttnews[tt_news]=' .
			$pArray['row']['uid'];

		return '<a target="_blank" href="' . $url . '">' . $url . '</a>';
	}

}
?>