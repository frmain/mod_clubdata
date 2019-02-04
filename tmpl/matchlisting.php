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
		<div class="knvbds-matchlisting"> 
<?php
// print_r($dataresult->List);
		foreach ($dataresult->List as $match) {
			$home_favorite = $helper->teamsearch($match->ThuisTeamId);
			$away_favorite = $helper->teamsearch($match->UitTeamId);
			echo '<div class="knvbds-match">';
			echo '<div class="knvbds-matchdate">' . date_format(date_create($match->Datum), 'd-m') . '</div>';
			echo '<div class="knvbds-teams">';
			echo '<span class="knvbds-hometeam';
			if ($home_favorite) {echo ' knvbds-favourite';}
			echo '">' . $match->ThuisClub . '</span>';
			echo TEAMSEPARATOR;
			echo '<span class="knvbds-awayteam';
			if ($away_favorite) {echo ' knvbds-favourite';}
			echo '">' . $match->UitClub . '</span>';
			echo '</div>';
			echo '<div class="knvbds-matchdetails">';
			$matchstart = DateTime::createFromFormat('Y-m-d Hi', $match->Datum . ' ' . $match->Tijd);
			$matchend = clone $matchstart;
			$matchend->add(new DateInterval('PT2H')); // after 2 hours assumed the match has ended
			$game_played =  (new DateTime() > $matchend) ||
			 !(is_null($match->PuntenTeam1) || is_null($match->PuntenTeam2));
			if ($game_played) {
				//game has been played
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
			} else {
				//game is scheduled 
				echo '<div class="knvbds-matchtime">' . date_format($matchstart, 'H:i') . '</div>';
			}
			echo '</div></div>';
		}
?>		
		</div> 
<?php

	}

/*
Example Match not played yet:
stdClass Object ( 
[Datum] => 2015-03-21 
[Tijd] => 1430 
[ThuisLogo] => http://knvbdataservice.nl/sites/all/themes/knvbdataservice/images/clublogo/1425064829.png 
[ThuisClub] => Bruse Boys 1 
[ThuisClubNummer] => BBHT55V 
[ThuisTeamId] => 133473 
[ThuisTeamSpeeldag] => ZA 
[UitLogo] => http://api.knvbdataservice.nl/images/leeg-clublogo-schildje.png 
[UitClub] => Tern.Boys 1 
[UitClubNummer] => BBHZ17H 
[UitTeamId] => 135377 
[UitTeamSpeeldag] => ZA 
[Scheidsrechter] => Roeland, I. 
[Hulpscheidsrechter1] => 
[Hulpscheidsrechter2] => 
[Facility_Id] => BBHT58Y 
[Facility_naam] => Sportpark Volharding 
[Facility_Stad] => BRUINISSE 
[Facility_Postcode] => 4311RT 
[Facility_Adres] => Nijverheidsweg 25-27 
[Aantal_Fotos] => 0 
[Aantal_Videos] => 0 
[Aantal_Reacties] => 
[Overzicht_Reacties] => 
[PuntenTeam1] => 
[PuntenTeam2] => 
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
[WedstrijdDag] => 20 
[Periode] => 3 
[Zaalveld] => Veld 
[MatchId] => 8845540 
[WedstrijdNummer] => 8045 
[Bijzonderheden] => 
[VeldKNVB] => Veld 2 
[VeldClub] => 
[Kleedkamer_thuis] => 
[Kleedkamer_uit] => 
[Kleedkamer_official] => )

Match played:
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

*/	
?>