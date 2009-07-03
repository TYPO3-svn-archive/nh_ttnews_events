<?php
class tx_nhttnewsevents_hooks {
	public function processSelectConfHook($pObj, $selectConf) {
		$selectConf['where'] .= ' AND tt_news.tx_nhttnewsevents_hide_in_list=0';
		return $selectConf;
	} 
}
?>