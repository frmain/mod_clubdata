<?php

/**
 * @package     Joomla
 * @subpackage  mod_clubdata
 *
 * @copyright   Copyright (C) 2017 vv Bruse Boys. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JLoader::registerPrefix('ClubData', JPATH_SITE . '/components/com_clubdata');
JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_clubdata/models', 'ClubDataModel');

/**
 * Helper for mod_clubdata
 */
class ModClubDataHelper
{

    /**
     * Get the Club
     * 
     * @return SportlinkClubData\Club  The Sportlink Club object
	 */
    public static function getClub() {
        $clubmodel = JModelLegacy::getInstance('Club', 'ClubDataModel');
        return $clubmodel->getClub();
    }
    
    /**
     * Get the scheduled club matches for the next 8 days
     * 
     * @return SportlinkClubData\Match[]  List of Match objects
     */
    public static function getScheduledMatches($daycount=null, $home=true, $away=true) {
 
        $clubmodel = JModelLegacy::getInstance('Club', 'ClubDataModel');
        return $clubmodel->getClubSchedule($daycount, $home, $away);
    }
    
    /**
     * Get the club match results of the last week
     *
     * @return SportlinkClubData\Match[]  List of Match objects
     */
    public static function getMatchResults($daycount=null) {
        
        $clubmodel = JModelLegacy::getInstance('Club', 'ClubDataModel');
        return $clubmodel->getClubResults($daycount);
    }
    
    /**
     * Get the teams of the club
     *
     * @return SportlinkClubData\Team[]  List of Team objects
     */
    public static function getTeams() {
        $clubmodel = JModelLegacy::getInstance('Club', 'ClubDataModel');
        return $clubmodel->getTeams();
    }
    
    /**
     * Get the imagefiles in a directory
     * 
     * @param string $dir absolute directory path
     *
     * @return array  Array of string with url file names
     */
    public static function getImageFiles($dir) {
        
        $jver_ge38 = ((JVersion::MAJOR_VERSION == 3) && (JVersion::MINOR_VERSION >= 8)) || (JVersion::MAJOR_VERSION > 3);
        if ($jver_ge38) {
            $dir = JPATH_ROOT.'/images/'.$dir;
        }
        if (!is_dir($dir)) return null;
        $urlpath = str_replace(JPATH_BASE, rtrim(JURI::root(), '/\\'), $dir);
        $urlpath = str_replace('\\', '/', $urlpath);
        $dh = opendir($dir);
        while (false !== ($filename = readdir($dh))) {
            $dirfiles[] = $urlpath . '/'. $filename;
        }
        closedir($dh);
        $images=preg_grep('/\.(jpg|jpeg|png|gif)(?:[\?\#].*)?$/i', $dirfiles);
        return $images;
    }

}
