<?php
/**
 * @version     0.8
 * @package     Minima
 * @subpackage  mod_myshortcuts
 * @author      Marco Barbosa
 * @copyright   Copyright (C) 2010 Webnific. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

class Mod_MyshortcutsInstallerScript {

    function postflight($type, $parent) {

        $db = JFactory::getDBO();

        // myshortcuts
        $db->setQuery("UPDATE `#__modules`".
            " SET `position` = 'shortcuts', `published` = '1', `access` = '3'".
            " WHERE `#__modules`.`module` = 'mod_myshortcuts'; ");

        if (!$db->query() && ($db->getErrorNum() != 1060)) {
            echo $db->getErrorMsg(true);
        }

        // mypanel
        $db->setQuery("UPDATE `#__modules`".
            " SET `position` = 'panel', `published` = '1', `access` = '3'".
            " WHERE `#__modules`.`module` = 'mod_mypanel'; ");

        if (!$db->query() && ($db->getErrorNum() != 1060)) {
            echo $db->getErrorMsg(true);
        }

        // add values to modules_menu
        $db->setQuery("INSERT INTO `#__modules_menu` (`moduleid`,`menuid`)".
            " SELECT `id`,0 FROM `#__modules`".
            " WHERE `#__modules`.`module` = 'mod_myshortcuts' OR `#__modules`.`module` = 'mod_mypanel' LIMIT 2");

        if (!$db->query() && ($db->getErrorNum() != 1060)) {
            echo $db->getErrorMsg(true);
        }

        // template
        // update modules positions
        $db->setQuery("UPDATE `#__modules`".
            " SET `position` = 'widgets-first'".
            " WHERE `#__modules`.`position` = 'cpanel'; ");

        if (!$db->query() && ($db->getErrorNum() != 1060)) {
            die($db->getErrorMsg(true));
        }

        $db->setQuery("UPDATE `#__modules`".
            " SET `position` = 'widgets-last'".
            " WHERE `#__modules`.`module` = 'mod_popular'; ");

        if (!$db->query() && ($db->getErrorNum() != 1060)) {
            die($db->getErrorMsg(true));
        }

        // set minima style default
        $db->setQuery("UPDATE `#__template_styles`".
            " SET `home` = '0'".
            " WHERE `#__template_styles`.`client_id` =1;");

        if (!$db->query() && ($db->getErrorNum() != 1060)) {
            die($db->getErrorMsg(true));
        }

        $db->setQuery("UPDATE `#__template_styles`".
            " SET `home` = '1' WHERE `#__template_styles`.`template` = 'minima';");

        if (!$db->query() && ($db->getErrorNum() != 1060)) {
            die($db->getErrorMsg(true));
        }

    }
}
