<?php
if (!defined('TYPO3_MODE')) die ('Access denied.');

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['rssdisplay_pi1'] = 'layout, select_key, pages, recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['rssdisplay_pi1'] = 'pi_flexform';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('rssdisplay_pi1', 'FILE:EXT:rss_display/Configuration/FlexForm/feed.xml');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'rss_display',
    'Pi1',
    'Fetch and display a RSS feed'
);

// Possible Static TS loading
$configuration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['rss_display']);
if (true === isset($configuration['autoload_typoscript']['value']) && true === (bool)$configuration['autoload_typoscript']['value']) {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('rss_display', 'Configuration/TypoScript', 'Vidi Frontend: generic List Component');
}