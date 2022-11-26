<?php
/**
 * @package     mod_clubdata
 *
 * @copyright   Copyright (C) 2017 vv Bruse Boys. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;


?>

<div class="m-clubdata-clubschedule">
<?php 
if (!empty($warning)) { ?>
<div class="m-clubdata-message alert alert-warning">
	<?php echo $warning; ?>
</div>
<?php 
} elseif (empty($scheduledmatches)) { ?>
	<div class="m-clubdata-nomatches">
		<?php JText::_('MOD_CLUBDATA_NO_DATA') ?>
	</div>
<?php 
} else {
?>
	<div class="m-clubdata-introtext"><?php echo $introtext;?></div>
	<?php 
	$lastdate = null;
	foreach ($scheduledmatches as $match) {
		// make a header per date; list need to be sorted by date
		if ($match->datum != $lastdate) {
			if (!empty($lastdate)) echo "</div>" ?>
			<h4 class="m-clubdata-match-date"><?php echo (new JDate($match->wedstrijddatum->format('Y-m-d')))->format('D j M'); ?></h4>
			<div class="m-clubdata-match-date-group">
			<?php 
			$lastdate = $match->datum;
		} ?>
			 	<div class="m-clubdata-match hasPopover <?php if ($match->getStatuscode() == 1) { echo 'm-clubdata-match-cancelled'; } ?>"
						data-toggle="popover"
						data-trigger="hover"
						data-html="true"
						data-placement="auto top" 
						title="<?php echo JText::_('MOD_CLUBDATA_MATCH_DETAILS'); ?>" 
						data-content="<?php echo JText::_('MOD_CLUBDATA_MATCH'), JText::_('MOD_CLUBDATA_ENUMERATION'), "<strong>", $match->wedstrijd, "</strong><br/>",
						JText::_('MOD_CLUBDATA_MATCH_FACILITIES'), JText::_('MOD_CLUBDATA_ENUMERATION'), htmlspecialchars($match->accommodatie), "<br/>",
						JText::_('MOD_CLUBDATA_MATCH_PLACE'), JText::_('MOD_CLUBDATA_ENUMERATION'), htmlspecialchars($match->plaats), "<br/>" ?>"
				>
					<div class="m-clubdata-match-time"><?php echo $match->aanvangstijd ?></div>
					<div class="m-clubdata-match-title"> 
						<span class="m-clubdata-match-home <?php if (in_array($match->thuisteamclubrelatiecode, $clubcodes)) echo 'm-clubdata-favourite'; ?>">
							<?php $clubindex = array_search($match->thuisteamclubrelatiecode, $clubcodes);
							if ($linkownteams && $clubindex !== false) { ?>
								<a href="<?php echo JRoute::_('index.php?option=com_clubdata&view=team&clubindex='.$clubindex.'&teamcode=' . $match->thuisteamid); ?>"><?php echo $match->thuisteam; ?></a>
							<?php } else { echo $match->thuisteam; }?>
						</span>
						<span><?php echo JText::_('MOD_CLUBDATA_TEAMSEPARATOR') ?></span>
						<span class="m-clubdata-match-away <?php if (in_array($match->uitteamclubrelatiecode, $clubcodes)) echo 'm-clubdata-favourite'; ?>">
							<?php $clubindex = array_search($match->uitteamclubrelatiecode, $clubcodes);
								if ($linkownteams && $clubindex !== false) { ?>
								<a href="<?php echo JRoute::_('index.php?option=com_clubdata&view=team&clubindex='.$clubindex.'&teamcode=' . $match->uitteamid); ?>"><?php echo $match->uitteam; ?></a>
							<?php } else { echo $match->uitteam; }?>
						</span>
						<?php if ($match->getStatuscode() == 1) { ?>
							<span class="m-clubdata-match-cancellation">
								<?php echo JText::_('MOD_CLUBDATA_MATCH_CANCELLED'); ?>
							</span>
						<?php }?>
					</div>
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
<?php } ?>
</div>		
