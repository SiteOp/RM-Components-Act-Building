<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Act_building
 * @author     Birgit Gebhard <info@routes-manager.de>
 * @copyright  2021 Birgit Gebhard
 * @license    GNU General Public License Version 2 oder später; siehe LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

use \Joomla\CMS\Factory;
use \Joomla\CMS\Router\Route;
use \Joomla\CMS\Language\Text;

$canEdit = Factory::getUser()->authorise('core.edit', 'com_act_building');

// Routes-Planning Params
$app = Factory::getApplication();
$params = $app->getParams();
$params         = $app->getParams('com_routes_planning');

$sectors = Act_buildingHelpersAct_building::getSectors($this->item->id);
$total_lines = Act_buildingHelpersAct_building::getTotalLinesFromBuilding($this->item->id);	

?>
<?php echo Text::_(''); ?>
<div id="building">
	<div class="page-header">
		<h1><?php echo  $this->item->building; ?></h1> 
	</div>
	<div class="row">
		<div class="col-12 col-lg-4">
			<div class="card">
				<div class="card-header">   
					<h3><?php echo Text::_('COM_ACT_BUILDING_SEKTORS'); ?>/<?php echo Text::_('COM_ACT_BUILDING_LINES'); ?></h3>
				</div>
				<div class="card-body">
					<table class="table table-striped table-sm table-hover">
						<thead>
							<tr>
								<th><?php echo Text::_('COM_ACT_BUILDING_SEKTOR'); ?></th>
								<th class="text-center"><?php echo Text::_('COM_ACT_BUILDING_LINES'); ?></th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($sectors AS $sector) : ?>
							<tr>
								<td><?php echo $sector->sector; ?></td>
								<td class="text-center"><?php echo  Act_buildingHelpersAct_building::getTotalLinesFromSector($sector->id); ?></td>
							</tr>
						<?php endforeach; ?>
						</tbody>
						<tfooter>
							<tr>
								<td></td>
								<td class="text-center"><?php echo $total_lines; ?></td>
							</tr>
						</tfooter>
					</table>
				</div>
			</div>
		</div>

		<?php // Wenn Sollerfassung innerhalb des Gebäudes ?>
		<?php if ((1 == $this->record_should) && (1 == $this->record_sector_or_building))  :  ?>

				<div class="col-12 col-lg-8">
					<div class="card">
						<div class="card-header">
							<h3><i class="fas fa-align-justify"></i> <?php echo Text::_('COM_ACT_BUILDING_SHOULD_DISTRIBUTE_GRADES'); ?></h3>
						</div>
						<div class="card-body">
							<?php if(1 == $this->record_type) { // Einzelwert (0) oder Prozente (1)?
								echo $this->loadTemplate('charts');
								echo '<div class="text-center mt-4">Anzahl Routen Soll: ' .$this->item->routestotal. '</div>';
							} else {
								echo 'Einzelwerte noch nicht integriert';	
							}; ?>
							
						</div> 
					</div>
				</div> 
		
		<?php endif; ?>
	</div>
	
	<div class="mt-5">
	<?php if($canEdit): ?>
		<a class="btn btn-secondary " href="<?php echo Route::_('index.php?option=com_act_building&task=building.edit&id='.$this->item->id); ?>">
			<?php echo Text::_("COM_ACT_BUILDING_EDIT_ITEM"); ?>
		</a>
	<?php endif; ?>
		<a class="btn btn-warning" href="<?php echo Route::_('index.php?option=com_act_building&view=buildings'); ?>">
			<?php echo Text::_("COM_ACT_BUILDING_TITLE_BUILDINGS"); ?>
		</a>

	</div>
</div>
