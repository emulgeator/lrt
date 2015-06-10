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


	protected function expectTruncate() {
		$builderMock = Mockery::mock('\Illuminate\Database\Query\Builder')
			->shouldReceive('truncate')
			->once()
			->getMock();

		return $this->getDatabaseManager($builderMock);
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

		return $this->getDatabaseManager($builderMock);
	}


	protected function getDatabaseManager(Builder $builderMock) {
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
}