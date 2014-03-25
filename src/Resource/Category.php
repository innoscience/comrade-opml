<?php

namespace Innoscience\ComradeOPML\Resource;

/**
 * Class Category
 * @package Innoscience\ComradeOPML\Resource
 */
class Category {

	/**
	 * @var
	 */
	protected $text;
	/**
	 * @var
	 */
	protected $title;
	/**
	 * @var array
	 */
	protected $feeds = array();

	/**
	 * @param $category
	 * @param string $categoryTitle
	 */
	public function __construct($text, $title = '') {
		$this->setText((string) $text);
		$this->setTitle((string) $title);
	}

	/**
	 * @param $title
	 * @param $xmlUrl
	 * @param string $text
	 * @param string $htmlUrl
	 *
	 * @return $this
	 */
	public function addFeed($text, $xmlUrl, $title = '', $htmlUrl = '', $type = 'rss') {
		$this->feeds[(string) $xmlUrl] = new Feed($this->getText(), (string)$text, (string)$xmlUrl, (string)$title, (string)$htmlUrl, (string)$type);
		return $this;
	}

	/**
	 * @param $xmlUrl
	 *
	 * @return \Innoscience\ComradeOPML\Resource\Feed
	 */
	public function getFeed($xmlUrl) {
		return $this->feeds[$xmlUrl];
	}

	/**
	 * @return array
	 */
	public function getAllFeeds() {
		return $this->feeds;
	}

	/**
	 * @param $xmlUrl
	 *
	 * @return $this
	 */
	public function removeFeed($xmlUrl) {
		unset($this->feeds[(string) $xmlUrl]);
		return $this;
	}

	/**
	 * @param $category
	 *
	 * @return $this
	 */
	public function setText($category) {
		$this->text = (string) $category;
		return $this;
	}

	/**
	 * @param $categoryTitle
	 *
	 * @return $this
	 */
	public function setTitle($categoryTitle) {
		$this->title = (string) $categoryTitle;
		return $this;
	}

	/**
	 * @return $this->category
	 */
	public function getText() {
		return $this->text;
	}

	/**
	 * @return $this->categoryText
	 */
	public function getTitle() {
		return $this->title;
	}



}