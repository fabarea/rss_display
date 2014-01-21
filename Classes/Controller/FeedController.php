<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Fabien Udriot <fabien.udriot@ecodev.ch>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * RSS display that will fetch the content of a RSS Feed and display it onto the Frontend.
 */
class Tx_RssDisplay_Controller_FeedController extends Tx_Extbase_MVC_Controller_ActionController {

	const PLUGIN_TYPE_USER_INT = 'USER_INT';

	const PLUGIN_TYPE_USER = 'USER';

	/**
	 * @var t3lib_cache_frontend_Frontend
	 */
	protected $cacheInstance;

	/**
	 * Initialize object
	 */
	public function initializeAction() {
		if (empty($this->settings['template'])) {
			$this->settings['template'] = 'EXT:rss_display/Resources/Private/Templates/Feed/Show.html';
		}

		// Check the template is a valid URL
		if (!filter_var($this->settings['feedUrl'], FILTER_VALIDATE_URL)) {
			$message = sprintf('Feed URL is not valid "%s". Update your settings.', $this->settings['feedUrl']);
			throw new Exception($message, 1320651278);
		}
	}

	/**
	 * @return string
	 */
	public function showAction() {

		// @todo !! useful feature: add check if the Feed URL is alive. If not log it and send an email to the webmaster.

		// Configure the template path dynamically
		$pathAbs = t3lib_div::getFileAbsFileName($this->settings['template']);
		$this->view->setTemplatePathAndFilename($pathAbs);

		if ($this->canFetchResultFromCache()) {

			// Get content from the caching framework.
			$result = $this->getCacheInstance()->get($this->getCacheIdentifier());
		} else {

			$feed = $this->getSimplePie($this->settings['feedUrl']);
			$this->view->assign('title', $feed->get_title());
			$this->view->assign('items', $feed->get_items(0, $this->settings['numberOfItems']));
			$this->view->assign('settings', $this->settings);
			$result = $this->view->render();

			if ($this->canCacheResult()) {

				// Set cache for next use
				$this->cacheInstance->set($this->getCacheIdentifier(), $result, array('type' => 'result'), $this->settings['cacheDuration']);
			}
		}

		return $result;
	}

	/**
	 * Tell whether the result must be cached in the Caching Framework.
	 *
	 * @return boolean
	 */
	protected function canCacheResult() {
		$result = FALSE;
		if ($this->getPluginType() === self::PLUGIN_TYPE_USER_INT) {
			$result = TRUE;
		}
		return $result;
	}

	/**
	 * Tell whether the caching framework can be used to fetch the result
	 *
	 * @return boolean
	 */
	protected function canFetchResultFromCache() {
		$result = FALSE;
		if ($this->getPluginType() === self::PLUGIN_TYPE_USER_INT
			&& $this->getCacheInstance()->has($this->getCacheIdentifier())
			&& ! t3lib_div::_GET('no_cache')) {
			$result = TRUE;
		}
		return $result;
	}

	/**
	 * Return a SimplePie object
	 * @todo wrap me in a Service
	 *
	 * @param string $feedUrl
	 * @return SimplePie
	 */
	protected function getSimplePie($feedUrl) { // Create a new instance of the SimplePie object and fetch the feed.
		$feed = new SimplePie();
		$feed->set_feed_url($feedUrl);
		$feed->init();
		return $feed;
	}

	/**
	 * Return the feed identifier for the caching framework
	 *
	 * @return string
	 */
	protected function getCacheIdentifier() {
		return md5($this->settings['feedUrl']);
	}

	/**
	 * Return whether the plugin is of type USER_INT (default) OR USER

	 * @return string
	 */
	protected function getPluginType() {

		$pluginType = self::PLUGIN_TYPE_USER_INT;
		$configuration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['rss_display']);
		if (!empty($configuration['plugin_type'])) {
			$pluginType = $configuration['plugin_type'];
		}

		// after 6.2 migration
		#$configurationUtility = $objectManager->get('TYPO3\CMS\Extensionmanager\Utility\ConfigurationUtility');
		#$configuration = $configurationUtility->getCurrentConfiguration('rss_display');
		#echo $configuration['plugin_type']['value']

		return $pluginType;
	}

	/**
	 * Initialize and returns cache instance to be ready to use
	 * @todo can be wrapped in a service to streamline this Controller
	 *
	 * @return t3lib_cache_frontend_Frontend
	 */
	protected function getCacheInstance() {

		$cacheName = 'cache_rssdisplay';
		if (is_null($this->cacheInstance)) {
			t3lib_cache::initializeCachingFramework();
			try {
				$this->cacheInstance = $this->getCachingManager()->getCache($cacheName);
			} catch (t3lib_cache_exception_NoSuchCache $e) {
				$this->cacheInstance = $this->getCacheFactory()->create(
					$cacheName,
					$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$cacheName]['frontend'],
					$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$cacheName]['backend'],
					$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$cacheName]['options']
				);
			}
		}
		return $this->cacheInstance;
	}

	/**
	 * Return the Cache Manager
	 *
	 * @return t3lib_cache_Manager
	 */
	protected function getCachingManager() {
		return $GLOBALS['typo3CacheManager'];
	}

	/**
	 * Return the Cache Factory
	 *
	 * @return t3lib_cache_Factory
	 */
	protected function getCacheFactory() {
		return $GLOBALS['typo3CacheFactory'];
	}
}

?>