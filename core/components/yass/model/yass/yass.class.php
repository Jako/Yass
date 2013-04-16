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
 * Yass modX service class.
 */

if (!class_exists('revoChunkie')) {
	include YASS_CORE_PATH . 'model/includes/chunkie.class.inc.php';
}

if (!class_exists('Yass')) {

	class Yass {

		// public
		public $output = array();
		// private
		private $modx;
		private $session;
		private $keyName;
		private $keyValue;
		private $keyExpires;
		private $resource;
		private $language;
		private $templates;
		private $currentParams;

		function __construct($modx) {
			$this->modx = &$modx;
			if (!isset($_SESSION['yass'])) {
				$_SESSION['yass'] = array();
			}
			$this->session = &$_SESSION['yass'];
			$this->output['html'] = '';
		}

		// Return the include path of a configuration/template/whatever file
		function includeFile($name, $type = 'config', $extension = '.inc.php', $defaultSuffix = '') {

			$folder = (substr($type, -1) != 'y') ? $type . 's/' : substr($folder, 0, -1) . 'ies/';
			$allowedConfigs = glob(YASS_PATH . $folder . '*.' . $type . $extension);
			$configs = array();
			foreach ($allowedConfigs as $config) {
				$configs[] = preg_replace('=.*/' . $folder . '([^.]*).' . $type . $extension . '=', '$1', $config);
			}

			if (in_array($name, $configs)) {
				$output = YASS_PATH . $folder . $name . '.' . $type . $extension;
			} else {
				if (file_exists(YASS_PATH . $folder . 'default' . $defaultSuffix . '.' . $type . $extension)) {
					$output = YASS_PATH . $folder . 'default' . $defaultSuffix . '.' . $type . $extension;
				} else {
					$output = 'Allowed ' . $name . ' and default Yass ' . $type . ' file "' . YASS_PATH . $folder . 'default' . $defaultSuffix . '.' . $type . $extension . '" not found. Did you upload all files?';
				}
			}
			return $output;
		}

		function setOptions($options = array()) {

			$this->keyName = $options['keyName'];
			$this->keyValue = $options['keyValue'];
			$this->keyExpires = $options['keyExpires'];
			$this->refreshExpires = $options['refreshExpires'];
			$this->resource = $options['resource'];

			$this->modx->setOption('cultureKey', $options['language']);
			$this->modx->getService('lexicon', 'modLexicon');
			$this->modx->lexicon->load('yass:default');
			$this->language['enable'] = $this->modx->lexicon('yass.enable');
			$this->language['disable'] = $this->modx->lexicon('yass.disable');

			// Pass through get parameter
			$reservedParams = array('q', $this->keyName);
			$this->currentParams = array();
			if ($options['passParams'] != '') {
				$passParams = explode(',', $options['passParams']);
				foreach ($_GET as $key => $value) {
					if ($options['passParams'] == 'all') {
						if (!in_array($key, $reservedParams)) {
							$this->currentParams[$key] = $value;
						}
					} else {
						if (in_array($key, $passParams)) {
							if (!in_array($key, $reservedParams)) {
								$this->currentParams[$key] = $value;
							}
						}
					}
				}
			}
		}

		function setKey() {
			if (isset($_REQUEST[$this->keyName])) {
				// the session key is only set by request
				if ($_REQUEST[$this->keyName] != '') {
					// and if the value is not empty
					$this->session[$this->keyName]['value'] = $this->modx->stripTags($_REQUEST[$this->keyName]);
					$this->session[$this->keyName]['expires'] = ($this->keyExpires) ? time() + $this->keyExpires : 0;
				} elseif (isset($this->session[$this->keyName])) {
					// otherwise the session key is removed
					unset($this->session[$this->keyName]);
				}
			}
		}

		function getKey() {
			if (isset($this->session[$this->keyName])) {
				if ($this->session[$this->keyName]['expires'] == 0 || $this->session[$this->keyName]['expires'] >= time()) {
					if ($this->refreshExpires) {
						$this->session[$this->keyName]['expires'] = ($this->keyExpires) ? time() + $this->keyExpires : 0;
					}
					// get session key value only if it is not expired
					return $this->session[$this->keyName]['value'];
				} else {
					// otherwise remove the session key
					unset($this->session[$this->keyName]);
					return FALSE;
				}
			} else {
				return FALSE;
			}
		}

		function setTemplates($enabledTpl, $disabledTpl) {
			$this->templates['enabledTpl'] = $enabledTpl;
			$this->templates['disabledTpl'] = $disabledTpl;
		}

		function setOutput() {
			if ($this->getKey()) {
				$parser = new revoChunkie($this->templates['enabledTpl']);
			} else {
				$parser = new revoChunkie($this->templates['disabledTpl']);
			}
			$parser->createVars($this->language, 'lang');
			$parser->addVar('id', $this->resource);
			$parser->addVar('enableUrl', $this->modx->makeUrl($this->resource, '', array_merge($this->currentParams, array($this->keyName => $this->keyValue)), 'full'));
			$parser->addVar('disableUrl', $this->modx->makeUrl($this->resource, '', array_merge($this->currentParams, array($this->keyName => '')), 'full'));
			$parser->addVar('key', $this->keyName);
			$parser->addVar('value', $this->keyValue);
			$this->output['html'] = $parser->render();
		}

	}

}
?>
