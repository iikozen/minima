<?php
/**
 * @version		$Id: controller.php 19281 2010-10-29 10:12:49Z eddieajau $
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

/**
 * Languages Controller
 *
 * @package		Joomla.Administrator
 * @subpackage	com_languages
 * @since		1.5
 */
class LanguagesController extends JController
{
	/**
	 * @var		string	The default view.
	 * @since	1.6
	 */
	protected $default_view = 'installed';

	/**
	 * Method to display a view.
	 *
	 * @param	boolean			If true, the view output will be cached
	 * @param	array			An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return	JController		This object to support chaining.
	 * @since	1.5
	 */
	public function display($cachable = false, $urlparams = false)
	{
		require_once JPATH_COMPONENT.'/helpers/languages.php';

		// Load the submenu.
		LanguagesHelper::addSubmenu(JRequest::getWord('view', 'installed'));

		$view	= JRequest::getWord('view', 'languages');
		$layout = JRequest::getWord('layout', 'default');
		$id		= JRequest::getInt('id');

		// Check for edit form.
		if ($view == 'language' && $layout == 'edit' && !$this->checkEditId('com_languages.edit.language', $id)) {

			// Somehow the person just went to the form - we don't allow that.
			$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
			$this->setMessage($this->getError(), 'error');
			$this->setRedirect(JRoute::_('index.php?option=com_languages&view=languages', false));

			return false;
		}

		parent::display();

		return $this;
	}

	/**
	 * task to set the default language
	 */
	function publish()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit(JText::_('JInvalid_Token'));
		$model = $this->getModel('languages');
		if ($model->publish()) {
			$msg = JText::_('COM_LANGUAGES_MSG_DEFAULT_LANGUAGE_SAVED');
			$type = 'message';
		} else {
			$msg = $this->getError();
			$type = 'error';
		}
		$client = $model->getClient();
		$this->setredirect('index.php?option=com_languages&client='.$client->id,$msg,$type);
	}
}
