<?php
require_once(PATH_tslib . 'class.tslib_pibase.php');

class tx_nhttnewsevents_pi1 extends tslib_pibase {
	public $extKey = 'nh_ttnews_events';
	public $prefixId = 'tx_nhttnewsevents_pi1';
	public $scriptRelPath = 'pi1/class.tx_nhttnewsevents_pi.php';
	protected $templateCode;
	protected $ttnewsUid;
	protected $errorMessages = array();

	public function main($content, $conf) {
		$this->conf = $conf;
		$this->pi_loadLL();
		$this->templateCode = $this->cObj->fileResource($conf['templateFile']);
		$this->ttnewsUid = (int)$_GET['tx_ttnews']['tt_news'];
		$eventsAppliedTo = $GLOBALS['TSFE']->fe_user->getKey('ses', $this->prefixId);

		if ($this->conf['recordData.']['tx_nhttnewsevents_application_until'] < time()) {
			$content = $this->renderApplicationPeriodExpired();
		} elseif (is_array($eventsAppliedTo) && in_array($this->ttnewsUid, $eventsAppliedTo)) {
			$content = $this->renderAlreadyApplied();
		} elseif($this->hasApplication('crdate+' . (int)$this->conf['ipLockPeriod'] .
			'>' . time() . ' AND remote_ip = \'' . $_SERVER['REMOTE_ADDR'] . '\'')) {
			$content = $this->renderApplicationLocked();
		} elseif ($this->piVars) { //@todo: Respect default piVars
			$this->errorMessages = $this->processValidation();
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
					'ttnews_uid' =>$this->ttnewsUid,
					'remote_ip' => $_SERVER['REMOTE_ADDR']);

				$GLOBALS['TYPO3_DB']->exec_INSERTquery('tx_nhttnewsevents_application',
					 $insertArray, 'pid, ttnews_uid, crdate, tstamp');

				if ($this->applicationLimitReached()) {
					$this->sendMail($this->conf['warningEmail.']['fromName'],
						$this->conf['warningEmail.']['fromName'],
						$this->conf['warningEmail.']['subject'],
						$this->renderWarningEmail(),
						$this->getOrganizerEmail());
				}

				if (trim($this->piVars['comment'])) {
					$this->sendMail($this->conf['commentEmail.']['fromName'],
						$this->conf['commentEmail.']['fromEmail'],
						$this->conf['commentEmail.']['subject'],
						$this->renderCommentEmail(),
						$this->getOrganizerEmail());
				}

				$eventsAppliedTo [] = $this->ttnewsUid;
				$GLOBALS['TSFE']->fe_user->setKey('ses' , $this->prefixId, $eventsAppliedTo);

				$content = $this->renderThankYou();
			}
		}

		if (!$content)
			$content = $this->renderApplicationForm();

		return $this->pi_wrapInBaseClass($content);
	}

	protected function renderApplicationForm() {
		$template = $this->cObj->getSubpart($this->templateCode, '###APPLICATION###');
		$template = $this->replaceDefaultMarkers($template);

		$subpartArray = array('###ERRORS###' => $this->getErrorMarkup($template));
		$markerArray = array('###FORM_ACTION###' => $this->getFormAction());

		$template = $this->cObj->substituteMarkerArrayCached($template,
			$markerArray, $subpartArray);
		return $template;
	}

	 //@todo: Optimize rendering of simple subparts.
	protected function renderThankYou() {
		$template = $this->cObj->getSubpart($this->templateCode, '###THANK_YOU###');
		$template = $this->replaceDefaultMarkers($template);

		return $template;
	}

	 //@todo: Optimize rendering of simple subparts.
	protected function renderAlreadyApplied() {
		$template = $this->cObj->getSubpart($this->templateCode, '###ALREADY_APPLIED###');
		$template = $this->replaceDefaultMarkers($template);

		return $template;
	}

	 //@todo: Optimize rendering of simple subparts.
	protected function renderApplicationPeriodExpired() {
		$template = $this->cObj->getSubpart($this->templateCode, '###APPLICATION_PERIOD_EXPIRED###');
		$template = $this->replaceDefaultMarkers($template);

		return $template;
	}

	 //@todo: Optimize rendering of simple subparts.
	protected function renderApplicationLocked() {
		$template = $this->cObj->getSubpart($this->templateCode, '###APPLICATION_LOCKED###');
		$template = $this->replaceDefaultMarkers($template);

		return $template;
	}

	 //@todo: Optimize rendering of simple subparts.
	protected function renderWarningEmail() {
		$template = $this->cObj->getSubpart($this->templateCode, '###WARNING_EMAIL###');
		$template = $this->replaceDefaultMarkers($template);

		return $template;
	}

	protected function renderCommentEmail() {
		$template = $this->cObj->getSubpart($this->templateCode, '###COMMENT_EMAIL###');
		$template = $this->replaceDefaultMarkers($template);

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
		if (!is_array($this->conf['fieldProcessing.']))
			return;

		$errorMessages = array();

		foreach($this->conf['fieldProcessing.'] as $fieldName => $processing) {
			if (!$validations = $processing['validation.'])
				continue;

			$fieldName = substr($fieldName, 0, -1);
			$fieldValue = $this->piVars[$fieldName];

			foreach ($validations as $validation) {
				$ok = FALSE;
				$extraMessageArgument = '';
				switch($validation['rule']) {
					case 'required':
						$ok = (bool) trim($fieldValue);
						break;
					case 'email' :
						if (trim($fieldValue))
							$ok = t3lib_div::validEmail($fieldValue);
						break;
					case 'unique' :
						 //@todo: Check for type of fieldValue to ensure correct quoting
						$ok = !$this->hasApplication($fieldName . '=\'' . $fieldValue .'\'');
						break;
					case 'numeric' :
						$ok = is_numeric($fieldValue);
						break;
					case 'lessThanOrEqualField' :
						$ok = $fieldValue <= $this->conf['recordData.'][$validation['field']] || $this->conf['recordData.'][$validation['field']] == -1;
						$extraMessageArgument = $this->conf['recordData.'][$validation['field']];
						break;
				}

				if (!$ok) {
					if (!$message = $this->pi_getLL($validation['message']))
						$message = $validation['message'];

					$errorMessages[] = sprintf($message, $fieldValue, $extraMessageArgument);
					break;
				}
			}
		}

		return $errorMessages;
	}

	protected function hasApplication($conditions) {
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*', 'tx_nhttnewsevents_application',
			$conditions . ' AND ' . 'ttnews_uid=' . $this->ttnewsUid .
				$this->cObj->enableFields('tx_nhttnewsevents_application'));

		return (bool)$GLOBALS['TYPO3_DB']->sql_num_rows($res);
	}

	protected function replaceDefaultMarkers($template) {
		$template = $this->replacePrefixMarkers($template, 'LL_',
			array(&$this, 'getTranslationForMarkers'));

		$template = $this->replacePrefixMarkers($template, 'FIELD_',
			array(&$this, 'getPivarForMarkers'));

		$template = $this->replacePrefixMarkers($template, 'RECORD_',
			array(&$this, 'getRecordFieldForMarkers'));

		return $template;
	}

	protected function replacePrefixMarkers($template, $prefix, $callback) {
		$template = preg_replace_callback('/###' . $prefix .'(\w*)###/',
			$callback, $template);

		return $template;
	}

	protected function getTranslationForMarkers($match) {
		return $this->pi_getLL(strtolower($match[1]));
	}

	protected function getPiVarForMarkers($match) {
		$key = strtolower($match[1]);
		return (isset($this->piVars[$key]) ? $this->piVars[$key] : '');
	}

	protected function getRecordFieldForMarkers($match) {
		$key = strtolower($match[1]);
		return (isset($this->conf['recordData.'][$key]) ? $this->conf['recordData.'][$key] : '');
	}

	protected function getNumberOfAttendees() {
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('SUM(attendance)', 'tx_nhttnewsevents_application',
			'ttnews_uid=' . $this->ttnewsUid . $this->cObj->enableFields('tx_nhttnewsevents_application'),
			'ttnews_uid'
		);

		list($count) = $GLOBALS['TYPO3_DB']->sql_fetch_row($res);
		return $count;
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

		return $GLOBALS['TSFE']->id;
	}

	protected function getOrganizerEmail() {
		if ($this->conf['recordData.']['tx_nhttnewsevents_organizer_email'])
			return $this->conf['recordData.']['tx_nhttnewsevents_organizer_email'];

		return $this->conf['organizerEmail'];

	}

	protected function applicationLimitReached() {
		if ($this->conf['recordData.']['tx_nhttnewsevents_left_openings_warning_limit'] != -1 &&
			$this->conf['recordData.']['tx_nhttnewsevents_max_attendees'] &&
			t3lib_div::validEmail($this->conf['recordData.']['tx_nhttnewsevents_organizer_email'])) {
				return ($this->conf['recordData.']['tx_nhttnewsevents_max_attendees'] - $this->getNumberOfAttendees() <
					$this->conf['recordData.']['tx_nhttnewsevents_left_openings_warning_limit']);
		}
		return FALSE;
	}

	protected function sendMail($fromName, $fromEmail, $subject, $content, $to) {
		$mail = t3lib_div::makeInstance('t3lib_htmlmail');
		$mail->start();
		$mail->from_name = $fromName;
		$mail->from_email = $fromEmail;
		$mail->subject = $subject;
		$mail->addPlain($content);
		$mail->send($to);
	}

}
?>