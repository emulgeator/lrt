<?php namespace Test;


use Illuminate\Database\Query\Builder;
use Mockery;
use App\Services\LinkHandler;

class LinkHandlerTest extends TestCase {

	/**
	 * @test
	 */
	public function eraseLinks_shouldTruncateLinksTable() {
		$dbManager = $this->expectTruncate();

		$linkHandler = new LinkHandler($dbManager);
		$linkHandler->eraseLinks();
	}

	/**
	 * @test
	 */
	public function storeLinks_shouldCallInsertForEveryThousandRows() {
		$testData = range(1, 2000);

		$dbManager = $this->expectInsert(array(range(1, 1000), range(1001, 2000)));

		(new LinkHandler($dbManager))->storeLinks($testData);

	}

	/**
	 * @test
	 */
	public function getAnchorOccurrenceStat_shouldRetrieveStatsFromDb() {
		$expectedResult = array('test');
		$dbManager = $this->expectGetDataFromDb($expectedResult);

		$result = (new LinkHandler($dbManager))->getAnchorOccurrenceStat();

		$this->assertEquals($expectedResult, $result);
	}

	/**
	 * @test
	 */
	public function getLinkStatusOccurrenceStat_shouldRetrieveStatsFromDb() {
		$expectedResult = array('test');
		$dbManager = $this->expectGetDataFromDb($expectedResult);

		$result = (new LinkHandler($dbManager))->getLinkStatusOccurrenceStat();

		$this->assertEquals($expectedResult, $result);
	}

	/**
	 * @test
	 */
	public function getFromUrlOccurrenceStat_shouldRetrieveStatsFromDb() {
		$expectedResult = array('test');
		$dbManager = $this->expectGetDataFromDb($expectedResult);

		$result = (new LinkHandler($dbManager))->getFromUrlHostnameOccurrenceStat();

		$this->assertEquals($expectedResult, $result);
	}

	/**
	 * @test
	 */
	public function getBlDomOccurrenceStat_shouldRetrieveStatsFromDb() {
		$expectedResult = array('test');
		$dbManager = $this->expectGetDataFromDb($expectedResult);

		$result = (new LinkHandler($dbManager))->getBlDomOccurrenceStat();

		$this->assertEquals($expectedResult, $result);
	}

	protected function expectTruncate() {
		$builderMock = Mockery::mock('\Illuminate\Database\Query\Builder')
			->shouldReceive('truncate')
			->once()
			->getMock();

		return $this->getDatabaseManagerWithTable($builderMock);
	}


	protected function expectInsert(array $chunks) {
		$builderMock = Mockery::mock('\Illuminate\Database\Query\Builder');

		foreach ($chunks as $chunk) {
			$builderMock
				->shouldReceive('insert')
				->ordered()
				->with($chunk)
				->getMock();
		}

		return $this->getDatabaseManagerWithTable($builderMock);
	}


	protected function getDatabaseManagerWithTable(Builder $builderMock) {
		$dbConnectionMock = Mockery::mock('Illuminate\Database\Connection')
			->shouldReceive('table')
			->once()
			->with('link')
			->andReturn($builderMock)
			->getMock();

		return Mockery::mock('Illuminate\Database\DatabaseManager')
			->shouldReceive('connection')
			->once()
			->andReturn($dbConnectionMock)
			->getMock();
	}

	protected function expectGetDataFromDb($expectedResult) {
		$dbConnectionMock = Mockery::mock('Illuminate\Database\Connection')
			->shouldReceive('select')
			->once()
			->andReturn($expectedResult)
			->getMock();

		return Mockery::mock('Illuminate\Database\DatabaseManager')
			->shouldReceive('connection')
			->once()
			->andReturn($dbConnectionMock)
			->getMock();
	}
}