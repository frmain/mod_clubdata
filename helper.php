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
	 * Get the Clubs
	 *
	 * @return SportlinkClubData\Club[]  The Sportlink Club object
	 */
	public static function getClubs() {
		$clubmodel = JModelLegacy::getInstance('Club', 'ClubDataModel');
		return $clubmodel->getClubs();
	}
	
	/**
	 * Get the clubcodes (of all clubs belonging to main club)
	 *
	 * @return array string clubcodes
	 */
	public static function getClubcodes() {
		$clubcodes = array();
		foreach (self::getClubs() as $club) {
			$clubcodes[] = $club->clubcode;
		}
		return $clubcodes;
	}
	
	
	
	/**
	 * Get the scheduled club matches for the next x days
	 * 
	 * @return SportlinkClubData\ClubMatch[]  List of Match objects
	 */
	public static function getScheduledMatches($daycount=null, $home=true, $away=true) {
 
		$clubmodel = JModelLegacy::getInstance('Club', 'ClubDataModel');
		return $clubmodel->getClubSchedule($daycount, $home, $away);
	}
	
	/**
	 * Get the club match results of the last week
	 *
	 * @return SportlinkClubData\ClubMatch[]  List of Match objects
	 */
	public static function getMatchResults($daycount=null) {
		
		$clubmodel = JModelLegacy::getInstance('Club', 'ClubDataModel');
		return $clubmodel->getClubResults($daycount);
	}
	
	/**
	 * Filter the scheduled club matches for the ones who need more focus
	 *
	 * @return SportlinkClubData\ClubMatch[]  List of Match objects
	 */
	public static function filterFocusedMatches($scheduledmatches, $focusedteams=null, $home=true, $away=true) {
		
		$focusedmatches = array();
		foreach ($scheduledmatches as $match) {
			if ( ( ($home && $match->isHomeMatch()) || ($away && $match->isAwayMatch()) ) && 
			(empty($focusedteams) || in_array($match->thuisteamid, $focusedteams) || in_array($match->uitteamid, $focusedteams))) {
				$focusedmatches[$match->wedstrijdcode] = $match;
			}
		}
		// sort on order of focused teams
		if (!empty($focusedteams)) {
			uasort($focusedmatches, 
				function($match1, $match2) use ($focusedteams) {
					if (in_array($match1->thuisteamid, $focusedteams)) $ownteamid1 = $match1->thuisteamid; else $ownteamid1 = $match1->uitteamid;
					if (in_array($match2->thuisteamid, $focusedteams)) $ownteamid2 = $match2->thuisteamid; else $ownteamid2 = $match2->uitteamid;
					return ((array_search($ownteamid1, $focusedteams) > array_search($ownteamid2, $focusedteams)) ? 1 : -1);
				}
			);
		}
		return $focusedmatches;
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
		$dirfiles = array();
		while (false !== ($filename = readdir($dh))) {
			$dirfiles[] = $urlpath . '/'. $filename;
		}
		closedir($dh);
		$images=preg_grep('/\.(jpg|jpeg|png|gif)(?:[\?\#].*)?$/i', $dirfiles);
		return $images;
	}

	/**
	 * Select randomly an image from an array with image file names
	 *
	 * @param array $imagearray array with image file names
	 *
	 * @return string filename referring to an image file
	 */
	public static function randomImage($imagearray) {
		if (empty($imagearray))
			return null;
			else
				return $imagearray[array_rand($imagearray)];
	}
	
	/**
	 * Checks whether a string starts with a certain substring (only needed when php < v8)
	 *
	 * @param string $haystack string to search in
	 * @param string $needle string to search for
	 *
	 * @return bool true when found at beginning of haystack
	 */
	public static function startsWith( $haystack, $needle ) {
		$length = strlen( $needle );
		return substr( $haystack, 0, $length ) === $needle;
	}


}
