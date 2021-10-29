<?php
namespace Fab\RssDisplay\Backend;

/*
 * This file is part of the Fab/RssDisplay project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3\CMS\Backend\Wizard\NewContentElementWizardHookInterface;


/**
 * Class that adds the wizard icon.
 */
class Wizard implements NewContentElementWizardHookInterface
{

    /**
     * Processing the wizard items array
     *
     * @param array $wizardItems The wizard items
     */
    public function manipulateWizardItems(&$wizardItems, &$parentObject)
    {
        # Find index of last plugin.
        foreach (array_keys($wizardItems) as $index => $key) {
            if(strpos($key, 'plugin') === 0) {
                $found = true;
            } elseif (isset($found)) {
                array_splice($wizardItems, $index, 0, [
                    'plugins_tx_rssdisplay_pi1' => [
                        'iconIdentifier' => 'plugins_tx_rssdisplay_pi1_wizard', // <- see ext_tables.php
                        'iconIdentifier' => 'ext-news-wizard-icon', // <- see ext_tables.php
                        'title' => $this->getLanguageService()->sL('LLL:EXT:rss_display/Resources/Private/Language/locallang.xlf:wizard.title'),
                        'description' => $this->getLanguageService()->sL('LLL:EXT:rss_display/Resources/Private/Language/locallang.xlf:wizard.description'),
                        'saveAndClose' => false,
                        'tt_content_defValues' => [
                            'CType' => "list",
                            'list_type' => "rssdisplay_pi1"
                        ],
                        'params' => '&defVals[tt_content][CType]=list&defVals[tt_content][list_type]=rssdisplay_pi1'
                    ]
                ]);
                break;
            };
        }
    }

    /**
     * @return \TYPO3\CMS\Core\Localization\LanguageService
     */
    protected function getLanguageService(): \TYPO3\CMS\Core\Localization\LanguageService
    {
        return $GLOBALS['LANG'];
    }

}
