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

	/**
	 * Returns the anchor_text occurrence stats.
	 *
	 * @return array
	 */
	public function getAnchorOccurrenceStat() {
		$query = '
			SELECT
				anchor_text, COUNT(*) as occurrenceCount
			FROM
				link
			GROUP BY
				anchor_text
		';

		return $this->dbConnection->select($query);
	}

	/**
	 * Returns the link_status occurrence stats.
	 *
	 * @return array
	 */
	public function getLinkStatusOccurrenceStat() {
		$query = '
			SELECT
				link_status, COUNT(*) as occurrenceCount
			FROM
				link
			GROUP BY
				link_status
		';

		return $this->dbConnection->select($query);
	}

	/**
	 * Returns the from_url_hostname occurrence stats.
	 *
	 * @return array
	 */
	public function getFromUrlHostnameOccurrenceStat() {
		$query = '
			SELECT
				from_url_hostname, COUNT(*) as occurrenceCount
			FROM
				link
			GROUP BY
				from_url_hostname
		';

		return $this->dbConnection->select($query);
	}

	/**
	 * Returns the bl_dom occurrence stats.
	 *
	 * @return array
	 */
	public function getBlDomOccurrenceStat() {
		$query = '
			SELECT
				L.blDomRange,
				COUNT(*) AS occurrenceCount
			FROM
			(
				SELECT
					bl_dom,
					CASE
						WHEN bl_dom = 0 THEN \'0\'
						WHEN bl_dom BETWEEN 1     AND 10    THEN \'1-10\'
						WHEN bl_dom BETWEEN 11    AND 100   THEN \'11-100\'
						WHEN bl_dom BETWEEN 101   AND 999   THEN \'101-999\'
						WHEN bl_dom BETWEEN 1000  AND 9999  THEN \'1000-9999\'
						WHEN bl_dom BETWEEN 10000 AND 99999 THEN \'10000-99999\'
						ELSE \'>=100,000\'
					END AS blDomRange
				FROM
					link
			) L
			GROUP BY
				L.blDomRange
			ORDER BY
				L.bl_dom
		';

		return $this->dbConnection->select($query);
	}
}