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
$dir = $params->get('imgfolder', '');
$useimg = $params->get('useimgoption', 0);
$introtext = $params->get('introtext', '');
$showhomeaway= $params->get('showhomeawayoption', 0);
$linkownteams= $params->get('linkownteamoption', 0);
$menuitemid = $params->get('linkmenuitem', '');
$menulinktext = $params->get('linkmenuitemtext', '');
$menulinkurl = JRoute::_('index.php?Itemid=' . $menuitemid);

$club = ModClubDataHelper::getClub();

switch ($params->get('displayoption', 0)) {
    case 3:
        break;
    case 4:
        try {
            $scheduledmatches = ModClubDataHelper::getScheduledMatches($daycount, $showhomeaway==0 || $showhomeaway==1, $showhomeaway==0 || $showhomeaway==2);
        } catch (Exception $e) {
            JLog::add($e->getMessage(), JLog::ERROR, 'mod_clubdata');
            $warning = JText::sprintf("MOD_CLUBDATA_SPORTLINK_DATA_ERROR",$e->getMessage());
        }
	    if ($params->get('carouseloption', 0)) {
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
	    try {
	        $scheduledmatches = ModClubDataHelper::getScheduledMatches();
    	    $playedmatches = ModClubDataHelper::getMatchResults();
	    } catch (Exception $e) {
	        JLog::add($e->getMessage(), JLog::ERROR, 'mod_clubdata');
	        $warning = JText::sprintf("MOD_CLUBDATA_SPORTLINK_DATA_ERROR",$e->getMessage());
	    }
	    require JModuleHelper::getLayoutPath('mod_clubdata', $params->get('layout', 'clubmix'));
	    break;
}
