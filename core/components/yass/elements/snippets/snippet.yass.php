<?php
/*
 * Yass
 * 
 * Copyright 2012 by Thomas Jakobi <thomas.jakobi@partout.info>
 * 
 * Yass is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation; either version 2 of the License, or (at your option) any
 * later version.
 *
 * Yass is distributed in the hope that it will be useful, but WITHOUT 
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more 
 * details.
 *
 * You should have received a copy of the GNU General Public License along with
 * Yass; if not, write to the Free Software Foundation, Inc., 
 * 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package yass
 * 
 * Yass snippet.
 */

// set base path
define(YASS_PATH, 'components/yass/');

define(YASS_CORE_PATH, MODX_CORE_PATH . YASS_PATH);

include YASS_CORE_PATH . 'model/yass/yass.class.php';

if (!isset($modx->Yass)) {
	$modx->Yass = new Yass($modx);
}

// Parameter
$options['keyName'] = $modx->getOption('keyName', $scriptProperties, 'default');
$options['keyValue'] = $modx->getOption('keyValue', $scriptProperties, 'defaultValue');
$options['keyExpires'] = (int) $modx->getOption('keyExpires', $scriptProperties, 0);
$options['refreshExpires'] = (boolean) $modx->getOption('refreshExpires', $scriptProperties, false);
$options['resource'] = (int) $modx->getOption('resource', $scriptProperties, 0);
$options['resource'] = ($options['resource'] != 0) ? $options['resource'] : $modx->resource->get('id');
$options['language'] = $modx->getOption('language', $scriptProperties, 'en');
$options['toPlaceholder'] = (boolean) $modx->getOption('toPlaceholder', $scriptProperties, false);
$options['debug'] = (boolean) $modx->getOption('debug', $scriptProperties, false);

$enabledTpl = $modx->getOption('enabledTpl', $scriptProperties, '@FILE ' . $modx->Yass->includeFile($options['keyName'] . 'Enabled', 'template', '.html', 'Enabled'));
$disabledTpl = $modx->getOption('disabledTpl', $scriptProperties, '@FILE ' . $modx->Yass->includeFile($options['keyName'] . 'Disabled', 'template', '.html', 'Disabled'));

$modx->Yass->setOptions($options);
$modx->Yass->setTemplates($enabledTpl, $disabledTpl);
$modx->Yass->setKey();
$modx->Yass->setOutput();

if ($options['debug']) {
	$modx->Yass->output['debug'] = '<pre>Yass Session' . "\r\n" . print_r($_SESSION['yass'], true) . "\r\n";
	$modx->Yass->output['debug'] .= 'Time' . "\r\n" . time() . "\r\n";
	$modx->Yass->output['debug'] .= 'Yass Settings' . "\r\n" . print_r($options, true) . '</pre>';
} else {
	$modx->Yass->output['debug'] = '';
}

$output = '';
if ($options['toPlaceholder']) {
	$keyName = ($options['keyName'] != 'default') ? $options['keyName'] . '.' : '';
	$modx->setPlaceholder('yass.' . $keyName . 'value', $modx->Yass->getKey());
	$modx->setPlaceholder('yass.' . $keyName . 'output', $modx->Yass->output['html']);
	$modx->setPlaceholder('yass.' . $keyName . 'debug', $modx->Yass->output['debug']);
} else {
	$output = $modx->Yass->output['html'] . $modx->Yass->output['debug'];
}
return $output;
?>
