<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Act_building
 * @author     Birgit Gebhard <info@routes-manager.de>
 * @copyright  2021 Birgit Gebhard
 * @license    GNU General Public License Version 2 oder später; siehe LICENSE.txt
 */
defined('_JEXEC') or die;

JLoader::register('Act_buildingHelper', JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_act_building' . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'act_building.php');

use \Joomla\CMS\Factory;
use \Joomla\CMS\MVC\Model\BaseDatabaseModel;

/**
 * Class Act_buildingFrontendHelper
 *
 * @since  1.6
 */
class Act_buildingHelpersAct_building
{
	/**
	 * Get an instance of the named model
	 *
	 * @param   string  $name  Model name
	 *
	 * @return null|object
	 */
	public static function getModel($name)
	{
		$model = null;

		// If the file exists, let's
		if (file_exists(JPATH_SITE . '/components/com_act_building/models/' . strtolower($name) . '.php'))
		{
			require_once JPATH_SITE . '/components/com_act_building/models/' . strtolower($name) . '.php';
			$model = BaseDatabaseModel::getInstance($name, 'Act_buildingModel');
		}

		return $model;
	}

	/**
	 * Gets the files attached to an item
	 *
	 * @param   int     $pk     The item's id
	 *
	 * @param   string  $table  The table's name
	 *
	 * @param   string  $field  The field's name
	 *
	 * @return  array  The files
	 */
	public static function getFiles($pk, $table, $field)
	{
		$db = Factory::getDbo();
		$query = $db->getQuery(true);

		$query
			->select($field)
			->from($table)
			->where('id = ' . (int) $pk);

		$db->setQuery($query);

		return explode(',', $db->loadResult());
	}

	/**
	 * Liste der Sektoren in diesem Gebäude/Mastersektor
	 *
	 * @param   int     $id
	 *
	 * @return  array  
	 */
	public static function getSectors($id)
	{
		$db = Factory::getDbo();
		$query = $db->getQuery(true);

		$query
			->select(array('sector, id'))
			->from('#__act_sector')
			->where('state = 1')
			->where('building = ' . (int) $id);

	    $db->setQuery($query);
        $result = $db->loadObjectList();
		return $result; 
	}


	/**
	 * Liste Linien innerhalb eines Sektors
	 *
	 * @param   int   $id Sektor
	 *
	 * @return  array  
	 */
	public static function getTotalLinesFromSector($id)
	{
		$db = Factory::getDbo();
		$query = $db->getQuery(true);

		$query
			->select(array('COUNT(*)'))
			->from('#__act_line')
			->where('state = 1')
			->where('sector = ' . (int) $id);

	    $db->setQuery($query);
        $result = $db->loadResult();
		return $result; 
	}

    /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function canUserEdit($item)
    {
        $permission = false;
        $user       = Factory::getUser();

        if ($user->authorise('core.edit', 'com_act_building'))
        {
            $permission = true;
        }
        else
        {
            if (isset($item->created_by))
            {
                if ($user->authorise('core.edit.own', 'com_act_building') && $item->created_by == $user->id)
                {
                    $permission = true;
                }
            }
            else
            {
                $permission = true;
            }
        }

        return $permission;
    }
}
