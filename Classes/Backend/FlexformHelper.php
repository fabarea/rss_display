<?php
declare(strict_types=1);
namespace Fab\RssDisplay\Backend;

/*
 * This file is part of the Fab/RssDisplay project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Object\ObjectManager;

/**
 * Helper functions for Flexform
 */
class FlexformHelper
{
    /**
     * itemsProcFunction for Flexform, adds all configured templates
     * to a select list.
     */
    public function populateTemplatesList(array $config): array
    {
        // workaround to set current page id for ConfigurationManager
        $_GET['id'] = $config['flexParentDatabaseRow']['pid'];

        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $configurationManager = $objectManager->get(ConfigurationManager::class);

        $setting = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        $templates = $setting['plugin.']['tx_rssdisplay.']['settings.']['templates.'] ?? [];

        foreach ($templates as $key => $values) {
            $config['items'][] = [$values['label'], $values['path']];
        }

        return $config['items'];
    }


}