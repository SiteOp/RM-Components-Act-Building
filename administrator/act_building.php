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

use \Joomla\CMS\MVC\Controller\BaseController;
use \Joomla\CMS\Factory;
use \Joomla\CMS\Language\Text;

// Access check.
if (!Factory::getUser()->authorise('core.manage', 'com_act_building'))
{
	throw new Exception(Text::_('JERROR_ALERTNOAUTHOR'));
}

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Act_building', JPATH_COMPONENT_ADMINISTRATOR);
JLoader::register('Act_buildingHelper', JPATH_COMPONENT_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'act_building.php');

$controller = BaseController::getInstance('Act_building');
$controller->execute(Factory::getApplication()->input->get('task'));
$controller->redirect();
