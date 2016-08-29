<?php
namespace Fab\RssDisplay\Backend;

/*
 * This file is part of the Fab/RssDisplay project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

/**
 * Class that adds the wizard icon.
 */
class Wizard
{

    /**
     * Processing the wizard items array
     *
     * @param array $wizardItems : The wizard items
     * @return array
     * @throws \BadFunctionCallException
     */
    public function proc($wizardItems)
    {
        $wizardItems['plugins_tx_rssdisplay_pi1'] = array(
            'icon' => ExtensionManagementUtility::extRelPath('rss_display') . 'ext_icon.png', #'Resources/Public/Images/RssDisplay.png',
            'title' => $this->getLanguageService()->sL('LLL:EXT:rss_display/Resources/Private/Language/locallang.xlf:wizard.title'),
            'description' => $this->getLanguageService()->sL('LLL:EXT:rss_display/Resources/Private/Language/locallang.xlf:wizard.description'),
            'params' => '&defVals[tt_content][CType]=list&defVals[tt_content][list_type]=rssdisplay_pi1'
        );

        return $wizardItems;
    }

    /**
     * @return \TYPO3\CMS\Lang\LanguageService
     */
    protected function getLanguageService()
    {
        return $GLOBALS['LANG'];
    }

}
