RSS Display
===========

Display the content elements of the RSS feed on the frontend.
The extension is wrapping `SimplePie`_ as low level library for fetching and parsing the feed. `SimplePie`_ is a fast and well tested library for RSS / Atom.
The extension has been almost fully rewritten in 2.0. Make sure to read the migration chapter.

Features:

* Define various Templates that can be picked by the User.
* Configurable caching mechanism
* Advanced View Helper that can extract content from feed items.

.. _SimplePie: https://github.com/simplepie/simplepie

Screenshots
-----------

In one picture!

.. image:: https://raw.github.com/fabarea/rss_display/master/Documentation/Manual-01.png


Project info and releases
-------------------------

Stable:
http://typo3.org/extensions/repository/view/rss_display

Development:
https://github.com/fabarea/rss_display

Installation
------------

Just install the Extension as normal in the Extension Manager and create a content element of type RSS Display.

Users manual
------------

To display a RSS feed on the page :
Click on the page where the RSS feed should be displayed and create a new content element.

.. image:: https://raw.github.com/fabarea/rss_display/master/Documentation/Manual-02.png

Choose the "Plugins" tab and then "RSS Feed Display".

.. image:: https://raw.github.com/fabarea/rss_display/master/Documentation/Manual-03.png

Write a header if needed ant choose "Plugin" tab.

.. image:: https://raw.github.com/fabarea/rss_display/master/Documentation/Manual-04.png

In the plugin :
1. Write the feed url
2. Define the number of items to be displayed
3. Tick if the item's description should be displayed
4. If number 3 is ticked, choose the description's length
5. Save and close

.. image:: https://raw.github.com/fabarea/rss_display/master/Documentation/Manual-05.png

How it should look like on the Frontend.

.. image:: https://raw.github.com/fabarea/rss_display/master/Documentation/Manual-06.png


Administration
==============

Migration towards 2.0
---------------------

Extension version 2.0 has been rewritten using Extbase as underlying framework. The database structure was changed.
To smooth the migration, run the update wizard from the Extension Manager. The script will take care of building the Flex Form
and change the ``list_type`` plugin signature.

It is recommended to backup table ``tt_content``!!!

.. image:: https://raw.github.com/fabarea/rss_display/master/Documentation/Manual-07.png


Plugin type USER_INT vs USER
----------------------------

In the Extension Manager, it can be decided whether to handle the cache by the plugin or by the global cache preferences.
This is known to be `USER_INT vs USER`_. If set to USER_INT the default cache duration is 3600 seconds and can be changed by TS.
If set to USER the cache is as long as the cache page is configured. Do clear TYPO3 cache when changing this value!!

.. _USER_INT vs USER: http://docs.typo3.org/typo3cms/TyposcriptReference/6.0/ContentObjects/UserAndUserInt/Index.html

Avoiding cache
--------------

Whenever RSS Display detects the parameter ``no_cache=1`` in the URL, the Caching Framework is skipped. This is convenient in development mode or
for forcing the cache to be regenerated.


Add a custom Template
---------------------

RSS Display is flexible enough to add a custom template which is then display in the drop down menu in the BE. The BE User can then pick this custom template.
New template must be added / configured by TypoScript like::

	# To be added somewhere in your settings
	# Replace "foo" by your extension.
	plugin.tx_rssdisplay {
		settings {
			templates {

				# foo1 is just a key which must be unique
				foo_1 {
					label = My Template
					path = EXT:foo/Resources/Private/Templates/Feed/Show.html
				}
			}
		}
	}


View Helpers
------------

RSS Display has various View Helpers to interact with a SimplePie object which provides an `API`_ for fetching data from a feed item.
Some advanced View Helpers are explains below ::

	# Retrieve url of enclosed image
	<feed:item.enclosure attribute="url"/>

	# Retrieve a custom value from the item "author". See the API http://simplepie.org/wiki/reference/start#methods1
	<feed:item.get value="author"/>

	# Retrieve a value of a custom tag according to a namespace
	<feed:item.tag namespace="http://purl.org/dc/elements/1.1/" tag="foo"/>

	# Retrieve multiple values from a tag according to a namespace
	# The example uses the shorthand syntax of Fluid - @see http://forge.typo3.org/issues/5033
	<f:for each="{feed:item.tags(namespace: 'http://purl.org/dc/elements/1.1/' tag: 'bar')}" as="value">
		{value}
	</f:for>
	{namespace feed=Fab\RssDisplay\ViewHelpers}




.. _API: http://simplepie.org/wiki/reference/start#methods1

Configuration
=============

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
