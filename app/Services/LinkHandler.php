<?php namespace App\Services;


use Illuminate\Database\Connection;
use Illuminate\Database\DatabaseManager;

/**
 * Service class responsible for handling the Link related tasks.
 */
class LinkHandler {

	/**
	 * @var Connection
	 */
	protected $dbConnection;

	/**
	 * @param Connection $dbManager
	 */
	function __construct(DatabaseManager $dbManager) {
		$this->dbConnection = $dbManager->connection('lrt');
	}

	/**
	 * Erases all the links from the Database
	 */
	public function eraseLinks() {
		$this->dbConnection->table('link')->truncate();
	}

	/**
	 * Stores the given links to the Database.
	 *
	 * @param array $links
	 */
	public function storeLinks(array $links) {
		$chunks = array_chunk($links, 1000);

		foreach ($chunks as $chunk) {
			$this->dbConnection->table('link')->insert($chunk);
		}
	}
}