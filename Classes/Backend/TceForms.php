<?php
namespace Fab\RssDisplay\Backend;

/*
 * This file is part of the Fab/RssDisplay project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
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
     * Provide configured template entries to FlexForm.
     *
     * @param array $params
     * @return string
     * @throws \InvalidArgumentException
     */
    public function getTemplateEntries(&$params)
    {

        $configurationManager = $this->getObjectManager()->get(BackendConfigurationManager::class);

        $setup = $configurationManager->getTypoScriptSetup();
        $configuration = $this->getPluginConfiguration($setup, 'rssdisplay');

        if (is_array($configuration['settings']['templates'])) {

            $output = [];
            foreach ($configuration['settings']['templates'] as $template) {
                $output[] = [$template['label'], $template['path']];
            }
            $params['items'] = $output;
        }
    }

    /**
     * Returns the TypoScript configuration found an extension name
     *
     * @param array $setup
     * @param string $extensionName
     * @return array
     * @throws \InvalidArgumentException
     */
    protected function getPluginConfiguration(array $setup, $extensionName)
    {
        $pluginConfiguration = array();
        if (is_array($setup['plugin.']['tx_' . strtolower($extensionName) . '.'])) {
            /** @var \TYPO3\CMS\Core\TypoScript\TypoScriptService $typoScriptService */
            $typoScriptService = GeneralUtility::makeInstance('TYPO3\CMS\Core\TypoScript\TypoScriptService');
            $pluginConfiguration = $typoScriptService->convertTypoScriptArrayToPlainArray($setup['plugin.']['tx_' . strtolower($extensionName) . '.']);
        }
        return $pluginConfiguration;
    }

    /**
     * @return ObjectManager
     * @throws \InvalidArgumentException
     */
    protected function getObjectManager()
    {
        return GeneralUtility::makeInstance(ObjectManager::class);
    }

}
