<?php namespace App\Console\Commands;

use App\Services\CsvHandler;
use App\Services\LinkHandler;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CsvImporterCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'lrt:csv_importer';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Imports the given CSV file into the Database';

	/**
	 * @var Filesystem
	 */
	protected $filesystem;

	/**
	 * @var \App\Services\CsvHandler
	 */
	protected $csvHandler;

	/**
	 * @var \App\Services\LinkHandler
	 */
	protected $linkHandler;

	/**
	 * Create a new command instance.
	 *
	 * @param Filesystem $filesystem
	 * @param CsvHandler $csvHandler
	 */
	public function __construct(Filesystem $filesystem, CsvHandler $csvHandler, LinkHandler $linkHandler)
	{
		parent::__construct();

		$this->filesystem = $filesystem;
		$this->csvHandler = $csvHandler;
		$this->linkHandler = $linkHandler;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$path = $this->argument('path');

		if (!$this->filesystem->exists($path)) {
			$this->error('Given path "' . $path . '" does not exist!');
		}

		$this->linkHandler->eraseLinks();
		$links = $this->csvHandler->getCsvContent($path);
		$this->linkHandler->storeLinks($links);
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			['path', InputArgument::REQUIRED, 'Path of the CSV file to import'],
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [];
	}

}
