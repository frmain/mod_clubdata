<?php
/**
 * @package     mod_clubdata
 *
 * @copyright   Copyright (C) 2017 vv Bruse Boys. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::stylesheet('com_clubdata/clubdata.css', array(), true);

JHtml::script(Juri::base() . 'media/com_clubdata/js/ajax.js');

function randomImage($imagearray) {
    if (empty($imagearray))
        return null;
    else
        return $imagearray[array_rand($imagearray)];
}

?>

<div class="m-clubdata-clubschedule m-clubdata-carousel">
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
<?php } else {
    echo JHtml::_('bootstrap.carousel', 'schedulecarousel', array('interval'=>500, 'pause'=>'hover'));
    
?>
	<div id="schedulecarousel" class="carousel slide" data-ride="carousel">
	<div class="m-clubdata-introtext"><?php echo $introtext;?></div>

        <!-- Indicators -->
        <ol class="carousel-indicators">
        	<?php $i = 0;
            foreach ($scheduledmatches as $match) {
            ?>
                <li data-target="#schedulecarousel" data-slide-to="<?php $i ?>" <?php if($i==0) echo 'class="active"' ?>></li>
        	<?php $i++; } ?>
        </ol>
        
        <!-- Wrapper for slides -->
        <div class="carousel-inner">
        	<?php $i = 0;
        	foreach ($scheduledmatches as $match) {
        	    //*** determine background image
        	    $img = null;
        	    $imgurl = null;
        	    if (($useimg == 1 || $useimg == 3) && !empty($teams)) {
        	        if (key_exists($match->thuisteamid, $teams)) $img = $teams[$match->thuisteamid]->teamfoto;
                    elseif (key_exists($match->uitteamid, $teams)) $img = $teams[$match->uitteamid]->teamfoto;
                    if ($img) $imgurl= "data:image/png;base64," . $img;
        	    }
        	    if (($useimg == 2) && !empty($dirimages)) {
       	            $imgurl = randomImage($dirimages);
        	    }
        	    if (($useimg == 3) && !empty($dirimages)) {
        	        if (empty($img)) {
                        $imgurl = randomImage($dirimages); 
                    } else {
                        $imgurl= "data:image/png;base64," . $img;
                    }
        	    }
        	    //***
            ?>
                <div class="m-clubdata-car-match item <?php if($i==0) echo "active" ?>" 
                    <?php if (!empty($imgurl)) { ?>
                		style="background-image:  linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url('<?php echo $imgurl ?>');"
                    <?php } ?>
                >
                	<div class="m-clubdata-car-match-inner">
                 		<div class="m-clubdata-car-match-date"><?php echo (new JDate($match->wedstrijddatum->format('Y-m-d')))->format('D j M'); ?></div>
                		<div class="m-clubdata-car-match-time"><?php echo $match->aanvangstijd ?></div>
                		<div class="m-clubdata-car-match-title">
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
                	</div>
                </div>
        	<?php $i++; } ?>
        </div>
        
        <!-- Left and right controls -->
        <a class="left carousel-control" href="#schedulecarousel" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#schedulecarousel" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
            <span class="sr-only">Next</span>
        </a>

        <?php 
        if (!empty($menulinkurl) && !empty($menulinktext)) { ?>
            <div class="m-clubdata-linktext">
            	<a class="m-clubdata-menulink" href="<?php echo $menulinkurl ?>"><?php echo $menulinktext ?></a>
            </div>
        <?php 
        } ?>
    </div>
    
<?php } ?>
</div>		
