<?php namespace App\Services;

use Illuminate\Filesystem\Filesystem;

/**
 * Service class responsible for handling the CSV related tasks.
 *
 * @package App\Services
 */
class CsvHandler {
	/**
	 * @var Filesystem
	 */
	protected $filesystem;

	/**
	 * Create a new command instance.
	 *
	 * @param Filesystem $filesystem
	 */
	public function __construct(Filesystem $filesystem) {
		$this->filesystem = $filesystem;
	}

	/**
	 * Returns the name of the columns in the CSV.
	 *
	 * @return array
	 */
	public function getCsvColumnNames() {
		return array(
			'Favorites', 'From URL', 'To URL', 'Anchor Text', 'Link Status', 'Type', 'BLdom', 'DomPop',
			'Power', 'Trust', 'Power*Trust', 'Alexa', 'IP', 'CNTRY'
		);
	}


	/**
	 * Parses the given CSV file and returns its content as an associative array.
	 *
	 * @param string $path   Path to the CSV file.
	 *
	 * @return array
	 */
	public function getCsvContent($path) {
		if (!$this->filesystem->exists($path)) {
			throw new \Exception('Given path does not exist: "' . $path . '"');
		}

		$file = fopen($path, 'r');

		$columnsInCsv = $this->getCsvColumnNames();

		$columns = array(
			'favorites', 'from_url', 'to_url', 'anchor_text', 'link_status', 'type', 'bl_dom', 'dom_pop',
			'power', 'trust', 'power_trust', 'alexa', 'ip', 'country'
		);

		$isFirstRow = true;
		$data = array();
		while (($row = fgetcsv($file, 1000, ',', '"')) !== false) {
			if ($isFirstRow) {
				if ($row !== $columnsInCsv) {
					throw new \Exception('Invalid CSV header!');
				}
				$isFirstRow = false;
				continue;
			}
			else {
				$row = array_combine($columns, $row);
				$row['bl_dom'] = $this->removeThousandSeparator($row['bl_dom']);
				$row['dom_pop'] = $this->removeThousandSeparator($row['dom_pop']);
				$row['power'] = $this->removeThousandSeparator($row['power']);
				$row['trust'] = $this->removeThousandSeparator($row['trust']);
				$row['power_trust'] = $this->removeThousandSeparator($row['power_trust']);
				$row['alexa'] = $this->formatAlexaRanking($row['alexa']);
				$data[] = $row;
			}
		}
		fclose($file);

		return $data;
	}

	/**
	 * Removes the thousand separator comma from the given string and returns it as an integer.
	 *
	 * @param string $value
	 *
	 * @return int
	 */
	protected function removeThousandSeparator($value) {
		return (int)str_replace(',', '', $value);
	}

	/**
	 * Formats the given alexa ranking.
	 *
	 * @param string $ranking
	 *
	 * @return int|null
	 */
	protected function formatAlexaRanking($ranking) {
		$ranking = $this->removeThousandSeparator($ranking);
		return $ranking == 0 ? null : $ranking;
	}
}