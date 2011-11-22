<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

  ## Extending TypoScript from static template uid=43 to set up userdefined tag:
t3lib_extMgm::addTypoScript($_EXTKEY,'editorcfg','
	tt_content.CSS_editor.ch.tx_rssdisplay_pi1 = < plugin.tx_rssdisplay_pi1.CSS_editor
',43);


t3lib_extMgm::addPItoST43($_EXTKEY,'pi1/class.tx_rssdisplay_pi1.php','_pi1','list_type',0);

// Register cache 'rssdisplay_cache'
if (!is_array($TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['rssdisplay_cache'])) {
    $TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['rssdisplay_cache'] = array();
}

// Register the cache table to be deleted when all caches are cleared
$TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearAllCache_additionalTables']['tx_rssdisplay_cache'] = 'tx_rssdisplay_cache';

// Define string frontend as default frontend, this must be set with TYPO3 4.5 and below
// and overrides the default variable frontend of 4.6
if (!isset($TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['rssdisplay_cache']['frontend'])) {
    $TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['rssdisplay_cache']['frontend'] = 't3lib_cache_frontend_StringFrontend';
}
if (t3lib_div::int_from_ver(TYPO3_version) < '4006000') {
    // Define database backend as backend for 4.5 and below (default in 4.6)
    if (!isset($TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['rssdisplay_cache']['backend'])) {
        $TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['rssdisplay_cache']['backend'] = 't3lib_cache_backend_DbBackend';
    }

    // Define data table for 4.5 and below (obsolete in 4.6)
    if (!isset($TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['rssdisplay_cache']['options'])) {
        $TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['rssdisplay_cache']['options'] = array();
    }
    if (!isset($TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['rssdisplay_cache']['options']['cacheTable'])) {
        $TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['rssdisplay_cache']['options']['cacheTable'] = 'tx_rssdisplay_cache';
    }
	if (!isset($TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['rssdisplay_cache']['options']['tagsTable'])) {
		$TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['rssdisplay_cache']['options']['tagsTable'] = 'tx_rssdisplay_cache_tags';
	}
}


?>