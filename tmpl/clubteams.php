<?php
/**
 * @package     mod_clubdata
 *
 * @copyright   Copyright (C) 2017 vv Bruse Boys. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

?>

<div class="m-clubdata-teams">
<?php if (empty($teams)) { ?>
	<div class="m-clubdata-nodata">
		<?php JText::_('MOD_KNVB_DATASERVICE_ERR_NO_DATA') ?>
	</div>
<?php } else { 		
	foreach ($teams as $team) { ?>
	<div class="m-clubdata-team">
		<div class="m-clubdata-team-name"><?php echo $club->clubnaam . " " . $team->teamnaam ?></div>
	</div>
	<?php } ?>
<?php } ?>
</div>		