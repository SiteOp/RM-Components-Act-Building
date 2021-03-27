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

use \Joomla\CMS\HTML\HTMLHelper;
use \Joomla\CMS\Factory;
use \Joomla\CMS\Uri\Uri;
use \Joomla\CMS\Router\Route;
use \Joomla\CMS\Language\Text;

$doc = Factory::getDocument();
$doc->addScript('node_modules/chart.js/dist/Chart.bundle.min.js');
$doc->addScript('node_modules/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.min.js');

$canEdit = Factory::getUser()->authorise('core.edit', 'com_act_building');

// Routes-Planning Params
$app = Factory::getApplication();
$params = $app->getParams();
$params         = $app->getParams('com_routes_planning');
$berechnungsart = $params['berechnungsart'];

$sectors = Act_buildingHelpersAct_building::getSectors($this->item->id); 

?>

<div id="building">
	<div class="page-header">
			<h1><?php echo  $this->item->building; ?></h1> 
		</div>

		<div class="row">
			<div class="col">
				<div class="card">
					<div class="card-header">   
						<h3>Bereiche/Linien</h3>
					</div>
					<div class="card-body">
						<?php foreach ($sectors AS $sector) : ?>
							<?php echo $sector->sector; ?>
							 - <?php echo  Act_buildingHelpersAct_building::getTotalLinesFromSector($sector->id); ?> Linien<br />
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
		<div class="row mt-5">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-align-justify"></i> Soll-Werte Schwierigkeitsgrade</h3> <?php // TODO ?>
            </div>
            <div class="card-body">
                <?php echo $this->loadTemplate('charts'); ?>
            </div>
        </div>
    </div> 
</div> 
		<?php //if (0 == $berechnungsart) {
		// echo $this->loadTemplate('charts_einzel');
	// } else {
		//   echo $this->loadTemplate('charts_prozent');
	// }; ?>


	<?php if($canEdit): ?>
		<a class="btn btn-secondary mt-5"  href="<?php echo Route::_('index.php?option=com_act_building&task=building.edit&id='.$this->item->id); ?>">
			<?php echo Text::_("COM_ACT_BUILDING_EDIT_ITEM"); ?>
		</a>
	<?php endif; ?>

</div>
