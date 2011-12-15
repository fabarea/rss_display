<?php

########################################################################
# Extension Manager/Repository config file for ext "rss_display".
#
# Auto generated 15-12-2011 11:55
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'RSS Feed Display',
	'description' => 'Take a RSS Feed and renders it onto the Frontend',
	'category' => 'plugin',
	'shy' => 0,
	'version' => '1.0.5',
	'dependencies' => '',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'stable',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearcacheonload' => 0,
	'lockType' => '',
	'author' => 'Virginie Udriot',
	'author_email' => 'virginie.udriot@ecodev.ch',
	'author_company' => '',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' => array(
			'typo3' => '4.5.0-0.0.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:16:{s:9:"ChangeLog";s:4:"a018";s:12:"ext_icon.gif";s:4:"0bfd";s:17:"ext_localconf.php";s:4:"0bc0";s:14:"ext_tables.php";s:4:"29ed";s:14:"ext_tables.sql";s:4:"8d3b";s:24:"ext_typoscript_setup.txt";s:4:"0fac";s:13:"locallang.xml";s:4:"1143";s:16:"locallang_db.xml";s:4:"041e";s:37:"Resources/Private/Templates/Feed.html";s:4:"2d98";s:14:"Tests/feed.xml";s:4:"fb4a";s:27:"Tests/feed_without_link.xml";s:4:"b64b";s:14:"doc/manual.pdf";s:4:"ad3e";s:14:"doc/manual.sxw";s:4:"f0cf";s:31:"pi1/class.tx_rssdisplay_pi1.php";s:4:"d707";s:39:"pi1/class.tx_rssdisplay_pi1_wizicon.php";s:4:"cc69";s:24:"pi1/static/editorcfg.txt";s:4:"89b0";}',
	'suggests' => array(
	),
);

?>