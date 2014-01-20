<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Fabien Udriot <fabien.udriot@ecodev.ch>
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
 * Backend integration with TCEforms
 */
class Tx_RssDisplay_Backend_TceForms {

	/**
	 * Render a template menu.
	 *
	 * @param array $params
	 * @param object $tsObj
	 * @return string
	 */
	public function renderTemplateMenu(&$params, &$tsObj) {


		#/** @var $objectManager \TYPO3\CMS\Extbase\Object\ObjectManager */
		#$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');
		$objectManager = t3lib_div::makeInstance('Tx_Extbase_Object_Manager');

		/** @var Tx_Extbase_Configuration_BackendConfigurationManager $configurationManager */
		$configurationManager = $objectManager->get('Tx_Extbase_Configuration_BackendConfigurationManager');

		$setup = $configurationManager->getTypoScriptSetup();
		$configuration = $this->getPluginConfiguration($setup, 'rssdisplay');

		$output = '';
		if (is_array($configuration['settings']['templates'])) {

			$values = t3lib_div::xml2array($params['row']['pi_flexform']);

			$selectedItem = '';
			if (!empty($values['data']['sDEF']['lDEF']['settings.template']['vDEF'])) {
				$selectedItem = $values['data']['sDEF']['lDEF']['settings.template']['vDEF'];
			}

			$options = array();
			foreach ($configuration['settings']['templates'] as $template) {
				$options[] = sprintf('<option value="%s" %s>%s</option>',
					$template['path'],
					$selectedItem  == $template['path'] ? 'selected="selected"' : '',
					$template['label']
				);
			}

			$output = sprintf('<select name="data[tt_content][%s][pi_flexform][data][sDEF][lDEF][settings.template][vDEF]">%s</select>',
				$params['row']['uid'],
				implode("\n", $options)
			);
		}
		return $output;

		#$backendConfiguration->setConfiguration(array('extensionName' => 'rssdisplay', 'pluginName' => 'pi1'));
		#var_dump($backendConfiguration->getConfiguration('RssDisplay', 'Pi1'));
		#var_dump($backendConfiguration->getConfiguration('rss_display', 'pi1'));
		exit();
	}

	/**
	 * Returns the TypoScript configuration found an extension name
	 *
	 * @param array $setup
	 * @param string $extensionName
	 * @return array
	 */
	protected function getPluginConfiguration(array $setup, $extensionName) {
		$pluginConfiguration = array();
		if (is_array($setup['plugin.']['tx_' . strtolower($extensionName) . '.'])) {
			$pluginConfiguration = Tx_Extbase_Utility_TypoScript::convertTypoScriptArrayToPlainArray($setup['plugin.']['tx_' . strtolower($extensionName) . '.']);
		}
		return $pluginConfiguration;
	}
}

?>