<?php

/* Copyright (c) 1998-2009 ILIAS open source, Extended GPL, see https://github.com/ILIAS-eLearning/ILIAS/tree/trunk/docs/LICENSE */

require_once __DIR__ . "/../../vendor/autoload.php";

use srag\DIC\SrTile\DICTrait;
use srag\Plugins\SrTile\Tile\Tile;
use srag\Plugins\SrTile\TileGUI\TileFormGUI\TileFormGUI;
use srag\Plugins\SrTile\Utils\SrTileTrait;

/**
 * Class SrTileGUI
 *
 * Generated by srag\PluginGenerator v0.9.2
 *
 * @author            studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 * @author            studer + raimann ag - Martin Studer <ms@studer-raimann.ch>
 *
 * @ilCtrl_isCalledBy SrTileGUI: ilUIPluginRouterGUI
 */
class SrTileGUI {

	use DICTrait;
	use SrTileTrait;
	const PLUGIN_CLASS_NAME = ilSrTilePlugin::class;
	const CMD_EDIT_TILE = "editTile";
	const CMD_UPDATE_TILE = "updateTile";
	const CMD_CANCEL = "cancel";
	const LANG_MODULE_TILE = "tile";
	const GET_PARAM_OBJ_REF_ID = 'ref_id';
	const GET_PARAM_REF_ID = "ref_id";
	const GET_PARAM_TARGET = "target";


	/**
	 * SrTileGUI constructor
	 */
	public function __construct() {

	}


	/**
	 *
	 */
	public function executeCommand()/*: void*/ {
		$next_class = self::dic()->ctrl()->getNextClass($this);

		switch (strtolower($next_class)) {
			default:
				$cmd = self::dic()->ctrl()->getCmd();

				switch ($cmd) {
					case self::CMD_EDIT_TILE:
					case self::CMD_UPDATE_TILE:
					case self::CMD_CANCEL:
						$this->{$cmd}();
						break;
					default:
						break;
				}
				break;
		}
	}


	/**
	 * @param Tile $tile
	 *
	 * @return TileFormGUI
	 */
	protected function getTileFormGUI(Tile $tile): TileFormGUI {
		$form = new TileFormGUI($this, $tile);

		return $form;
	}


	/**
	 *
	 */
	protected function cancel()/*:void*/ {
		$this->dic()->ctrl()->initBaseClass(ilRepositoryGUI::class);
		ilObjectGUI::_gotoRepositoryNode(self::filterRefId());
	}


	/**
	 *
	 */
	protected function editTile()/*: void*/ {
		$tile = Tile::getInstanceForObjRefId(filter_input(INPUT_GET, "ref_id"));
		self::dic()->ctrl()->saveParameterByClass(SrTileGUI::class, self::GET_PARAM_OBJ_REF_ID);

		if (!is_object($tile)) {
			$tile = new Tile();
		}

		$form = $this->getTileFormGUI($tile);

		self::output()->output($form);
	}


	/**
	 *
	 */
	protected function updateTile()/*: void*/ {
		$tile = Tile::getInstanceForObjRefId($this->filterRefId());
		self::dic()->ctrl()->saveParameterByClass(SrTileGUI::class, self::GET_PARAM_OBJ_REF_ID);

		if (!is_object($tile)) {
			$tile = new Tile();
			$tile->setObjRefId(self::filterRefId());
		}

		$form = $this->getTileFormGUI($tile);

		$form->storeForm();

		ilUtil::sendSuccess(self::plugin()->translate("saved", self::LANG_MODULE_TILE), true);

		self::dic()->ctrl()->redirect($this, self::CMD_EDIT_TILE);
	}


	/**
	 * @return int|null
	 */
	public static function filterRefId()/*: ?int*/ {
		$ref_id = filter_input(INPUT_GET, self::GET_PARAM_REF_ID);
		if (is_null($ref_id)) {
			$param_target = filter_input(INPUT_GET, self::GET_PARAM_TARGET);
			$ref_id = explode('_', $param_target)[1];
		}

		return $ref_id;
	}
}
