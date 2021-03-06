<?php
/**
 * @version     0.8
 * @package     Minima
 * @subpackage  mod_mypanel
 * @author      Marco Barbosa
 * @copyright   Copyright (C) 2010 Webnific. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

/**
 * @package     Minima
 * @subpackage  mod_mypanel
 */
class ModMypanelHelper
{

    /**
     * Get a list of the authorised, non-special components to display in the components menu.
     *
     * @param   boolean $authCheck  An optional switch to turn off the auth check (to support custom layouts 'grey out' behaviour).
     *
     * @return  array   A nest array of component objects and submenus
     * @since   1.6
     */
    function getItems($authCheck = true)
    {
        // Initialise variables.
        $lang   = JFactory::getLanguage();
        $user   = JFactory::getUser();
        $db     = JFactory::getDbo();
        $query  = $db->getQuery(true);
        $result = array();
        $langs  = array();

        // Prepare the query.
        $query->select('m.id, m.title, m.alias, m.link, m.img, m.parent_id, m.client_id, e.element');
        $query->from('#__menu AS m');

        // Filter on the enabled states.
        $query->leftJoin('#__extensions AS e ON m.component_id = e.extension_id');

        $query->where('m.client_id=1');
        $query->where('e.enabled = 1');
        $query->where('m.id > 1');

        // Order by lft.
        //$query->order('m.title');
        $query->order('m.id DESC');

        $db->setQuery($query);

        // component list
        $components = $db->loadObjectList();
        // FIXME change to array here
        //$components = $db->loadObjectList();

        // Parse the list of extensions.
        foreach ($components as &$component) {
            // Trim the menu link.
            $component->link = trim($component->link);

            if ($component->parent_id == 1) {
                // Only add this top level if it is authorised and enabled.
                if ($authCheck == false || ($authCheck && $user->authorize('core.manage', $component->element))) {
                    // Root level.
                    $result[$component->id] = $component;
                    if (!isset($result[$component->id]->submenu)) {
                        $result[$component->id]->submenu = array();
                    }

                    // If the root menu link is empty, add it in.
                    if (empty($component->link)) {
                        $component->link = 'index.php?option='.$component->element;
                    }

                    if (!empty($component->element)) {
                        $langs[$component->element.'.sys'] = true;
                    }
                } //end if $authCheck
            } //end if $component
        } //end foreach

        // Load additional language files.
        foreach (array_keys($langs) as $langName) {
            // Load the core file then
            // Load extension-local file.
                $lang->load($langName, JPATH_BASE, null, false, false)
            ||  $lang->load($langName, JPATH_ADMINISTRATOR.'/components/'.str_replace('.sys', '', $langName), null, false, false)
            ||  $lang->load($langName, JPATH_BASE, $lang->getDefault(), false, false)
            ||  $lang->load($langName, JPATH_ADMINISTRATOR.'/components/'.str_replace('.sys', '', $langName), $lang->getDefault(), false, false);
        }

        return $result;
    }

}
