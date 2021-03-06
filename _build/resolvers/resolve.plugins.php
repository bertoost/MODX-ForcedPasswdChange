<?php

$plugins = array(
	'ForcedPasswdChange' => array(
		'OnManagerPageBeforeRender',
		'OnUserFormPrerender',
		'OnUserFormSave'
	)
);

$modx->log(xPDO::LOG_LEVEL_INFO,'Running PHP Resolver.');
switch($options[xPDOTransport::PACKAGE_ACTION]) {
	case xPDOTransport::ACTION_INSTALL:
		foreach($plugins as $plugin => $pluginEvents) {
			$pluginObj = $modx->getObject('modPlugin', array('name' => $plugin));
			if (!$pluginObj) $modx->log(xPDO::LOG_LEVEL_INFO, 'Cannot get object: '.$plugin);
			if (empty($pluginEvents)) $modx->log(xPDO::LOG_LEVEL_INFO, 'Cannot get System Events');
			if (!empty($pluginEvents) && $pluginObj) {
			
				$modx->log(xPDO::LOG_LEVEL_INFO, 'Assigning Events to Plugin '.$plugin);

				foreach($pluginEvents as $event) {
					$intersect = $modx->newObject('modPluginEvent');
					$intersect->set('event', $event);
					$intersect->set('pluginid', $pluginObj->get('id'));
					$intersect->save();
				}
			}
		}
	break;
}

?>