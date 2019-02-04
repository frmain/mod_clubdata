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
		<div class="knvbds-schedule"> 
<?php
		foreach ($dataresult->List as $match) {
			echo '<div class="knvbds-match">';
			$matchdate = DateTime::createFromFormat('Y-m-d Hi', $match->Datum . ' ' . $match->Tijd);
			echo '<div class="knvbds-matchdate">' . date_format($matchdate, $dateformat) . '</div>';
			//echo '<div class="knvbds-matchdate">' . strftime("%a %d-%m|%H:%M", $matchdate) . '</div>';
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
			echo '</div></div>';
		}
?>		
		</div> 
<?php

	}

/*
Example:
stdClass Object ( 
[MatchID] => 8845540 
[WedstrijdNummer] => 8045 
[Datum] => 2015-03-21 
[Tijd] => 1430 
[ThuisClub] => Bruse Boys 1 
[ThuisLogo] => http://knvbdataservice.nl/sites/all/themes/knvbdataservice/images/clublogo/1425064829.png 
[ThuisTeamID] => 133473 
[ThuisTeamSpeeldag] => ZA 
[UitClub] => Tern.Boys 1 
[UitLogo] => http://api.knvbdataservice.nl/images/leeg-clublogo-schildje.png 
[UitTeamID] => 135377 
[UitTeamSpeeldag] => ZA 
[Bijzonderheden] => 
[Scheidsrechter] => Wattel, B. 
[CompNummer] => Z1-0212**-12-379726! 
[CompType] => R [WedstrijdDag] => 20 
[VeldKNVB] => Veld 2 [VeldClub] => 
[Kleedkamer_thuis] => 
[Kleedkamer_uit] => 
[Kleedkamer_official] => )
*/	
?>