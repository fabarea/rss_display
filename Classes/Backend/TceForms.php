<?php

/**
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Backend integration with TCEforms
 */
class Tx_RssDisplay_Backend_TceForms
{

    /**
     * Render a template menu.
     *
     * @param array $params
     * @param object $tsObj
     * @return string
     */
    public function renderTemplateMenu(&$params, &$tsObj)
    {

        /** @var $objectManager \TYPO3\CMS\Extbase\Object\ObjectManager */
        if ($this->isVersionHigherOrEqualToVersionSix()) {
            $objectManager = GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');
        } else {
            $objectManager = t3lib_div::makeInstance('Tx_Extbase_Object_Manager');
        }

        /** @var Tx_Extbase_Configuration_BackendConfigurationManager $configurationManager */
        $configurationManager = $objectManager->get('Tx_Extbase_Configuration_BackendConfigurationManager');

        $setup = $configurationManager->getTypoScriptSetup();
        $configuration = $this->getPluginConfiguration($setup, 'rssdisplay');

        $output = '';
        if (is_array($configuration['settings']['templates'])) {

            $selectedItem = '';
            if (!empty($params['row']['pi_flexform'])) {
                $values = t3lib_div::xml2array($params['row']['pi_flexform']);
                if (!empty($values['data']['sDEF']['lDEF']['settings.template'])) {
                    $selectedItem = $values['data']['sDEF']['lDEF']['settings.template']['vDEF'];
                }
            }

            $options = array();
            foreach ($configuration['settings']['templates'] as $template) {
                $options[] = sprintf('<option value="%s" %s>%s</option>',
                    $template['path'],
                    $selectedItem == $template['path'] ? 'selected="selected"' : '',
                    $template['label']
                );
            }

            $output = sprintf('<select name="data[tt_content][%s][pi_flexform][data][sDEF][lDEF][settings.template][vDEF]">%s</select>',
                $params['row']['uid'],
                implode("\n", $options)
            );
        }
        return $output;
    }

    /**
     * Returns the TypoScript configuration found an extension name
     *
     * @param array $setup
     * @param string $extensionName
     * @return array
     */
    protected function getPluginConfiguration(array $setup, $extensionName)
    {
        $pluginConfiguration = array();
        if (is_array($setup['plugin.']['tx_' . strtolower($extensionName) . '.'])) {
            if ($this->isVersionHigherOrEqualToVersionSix()) {
                /** @var \TYPO3\CMS\Extbase\Service\TypoScriptService $typoScriptService */
                $typoScriptService = GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Service\TypoScriptService');
                $pluginConfiguration = $typoScriptService->convertTypoScriptArrayToPlainArray($setup['plugin.']['tx_' . strtolower($extensionName) . '.']);
            } else {
                $pluginConfiguration = Tx_Extbase_Utility_TypoScript::convertTypoScriptArrayToPlainArray($setup['plugin.']['tx_' . strtolower($extensionName) . '.']);
            }
        }
        return $pluginConfiguration;
    }

    /**
     * Tell whether current CMS version is greater or equal than 6.0.
     *
     * @return bool
     */
    protected function isVersionHigherOrEqualToVersionSix()
    {
        $version = class_exists('t3lib_utility_VersionNumber') ?
            t3lib_utility_VersionNumber::convertVersionNumberToInteger(TYPO3_version) :
            TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version);

        return $version >= 6000000;
    }
}
