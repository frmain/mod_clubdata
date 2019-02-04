<?php
/**
 * @package     mod_clubdata
 *
 * @copyright   Copyright (C) 2017 vv Bruse Boys. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;


?>

<div class="m-clubdata-clubresults">
<?php 
if (!empty($warning)) { ?>
<div class="m-clubdata-message alert alert-warning">
	<?php echo $warning; ?>
</div>
<?php 
} elseif (empty($playedmatches)) { ?>
	<div class="m-clubdata-nomatches">
		<?php JText::_('MOD_CLUBDATA_NO_DATA') ?>
	</div>
<?php 
} else {
?>
	<div class="m-clubdata-introtext"><?php echo $introtext;?></div>
    <?php 
    $lastdate = null;
	foreach ($playedmatches as $match) {
        // make a header per date; list need to be sorted by date
	    if ($match->datum != $lastdate) { 
	        if (!empty($lastdate)) echo "</div>" ?>
	        <h4 class="m-clubdata-match-date"><?php echo (new JDate($match->wedstrijddatum->format('Y-m-d')))->format('D j M'); ?></h4>
	    	<div class="m-clubdata-match-date-group">
    	<?php 
    	   $lastdate = $match->datum;
	    } ?>
            	<div class="m-clubdata-match">
            		<div class="m-clubdata-match-title">
            			<span class="m-clubdata-match-home <?php if ($match->thuisteamclubrelatiecode==$club->clubcode) echo 'm-clubdata-favourite'; ?>">
            				<?php if ($linkownteams && ($match->thuisteamclubrelatiecode==$club->clubcode)) { ?>
            					<a href="<?php echo JRoute::_('index.php?option=com_clubdata&view=team&teamcode=' . $match->thuisteamid); ?>"><?php echo $match->thuisteam; ?></a>
            				<?php } else { echo $match->thuisteam; }?>
            			</span>
            			<span><?php echo JText::_('MOD_CLUBDATA_TEAMSEPARATOR') ?></span>
            			<span class="m-clubdata-match-away <?php if ($match->uitteamclubrelatiecode==$club->clubcode) echo 'm-clubdata-favourite'; ?>">
            				<?php if ($linkownteams && ($match->uitteamclubrelatiecode==$club->clubcode)) { ?>
            					<a href="<?php echo JRoute::_('index.php?option=com_clubdata&view=team&teamcode=' . $match->uitteamid); ?>"><?php echo $match->uitteam; ?></a>
            				<?php } else { echo $match->uitteam; }?>
            			</span>			
            		</div>
            		<div class="m-clubdata-match-result"><?php echo $match->uitslag ?></div>
            	</div>
    	<?php 
	} 
    if (!empty($lastdate)) { ?>
    		</div>
    <?php 
    } 
    if (!empty($menulinkurl) && !empty($menulinktext)) { ?>
        <div class="m-clubdata-linktext">
        	<a class="m-clubdata-menulink" href="<?php echo $menulinkurl ?>"><?php echo $menulinktext ?></a>
        </div>
    <?php 
    } ?>
<?php 
} ?>
</div>		
