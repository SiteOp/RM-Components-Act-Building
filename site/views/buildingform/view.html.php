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

use Joomla\CMS\Factory;
use \Joomla\CMS\Language\Text;

jimport('joomla.application.component.view');

/**
 * View to edit
 *
 * @since  1.6
 */
class Act_buildingViewBuildingform extends \Joomla\CMS\MVC\View\HtmlView
{
	protected $state;

	protected $item;

	protected $form;

	protected $params;

	protected $canSave;

	/**
	 * Display the view
	 *
	 * @param   string  $tpl  Template name
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	public function display($tpl = null)
	{
		$app  = Factory::getApplication();
		$user = Factory::getUser();

		$this->state      = $this->get('State');
		$this->item       = $this->get('Item');
		$this->params     = $this->state->get('params');
		$this->canSave    = $this->get('CanSave');
		$this->form		  = $this->get('Form');

		// Params ACT
		$this->params_act = $app->getParams('com_act');
		$this->c3   	  = $this->params_act['color3grad'];
		$this->c4  		  = $this->params_act['color4grad'];
		$this->c5         = $this->params_act['color5grad'];
		$this->c6         = $this->params_act['color6grad'];
		$this->c7         = $this->params_act['color7grad'];
		$this->c8         = $this->params_act['color8grad'];
		$this->c9         = $this->params_act['color9grad'];
		$this->c10        = $this->params_act['color10grad'];
		$this->c11        = $this->params_act['color11grad'];
		$this->c12        = $this->params_act['color12grad'];
	
		// Params Routes-Planning
		$this->params_rp = $app->getParams('com_routes_planning');
		$this->record_should = $this->params_rp['record_should']; 						  // Soll Soll erfasst werden 0=nein 1=ja
		$this->record_sector_or_building = $this->params_rp['record_sector_or_building']; // Sollen die Sollwerte im Sektor oder Gebäude erfasst werden? 1=Gebäude 2=Sektor
		$this->record_type = $this->params_rp['record_type'];                             // Welche Berechnungsart Prozent oder Einzelwerte? Einzel=0 Prozent=1
		$this->grade_start_percent = $this->params_rp['grade_start_percent'];             // Prozentwerte - Niedrigster Schwierigkeitsgrad
		$this->grade_end_percent = $this->params_rp['grade_end_percent'];                 // Prozentwerte - Höchster  Schwierigkeitsgrad

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors));
		}

		

		$this->_prepareDocument();

		parent::display($tpl);
	}

	/**
	 * Prepares the document
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	protected function _prepareDocument()
	{
		$app   = Factory::getApplication();
		$menus = $app->getMenu();
		$title = null;

		// Because the application sets a default page title,
		// we need to get it from the menu item itself
		$menu = $menus->getActive();

		if ($menu)
		{
			$this->params->def('page_heading', $this->params->get('page_title', $menu->title));
		}
		else
		{
			$this->params->def('page_heading', Text::_('COM_ACT_BUILDING_DEFAULT_PAGE_TITLE'));
		}

		$title = $this->params->get('page_title', '');

		if (empty($title))
		{
			$title = $app->get('sitename');
		}
		elseif ($app->get('sitename_pagetitles', 0) == 1)
		{
			$title = Text::sprintf('JPAGETITLE', $app->get('sitename'), $title);
		}
		elseif ($app->get('sitename_pagetitles', 0) == 2)
		{
			$title = Text::sprintf('JPAGETITLE', $title, $app->get('sitename'));
		}

		$this->document->setTitle($title);

		if ($this->params->get('menu-meta_description'))
		{
			$this->document->setDescription($this->params->get('menu-meta_description'));
		}

		if ($this->params->get('menu-meta_keywords'))
		{
			$this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
		}

		if ($this->params->get('robots'))
		{
			$this->document->setMetadata('robots', $this->params->get('robots'));
		}
	}
}
