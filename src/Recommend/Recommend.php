<?php

namespace srag\Plugins\SrTile\Recommend;

use ilSrTilePlugin;
use srag\DIC\SrTile\DICTrait;
use srag\Plugins\Notifications4Plugins\Notification\srNotification;
use srag\Plugins\Notifications4Plugins\NotificationSender\srNotificationMailSender;
use srag\Plugins\SrTile\Tile\Tile;
use srag\Plugins\SrTile\Utils\SrTileTrait;
use Throwable;

/**
 * Class Recommend
 *
 * @package srag\Plugins\SrTile\Recommend
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class Recommend {

	use DICTrait;
	use SrTileTrait;
	const PLUGIN_CLASS_NAME = ilSrTilePlugin::class;
	/**
	 * @var Tile
	 */
	protected $tile;
	/**
	 * @var string
	 */
	protected $recommended_to = "";
	/**
	 * @var string
	 */
	protected $message = "";


	/**
	 * Recommend constructor
	 */
	public function __construct(Tile $tile) {
		$this->tile = $tile;
	}


	/**
	 * @return bool
	 */
	public function send() {
		try {
			$mail_template = $this->tile->getProperties()->getRecommendMailTemplate();

			$notification = srNotification::getInstanceByName($mail_template);

			$sender = new srNotificationMailSender($this->getRecommendedTo());

			$placeholders = [
				"link" => $this->getLink(),
				"message" => $this->getMessage(),
				"object" => $this->tile->getProperties()->getIlObject(),
				"user" => self::dic()->user()
			];

			return $notification->send($sender, $placeholders, $placeholders["user"]->getLanguage());
		} catch (Throwable $ex) {
			return false;
		}
	}


	/**
	 * @return string
	 */
	public function getLink(): string {
		return $this->tile->getProperties()->getLink();
	}


	/**
	 * @return string
	 */
	public function getRecommendedTo(): string {
		return $this->recommended_to;
	}


	/**
	 * @param string $recommended_to
	 */
	public function setRecommendedTo(string $recommended_to)/*: void*/ {
		$this->recommended_to = $recommended_to;
	}


	/**
	 * @return string
	 */
	public function getMessage(): string {
		return $this->message;
	}


	/**
	 * @param string $message
	 */
	public function setMessage(string $message)/*: void*/ {
		$this->message = $message;
	}
}