<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

#t3lib_extMgm::addPItoST43($_EXTKEY,'pi1/class.tx_rssdisplay_pi1.php','_pi1','list_type',0);

// @todo enable me once TYPO3 CMS 6.2
///** @var \TYPO3\CMS\Extensionmanager\Utility\ConfigurationUtility $configurationUtility */
//$configurationUtility = $objectManager->get('TYPO3\CMS\Extensionmanager\Utility\ConfigurationUtility');
//$configuration = $configurationUtility->getCurrentConfiguration($_EXTKEY);
// echo $configuration['extension_type']['value']
// @todo ... and remove me!
$pluginType = 'USER_INT';
$configuration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['rss_display']);
if (!empty($configuration['extension_type'])) {
	$pluginType = $configuration['extension_type'];
}

// Configure Extbase plugin
Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Pi1',
	array('Feed' => 'show'),
	$pluginType === 'USER_INT' ? array('Feed' => 'show') : array()
);

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

# Install PSR-0-compatible class autoloader for SimplePie Library in Resources/PHP/SimplePie
spl_autoload_register(function ($class) {

	// Only load the class if it starts with "SimplePie"
	if (strpos($class, 'SimplePie') !== 0) {
		return;
	}

	require sprintf('%sResources/Private/PHP/SimplePie/%s',
		t3lib_extMgm::extPath('rss_display'),
		DIRECTORY_SEPARATOR . str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php'
	);
});

?>