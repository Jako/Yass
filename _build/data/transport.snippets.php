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
 * snippets for Yass package
 */
$snippets = array();

$snippets[1] = $modx->newObject('modSnippet');
$snippets[1]->fromArray(array(
	'id' => 1,
	'name' => 'Yass',
	'description' => 'Yet Another Session Saver.',
	'snippet' => getSnippetContent($sources['snippets'] . 'snippet.yass.php'),
		), '', true, true);
$properties = include $sources['properties'] . 'properties.yass.php';
$snippets[1]->setProperties($properties);
unset($properties);

return $snippets;