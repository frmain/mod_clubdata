<?php
/**
 * @package     mod_knvb_dataservice
 *
 * @copyright   Copyright (C) 2015 vv Bruse Boys. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;


	if (empty($dataresult->List)) {
		echo '<div class="knvbds-nodata">' . JText::_('MOD_KNVB_DATASERVICE_ERR_NO_DATA') . '</div>';
	} else {
?>		
		<div class="knvbds-ranking"> 
<?php
		foreach ($dataresult->List as $team) {
			// determine favourite-team 
			$favorite = $helper->teamsearch($team->TeamID);
			echo '<div class="knvbds-rank">';
			echo '<div class="knvbds-ranknr">' . $team->Positie . '</div>';
			echo '<div class="knvbds-team';
			if ($favorite) {echo ' knvbds-favourite';}
			echo '">' . $team->naam . '</div>';
			echo '<div class="knvbds-matches-total">' . $team->Gespeeld . '</div>';
			echo '<div class="knvbds-matches-won">' . $team->Gewonnen . '</div>';
			echo '<div class="knvbds-matches-draw">' . $team->Gelijk . '</div>';
			echo '<div class="knvbds-matches-lost">' . $team->Verloren . '</div>';
			echo '<div class="knvbds-matches-points">' . $team->Punten . '</div>';
			echo '<div class="knvbds-matches-score">' . $team->DoelpuntenVoor . SCORESEPARATOR . $team->DoelpuntenTegen . '</div>';
			if ($team->PuntenMindering != 0) {
				echo '<div class="knvbds-matches-points-deducted"> -' . $team->PuntenMindering . '</div>';
			}
			echo '</div>';
		}
?>		
		</div> 
<?php

	}

/*
Example:
stdClass Object ( 
[naam] => Bruse Boys 1 
[TeamID] => 133473 
[logo] => http://knvbdataservice.nl/sites/all/themes/knvbdataservice/images/clublogo/1425064829.png 
[Positie] => 1 
[Gespeeld] => 18 
[Gewonnen] => 12 
[Gelijk] => 3 
[Verloren] => 3 
[Punten] => 39 
[DoelpuntenVoor] => 50 
[DoelpuntenTegen] => 16 
[PuntenMindering] => 0 
[CompType] => R 
[CompNummer] => Z1-0212**-12-379726! 
[WedstrijdDag] => ZA 
[Periode] => S ) */	
?>