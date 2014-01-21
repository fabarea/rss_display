<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$extensionName = t3lib_div::underscoredToUpperCamelCase($_EXTKEY);
$pluginSignature = strtolower($extensionName) . '_pi1';
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature]='layout,select_key';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature]='pi_flexform';

t3lib_extMgm::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForm/feed.xml');

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Pi1',
	'Fetch and display a RSS feed'
);

t3lib_extMgm::addPlugin(Array('LLL:EXT:rss_display/locallang_db.xml:tt_content.list_type_pi1', $_EXTKEY.'_pi1'),'list_type');
#if (TYPO3_MODE=='BE')	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_rssdisplay_pi1_wizicon'] = t3lib_extMgm::extPath($_EXTKEY).'pi1/class.tx_rssdisplay_pi1_wizicon.php';
?>