<?php
if (!defined('TYPO3_MODE')) die ('Access denied.');
$typo3Version = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Information\Typo3Version::class);

// Define whether USER or USER_INT.
$pluginType = 'USER_INT';
$configuration = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class)->get('rss_display');
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
if ($typo3Version->getMajorVersion() >= 11) {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'rss_display',
        'Pi1',
        [\Fab\RssDisplay\Controller\FeedController::class => 'show'],
        $pluginType === 'USER_INT' ? [\Fab\RssDisplay\Controller\FeedController::class => 'show'] : [],
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_PLUGIN
    );

} else  {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Fab.rss_display',
        'Pi1',
        ['Feed' => 'show'],
        $pluginType === 'USER_INT' ? ['Feed' => 'show'] : []
    );
}

// cache configuration, see
// https://docs.typo3.org/typo3cms/CoreApiReference/ApiOverview/CachingFramework/Configuration/Index.html#cache-configurations
$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['rssdisplay']['frontend'] = \TYPO3\CMS\Core\Cache\Frontend\VariableFrontend::class;
$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['rssdisplay']['groups'] = ['all', 'rssdisplay'];

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

