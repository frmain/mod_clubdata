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
		<div class="knvbds-leagues"> 
<?php
	foreach ($dataresult->List as $league) {
		switch ($league->CompType) {
			case 'R': $comptype = JText::_('MOD_KNVB_DATASERVICE_FIELD_COMPTYPE_REGULAR'); break;
			case 'B': $comptype = JText::_('MOD_KNVB_DATASERVICE_FIELD_COMPTYPE_CUP'); break;
			case 'N': $comptype = JText::_('MOD_KNVB_DATASERVICE_FIELD_COMPTYPE_PLAYOFFS'); break;
			case 'V': $comptype = JText::_('MOD_KNVB_DATASERVICE_FIELD_COMPTYPE_FRIENDLY');  break;
			default: $comptype = '';
		}
		echo '<div class="knvbds-league">';
		echo '<div class="knvbds-league-name">' . $league->CompName . '</div>';
		echo '<div class="knvbds-league-class-poule">' . $league->ClassName . POULESEPARATOR . $league->PouleName . '</div>';
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
[CompName] => Mannen Zaterdag standaard (A-cat) 
[ClassName] => 2e klasse 
[PouleName] => E 
[District] => Z1 
[CompId] => 0212 
[ClassId] => 12 
[PouleId] => 379726 
[CompType] => R 
[metStand] => J 
[Perioden] => 3 ) 

stdClass Object ( 
[CompName] => Mannen KNVB beker Amateurs poule 
[ClassName] => Groep 1 
[PouleName] => 13 
[District] => Z1 
[CompId] => B1000 
[ClassId] => 21 
[PouleId] => 388211 
[CompType] => B 
[metStand] => J 
[Perioden] => 0 )
*/	
?>