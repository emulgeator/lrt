<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Services\LinkHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LinkController extends Controller {

	/**
	 * @var LinkHandler
	 */
	protected $linkHandler;

	/**
	 * @param LinkHandler $linkHandler
	 */
	function __construct(LinkHandler $linkHandler) {
		$this->linkHandler = $linkHandler;
	}

	/**
	 * Displays a chart of the Anchor stats
	 *
	 * @return Response
	 */
	public function getAnchorChart() {
		$anchorStats = $this->linkHandler->getAnchorOccurrenceStat();

		return view('link.anchorChart', compact('anchorStats'));
	}

	/**
	 * Displays a chart of the link status stats
	 *
	 * @return Response
	 */
	public function getLinkStatusChart() {
		$linkStatusStats = $this->linkHandler->getLinkStatusOccurrenceStat();

		return view('link.linkStatusChart', compact('linkStatusStats'));
	}

	/**
	 * Displays a chart of the from URL stats
	 *
	 * @return Response
	 */
	public function getFromUrlChart() {
		$fromUrlStats = $this->linkHandler->getFromUrlHostnameOccurrenceStat();

		return view('link.fromUrlChart', compact('fromUrlStats'));
	}


	/**
	 * Displays a chart of the BL dom stats
	 *
	 * @return Response
	 */
	public function getBlDomChart() {
		$blDomStats = $this->linkHandler->getBlDomOccurrenceStat();

		return view('link.blDomChart', compact('blDomStats'));
	}
}
