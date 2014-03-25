<?php

namespace Innoscience\ComradeOPML;

use Innoscience\ComradeOPML\Resource\Document;

/**
 * Class ComradeOPML
 * @package Innoscience\ComradeOPML
 */
class ComradeOPML {

	/**
	 * @param $file
	 *
	 * @return Document
	 * @throws \Exception
	 */
	public static function importFile($file) {
		if (!file_exists($file)) {
			throw new \Exception("OPML file [{$file}] not found");
		}

		return static::import(file_get_contents($file));
	}

	/**
	 * @param $string
	 *
	 * @return Document
	 */
	public static function importString($string) {
		return static::import($string);
	}

	/**
	 * @param $xmlString
	 *
	 * @return Document
	 * @throws \Exception
	 */
	protected static function import($xmlString) {

		if (empty($xmlString)) {
			throw new \Exception("OPML data cannot be empty.");
		}

		return static::newDocument()->parse($xmlString);
	}

	/**
	 * @return Document
	 */
	public static function newDocument() {
		return new Document();
	}

	/**
	 * @param Document $document
	 * @param $filePath
	 *
	 * @return int
	 */
	public static function exportFile(Document $document, $filePath) {
		return file_put_contents($filePath, $document);
	}

}