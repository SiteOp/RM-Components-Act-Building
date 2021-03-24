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

HTMLHelper::_('behavior.keepalive');
HTMLHelper::_('behavior.tooltip');
HTMLHelper::_('behavior.formvalidation');
HTMLHelper::_('formbehavior.chosen', 'select');

// Menüparameter - Titel usw
$app = Factory::getApplication();
$menu = $app->getMenu();
$active = $menu->getActive();
$itemId = $active->id;
$menuparams = $menu->getParams($itemId);

$user    = Factory::getUser();
$canEdit = Act_buildingHelpersAct_building::canUserEdit($this->item, $user);


$canState = JFactory::getUser()->authorise('core.edit.state','com_act_building');
?>
<div id="building">
	<div class="building-edit front-end-edit">
		<?php if (!$canEdit) : ?>
			<div class="page-header">
				<h3><?php throw new Exception(Text::_('COM_ACT_BUILDING_ERROR_MESSAGE_NOT_AUTHORISED'), 403); ?></h3>
			</div>
		<?php else : ?>
			<?php if (!empty($this->item->id)): ?>
				<div class="page-header">
					<h1><?php echo Text::sprintf('COM_ACT_BUILDING_EDIT_ITEM_TITLE', $this->item->id); ?></h1>
				</div>
			<?php else: ?>
				<div class="page-header">
					<h1><?php echo Text::_('COM_ACT_BUILDING_ADD_ITEM_TITLE'); ?></h1>
				</div>
			<?php endif; ?>

		<form id="form-building"action="<?php echo Route::_('index.php?option=com_act_building&task=buildingform.save'); ?>" method="post" class="form-validate form-horizontal" enctype="multipart/form-data">
					
			<div class="form-group row">
				<div class="col-md-5">
					<?php if(!$canState): ?>
						<div class="control-label"><?php echo $this->form->getLabel('state'); ?></div>
						<div class="controls"><?php echo $state_string; ?></div>
						<input type="hidden" name="jform[state]" value="<?php echo $state_value; ?>" />
					<?php else: ?>
						<div class="control-label"><?php echo $this->form->getLabel('state'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('state'); ?></div>
					<?php endif; ?>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-md-5"><?php echo $this->form->renderField('building'); ?></div>
			</div>
			<div class="control-group">
				<div class="controls mt-1">
					<?php if ($this->canSave): ?>
						<button type="submit" class="validate btn btn-secondary">
							<?php echo Text::_('JSUBMIT'); ?>
						</button>
					<?php endif; ?>
					<a class="btn btn-warning"
						href="<?php echo Route::_('index.php?option=com_act_building&task=buildingform.cancel'); ?>"
						title="<?php echo Text::_('JCANCEL'); ?>">
							<?php echo Text::_('JCANCEL'); ?>
					</a>
				</div>
			</div>
			<input type="hidden" name="jform[id]" value="<?php echo isset($this->item->id) ? $this->item->id : ''; ?>" />
			<input type="hidden" name="jform[ordering]" value="<?php echo isset($this->item->ordering) ? $this->item->ordering : ''; ?>" />
			<input type="hidden" name="jform[checked_out]" value="<?php echo isset($this->item->checked_out) ? $this->item->checked_out : ''; ?>" />
			<input type="hidden" name="jform[checked_out_time]" value="<?php echo isset($this->item->checked_out_time) ? $this->item->checked_out_time : ''; ?>" />
			<?php echo $this->form->getInput('created_by'); ?>
			<?php echo $this->form->getInput('modified_by'); ?>
			<input type="hidden" name="option" value="com_act_building"/>
			<input type="hidden" name="task"
					value="buildingform.save"/>
			<?php echo HTMLHelper::_('form.token'); ?>
		</form>
	<?php endif; ?>
	</div>
</div>