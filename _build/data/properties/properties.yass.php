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
 * @subpackage build
 *
 * Properties for the Yass snippet.
 */
$properties = array(
	array(
		'name' => 'resource',
		'desc' => 'prop_yass.resource',
		'type' => 'textfield',
		'options' => '',
		'value' => '0',
		'lexicon' => 'yass:properties',
	),
	array(
		'name' => 'keyName',
		'desc' => 'prop_yass.keyName',
		'type' => 'textfield',
		'options' => '',
		'value' => 'default',
		'lexicon' => 'yass:properties',
	),
	array(
		'name' => 'keyValue',
		'desc' => 'prop_yass.keyValue',
		'type' => 'textfield',
		'options' => '',
		'value' => 'defaultValue',
		'lexicon' => 'yass:properties',
	),
	array(
		'name' => 'keyExpires',
		'desc' => 'prop_yass.keyExpires',
		'type' => 'textfield',
		'options' => '',
		'value' => '0',
		'lexicon' => 'yass:properties',
	),
	array(
		'name' => 'language',
		'desc' => 'prop_yass.language',
		'type' => 'textfield',
		'options' => '',
		'value' => 'en',
		'lexicon' => 'yass:properties',
	),
	array(
		'name' => 'toPlaceholder',
		'desc' => 'prop_yass.toPlaceholder',
		'type' => 'combo-boolean',
		'options' => '',
		'value' => false,
		'lexicon' => 'yass:properties',
	),
	array(
		'name' => 'debug',
		'desc' => 'prop_yass.debug',
		'type' => 'combo-boolean',
		'options' => '',
		'value' => false,
		'lexicon' => 'yass:properties',
	),
	array(
		'name' => 'enabledTpl',
		'desc' => 'prop_yass.enabledTpl',
		'type' => 'textarea',
		'options' => '',
		'value' => '@INLINE ' . getChunkContent($sources['templates'] . 'defaultEnabled.template.html'),
		'lexicon' => 'yass:properties',
	),
	array(
		'name' => 'disabledTpl',
		'desc' => 'prop_yass.disabledTpl',
		'type' => 'textarea',
		'options' => '',
		'value' => '@INLINE ' . getChunkContent($sources['templates'] . 'defaultDisabled.template.html'),
		'lexicon' => 'yass:properties',
	)
);

return $properties;