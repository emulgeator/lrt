<?php namespace App\Services;


/**
 * Service class responsible for handling the CSV related tasks.
 *
 * @package App\Services
 */
class CsvHandler {

	/**
	 * Parses the given CSV file and returns its content as an associative array.
	 *
	 * @param string $path   Path to the CSV file.
	 *
	 * @return array
	 */
	public function getCsvContent($path) {
		$file = fopen($path, 'r');

		$header = array(
			'favorites',
			'from_url',
			'to_url',
			'anchor_text',
			'link_status',
			'type',
			'bl_dom',
			'dom_pop',
			'power',
			'trust',
			'power_trust',
			'Alexa',
			'ip',
			'country',
		);
		$isFirstRow = true;
		$data = array();
		while (($row = fgetcsv($file, 1000, ',', '"')) !== false) {
			if ($isFirstRow) {
				$isFirstRow = false;
				continue;
			}
			else {
				$row = array_combine($header, $row);
				$row['bl_dom'] = $this->removeThousandSeparator($row['bl_dom']);
				$row['dom_pop'] = $this->removeThousandSeparator($row['dom_pop']);
				$row['power'] = $this->removeThousandSeparator($row['power']);
				$row['trust'] = $this->removeThousandSeparator($row['trust']);
				$row['power_trust'] = $this->removeThousandSeparator($row['power_trust']);
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
	public function removeThousandSeparator($value) {
		return (int)str_replace(',', '', $value);
	}
}