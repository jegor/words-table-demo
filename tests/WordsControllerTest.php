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
		'deleteNonUniqueWords' => ['deleteNonUniqueWordsResult'],
		'sortWords' => ['sortWordsResult'],
		'makeWordsTableByFirstLetter' => ['makeWordsTableByFirstLetterResult'],
		'getMaxWordCountByLetter' => 'getMaxWordCountByLetterResult'

	];
	/**
	 * @var \PHPUnit_Framework_MockObject_MockObject
	 */
	private $mockModel;
	/**
	 * @var \PHPUnit_Framework_MockObject_MockObject
	 */
	private $mockOut;
	private $testUrl = 'http://foo';

	function setUp() {
		$this->prepareModelMock();
		$this->prepareHtmlOutputMock();
	}

	private function prepareModelMock() {
		$this->mockModel = $this->getMock('Phpdemo\WordsModel');
		foreach ($this->modelMethodReturns as $method => $returnValue) {
			$this->mockModel
					->expects($this->any())
					->method($method)
					->will($this->returnValue($returnValue));
		}
	}

	private function prepareHtmlOutputMock() {
		$this->mockOut = $this->getMock('Phpdemo\HtmlOutput');
		$this->mockOut
				->expects($this->any())
				->method('makeHtml')
				->will($this->returnValue('<html>foo</html>'));
	}

	function testShowTableGetWebPageHtmlIsCalled() {
		$this->expectMethodCalledOnceWithArg('getWebPageHtmlContents', $this->testUrl);
		$this->callShowTable();
	}

	function expectMethodCalledOnceWithArg($methodName, $argument) {
		$this->mockModel
				->expects($this->once())
				->method($methodName)
				->with($argument);
	}

	function callShowTable() {
		$controller = new WordsController($this->mockModel, $this->mockOut);
		$controller->showTable($this->testUrl);
	}

	function testShowTableGetHtmlBodyTextIsCalled() {
		$this->expectMethodCalledOnceWithArg('getHtmlBodyText', $this->modelMethodReturns['getWebPageHtmlContents']);
		$this->callShowTable();
	}

	function testShowTableGetAllWordsFromHtmlIsCalled() {
		$this->expectMethodCalledOnceWithArg('getAllWordsFromHtml', $this->modelMethodReturns['getHtmlBodyText']);
		$this->callShowTable();

	}

	function testShowTableDeleteWordsWithSpecSymbolsIsCalled() {
		$this->expectMethodCalledOnceWithArg(
			'deleteWordsWithSpecSymbols',
			$this->modelMethodReturns['getAllWordsFromHtml']);
		$this->callShowTable();
	}

	function testShowTableDeleteNonUniqueWordsIsCalled() {
		$this->expectMethodCalledOnceWithArg(
			'deleteNonUniqueWords',
			$this->modelMethodReturns['deleteWordsWithSpecSymbols']);
		$this->callShowTable();
	}

	function testShowTableSortWordsIsCalled() {
		$this->expectMethodCalledOnceWithArg('sortWords', $this->modelMethodReturns['deleteNonUniqueWords']);
		$this->callShowTable();
	}

	function testShowTableMakeWordsTableByFirstLetterIsCalled() {
		$this->expectMethodCalledOnceWithArg('makeWordsTableByFirstLetter', $this->modelMethodReturns['sortWords']);
		$this->callShowTable();
	}

	function testShowTableGetMaxWordCountByLetterIsCalled() {
		$this->expectMethodCalledOnceWithArg(
			'getMaxWordCountByLetter',
			$this->modelMethodReturns['makeWordsTableByFirstLetter']);
		$this->callShowTable();
	}

	function testShowTableGetOutputHtmlIsCalled() {
		$this->mockOut
				->expects($this->once())
				->method('makeHtml')
				->with(
					$this->modelMethodReturns['makeWordsTableByFirstLetter'],
					$this->modelMethodReturns['getMaxWordCountByLetter']
				);
		$this->callShowTable();
	}

	function testShowTableMakeHtmlIsCalled() {
		$this->mockOut
				->expects($this->once())
				->method('makeHtml')
				->with(
					$this->modelMethodReturns['makeWordsTableByFirstLetter'],
					$this->modelMethodReturns['getMaxWordCountByLetter']
				);
		$this->callShowTable();
	}

	function testShowTableDisplayIsCalled() {
		$this->mockOut
				->expects($this->once())
				->method('display')
				->with('<html>foo</html>');
		$this->callShowTable();
	}


}

