<?php namespace Test;


use Mockery;
use App\Services\CsvHandler;

class CsvHandlerTest extends TestCase {

	/**
	 * @var \Mockery\MockInterface
	 */
	protected $filesystemMock;

	public function __construct($name = null, array $data = array(), $dataName = '') {
		parent::__construct($name, $data, $dataName);

		$this->filesystemMock = Mockery::mock('\Illuminate\Filesystem\Filesystem');
	}

	/**
	 * @test
	 */
	public function getCsvContentWhenFileDoesNotExist_shouldThrowException() {
		$path = 'test';

		$this->expectCheckIfFileExists($path, false);
		$csvHandler = new CsvHandler($this->filesystemMock);

		$this->setExpectedException('\Exception', 'Given path does not exist:');
		$csvHandler->getCsvContent($path);
	}

	/**
	 * @test
	 */
	public function getCsvContentWhenFileNotReadable_shouldThrowException() {
		$path = '/tmp/nonExistent';

		$this->expectCheckIfFileExists($path, true);
		$csvHandler = new CsvHandler($this->filesystemMock);

		$this->setExpectedException('\ErrorException');
		$csvHandler->getCsvContent($path);
	}

	/**
	 * @test
	 */
	public function getCsvContentWhenHeadersAreInvalid_shouldThrowException() {
		$path = base_path('tests/data/invalidHeader.csv');

		$this->expectCheckIfFileExists($path, true);
		$csvHandler = new CsvHandler($this->filesystemMock);

		$this->setExpectedException('\Exception', 'Invalid CSV header!');
		$csvHandler->getCsvContent($path);
	}

	/**
	 * @test
	 */
	public function getCsvContentWhenCsvValid_shouldReturnItsContent() {
		$path = base_path('tests/data/valid.csv');

		$this->expectCheckIfFileExists($path, true);
		$csvHandler = new CsvHandler($this->filesystemMock);
		$expectedResult = array(array(
			'favorites'         => 'favorites',
			'from_url'          => 'http://fromUrl.com/test',
			'from_url_hostname' => 'fromUrl.com',
			'to_url'            => 'to url',
			'anchor_text'       => 'anchor text',
			'link_status'       => 'link status',
			'type'              => 'type',
			'bl_dom'            => 123456,
			'dom_pop'           => 12345,
			'power'             => 1,
			'trust'             => 2,
			'power_trust'       => 3,
			'alexa'             => null,
			'ip'                => '50.116.50.37',
			'country'           => 'US'
		));

		$result = $csvHandler->getCsvContent($path);

		$this->assertEquals($expectedResult, $result);
	}


	protected function expectCheckIfFileExists($path, $expectedResult) {
		$this->filesystemMock
			->shouldReceive('exists')
				->once()
				->with($path)
				->andReturn($expectedResult);
	}
}