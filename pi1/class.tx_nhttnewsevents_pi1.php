<?php
require_once(PATH_tslib . 'class.tslib_pibase.php');

class tx_nhttnewsevents_pi1 extends tslib_pibase {
	public $extKey = 'nh_ttnews_events';
	public $prefixId = 'tx_nhttnewsevents_pi1';
	public $scriptRelPath = 'pi1/class.tx_nhttnewsevents_pi.php';
	protected $templateCode;
	protected $errorMessages = array();

	public function main($content, $conf) {
		$this->conf = $conf;
		$this->pi_loadLL();
		$this->templateCode = $this->cObj->fileResource($conf['templateFile']);

		 //@todo: Respect default piVars
		if ($this->piVars) {
			$this->errorMessages = $this->processValidation();
		}

		if (empty($this->errorMessages)) {
			$insertArray = array(
				'pid' => $this->getStoragePid(),
				'tstamp' => time(),
				'crdate' => time(),
				'forename' => $this->piVars['forename'],
				'surname'=> $this->piVars['surname'],
				'email'=> $this->piVars['email'],
				'institution' => $this->piVars['institution'],
				'comment' => $this->piVars['comment'],
				'attendance' =>$this->piVars['attendance'],
				'ttnews_uid' =>(int)$_GET['tx_ttnews']['tt_news']);

			$GLOBALS['TYPO3_DB']->exec_INSERTquery('tx_nhttnewsevents_application',
				 $insertArray, 'pid, ttnews_uid, crdate, tstamp');
		}

		$content = $this->renderApplicationForm();
		return $content;
	}

	protected function renderApplicationForm() {
		$template = $this->cObj->getSubpart($this->templateCode,
			'###APPLICATION###');

		$template = $this->replacePrefixMarker($template, 'LL_',
			array(&$this, 'getTranslationForMarker'));

		$template = $this->replacePrefixMarker($template, 'FIELD_',
			array(&$this, 'getPivarForMarker'));

		$subpartArray = array('###ERRORS###' => $this->getErrorMarkup($template));
		$markerArray = array('###FORM_ACTION###' => $this->getFormAction());

		$template = $this->cObj->substituteMarkerArrayCached($template,
			$markerArray, $subpartArray);
		return $template;
	}

	protected function getErrorMarkup($template) {
		if (empty($this->errorMessages))
			return;

		$errorMarkup = '';
		$template = $this->cObj->getSubpart($template, '###ERRORS###');
		$templateItem = $this->cObj->getSubpart($template, '###ERROR_ITEM###');

		foreach($this->errorMessages as $message)
			$errorMarkup .= $this->cObj->substituteMarker($templateItem,
				'###MESSAGE###', $message);
		$errorMarkup = $this->cObj->substituteSubpart($template,
				'###ERROR_ITEM###', $errorMarkup, 0);

		return $errorMarkup;
	}

	protected function processValidation() {
		$errorMessages = array();
		foreach($this->piVars as $fieldName => $fieldValue) {
			if (!$validations = $this->conf['fieldProcessing.'][$fieldName . '.']['validation.'])
				continue;

			foreach ($validations as $validation) {
				$ok = FALSE;
				switch($validation['rule']) {
					case 'required':
						$ok = (bool) trim($fieldValue);
						break;
					case 'email' :
						if (trim($fieldValue))
							$ok = t3lib_div::validEmail($fieldValue);
						break;
				}

				if (!$ok) {
					if (!$message = $this->pi_getLL($validation['message']))
						$message = $validation['message'];
					$errorMessages[] = sprintf($message, $fieldValue);

				}
			}
		}

		return $errorMessages;
	}
	protected function replacePrefixMarker($template, $prefix, $callback) {
		$template = preg_replace_callback('/###' . $prefix .'(\w*)###/',
			$callback, $template);

		return $template;
	}

	protected function getTranslationForMarker($match) {
		return $this->pi_getLL(strtolower($match[1]));
	}

	protected function getPiVarForMarker($match) {
		$key = strtolower($match[1]);
		return (isset($this->piVars[$key]) ? $this->piVars[$key] :'' );
	}

	protected function getFormAction() {
		$tsConfig = array(
			'parameter' => $GLOBALS['TSFE']->id,
			'additionalParams' => t3lib_div::implodeArrayForUrl(NULL, $_GET),
			'returnLast' => 'url');

		return $this->cObj->typolink(NULL, $tsConfig);
	}

	protected function getStoragePid() {
		 //@todo: Add more possibilites e.g. page storage folder etc.
		if ($this->conf['storagePid'])
			return (int)$this->conf['storagePid'];

		return $GLOBALS['TSFE'']->id;
	}

}
?>