<?php

namespace srag\Notifications4Plugin\SrTile\Parser;

use srag\DIC\SrTile\DICTrait;
use srag\Notifications4Plugin\SrTile\Utils\Notifications4PluginTrait;

/**
 * Class Factory
 *
 * @package srag\Notifications4Plugin\SrTile\Parser
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
final class Factory {

	use DICTrait;
	use Notifications4PluginTrait;
	/**
	 * @var self
	 */
	protected static $instance = null;


	/**
	 * @return self
	 */
	public static function getInstance(): self {
		if (self::$instance === null) {
			self::$instance = new self();
		}

		return self::$instance;
	}


	/**
	 * Factory constructor
	 */
	private function __construct() {

	}


	/**
	 * @return twigParser
	 */
	public function twig(): twigParser {
		return new twigParser();
	}
}