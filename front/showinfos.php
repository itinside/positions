<?php

/*
 * @version $Id: HEADER 15930 2013-02-07 09:47:55Z tsmr $
  -------------------------------------------------------------------------
  Positions plugin for GLPI
  Copyright (C) 2003-2011 by the Positions Development Team.

  https://forge.indepnet.net/projects/positions
  -------------------------------------------------------------------------

  LICENSE

  This file is part of Positions.

  Positions is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  Positions is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with Positions. If not, see <http://www.gnu.org/licenses/>.
  --------------------------------------------------------------------------
 */

include ('../../../inc/includes.php');

if (!isset($_GET["file"])) {
   $_GET["file"] = "";
   $image        = $_GET['img'];
} else {
   $image = $_GET['file'];
}

$items_id = $_GET['items_id'];
$name     = $_GET['name'];
$itemtype = $_GET['itemtype'];
$idpos    = $_GET['id'];

$pos = new PluginPositionsPosition();

if ($itemtype == 'Location') {
   PluginPositionsPosition::showGeolocLocation($itemtype, $items_id);
} else {

   $detail   = new PluginPositionsInfo();
   $restrict = "`is_active` = 1 ";
   $pos->getFromDB($idpos);
   $restrict  = "`is_active` = '1' AND `is_deleted` = '0'";
   $restrict .= getEntitiesRestrictRequest(" AND ", "glpi_plugin_positions_infos", '', '', $pos->maybeRecursive());
   $infos     = getAllDatasFromTable('glpi_plugin_positions_infos', $restrict);

   $item = new $itemtype();
   $item->getFromDB($items_id);

   PluginPositionsPosition::showOverlay($items_id, $image, $item, $infos);
}
?>