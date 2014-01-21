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

?>