<?php

namespace Phpdemo;

require_once 'WordsModel.php';
require_once 'HtmlOutput.php';

class WordsController {

	/**
	 * @var WordsModel
	 */
	private $wordsModel;

	/**
	 * @var HtmlOutput
	 */
	private $out;

	function __construct(WordsModel $wordsModel, HtmlOutput $out) {
		$this->wordsModel = $wordsModel;
		$this->out = $out;
	}

	public function showTable($url) {

		$model = &$this->wordsModel;
		$html = $model->getWebPageHtmlContents($url);
		$body = $model->getHtmlBodyText($html);
		$words = $model->getAllWordsFromHtml($body);
		$words = $model->deleteWordsWithSpecSymbols($words);
		$words = $model->deleteNonUniqueWords($words);
		$words = $model->sortWords($words);
		$table = $model->makeWordsTableByFirstLetter($words);
		$rowsCount = $model->getMaxWordCountByLetter($table);

		$this->out->display(
			$this->out->makeHtml($table, $rowsCount)
		);
	}





}
