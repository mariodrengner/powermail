<?php
/*
 * Register necessary class names with autoloader
 */

$powermailExtPath = t3lib_extMgm::extPath('powermail');

$arr = array(

		/* ajax actions*/
	'tx_powermail_action' => $powermailExtPath . 'mod1/class.tx_powermail_action.php',

		/* ajax repositories */
	'tx_powermail_export' => $powermailExtPath . 'mod1/class.tx_powermail_export.php',
	'tx_powermail_repository' => $powermailExtPath . 'mod1/class.tx_powermail_repository.php',

		/* lib */
	'tx_powermail_countryzones' => $powermailExtPath . 'lib/class.tx_powermail_countryzones.php',
	'tx_powermail_db' => $powermailExtPath . 'lib/class.tx_powermail_db.php',
	'tx_powermail_dynamicmarkers' => $powermailExtPath . 'lib/class.tx_powermail_dynamicmarkers.php',
	'tx_powermail_functions_div' => $powermailExtPath . 'lib/class.tx_powermail_functions_div.php',
	'tx_powermail_geoip' => $powermailExtPath . 'lib/class.tx_powermail_geoip.php',
	'tx_powermail_markers' => $powermailExtPath . 'lib/class.tx_powermail_markers.php',
	'tx_powermail_sessions' => $powermailExtPath . 'lib/class.tx_powermail_sessions.php',

		/* pi1 */
	'tx_powermail_confirmation' => $powermailExtPath . 'pi1/class.tx_powermail_confirmation.php',
	'tx_powermail_form' => $powermailExtPath . 'pi1/class.tx_powermail_form.php',
	'tx_powermail_html' => $powermailExtPath . 'pi1/class.tx_powermail_html.php',
	'tx_powermail_mandatory' => $powermailExtPath . 'pi1/class.tx_powermail_mandatory.php',
	'tx_powermail_submit' => $powermailExtPath . 'pi1/class.tx_powermail_submit.php',

		/* scheduler */
	'tx_powermail_scheduler' => $powermailExtPath . 'cli/class.tx_powermail_scheduler.php',
	'tx_powermail_scheduler_addFields' => $powermailExtPath . 'cli/class.tx_powermail_scheduler_addFields.php'

);

return $arr;
?>
