RSS Display
==================

Display the content elements of the RSS feed on the frontend. The content is put in cache.

Features:

* Flexible caching
* Extract content with custom namespace
* Flexible Template source

Screenshots
--------------------

Here you see what the extension does:

.. image:: https://raw.github.com/TYPO3-extensions/rss_display/master/Documentation/Manual-01.png

Project info and releases
-----------------------------------

Stable version:
http://typo3.org/extensions/repository/view/rss_display

Development version:
https://git.typo3.org/TYPO3CMS/Extensions/rss_display.git

::

	git clone git://git.typo3.org/TYPO3CMS/Extensions/rss_display.git

Github mirror:
https://github.com/TYPO3-extensions/rss_display


Flash news about latest development or release
http://twitter.com/fudriot


Users manual
--------------------

To display a RSS feed on the page :
Click on the page where the RSS feed should be displayed and create a new content element.

.. image:: https://raw.github.com/TYPO3-extensions/rss_display/master/Documentation/Manual-02.png

Choose the "Plugins" tab and then "RSS Feed Display".

.. image:: https://raw.github.com/TYPO3-extensions/rss_display/master/Documentation/Manual-03.png

Write a header if needed ant choose "Plugin" tab.

.. image:: https://raw.github.com/TYPO3-extensions/rss_display/master/Documentation/Manual-04.png

In the plugin :
1. Write the feed url
2. Define the number of items to be displayed
3. Tick if the item's description should be displayed
4. If number 3 is ticked, choose the description's length
5. Save and close

.. image:: https://raw.github.com/TYPO3-extensions/rss_display/master/Documentation/Manual-05.png

How it should appear (in orange) on the frontend.

.. image:: https://raw.github.com/TYPO3-extensions/rss_display/master/Documentation/Manual-06.png

Configuration
=================

.. ...............................................................
.. container:: table-row

Property
	**tags**

Data type
	string

Description
	List of tags that will be exctracted from the feed

Default
	title, link, description, pubDate


.. ...............................................................
.. container:: table-row

Property
	**templateFile**

Data type
	string

Description
	Path to the template file

Default
	TemplateFile


.. ...............................................................
.. container:: table-row

Property
	**cacheDuration**

Data type
	integer

Description
	Life time of the cache. The value is relevant only if the extension is a USER_INT which is the default. The extension can also be configured as USER in the Extension Manager.

Default
	3600
