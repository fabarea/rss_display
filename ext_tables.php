<?php
if (!defined('TYPO3_MODE')) die ('Access denied.');


// Possible Static TS loading
$configuration = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class)->get('rss_display');


if (true === isset($configuration['autoload_typoscript']['value']) && true === (bool)$configuration['autoload_typoscript']['value']) {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('rss_display', 'Configuration/TypoScript', 'RSS Display: display a RSS / Atom feed');
}

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms']['db_new_content_el']['wizardItemsHook'][\Fab\RssDisplay\Backend\Wizard::class] = \Fab\RssDisplay\Backend\Wizard::class;

call_user_func(function () {
    /**
     * Register icons
     */
    $identifier = 'plugins_tx_rssdisplay_pi1_wizard';

    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
        \TYPO3\CMS\Core\Imaging\IconRegistry::class
    );
    $iconRegistry->registerIcon(
        $identifier, // Icon-Identifier, z.B. tx-myext-action-preview
        \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
        ['source' => 'EXT:rss_display/Resources/Public/Images/RssDisplay.png']
    );
});
