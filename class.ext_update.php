<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2011 powermail development team (details on http://forge.typo3.org/projects/show/extension-powermail)
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Class for updating powermail content elements
 *
 * @author	 Alexander Grein <ag@mediaessenz.eu>
 * @package	TYPO3
 * @subpackage tx_powermail
 */
class ext_update {

	/**
	 * @var string $LLkey
	 */
	private $LLkey = 'LLL:EXT:powermail/locallang.xml:updater_';

	/**
	 * Always returns TRUE to enable update script.
	 *
	 * @param string $what: what should be updated
	 * @return boolean
	 */
	public function access($what = 'all') {
		return TRUE;
	}

	/**
	 * @return string
	 */
	public function main() {
		$out = '';

		if (t3lib_div::_GP('do_update')) {
			$function = t3lib_div::_GP('function');
			if (method_exists($this, $function)) {
				$out .= $this->$function();
			}
		}

		$out .= $this->displayReload();
		$out .= $this->displayWarning();
		$out .= '<h3>' . $GLOBALS['LANG']->sL($this->LLkey . 'actions') . ':</h3>';
		$out .= $this->displayPageUpdate();

		return $out;
	}

	/**
	 * @return string
	 */
	protected function displayReload() {
		$out = '<a href="' . t3lib_div::linkThisScript(array('do_update' => '', 'function' => '')) . '">' .
			$GLOBALS['LANG']->sL($this->LLkey . 'reload') .
			'<img style="vertical-align:bottom;" ' . t3lib_iconWorks::skinImg($GLOBALS['BACK_PATH'], 'gfx/refresh_n.gif', 'width="18" height="16"') . ' />' .
			'</a><br /><br />';

		return $out;
	}

	/**
	 * @return string
	 */
	protected function displayWarning() {
		$message = new t3lib_FlashMessage(
			$GLOBALS['LANG']->sL($this->LLkey . 'warning_message'),
			$GLOBALS['LANG']->sL($this->LLkey . 'warning_header'),
			t3lib_FlashMessage::WARNING
		);

		return $message->render();
	}

	/**
	 * @param string $function
	 * @param string|NULL $label
	 *
	 * @return string
	 */
	protected function addButton($function, $label = NULL) {
		$params = array(
			'do_update' => 1,
			'function' => $function
		);

		if ($label === NULL) {
			$label = $GLOBALS['LANG']->sL($this->LLkey . 'do_it');
		}

		return '<br /><br /><form action="' . htmlspecialchars(t3lib_div::linkThisScript($params)) . '" method="post">' .
			'<input type="submit" value="' . $label . '" /></form>';
	}

	/**
	 * @return string
	 */
	protected function displayPageUpdate() {
		$rows = $this->findPageUpdate();
		$messageText = $GLOBALS['LANG']->sL($this->LLkey . 'result') . ':<br />' .
						'<strong>' . sprintf($GLOBALS['LANG']->sL($this->LLkey . 'elements_found'), count($rows)) . '</strong>';

		if (count($rows) > 0) {
			$messageText .= '<br /><br />' . $GLOBALS['LANG']->sL($this->LLkey . 'fix_issue') . '<br />' .
				'<em>(' . $GLOBALS['LANG']->sL($this->LLkey . 'pageupdate_notice') . ')</em>' .
				$this->addButton('updatePageUpdate');
			$type = t3lib_FlashMessage::ERROR;
		} else {
			$type = t3lib_FlashMessage::OK;
		}

		$message = new t3lib_FlashMessage(
			$messageText,
			$GLOBALS['LANG']->sL($this->LLkey . 'pageupdate_title'),
			$type
		);

		return $message->render();
	}

	/**
	 * @return array
	 */
	protected function findPageUpdate() {
		$select = '*';
		$from = 'tt_content';
		$where = 'tx_powermail_pages="" AND CType="powermail_pi1"';

		return $GLOBALS['TYPO3_DB']->exec_SELECTgetRows($select, $from, $where);
	}

	/**
	 * @return string
	 */
	protected function updatePageUpdate() {
		$updates = array();

		$rows = $this->findPageUpdate();
		if (count($rows) > 0) {
			foreach ($rows as $row) {
				$updateArray = array(
					'tx_powermail_pages' => $row['pid']
				);
				if ($GLOBALS['TYPO3_DB']->exec_UPDATEquery('tt_content', 'uid=' . $row['uid'], $updateArray)) {
					$updates[] = sprintf($GLOBALS['LANG']->sL($this->LLkey . 'pageupdate_updated'), $row['uid']);
				}
			}

			$message = new t3lib_FlashMessage(
				implode('<br />', $updates),
				$GLOBALS['LANG']->sL($this->LLkey . 'pageupdate_title'),
				t3lib_FlashMessage::OK
			);

			return $message->render();
		}

		return '';
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/powermail/class.ext_update.php']) {
	include_once ($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/powermail/class.ext_update.php']);
}
?>