<?php

use Innoscience\ComradeOPML\ComradeOPML;

class ComradeOPMLTest extends PHPUnit_Framework_TestCase {

	var $testFile;
	var $testFullFile;

	function setUp() {
		$this->testFile = __DIR__.'/data/test-file.opml';
		$this->testFullFile = __DIR__.'/data/test-file-full.opml';
	}

	function testImportOPMLFile() {
		$document = ComradeOPML::importFile($this->testFile);

		$this->assertEquals('ComradeOPML Test File', $document->getTitle());
		$this->assertEquals(3, count($document->getAllCategories()));
		$this->assertEquals(2, count($document->getCategory('Food')->getAllFeeds()));
		$this->assertEquals('NPR', $document->getCategory('News')->getFeed('http://www.npr.com/rss')->getText());
	}

	function testImportFullOPMLFile() {
		$document = ComradeOPML::importString(file_get_contents($this->testFullFile));

		$this->assertEquals('ComradeOPML Full Test File', $document->getTitle());
	}

	function testExportOPMLFile() {
		$document = ComradeOPML::importFile($this->testFullFile);

		$exportedData = $document->output();

		$checkDocument = ComradeOPML::importString($exportedData);

		$this->assertEquals('ComradeOPML Full Test File', $checkDocument->getTitle());
		$this->assertEquals(3, count($checkDocument->getAllCategories()));
		$this->assertEquals(2, count($checkDocument->getCategory('Food')->getAllFeeds()));
		$this->assertEquals('NPR', $checkDocument->getCategory('News')->getFeed('http://www.npr.com/rss')->getText());
	}

	function testExportOPMLFileToString() {
		$document = ComradeOPML::importFile($this->testFullFile);

		$checkDocument = ComradeOPML::importString($document);

		$this->assertEquals('ComradeOPML Full Test File', $checkDocument->getTitle());
		$this->assertEquals(3, count($checkDocument->getAllCategories()));
		$this->assertEquals(2, count($checkDocument->getCategory('Food')->getAllFeeds()));
		$this->assertEquals('NPR', $checkDocument->getCategory('News')->getFeed('http://www.npr.com/rss')->getText());
	}

	function testExportOPMLFileWithOptions() {
		$document = ComradeOPML::importFile($this->testFile);

		$document->setDomInstance(new \DOMDocument());

		$document->output();
	}

	function testExportFullOPMLFile() {
		$document = ComradeOPML::importFile($this->testFullFile);

		$document->output();
	}

	function testCreateAndExport() {
		$document = new \Innoscience\ComradeOPML\Resource\Document();
		$document->addFeed('News', 'test feed', 'http://www.test.com');

		$this->assertEquals('test feed', $document->getCategory('News')->getFeed('http://www.test.com')->getText());
	}

	function testRemoveCategory() {
		$document = ComradeOPML::importFile($this->testFile);

		$document->removeCategory('News');

		$this->assertEquals(2, count($document->getAllCategories()));
	}

	function testRemoveFeed() {
		$document = ComradeOPML::importFile($this->testFile);

		$document->getCategory('News')->removeFeed('http://www.npr.com/rss');
		$this->assertEquals(2, count($document->getCategory('News')->getAllFeeds()));
	}

	function testManipulateFeed() {
		$document = ComradeOPML::importFile($this->testFile);

		$feedItem = $document->getCategory('News')->getFeed('http://www.npr.com/rss');
		$feedItem->getCatgory();
		$feedItem->setTitle('Test');

		$document->addFeed('News' , 'TestNews', 'http://www.news.com/rss');

		$this->assertEquals('Test', $document->getCategory('News')->getFeed('http://www.npr.com/rss')->getTitle());
		$this->assertEquals(4, count($document->getCategory('News')->getAllFeeds()));
	}

	function testNewDocument() {
		$this->assertInstanceOf('\Innoscience\ComradeOPML\Resource\Document',ComradeOPML::newDocument());
	}

	function testChaining() {
		$document = ComradeOPML::newDocument();
		$document->addCategory('News')
			->addFeed('NPR', 'npr.rss')
			->addFeed('BBC', 'bbc.rss')
			->addFeed('538', '538.rss');

		$document->addFeed('Food', 'Food.com', 'Food.rss')
			->addFeed('Food', 'Cooking.com', 'cooking.rss')
			->addFeed('News', 'News.com', 'news.rss');

		$this->assertEquals(4, count($document->getCategory('News')->getAllFeeds()));
		$this->assertEquals(2, count($document->getCategory('Food')->getAllFeeds()));

	}

	function testExportToFile() {
		$document = new \Innoscience\ComradeOPML\Resource\Document();
		$document->addFeed('News', 'test feed', 'http://www.test.com');

		$tmlOpml = __DIR__.'/data/tmp.opml';

		$return = ComradeOPML::exportFile($document, $tmlOpml);

		$this->assertGreaterThan(0, $return);

		unlink($tmlOpml);
	}

	/**
	 * @expectedException Exception
	 */
	function testBadXMLData() {
		$document = new \Innoscience\ComradeOPML\Resource\Document();
		$document->parse('<>');
	}

	/**
	 * @expectedException Exception
	 */
	function testBadOPMLData() {
		$document = new \Innoscience\ComradeOPML\Resource\Document();
		$document->parse('<?xml version="1.0" encoding="UTF-8"?><opml version="1.0"><body><things></things></body></opml>');
	}

	/**
	 * @expectedException Exception
	 */
	function testImportFileNotFound() {
		ComradeOPML::importFile('123');
	}

	/**
	 * @expectedException Exception
	 */
	function testImportEmptyException() {
		ComradeOPML::importString('');
	}

	/**
	 * @expectedException Exception
	 */
	function testDomInstanceException() {
		$document = ComradeOPML::importFile($this->testFile);
		$document->setDomInstance(new stdClass());
	}

	function testReadmeImportExample() {
		$document = ComradeOPML::importFile(__DIR__.'/data/test-file.opml');
		foreach ($document->getAllCategories() as $category) {
			echo '<h2>'.$category->getText().'</h2>';
			foreach ($category->getAllFeeds() as $feed) {
				echo $feed->getText().' - '.$feed->getXmlUrl().'</br>';
			}
		}

		$this->assertEquals(3, count($document->getAllCategories()));
	}

	function testReadmeExportExample() {
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

		$this->assertEquals(2, count($document->getAllCategories()));
		$this->assertTrue(file_exists(__DIR__.'/data/new.opml'));
		unlink( __DIR__.'/data/new.opml');
	}

	function testReadmeManipulateExample() {

		$document = ComradeOPML::newDocument();

		$document->addCategory('Superfluous')
			->addFeed('Useless Things', 'http//uselesss.things/rss');

		$document->addCategory('News')
			->addFeed('Horrible News', 'http//horribe.news/rss')
			->addFeed('Good Times', 'http//good.times/rss');

		$document->removeCategory('Superfluous');
		$document->getCategory('News')->removeFeed('http//horribe.news/rss');

		$this->assertEquals(1, count($document->getAllCategories()));
		$this->assertEquals(1, count($document->getCategory('News')->getAllFeeds()));
	}

}