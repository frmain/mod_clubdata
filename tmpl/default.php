<?php
/**
 * @package     mod_clubdata
 *
 * @copyright   Copyright (C) 2017 vv Bruse Boys. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
JHtml::_('bootstrap.framework');
JHtml::_('bootstrap.popover');

$app = JFactory::getApplication();
$teamcode=$app->input->getVar('teamcode');
$league=$app->input->getvar('league');

$link = new JUri(JRoute::_(JUri::base().'index.php?option=com_clubdata&task=display&format=raw', false));
$link->setVar('teamcode', $teamcode);
$link->setVar('league', $league);

?>
<div class="m-clubdata">
    <?php 
    	echo JHtml::_('bootstrap.startAccordion', 'accClub');
    	echo JHtml::_('bootstrap.addSlide', 'accClub', JText::_('MOD_CLUBDATA_CLUB_SCHEDULE_SLIDE'), 'accClubSchedule');
    ?>
    <?php 
 	    require JModuleHelper::getLayoutPath('mod_clubdata', $params->get('layout', 'clubschedule'));
 	?>
    <?php 
    	echo JHtml::_('bootstrap.endSlide');
    	echo JHtml::_('bootstrap.addSlide', 'accClub', JText::_('MOD_CLUBDATA_CLUB_RESULTS_SLIDE'), 'accClubResults');
    	?>
    
    <?php 
    	echo JHtml::_('bootstrap.endSlide');
    	echo JHtml::_('bootstrap.addSlide', 'accClub', JText::_('MOD_CLUBDATA_CLUB_CANCELLATIONS_SLIDE'), 'accClubCancellations');
    	?>
    
    <?php 
    	echo JHtml::_('bootstrap.endSlide');
    	echo JHtml::_('bootstrap.endAccordion');
    ?>
    <div id="clubloader" class="clubdata-loader-wrapper">
    	<div class="clubdata-loader"></div>
    </div>
</div>
<?php 
$document = JFactory::getDocument();
$document->addScriptDeclaration('
	(function($){
		$(document).ready(function() {
		    $(document).ajaxStart(function(){
		    });
		    $(document).ajaxComplete(function(){
		    });
			var func = 	function(e){
	        		var target = $(e.target).attr("href"); // activated slide
alert("target: " + target);
					if (!target) return false;
					var tmp = "";
					switch(target) {
						case "#accClubSchedule": tmp = "&view=nextleagueschedule";break;
						case "#accClubResults": tmp = "&view=ownleagueschedule";break;
						case "#accClubCancellations": tmp = "&view=leagueschedule";break;
					}					
					if (!$.trim( $(target).html() ).length) {  // check if element is empty
				        $.ajax(
							{url: "'. $link->toString() .'".concat(tmp), 
							type: "post",
							dataType: "html",
							async: true,
						    beforeSend: function(){
						        	$("#scheduleloader").show();
							    },
						    complete: function(){
						        	$("#scheduleloader").hide();
						    	},
							error: function (xhr, ajaxOptions, thrownError) {
						        	$(target).html("Error: " + xhr.status + ", " + thrownError);
						    	},
							success: function(result){
            						$(target).html(result);
    								$("[data-toggle=\'popover\']").popover();
								}
							});
					}
	    	}

	    	$("#accClub > li > a").on("shown.bs.tab", func);
			$("#accClub > li.active > a").trigger("shown.bs.tab");
		});
	}) (jQuery);
');
?>
