<?php

namespace Phpdemo\Test;

use Phpdemo\WordsController;

require_once 'src/WordsController.php';
require_once 'src/WordsModel.php';

class WordsControllerTest extends \PHPUnit_Framework_TestCase {

	public $modelMethodReturns = [
		'getWebPageHtmlContents' => 'getWebPageHtmlContentsResult',
		'getHtmlBodyText' => 'getHtmlBodyTextResult',
		'getAllWordsFromHtml' => ['getAllWordsFromHtmlResult'],
		'deleteWordsWithSpecSymbols' => ['deleteWordsWithSpecSymbolsResult'],
	];
	private $mockModel;
	private $testUrl = 'http://foo';

	function setUp() {
		$this->mockModel = $this->getMock('Phpdemo\WordsModel');

		foreach ($this->modelMethodReturns as $method => $returnValue) {
			$this->mockModel->expects($this->any())
					->method($method)
					->will($this->returnValue($returnValue));
		}

	}

	function testShowTableGetWebPageHtmlIsCalled() {
		$this->expectMethodCalledOnceWithArg('getWebPageHtmlContents', $this->testUrl);
		$this->callShowTable();
	}

	public
	function expectMethodCalledOnceWithArg($methodName, $argument) {
		$this->mockModel->expects($this->once())
				->method($methodName)
				->with($this->equalTo($argument));
	}

	public
	function callShowTable() {
		$controller = new WordsController($this->mockModel);
		$controller->showTable($this->testUrl);
	}

	function testShowTableGetHtmlBodyTextIsCalled() {
		$this->expectMethodCalledOnceWithArg('getHtmlBodyText', 'getWebPageHtmlContentsResult');
		$this->callShowTable();
	}

	function testShowTableGetAllWordsFromHtmlIsCalled() {
		$this->expectMethodCalledOnceWithArg('getAllWordsFromHtml', 'getHtmlBodyTextResult');
		$this->callShowTable();

	}

	function testShowTableDeleteWordsWithSpecSymbolsIsCalled() {
		$this->expectMethodCalledOnceWithArg('deleteWordsWithSpecSymbols', ['getAllWordsFromHtmlResult']);
		$this->callShowTable();
	}

	function testShowTableDeleteNonUniqueWordsIsCalled() {
		$this->expectMethodCalledOnceWithArg('deleteNonUniqueWords', ['deleteWordsWithSpecSymbolsResult']);
		$this->callShowTable();
	}

	function testShowTableSortWordsIsCalled() {
		$this->expectMethodCalledOnceWithArg('deleteNonUniqueWords', ['deleteWordsWithSpecSymbolsResult']);
		$this->callShowTable();
	}


}

