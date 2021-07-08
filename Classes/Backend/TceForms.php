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
use TYPO3\CMS\Backend\Form\Element\AbstractFormElement;

/**
 * Backend integration with TCEForms
 *
 * @deprecated No longer used, will be removed
 */
class TceForms extends AbstractFormElement
{

    /**
     * Render a template menu.
     *
     * @param array $row
     * @return string
     * @throws \InvalidArgumentException
     */
    public function renderTemplateMenu($row)
    {
        $configurationManager = $this->getObjectManager()->get(BackendConfigurationManager::class);

        $setup = $configurationManager->getTypoScriptSetup();
        $configuration = $this->getPluginConfiguration($setup, 'rssdisplay');

        $output = '';
        if (is_array($configuration['settings']['templates'])) {

            $selectedItem = '';
            if (!empty($row['pi_flexform'])) {
                $values = $row['pi_flexform'];
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
                $row['uid'],
                implode("\n", $options)
            );
        }
        return $output;
    }

    /**
     * Render a template.
     *
     * @return array
     */
    public function render() {
        $result = $this->initializeResultArray();
        $result["html"] = $this->renderTemplateMenu($this->data["databaseRow"]);
        return $result;
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
