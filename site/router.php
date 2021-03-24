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

use Joomla\CMS\Component\Router\RouterViewConfiguration;
use Joomla\CMS\Component\Router\RouterView;
use Joomla\CMS\Component\Router\Rules\StandardRules;
use Joomla\CMS\Component\Router\Rules\NomenuRules;
use Joomla\CMS\Component\Router\Rules\MenuRules;
use Joomla\CMS\Factory;
use Joomla\CMS\Categories\Categories;

/**
 * Class Act_buildingRouter
 *
 */
class Act_buildingRouter extends RouterView
{
	private $noIDs;
	public function __construct($app = null, $menu = null)
	{
		$params = JComponentHelper::getComponent('com_act_building')->params;
		$this->noIDs = (bool) $params->get('sef_ids');
		
		$buildings = new RouterViewConfiguration('buildings');
		$this->registerView($buildings);
			$building = new RouterViewConfiguration('building');
			$building->setKey('id')->setParent($buildings);
			$this->registerView($building);
			$buildingform = new RouterViewConfiguration('buildingform');
			$buildingform->setKey('id');
			$this->registerView($buildingform);

		parent::__construct($app, $menu);

		$this->attachRule(new MenuRules($this));

		if ($params->get('sef_advanced', 0))
		{
			$this->attachRule(new StandardRules($this));
			$this->attachRule(new NomenuRules($this));
		}
		else
		{
			JLoader::register('Act_buildingRulesLegacy', __DIR__ . '/helpers/legacyrouter.php');
			JLoader::register('Act_buildingHelpersAct_building', __DIR__ . '/helpers/act_building.php');
			$this->attachRule(new Act_buildingRulesLegacy($this));
		}
	}


	
		/**
		 * Method to get the segment(s) for an building
		 *
		 * @param   string  $id     ID of the building to retrieve the segments for
		 * @param   array   $query  The request that is built right now
		 *
		 * @return  array|string  The segments of this item
		 */
		public function getBuildingSegment($id, $query)
		{
			return array((int) $id => $id);
		}
			/**
			 * Method to get the segment(s) for an buildingform
			 *
			 * @param   string  $id     ID of the buildingform to retrieve the segments for
			 * @param   array   $query  The request that is built right now
			 *
			 * @return  array|string  The segments of this item
			 */
			public function getBuildingformSegment($id, $query)
			{
				return $this->getBuildingSegment($id, $query);
			}

	
		/**
		 * Method to get the segment(s) for an building
		 *
		 * @param   string  $segment  Segment of the building to retrieve the ID for
		 * @param   array   $query    The request that is parsed right now
		 *
		 * @return  mixed   The id of this item or false
		 */
		public function getBuildingId($segment, $query)
		{
			return (int) $segment;
		}
			/**
			 * Method to get the segment(s) for an buildingform
			 *
			 * @param   string  $segment  Segment of the buildingform to retrieve the ID for
			 * @param   array   $query    The request that is parsed right now
			 *
			 * @return  mixed   The id of this item or false
			 */
			public function getBuildingformId($segment, $query)
			{
				return $this->getBuildingId($segment, $query);
			}
}
