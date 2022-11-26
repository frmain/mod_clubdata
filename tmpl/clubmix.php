<?php
/**
 * @package	 mod_clubdata
 *
 * @copyright   Copyright (C) 2017 vv Bruse Boys. All rights reserved.
 * @license	 GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
JHtml::_('bootstrap.framework');
JHtml::_('bootstrap.popover');

?>
<div class="m-clubdata"></div>
	<div class="m-clubdata-introtext"><?php echo $introtext_overall;?></div>
	<?php 
		echo JHtml::_('bootstrap.startTabSet', 'tabsClubMix', $tabsclubmixoptions);
		if (in_array("focus", $tabshow)) {
			echo JHtml::_('bootstrap.addTab', 'tabsClubMix', 'tabClubMixHighlight', '<span class="fa fa-home"></span>&nbsp;' . JText::_('MOD_CLUBDATA_CLUB_HIGHLIGHT_TAB') . '</span>');
			require JModuleHelper::getLayoutPath('mod_clubdata', $params->get('layout', 'clubschedulecarousel'));
			echo JHtml::_('bootstrap.endTab');
		}
	?>
	<?php 
		if (in_array("schedule", $tabshow)) {
			echo JHtml::_('bootstrap.addTab', 'tabsClubMix', 'tabClubMixSchedule', '<span class="fa fa-calendar-o"></span>&nbsp;' . JText::_('MOD_CLUBDATA_CLUB_SCHEDULE_TAB') . '</span>');
	?>
			<div class="m-clubdata-mix">
			<?php
				require JModuleHelper::getLayoutPath('mod_clubdata', $params->get('layout', 'clubschedule'));
			?>
			</div>
	<?php 
			echo JHtml::_('bootstrap.endTab');
		} 
	?>
	<?php 
		if (in_array("results", $tabshow)) {
			echo JHtml::_('bootstrap.addTab', 'tabsClubMix', 'tabClubMixResults', '<span class="fa fa-soccer-ball-o"></span>&nbsp;' . JText::_('MOD_CLUBDATA_CLUB_RESULTS_TAB') . '</span>');
			?>
			<div class="m-clubdata-mix">
			<?php
				require JModuleHelper::getLayoutPath('mod_clubdata', $params->get('layout', 'clubresults'));
			?>
			</div>
	<?php 
			echo JHtml::_('bootstrap.endTab');
		} 
	?>
	<?php 
		if (in_array("cancellations", $tabshow)) {
			echo JHtml::_('bootstrap.addTab', 'tabsClubMix', 'tabClubMixCancellations', '<span class="fa fa-snowflake-o"></span>&nbsp;' . JText::_('MOD_CLUBDATA_CLUB_CANCELLATIONS_TAB') . '</span>');
			?>
			<div class="m-clubdata-mix">
			<?php
				require JModuleHelper::getLayoutPath('mod_clubdata', $params->get('layout', 'clubcancellations'));
			?>
			</div>
	<?php 
			echo JHtml::_('bootstrap.endTab');
		} 
	?>
	<?php
		echo JHtml::_('bootstrap.endTabSet');
	?>
	<div id="clubloader" class="clubdata-loader-wrapper">
		<div class="clubdata-loader"></div>
	</div>
	<?php 
	if (!empty($menulinkurl) && !empty($menulinktext_overall)) { ?>
		<div class="m-clubdata-linktext">
			<a class="m-clubdata-menulink" href="<?php echo $menulinkurl ?>"><?php echo $menulinktext_overall ?></a>
		</div>
	<?php 
	} ?>
</div>
<?php 
$document = JFactory::getDocument();
$document->addScriptDeclaration('
	(function($){
		$(document).ready(function() {
			$("#tabsClubMixTabs > li.active > a").trigger("shown.bs.tab");

			$("#tabsClubMixTabs > li > a").click( function(e) {
				e.preventDefault();
			} );

		});
	}) (jQuery);
');

$document->addScriptDeclaration("
	(function($){
		$(document).ready(function(){
			$('a[data-toggle=\"tab\"]').on('show.bs.tab', function(e) {
				localStorage.setItem('clubmixviewActiveTab', $(e.target).attr('href'));
			});
			var activeTab = localStorage.getItem('clubmixviewActiveTab');
			if(activeTab && $('#tabsClubMixTabs a[href=\"' + activeTab + '\"]').length > 0){
				$('#tabsClubMixTabs a[href=\"' + activeTab + '\"]').tab('show');
			}
		});
	}) (jQuery);
");
?>
