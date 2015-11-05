<?php
if (!defined('TYPO3_MODE')) die ('Access denied.');

$pluginType = 'USER_INT';
$configuration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['rss_display']);
if (!empty($configuration['plugin_type'])) {
    $pluginType = $configuration['plugin_type'];
}

// Configure Extbase plugin
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Fab.rss_display',
    'Pi1',
    array('Feed' => 'show'),
    $pluginType === 'USER_INT' ? array('Feed' => 'show') : array()
);

$TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['rssdisplay'] = array(
    'frontend' => 'TYPO3\CMS\Core\Cache\Frontend\StringFrontend',
//	'options' => array(),
    'groups' => array('all', 'rssdisplay')
);


# Install PSR-0-compatible class autoloader for SimplePie Library in Resources/PHP/SimplePie
spl_autoload_register(function ($class) {

    // Only load the class if it starts with "SimplePie"
    if (strpos($class, 'SimplePie') !== 0) {
        return;
    }

    require sprintf('%sResources/Private/PHP/SimplePie/%s',
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('rss_display'),
        DIRECTORY_SEPARATOR . str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php'
    );
});
