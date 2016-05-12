<?php
namespace Fab\RssDisplay\Backend;

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
use TYPO3\CMS\Extbase\Configuration\BackendConfigurationManager;
use TYPO3\CMS\Extbase\Object\ObjectManager;

/**
 * Backend integration with TCEForms
 */
class TceForms
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

        $configurationManager = $this->getObjectManager()->get(BackendConfigurationManager::class);

        $setup = $configurationManager->getTypoScriptSetup();
        $configuration = $this->getPluginConfiguration($setup, 'rssdisplay');

        $output = '';
        if (is_array($configuration['settings']['templates'])) {

            $selectedItem = '';
            if (!empty($params['row']['pi_flexform'])) {
                $flexform = \TYPO3\CMS\Core\Utility\GeneralUtility::xml2array($params['row']['pi_flexform']);
                if (!empty($flexform['data']['sDEF']['lDEF']['settings.template'])) {
                    $selectedItem = $flexform['data']['sDEF']['lDEF']['settings.template']['vDEF'];
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
            /** @var \TYPO3\CMS\Extbase\Service\TypoScriptService $typoScriptService */
            $typoScriptService = GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Service\TypoScriptService');
            $pluginConfiguration = $typoScriptService->convertTypoScriptArrayToPlainArray($setup['plugin.']['tx_' . strtolower($extensionName) . '.']);
        }
        return $pluginConfiguration;
    }

    /**
     * @return ObjectManager
     */
    protected function getObjectManager()
    {
        return GeneralUtility::makeInstance(ObjectManager::class);
    }

}
