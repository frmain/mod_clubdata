<?php
/**
 * @package     mod_knvb_dataservice
 *
 * @copyright   Copyright (C) 2015 vv Bruse Boys. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

define('SEPARATOR', '-');


	if (empty($dataresult->List)) {
		echo '<div class="knvbds-nodata">' . JText::_(MOD_KNVB_DATASERVICE_ERR_NO_DATA) . '</div>';
	} else {
?>		
		<div class="knvbds-leagues"> 
<?php
	foreach ($dataresult->List as $league) {
		switch ($league->CompType) {
			case 'R': $comptype = JText::_(MOD_KNVB_DATASERVICE_FIELD_COMPTYPE_REGULAR); break;
			case 'B': $comptype = JText::_(MOD_KNVB_DATASERVICE_FIELD_COMPTYPE_CUP); break;
			case 'N': $comptype = JText::_(MOD_KNVB_DATASERVICE_FIELD_COMPTYPE_PLAYOFFS); break;
			default: $comptype = '';
		}
		echo '<div class="knvbds-league">';
		echo '<div class="knvbds-league-teamid">' . $league->TeamId . '</div>';
		echo '<div class="knvbds-league-teamname">' . $league->TeamAanduiding . '</div>';
		echo '<div class="knvbds-league-name">' . $league->CompName . '</div>';
		echo '<div class="knvbds-league-class-poule">' . $league->ClassName . SEPARATOR . $league->PouleName . '</div>';
		echo '<div class="knvbds-league-type">' . $comptype . '</div>';
		echo '</div>';
	}
?>		
		</div> 
<?php

	}

/*
Example:
stdClass Object ( 
[CompName] => A-Junioren 
[ClassName] => 2e klasse 
[PouleName] => A21 
[District] => Z1 
[CompId] => 0222 
[ClassId] => 12 
[PouleId] => 379771 
[CompType] => R 
[TeamId] => 133488 
[TeamAanduiding] => A1 
[metStand] => J 
[Perioden] => 0 ) 

stdClass Object ( 
[CompName] => A-Junioren beker 2e ronde 
[ClassName] => Groep 5 
[PouleName] => 1 
[District] => Z1 
[CompId] => B3220 
[ClassId] => 25 
[PouleId] => 403639 
[CompType] => B 
[TeamId] => 133488 
[TeamAanduiding] => A1 
[metStand] => N 
[Perioden] => 0 )

*/	
?>