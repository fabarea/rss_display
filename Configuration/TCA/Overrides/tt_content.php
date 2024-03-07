<?php

defined('TYPO3') or die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'rss_display',
    'Pi1',
    'Fetch and display a RSS feed'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('rssdisplay_pi1', 'FILE:EXT:rss_display/Configuration/FlexForm/feed.xml');
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['rssdisplay_pi1'] = 'layout, select_key, pages, recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['rssdisplay_pi1'] = 'pi_flexform';

