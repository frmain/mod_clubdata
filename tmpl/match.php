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
		<div class="knvbds-match-single"> 
<?php
		foreach ($dataresult->List as $match) {
			$home_favorite = $helper->teamsearch($match->ThuisTeamId);
			$away_favorite = $helper->teamsearch($match->UitTeamId);
			echo '<div class="knvbds-matchdate">' . date_format(date_create($match->Datum), 'd-m') . '</div>';
			echo '<div class="knvbds-teams">';
			echo '<span class="knvbds-hometeam';
			if ($home_favorite) {echo ' knvbds-favourite';}
			echo '">' . '<img src="' . $match->ThuisLogo . '">'. $match->ThuisClub . '</span>';
			echo TEAMSEPARATOR;
			echo '<span class="knvbds-awayteam';
			if ($away_favorite) {echo ' knvbds-favourite';}
			echo '">' . $match->UitClub . '<img src="' . $match->UitLogo . '">' . '</span>';
			echo '</div>';
			$matchstart = DateTime::createFromFormat('Y-m-d Hi', $match->Datum . ' ' . $match->Tijd);
			$matchend = clone $matchstart;
			$matchend->add(new DateInterval('PT2H')); // after 2 hours assumed the match has ended
			$game_played =  (new DateTime() > $matchend) ||
			 !(is_null($match->PuntenTeam1) || is_null($match->PuntenTeam2));
			if ($game_played) {
				//game has been played
				if (!(is_null($match->PuntenTeam1) || is_null($match->PuntenTeam2))) {
					echo '<div class="knvbds-matchdetails">';
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
				echo '</div>';
			} else {
				//game is scheduled 
				echo '<div class="knvbds-matchtime">' . date_format($matchstart, 'H:i') . '</div>';
				echo '<div class="knvbds-facility-name">' . $match->Facility_naam . '</div>';
				echo '<div class="knvbds-facility-city">' . $match->Facility_Stad . '</div>';
				
			}
		}
?>		
		</div> 
<?php

	}

/*
Example:
stdClass Object ( 
[Datum] => 2015-03-14 
[Tijd] => 1430 
[ThuisLogo] => http://bin617.website-voetbal.nl/sites/voetbal.nl/files/knvblogos/BBJG152.png 
[ThuisClub] => Zwaluwe 1 
[ThuisClubNummer] => BBJG152 
[ThuisTeamId] => 148833 
[ThuisTeamSpeeldag] => ZA 
[UitLogo] => http://knvbdataservice.nl/sites/all/themes/knvbdataservice/images/clublogo/1425064829.png 
[UitClub] => Bruse Boys 1 
[UitClubNummer] => BBHT55V 
[UitTeamId] => 133473 
[UitTeamSpeeldag] => ZA 
[Scheidsrechter] => 
[Hulpscheidsrechter1] => 
[Hulpscheidsrechter2] => 
[Facility_Id] => BBJG163 
[Facility_naam] => Sportpark De Kwarrehoek 
[Facility_Stad] => LAGE ZWALUWE 
[Facility_Postcode] => 4926BV 
[Facility_Adres] => Oudeweg 24 A 
[Aantal_Fotos] => 0 
[Aantal_Videos] => 0 
[Aantal_Reacties] => 
[Overzicht_Reacties] => 
[PuntenTeam1] => 1 
[PuntenTeam2] => 1 
[PuntenTeam1Verl] => 
[PuntenTeam2Verl] => 
[PuntenTeam1Strafsch] => 
[PuntenTeam2Strafsch] => 
[Competitie] => Z1-0212**-12-379726! 
[District] => Z1 
[CompId] => 0212 
[ClassId] => 12 
[PouleId] => 379726 
[CompType] => R 
[WedstrijdDag] => 15 
[Periode] => 2 
[Zaalveld] => Veld 
[MatchId] => 8846730 
[WedstrijdNummer] => 9235 
[Bijzonderheden] => 
[VeldKNVB] => De Kwarrehoek veld 2 
[VeldClub] => 
[Kleedkamer_thuis] => 
[Kleedkamer_uit] => 
[Kleedkamer_official] => ) 
stdClass Object ( 
[Datum] => 2015-03-14 
[Tijd] => 1430 
[ThuisLogo] => http://bin617.website-voetbal.nl/sites/voetbal.nl/files/knvblogos/BBJG152.png 
[ThuisClub] => Zwaluwe 1 
[ThuisClubNummer] => BBJG152 
[ThuisTeamId] => 148833 
[ThuisTeamSpeeldag] => ZA 
[UitLogo] => http://knvbdataservice.nl/sites/all/themes/knvbdataservice/images/clublogo/1425064829.png 
[UitClub] => Bruse Boys 1 
[UitClubNummer] => BBHT55V 
[UitTeamId] => 133473 
[UitTeamSpeeldag] => ZA 
[Scheidsrechter] => 
[Facility_Id] => BBJG163 
[Facility_naam] => Sportpark De Kwarrehoek 
[Facility_Stad] => LAGE ZWALUWE 
[Facility_Postcode] => 4926BV 
[Facility_Adres] => Oudeweg 24 A 
[Aantal_Fotos] => 0 
[Aantal_Videos] => 0 
[Aantal_Verslagen] => 0 
[Aantal_Reacties] => 0 
[PuntenTeam1] => 1 
[PuntenTeam2] => 1 
[PuntenTeam1Verl] => 
[PuntenTeam2Verl] => 
[PuntenTeam1Strafsch] => 
[PuntenTeam2Strafsch] => 
[MatchId] => 8846730 
[WedstrijdNummer] => 9235 
[Longitude] => 4.70271405784836 
[Latitude] => 51.7057840865525 
[Bijzonderheden] => 
[VeldKNVB] => De Kwarrehoek veld 2 
[VeldClub] => 
[Kleedkamer_thuis] => 
[Kleedkamer_uit] => 
[Kleedkamer_official] => )
*/	
?>