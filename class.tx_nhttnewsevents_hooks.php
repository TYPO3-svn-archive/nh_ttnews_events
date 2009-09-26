<?php
class tx_nhttnewsevents_hooks {
	public function processSelectConfHook($pObj, $selectConf) {
		$selectConf['where'] .= ' AND tt_news.tx_nhttnewsevents_hide_in_list=0';
		return $selectConf;
	}

	public function extraItemMarkerProcessor($markerArray, $row, $lConf, $pObj) {
		if ($pObj->config['code'] != 'SINGLE' || !$row['tx_nhttnewsevents_enable_application'])
			return $markerArray;

		$tsConf = array();
		$tsConf['10'] = 'COA_INT';
		$tsConf['10.']['10'] = 'USER';
		$tsConf['10.']['10.'] = $pObj->conf['tx_nhttnews_events_pi1.'];
		$tsConf['10.']['10.']['recordData.'] = $row;

		$pluginOutput =
			$pObj->cObj->cObjGetSingle($tsConf['10'], $tsConf['10.']);

		$markerArray['###NEWS_CONTENT###'] .=  $pluginOutput;

		return $markerArray;
	}

	function processDatamap_preProcessFieldArray(&$incomingFieldArray, $table, $id, $pObj) {
		if ($table != 'tt_news')
			return;

		if ($incomingFieldArray['tx_nhttnewsevents_export']) {
			$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('forename, surname, email,' .
			 	'institution, comment, attendance', 'tx_nhttnewsevents_application',
				'deleted=0 AND ttnews_uid=' . $id);

			if ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
				 //@todo: Use localland_db.xml instead
				$csvData = 'forename;surname;email;institution;comment;attendance' ."\n";
				do {
					$csvData .= implode(';', $row). "\n";
				} while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res));

				header('Content-Type: text/csv');
				header('Content-Disposition: attachment; filename=test.csv');
				header('Content-Description: csv File');
				header('Pragma: no-cache');
				header('Expires: 0');
				echo $csvData;
				exit;
			}

		}

		unset($incomingFieldArray['tx_nhttnewsevents_export']);
	}


}
?>