<?php
if (!defined('TYPO3_MODE')) die ('Access denied.');

// Define whether USER or USER_INT.
$pluginType = 'USER_INT';
$configuration = $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['rss_display'];
if (!empty($configuration['plugin_type'])) {
    $pluginType = $configuration['plugin_type'];
}

// Define whether to automatically load TS.
if (false === isset($configuration['autoload_typoscript']) || true === (bool)$configuration['autoload_typoscript']) {

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScript(
        'rss_display',
        'constants',
        '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:rss_display/Configuration/TypoScript/constants.txt">'
    );

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScript(
        'rss_display',
        'setup',
        '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:rss_display/Configuration/TypoScript/setup.txt">'
    );
}

// Configure Extbase plugin
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Fab.rss_display',
    'Pi1',
    ['Feed' => 'show'],
    $pluginType === 'USER_INT' ? ['Feed' => 'show'] : []
);

// cache configuration, see
// https://docs.typo3.org/typo3cms/CoreApiReference/ApiOverview/CachingFramework/Configuration/Index.html#cache-configurations
if (empty($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['rssdisplay'])) {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['rssdisplay'] = [];
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['rssdisplay']['groups'] = ['all', 'rssdisplay'];
}

if (!\TYPO3\CMS\Core\Core\Environment::isComposerMode()) {
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
}
