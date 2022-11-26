<?php
use function GuzzleHttp\Promise\exception_for;

/**
 * @package     Joomla
 * @subpackage  mod_clubdata
 *
 * @copyright   Copyright (C) 2017 vv Bruse Boys. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JLoader::register('ModClubDataHelper', __DIR__ . '/helper.php');

JHtml::stylesheet('mod_clubdata/mod_clubdata.css', array(), true);

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

$daycount = $params->get('daycount', 7);
$tabshow = $params->get('tabshow', array());
$carousel = $params->get('carouseloption', 0) || in_array("focus", $tabshow);
$dir = $params->get('imgfolder', '');
$useimg = $params->get('useimgoption', 0);
$introtext = $params->get('introtext', '');
$showhomeaway= $params->get('showhomeawayoption', 0);
$linkownteams= $params->get('linkownteamoption', 0);
$focusedteams = $params->get('focusedteamcodes', array());
$menuitemid = $params->get('linkmenuitem', '');
$menulinktext = $params->get('linkmenuitemtext', '');
$menulinkurl = JRoute::_('index.php?Itemid=' . $menuitemid);

$club = ModClubDataHelper::getClub();
$clubs = ModClubDataHelper::getClubs();
$clubcodes = ModClubDataHelper::getClubcodes();

switch ($params->get('displayoption', 0)) {
	case 3:
		break;
	case 4:
		try {
			$scheduledmatches = ModClubDataHelper::getScheduledMatches($daycount, $showhomeaway==0 || $showhomeaway==1, $showhomeaway==0 || $showhomeaway==2);
			$focusedmatches = ModClubDataHelper::filterFocusedMatches($scheduledmatches, $focusedteams);
		} catch (Exception $e) {
			JLog::add($e->getMessage(), JLog::ERROR, 'mod_clubdata');
			$warning = JText::sprintf("MOD_CLUBDATA_SPORTLINK_DATA_ERROR",$e->getMessage());
		}
		if ($carousel) {
			if ($useimg == 1 || $useimg == 3) { // use team image from Sportlink
				$teams = ModClubDataHelper::getTeams();
			} 
			if ($useimg == 2 || $useimg == 3) { // use image from folder
				$dirimages = ModClubDataHelper::getImageFiles($dir);
			}
			require JModuleHelper::getLayoutPath('mod_clubdata', $params->get('layout', 'clubschedulecarousel'));
		} else {
			require JModuleHelper::getLayoutPath('mod_clubdata', $params->get('layout', 'clubschedule'));
		}
		break;
	case 5:
		try {
			$playedmatches = ModClubDataHelper::getMatchResults($daycount);
		} catch (Exception $e) {
			JLog::add($e->getMessage(), JLog::ERROR, 'mod_clubdata');
			$warning = JText::sprintf("MOD_CLUBDATA_SPORTLINK_DATA_ERROR",$e->getMessage());
		}
		require JModuleHelper::getLayoutPath('mod_clubdata', $params->get('layout', 'clubresults'));
		break;
	case 10:
		try {
			$teams = ModClubDataHelper::getTeams();
		} catch (Exception $e) {
			JLog::add($e->getMessage(), JLog::ERROR, 'mod_clubdata');
			$warning = JText::sprintf("MOD_CLUBDATA_SPORTLINK_DATA_ERROR",$e->getMessage());
		}
		require JModuleHelper::getLayoutPath('mod_clubdata', $params->get('layout', 'clubteams'));
		break;
	case 11: //clubmix
		// place introtext above tabs instead of inside 
		$introtext_overall = $introtext;
		$introtext = '';
		$menulinktext_overall = $menulinktext;
		$menulinktext = '';
		
		// Define tabs options
		$tabsclubmixoptions = array("active" => ($carousel ? 'tabClubMixHighlight' : 'tabClubMixSchedule'));
		try {
			$scheduledmatches = ModClubDataHelper::getScheduledMatches($daycount);
			$playedmatches = ModClubDataHelper::getMatchResults($daycount);
			$focusedmatches = ModClubDataHelper::filterFocusedMatches($scheduledmatches, $focusedteams, $showhomeaway==0 || $showhomeaway==1, $showhomeaway==0 || $showhomeaway==2);
			if ($carousel) {
				$teams = ModClubDataHelper::getTeams();
				if ($useimg == 2 || $useimg == 3) { // use image from folder
					$dirimages = ModClubDataHelper::getImageFiles($dir);
				}
			}
		} catch (Exception $e) {
			JLog::add($e->getMessage(), JLog::ERROR, 'mod_clubdata');
			$warning = JText::sprintf("MOD_CLUBDATA_SPORTLINK_DATA_ERROR",$e->getMessage());
		}
		require JModuleHelper::getLayoutPath('mod_clubdata', $params->get('layout', 'clubmix'));
		break;
	case 11: //clubcancellations
		// todo
		break;
}
