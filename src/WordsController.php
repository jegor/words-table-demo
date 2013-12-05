<?php

namespace Phpdemo;

require_once 'WordsModel.php';
class WordsController {

	/**
	 * @var WordsModel
	 */
	private $wordsModel;

	function __construct(WordsModel $wordsModel) {
		$this->wordsModel = $wordsModel;
	}

	public function showTable($url) {
		$html = $this->wordsModel->getWebPageHtmlContents($url);
		$body = $this->wordsModel->getHtmlBodyText($html);
		$words = $this->wordsModel->getAllWordsFromHtml($body);
		$words = $this->wordsModel->deleteWordsWithSpecSymbols($words);
		$words = $this->wordsModel->deleteNonUniqueWords($words);
		$words = $this->wordsModel->sortWords($words);
		$table = $this->wordsModel->makeWordsTableByFirstLetter($words);
		$rows = $this->wordsModel->getMaxWordCountByLetter($table);
		$output = $this->getOutputHtml($table, $rows);
		$this->output($output);
	}

	public function output($outputHtml) {
		echo $outputHtml;
	}

	private function getOutputHtml($table, $rows) {
		return "";
	}

}
