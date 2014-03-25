<?php

namespace Innoscience\ComradeOPML\Resource;

/**
 * Class Feed
 * @package Innoscience\ComradeOPML\Resource
 */
class Feed {

	/**
	 * @var string
	 */
	protected $text;
	/**
	 * @var string
	 */
	protected $title;
	/**
	 * @var string
	 */
	protected $xmlUrl;
	/**
	 * @var string
	 */
	protected $htmlUrl;
	/**
	 * @var string
	 */
	protected $category;

	/**
	 * @param $category
	 * @param $text
	 * @param $xmlUrl
	 * @param string $title
	 * @param string $htmlUrl
	 * @param string $type
	 */
	public function __construct($category, $text, $xmlUrl, $title = '', $htmlUrl = '', $type = 'rss') {
		$this->setCategory($category);
		$this->setText($text);
		$this->setXmlUrl($xmlUrl);
		$this->setTitle($title);
		$this->setHtmlUrl($htmlUrl);
		$this->setType($type);
	}

	/**
	 * @return string
	 */
	public function getCatgory() {
		return $this->category;
	}

	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @return string
	 */
	public function getText() {
		return $this->text;
	}

	/**
	 * @return string
	 */
	public function getXmlUrl() {
		return $this->xmlUrl;
	}

	/**
	 * @return string
	 */
	public function getHtmlUrl() {
		return $this->htmlUrl;
	}

	/**
	 * @return string
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * @param $string
	 */
	public function setText($string) {
		$this->text = (string) $string;
	}

	/**
	 * @param $string
	 */
	public function setTitle($string) {
		$this->title = (string) $string;
	}

	/**
	 * @param $string
	 */
	public function setXmlUrl($string) {
		$this->xmlUrl = (string) $string;
	}

	/**
	 * @param $string
	 */
	public function setHtmlUrl($string) {
		$this->htmlUrl = (string) $string;
	}

	/**
	 * @param $string
	 */
	public function setCategory($string) {
		$this->category = (string) $string;
	}

	/**
	 * @param $string
	 */
	public function setType($string) {
		$this->type = (string) $string;
	}
}