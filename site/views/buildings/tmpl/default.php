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
use \Joomla\CMS\Layout\LayoutHelper;

HTMLHelper::addIncludePath(JPATH_COMPONENT . '/helpers/html');
HTMLHelper::_('bootstrap.tooltip');
HTMLHelper::_('behavior.multiselect');
HTMLHelper::_('formbehavior.chosen', 'select');

// Menüparameter - Titel usw
$app = Factory::getApplication();
$menu = $app->getMenu();
$active = $menu->getActive();
$itemId = $active->id;
$menuparams = $menu->getParams($itemId);

$user       = Factory::getUser();
$userId     = $user->get('id');
$listOrder  = $this->state->get('list.ordering');
$listDirn   = $this->state->get('list.direction');
$canCreate  = $user->authorise('core.create', 'com_act_building') && file_exists(JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'forms' . DIRECTORY_SEPARATOR . 'buildingform.xml');
$canEdit    = $user->authorise('core.edit', 'com_act_building') && file_exists(JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'forms' . DIRECTORY_SEPARATOR . 'buildingform.xml');
$canCheckin = $user->authorise('core.manage', 'com_act_building');
$canChange  = $user->authorise('core.edit.state', 'com_act_building');
$canDelete  = $user->authorise('core.delete', 'com_act_building');


?>
	<?php // Page-Header ?>
	<?php if ($menuparams['show_page_heading']) : ?>
		<div class="page-header">
			<h1><?php echo $this->escape($menuparams['page_heading']); ?></h1> 
		</div>
	<?php else : ?>
		<div class="page-header">
			<h1><?php echo $this->escape($active->title); ?></h1>
		</div>
	<?php endif; ?>

	<form action="<?php echo htmlspecialchars(Uri::getInstance()->toString()); ?>" method="post" name="adminForm" id="adminForm">

	<?php //echo JLayoutHelper::render('default_filter', array('view' => $this), dirname(__FILE__)); ?>
        <div class="table-responsive">
			<table class="table table-striped" id="buildingList">
				<thead>
					<tr>
						<th><?php echo HtmlHelper::_('grid.sort',  'COM_ACT_BUILDING_BUILDINGS_BUILDING', 'a.building', $listDirn, $listOrder); ?></th>
						<?php if ($canEdit || $canDelete): ?>
							<th class="center" style="width: 5rem;"><?php echo Text::_('COM_ACT_BUILDING_BUILDINGS_EDIT'); ?></th>
						<?php endif; ?>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="<?php echo isset($this->items[0]) ? count(get_object_vars($this->items[0])) : 10; ?>">
							<?php echo $this->pagination->getListFooter(); ?>
						</td>
					</tr>
				</tfoot>
				<tbody>
				<?php foreach ($this->items as $i => $item) : ?>
					<?php $canEdit = $user->authorise('core.edit', 'com_act_building'); ?>
					<tr class="row<?php echo $i % 2; ?>">	
						<td><a href="<?php echo Route::_('index.php?option=com_act_building&view=building&id='.(int) $item->id); ?>">
								<?php echo $this->escape($item->building); ?>
							</a>
						</td>
						<?php if ($canEdit): ?>
						<td class="center">
							<a href="<?php echo Route::_('index.php?option=com_act_building&task=building.edit&id=' . $item->id, false, 2); ?>" 
							   class="btn btn-mini" type="button">
							   <i class="fas fa-edit"></i>
							</a>
						</td>
						<?php endif; ?>

					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
        </div>
		<?php if ($canCreate) : ?>
			<a href="<?php echo Route::_('index.php?option=com_act_building&task=buildingform.edit&id=0', false, 0); ?>"
			   class="btn btn-secondary btn-small mt-4">
			   <i class="fas fa-plus-circle"></i>
				<?php echo Text::_('COM_ACT_BUILDING_ADD_ITEM'); ?>
				</a>
		<?php endif; ?>

		<input type="hidden" name="task" value=""/>
		<input type="hidden" name="boxchecked" value="0"/>
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>"/>
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>"/>
		<?php echo HTMLHelper::_('form.token'); ?>
	</form>
