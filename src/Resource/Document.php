<?php

namespace Innoscience\ComradeOPML\Resource;
use SimpleXMLElement;
use DOMDocument;

/**
 * Class Document
 * @package Innoscience\ComradeOPML\Resource
 */
class Document {

	protected $categories = array();
	protected $domInstance = null;

	protected $title;
	protected $dateCreated;
	protected $dateModified;
	protected $ownerName;
	protected $ownerEmail;
	protected $expansionState;
	protected $vertScrollState;
	protected $windowTop;
	protected $windowLeft;
	protected $windowBottom;
	protected $windowRight;

	/**
	 * @param $category
	 *
	 * @return \Innoscience\ComradeOPML\Resource\Category
	 */
	public function addCategory($category, $title = '') {
		$category = (string) $category;
		$title = (string) $title?:$category;

		$this->categories[$category] = new Category($category, $title);
		return $this->categories[$category];
	}

	/**
	 * @param $category
	 *
	 * @return \Innoscience\ComradeOPML\Resource\Category
	 */
	public function getCategory($category) {
		$category = (string) $category;
		return $this->categories[$category];
	}

	/**
	 * @return array
	 */
	public function getAllCategories() {
		return $this->categories;
	}

	/**
	 * @param $category
	 *
	 * @return $this->categories
	 */
	public function removeCategory($category) {
		unset($this->categories[(string)$category]);
		return $this;
	}

	/**
	 * @param $category
	 * @param $title
	 * @param $xmlUrl
	 * @param string $text
	 * @param string $htmlUrl
	 *
	 * @return $this
	 */
	public function addFeed($category, $text, $xmlUrl, $title = '', $htmlUrl = '', $type = 'rss') {
		if (!isset($this->categories[$category])) {
			$this->addCategory((string) $category);
		}

		$this->categories[(string) $category]->addFeed($text, $xmlUrl, $title, $htmlUrl, $type);

		return $this;
	}

	/**
	 * @param $xmlString
	 *
	 * @return $this
	 * @throws \Exception
	 */
	public function parse($xmlString) {

		$xmlDocument = new SimpleXMLElement($xmlString);

		if (!isset($xmlDocument->body) || !isset($xmlDocument->body->outline)) {
			throw new \Exception("Invalid OPML data.");
		}

		if ($xmlDocument->head) {
			if (isset($xmlDocument->head->title)) {
				$this->setTitle($xmlDocument->head->title);
			}

			if (isset($xmlDocument->head->dateCreated)) {
				$this->setDateCreated($xmlDocument->head->dateCreated);
			}

			if (isset($xmlDocument->head->dateModified)) {
				$this->setDateModified($xmlDocument->head->dateModified);
			}

			if (isset($xmlDocument->head->ownerName)) {
				$this->setOwnerName($xmlDocument->head->ownerName);
			}

			if (isset($xmlDocument->head->ownerEmail)) {
				$this->setOwnerEmail($xmlDocument->head->ownerEmail);
			}

			if (isset($xmlDocument->head->expansionState)) {
				$this->setExpansionState($xmlDocument->head->expansionState);
			}

			if (isset($xmlDocument->head->vertScrollState)) {
				$this->setVertScrollState($xmlDocument->head->vertScrollState);
			}

			if (isset($xmlDocument->head->windowTop)) {
				$this->setWindowTop($xmlDocument->head->windowTop);
			}

			if (isset($xmlDocument->head->windowLeft)) {
				$this->setWindowLeft($xmlDocument->head->windowLeft);
			}

			if (isset($xmlDocument->head->windowBottom)) {
				$this->setWindowBottom($xmlDocument->head->windowBottom);
			}

			if (isset($xmlDocument->head->windowRight)) {
				$this->setWindowRight($xmlDocument->head->windowRight);
			}
		}

		foreach ($xmlDocument->body->outline as $category) {
			$opmlCategory = $this->addCategory($category['title'], $category['text']);
			foreach ($category->outline as $feed) {
				$opmlCategory->addFeed($feed['title'], $feed['xmlUrl'], $feed['text'], $feed['htmlUrl'], $feed['type']);
			}
		}

		return $this;
	}

	/**
	 * @param DOMDocument $instance
	 *
	 */
	public function setDomInstance(DOMDocument $instance) {
		$this->domInstance = $instance;
	}

	/**
	 * @return string
	 */
	public function output() {

		if ($this->domInstance) {
			$xmlDoc = $this->domInstance;
		}
		else {
			$xmlDoc = new DOMDocument;
			$xmlDoc->encoding = 'UTF-8';
			$xmlDoc->preserveWhiteSpace = false;
			$xmlDoc->formatOutput = true;
		}

		$xmlRoot = $xmlDoc->createElement('opml');
		$xmlRoot->setAttribute('version', '1.0');
		$xmlRootNode = $xmlDoc->appendChild($xmlRoot);

		$headerElem = $xmlDoc->createElement('head');

		if ($this->getTitle()) {
			$headerSubElem = $xmlDoc->createElement('title');
			$headerSubElem->appendChild($xmlDoc->createTextNode($this->getTitle()));
			$headerElem->appendChild($headerSubElem);
		}

		if ($this->getDateCreated()) {
			$headerSubElem = $xmlDoc->createElement('dateCreated');
			$headerSubElem->appendChild($xmlDoc->createTextNode($this->getDateCreated()));
			$headerElem->appendChild($headerSubElem);
		}

		if ($this->getDateModified()) {
			$headerSubElem = $xmlDoc->createElement('dateModified');
			$headerSubElem->appendChild($xmlDoc->createTextNode($this->getDateModified()));
			$headerElem->appendChild($headerSubElem);
		}

		if ($this->getOwnerName()) {
			$headerSubElem = $xmlDoc->createElement('ownerName');
			$headerSubElem->appendChild($xmlDoc->createTextNode($this->getOwnerName()));
			$headerElem->appendChild($headerSubElem);
		}

		if ($this->getOwnerName()) {
			$headerSubElem = $xmlDoc->createElement('ownerName');
			$headerSubElem->appendChild($xmlDoc->createTextNode($this->getOwnerName()));
			$headerElem->appendChild($headerSubElem);
		}

		if ($this->getOwnerEmail()) {
			$headerSubElem = $xmlDoc->createElement('ownerEmail');
			$headerSubElem->appendChild($xmlDoc->createTextNode($this->getOwnerEmail()));
			$headerElem->appendChild($headerSubElem);
		}

		if ($this->getExpansionState()) {
			$headerSubElem = $xmlDoc->createElement('expansionState');
			$headerSubElem->appendChild($xmlDoc->createTextNode($this->getExpansionState()));
			$headerElem->appendChild($headerSubElem);
		}

		if ($this->getVertScrollState()) {
			$headerSubElem = $xmlDoc->createElement('vertScrollState');
			$headerSubElem->appendChild($xmlDoc->createTextNode($this->getVertScrollState()));
			$headerElem->appendChild($headerSubElem);
		}

		if ($this->getWindowTop()) {
			$headerSubElem = $xmlDoc->createElement('windowTop');
			$headerSubElem->appendChild($xmlDoc->createTextNode($this->getWindowTop()));
			$headerElem->appendChild($headerSubElem);
		}

		if ($this->getWindowLeft()) {
			$headerSubElem = $xmlDoc->createElement('windowLeft');
			$headerSubElem->appendChild($xmlDoc->createTextNode($this->getWindowLeft()));
			$headerElem->appendChild($headerSubElem);
		}

		if ($this->getWindowBottom()) {
			$headerSubElem = $xmlDoc->createElement('windowBottom');
			$headerSubElem->appendChild($xmlDoc->createTextNode($this->getWindowBottom()));
			$headerElem->appendChild($headerSubElem);
		}

		if ($this->getWindowRight()) {
			$headerSubElem = $xmlDoc->createElement('windowRight');
			$headerSubElem->appendChild($xmlDoc->createTextNode($this->getWindowRight()));
			$headerElem->appendChild($headerSubElem);
		}

		if ($headerElem->childNodes->length) {
			$xmlRootNode->appendChild($headerElem);
		}

		$bodyElem = $xmlDoc->createElement('body');

		foreach ($this->getAllCategories() as $category) {
			/**
			 * @var $category \Innoscience\ComradeOPML\Resource\Category
			 */
			$catElem = $xmlDoc->createElement('outline');
			$catElem->setAttribute('text', $category->getText());
			$catElem->setAttribute('title', $category->getTitle());

			foreach ($category->getAllFeeds() as $feed) {
				/**
				 * @var $feed \Innoscience\ComradeOPML\Resource\Feed
				 */
				$feedElem = $xmlDoc->createElement('outline');
				$feedElem->setAttribute('type', $feed->getType());
				$feedElem->setAttribute('text', $feed->getText());
				$feedElem->setAttribute('xmlUrl', $feed->getXmlUrl());
				$feedElem->setAttribute('title', $feed->getTitle());
				$feedElem->setAttribute('htmlUrl', $feed->getHtmlUrl());
				$catElem->appendChild($feedElem);
			}
			$bodyElem->appendChild($catElem);
		}
		$xmlRootNode->appendChild($bodyElem);

		return $xmlDoc->saveXML();
	}

	/**
	 * @param $title
	 *
	 * @return $this
	 */
	public function setTitle($title) {
		$this->title = (string) $title;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @param $date
	 *
	 * @return $this
	 */
	public function setDateCreated($date) {
		$this->dateCreated = (string) $date;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getDateCreated() {
		return $this->dateCreated;
	}

	/**
	 * @param $date
	 *
	 * @return $this
	 */
	public function setDateModified($date) {
		$this->dateModified = (string) $date;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getDateModified() {
		return $this->dateModified;
	}

	/**
	 * @param $name
	 *
	 * @return $this
	 */
	public function setOwnerName($name) {
		$this->ownerName = (string) $name;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getOwnerName() {
		return $this->ownerName;
	}

	/**
	 * @param $email
	 *
	 * @return $this
	 */
	public function setOwnerEmail($email) {
		$this->ownerEmail = (string) $email;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getOwnerEmail() {
		return $this->ownerEmail;
	}

	/**
	 * @param $state
	 *
	 * @return $this
	 */
	public function setExpansionState($state) {
		$this->expansionState = (string) $state;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getExpansionState() {
		return $this->expansionState;
	}

	/**
	 * @param $state
	 *
	 * @return $this
	 */
	public function setVertScrollState($state) {
		$this->vertScrollState = (string) $state;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getVertScrollState() {
		return $this->vertScrollState;
	}

	/**
	 * @param $pos
	 *
	 * @return $this
	 */
	public function setWindowTop($pos) {
		$this->windowTop = (string) $pos;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getWindowTop() {
		return $this->windowTop;
	}

	/**
	 * @param $pos
	 *
	 * @return $this
	 */
	public function setWindowLeft($pos) {
		$this->windowLeft = (string) $pos;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getWindowLeft() {
		return $this->windowLeft;
	}

	/**
	 * @param $pos
	 *
	 * @return $this
	 */
	public function setWindowBottom($pos) {
		$this->windowBottom = (string) $pos;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getWindowBottom() {
		return $this->windowBottom;
	}

	/**
	 * @param $pos
	 *
	 * @return $this
	 */
	public function setWindowRight($pos) {
		$this->windowRight = (string) $pos;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getWindowRight() {
		return $this->windowRight;
	}

	/**
	 * @return string
	 */
	public function __toString() {
		return $this->output();
	}

}