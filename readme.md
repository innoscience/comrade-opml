# ComradeOPML
Comrade need help with OPML, da? We read and write OPML data together no problem. It to spec & simple too, with PHP.

[![Build Status](https://travis-ci.org/innoscience/comrade-opml.png?branch=master)](https://travis-ci.org/innoscience/comrade-opml)

Copyright (C) 2014 Brandon Fenning

## Requirements

Compatible with PHP 5.3+

## Installation

Add `innoscience/comrade-opml` to the `composer.json` file:

	"require": {
        "innoscience/comrade-opml": "dev-master"
    }

After this, run `composer update`

ComradeOPML is namespaced to `Innoscience\ComradeOPML`, use this in the top of any files that require it:

	use Innoscience\ComradeOPML\ComradeOPML;

## Usage

### Importing & Reading an OPML File

	$document = ComradeOPML::importFile('file.opml');

	foreach ($document->getAllCategories() as $category) {

		echo '<h2>'.$category->getText().'</h2>';

		foreach ($category->getAllFeeds() as $feed) {
			echo $feed->getText().' - '.$feed->getXmlUrl().'</br>';
		}
	}

### Creating & Exporting an OPML File

	$document = ComradeOPML::newDocument();

	$document->addCategory('News')
		->addFeed('Awesome News', 'http//awesome.news/rss')
		->addFeed('Good Times', 'http//good.times/rss')
		->addFeed('Best News', 'http//best.news/rss');

	$document->addFeed('Food', 'Recipe Site', 'http://recipe.site/rss');
	$document->addFeed('Food', 'Succulent Soups', 'http://succulent.soups/rss');

	echo $document;

	// # Or write to a file

	ComradeOPML::exportFile($document, __DIR__.'/data/new.opml');

### Manipulating OPML Data

	$document = ComradeOPML::newDocument();

	$document->addCategory('Superfluous')
		->addFeed('Useless Things', 'http//uselesss.things/rss');

	$document->addCategory('News')
		->addFeed('Horrible News', 'http//horribe.news/rss')
		->addFeed('Good Times', 'http//good.times/rss');

	$document->removeCategory('Superfluous');
	$document->getCategory('News')->removeFeed('http//horribe.news/rss');

## Classes & Methods

### Innoscience\ComradeOPML\ComradeOPML

The `ComradeOPML` class is just a super-helpful factory class for ComradeOPML components.

`Comrade::importString($string)` : Import an OPML file in string format, returns a `Document`

`Comrade::importFile($filePath)` : Import an OPML file directly, returns a `Document`

`Comrade::newDocument()` : Creates a new `Document` instance. It's also a fancy way to write `new \Innoscience\ComradeOPML\Resource\Document`;

`Comrade::exportFile(Document $document, $filePath)` : Exports a `Document` to an OPML file

### Innoscience\ComradeOPML\Resource\Document

The `Innoscience\ComradeOPML\Resource\Document` class, (we call it `Document` amongst friends) is where much of the magic happens.

`$document->addCategory($category, $title = '')` : Add a category, returns the created `Category` instance. The required `$category` argument is the `text` attribute, the `$title` is the `title` attribute.

`$document->getCategory($category)` : Get a category by its `text` attribute, returns the created `Category` instance. 

`$document->getAllCategories()` : Get all categories, returns an array of `Category` instances.

`$document->removeCategory()` : Remove a category & its feeds by its `text` attribute. Returns the `Document` instance.

`$document->addFeed($category, $text, $xmlUrl, $title = '', $htmlUrl = '', $type = 'rss')` : Adds a feed to the given category. Returns `Document` instance.

`$document->parse($xmlString)` : Parses OPML data into the `Document` instance, appending to the document if it has existing data. Returns the `Document` instance.

`$document->setDomInstance($instance)` : Pass an alternative instance of `DOMDocument` for exporting.

`$document->output()` : Returns the OPML formatted document.

`echo $document` : Same as above, returns the OPML formatted document.

##### Header Property Methods

`$document->setTitle($string)` : Sets the `Document` `title` property in `head`

`$document->getTitle()` : Gets the `Document` `title` property in `head` 

`$document->setDateCreated($string)` : Sets the `Document` `dateCreated` property in `head`

`$document->getDateCreated()` : Gets the `Document` `dateCreated` property in `head`

`$document->setDateModified($string)` : Sets the `Document` `dateModified` property in `head`

`$document->getDateModified()` : Gets the `Document` `dateModified` property in `head`

`$document->setOwnerName($string)` : Sets the `Document` `ownerName` property in `head`

`$document->getOwnerName()` : Gets the `Document` `ownerName` property in `head`

`$document->setOwnerEmail($string)` : Sets the `Document` `ownerEmail` property in `head`

`$document->setOwnerEmail()` : Gets the `Document` `ownerEmail` property in `head`

`$document->setExpansionState($string)` : Sets the `Document` `expansionState` property in `head`

`$document->getExpansionState()` : Gets the `Document` `expansionState` property in `head`

`$document->setVertScrollState($string)` : Sets the `Document` `vertScrollState` property in `head`

`$document->getVertScrollState()` : Gets the `Document` `vertScrollState` property in `head`

`$document->setWindowTop($string)` : Sets the `Document` `windowTop` property in `head`

`$document->getWindowTop()` : Gets the `Document` `windowTop` property in `head`

`$document->setWindowLeft($string)` : Sets the `Document` `windowLeft` property in `head`

`$document->getWindowLeft()` : Gets the `Document` `windowLeft` property in `head`

`$document->setWindowBottom($string)` : Sets the `Document` `windowBottom` property in `head`

`$document->getWindowBottom()` : Gets the `Document` `windowBottom` property in `head`

`$document->setWindowRight($string)` : Sets the `Document` `windowRight` property in `head`

`$document->getWindowRight()` : Gets the `Document` `windowRight` property in `head`

### Innoscience\ComradeOPML\Resource\Category

`$category->addFeed($text, $xmlUrl, $title = '', $htmlUrl = '', $type = 'rss')` : Add a `Feed` to the `Category`, returns the `Category` instance.

`$category->getFeed($xmlUrl)` : Returns a `Feed` instance for the given feed.

`$category->getAllFeeds()` : Returns an array of `Feed` instances for the given `Category`

`$category->removeFeed($xmlurl)` : Removes the given feed from the `Category`

`$category->setText($string)` : Sets the `Category` `text` property, which is required. Returns the `Category` instance. 

`$category->getText()` : Gets the `Category` `text` property.

`$category->setTitle($string)` : Sets the `Category` `title` property. Returns the `Category` instance. 

`$category->getTitle()` : Gets the `Category` `title` property.

### Innoscience\ComradeOPML\Resource\Feed

`$feed->getCategory()` : Returns the feed's `Category` `text` property

`$feed->getText()` : Returns the `Feed` `text` property

`$feed->setText($string)` : Sets the `Feed` `text` property

`$feed->getXmlUrl()` : Returns the `Feed` `xmlUrl` property

`$feed->setXmlUrl($string)` : Sets the `Feed` `xmlUrl` property

`$feed->getTitle()` : Returns the `Feed` `title` property

`$feed->setTitle($string)` : Sets the `Feed` `title` property

`$feed->getHtmlUrl()` : Returns the `Feed` `htmlUrl` property

`$feed->setHtmlUrl($string)` : Sets the `Feed` `htmlUrl` property

`$feed->getType()` : Returns the `Feed` `type` property

`$feed->setType($string)` : Sets the `Feed` `type` property


## Tests
ComradeOPML is fully unit tested. Tests are located in the `tests` directory of the Passwordly package and can be run with `phpunit` in the package's base directory.


## License
ComradeOPML is licensed under GPLv2