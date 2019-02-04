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
//print_r($league);
		//header
		switch ($league->CompType) {
			case 'R': $comptype = JText::_('MOD_KNVB_DATASERVICE_FIELD_COMPTYPE_REGULAR_SHORT'); break;
			case 'B': $comptype = JText::_('MOD_KNVB_DATASERVICE_FIELD_COMPTYPE_CUP_SHORT');  break;
			case 'N': $comptype = JText::_('MOD_KNVB_DATASERVICE_FIELD_COMPTYPE_PLAYOFFS_SHORT');  break;
			case 'V': $comptype = JText::_('MOD_KNVB_DATASERVICE_FIELD_COMPTYPE_FRIENDLY_SHORT');  break;
		}
		echo '<div class="knvbds-league-header">' . $comptype . ': ' . $league->District . ' ' . $league->ClassName . ' '  . $league->PouleName;
		echo '<div class="knvbds-league-subheader">' . $league->CompName . '</div>';
  	echo '</div>';
?>		
		<div class="knvbds-results"> 
<?php
//print_r($dataresult->List);
		foreach ($dataresult->List as $match) {
			echo '<div class="knvbds-match">';
			echo '<div class="knvbds-matchdate">' . date_format(date_create($match->Datum), $dateformat) . '</div>';
			echo '<div class="knvbds-teams">';
			echo '<span class="knvbds-hometeam';
			// determine favourite-team 
			$home_favorite = $helper->teamsearch($match->ThuisTeamID);
			$away_favorite = $helper->teamsearch($match->UitTeamID);
			if ($home_favorite) {echo ' knvbds-favourite';}
			echo '">' . $match->ThuisClub . '</span>';
			echo TEAMSEPARATOR;
			echo '<span class="knvbds-awayteam';
			if ($away_favorite) {echo ' knvbds-favourite';}
			echo '">' . $match->UitClub . '</span>';
			echo '</div>';
			echo '<div class="knvbds-result">';
			if (!(is_null($match->PuntenTeam1) || is_null($match->PuntenTeam2))) {
				echo '<span class="knvbds-hometeam-result';
				if ($home_favorite) {echo ' knvbds-favourite';}
				echo '">' . $match->PuntenTeam1 . '</span>';
				echo RESULTSEPARATOR;
				echo '<span class="knvbds-awayteam-result';
				if ($away_favorite) {echo ' knvbds-favourite';}
				echo '">' . $match->PuntenTeam2 . '</span>';
			} else {
				echo RESULTSEPARATOR;
			};
			if (!empty($match->Bijzonderheden)) {
				switch ($match->Bijzonderheden) {
					case 'ADO': echo JText::_('MOD_KNVB_DATASERVICE_LABEL_MATCH_CANCELLED'); break;
					case 'ADB': echo JText::_('MOD_KNVB_DATASERVICE_LABEL_MATCH_CANCELLED'); break;
					case 'BNO': echo JText::_('MOD_KNVB_DATASERVICE_LABEL_MATCH_CANCELLED'); break;
					case 'TNO': echo JText::_('MOD_KNVB_DATASERVICE_LABEL_MATCH_CANCELLED'); break;
					case 'SNO': echo JText::_('MOD_KNVB_DATASERVICE_LABEL_MATCH_CANCELLED'); break;
					case 'TAS': echo JText::_('MOD_KNVB_DATASERVICE_LABEL_MATCH_CANCELLED'); break;
					case 'GOB': echo JText::_('MOD_KNVB_DATASERVICE_LABEL_MATCH_ABANDONED'); break;
					case 'GOT': echo JText::_('MOD_KNVB_DATASERVICE_LABEL_MATCH_ABANDONED'); break;
					case 'GVS': echo JText::_('MOD_KNVB_DATASERVICE_LABEL_MATCH_ABANDONED'); break;
					case 'GWO': echo JText::_('MOD_KNVB_DATASERVICE_LABEL_MATCH_ABANDONED'); break;
					case 'GWT': echo JText::_('MOD_KNVB_DATASERVICE_LABEL_MATCH_ABANDONED'); break;
					case 'GWW': echo JText::_('MOD_KNVB_DATASERVICE_LABEL_MATCH_ABANDONED'); break;
					case 'WNO': echo JText::_('MOD_KNVB_DATASERVICE_LABEL_MATCH_ADM_FALSE'); break;
					case 'WOV': echo JText::_('MOD_KNVB_DATASERVICE_LABEL_MATCH_ADM_FALSE'); break;
					default: echo JText::_('MOD_KNVB_DATASERVICE_LABEL_MATCH_ADM_FALSE');
				}
			};
			echo '</div></div>';
		}
?>		
		</div> 
<?php

	}

/*
Example:
stdClass Object ( 
[MatchID] => 8845385 
[WedstrijdNummer] => 7890 
[Datum] => 2014-09-06 
[Tijd] => 1430 
[ThuisClub] => FC Dauwendaele 1 
[ThuisLogo] => http://bin617.website-voetbal.nl/sites/voetbal.nl/files/knvblogos/BBHV01I.png 
[ThuisTeamID] => 130155 
[ThuisClubNummer] => BBHV01I 
[UitClub] => Tern.Boys 1 
[UitLogo] => http://api.knvbdataservice.nl/images/leeg-clublogo-schildje.png 
[UitTeamID] => 135377 
[UitClubNummer] => BBHZ17H 
[PuntenTeam1] => 3 
[PuntenTeam2] => 5 
[PuntenTeam1Verl] => 
[PuntenTeam2Verl] => 
[PuntenTeam1Strafsch] => 
[PuntenTeam2Strafsch] => 
[Bijzonderheden] => 
[Scheidsrechter] => 
[CompType] => R 
[WedstrijdDag] => 1 )

stdClass Object ( 
[MatchID] => 8846730 
[WedstrijdNummer] => 9235 
[Datum] => 2015-03-14 
[Tijd] => 1430 
[ThuisClub] => Zwaluwe 1 
[ThuisLogo] => http://bin617.website-voetbal.nl/sites/voetbal.nl/files/knvblogos/BBJG152.png 
[ThuisTeamID] => 148833 
[UitClub] => Bruse Boys 1 
[UitLogo] => http://knvbdataservice.nl/sites/all/themes/knvbdataservice/images/clublogo/1425064829.png 
[UitTeamID] => 133473 
[PuntenTeam1] => 1 
[PuntenTeam2] => 1 
[PuntenTeam1Verl] => 
[PuntenTeam2Verl] => 
[PuntenTeam1Strafsch] => 
[PuntenTeam2Strafsch] => 
[Bijzonderheden] => 
[Scheidsrechter] => 
[CompType] => R 
[CompNummer] => Z1-0212**-12-379726! 
[WedstrijdDag] => 15 ) 
*/	
?>