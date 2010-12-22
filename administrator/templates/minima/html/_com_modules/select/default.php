<?php
/**
 * @version		$Id: default.php 19449 2010-11-12 05:55:09Z chdemko $
 * @package		Joomla.Administrator
 * @subpackage	com_modules
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
?>

<!--<ul id="new-modules-list">-->
<dl id="new-modules-list">
<?php foreach ($this->items as &$item) : ?>
	<li>
		<?php
		// Prepare variables for the link.

		$link	= 'index.php?option=com_modules&task=module.add&eid='. $item->extension_id;
		$name	= $this->escape($item->name);
		$desc	= $this->escape($item->desc); 
		//$desc       = substr($desc,0,strpos($desc, '.')+1);
		?>
		<!--<span class="editlinktip hasTip" title="<?php echo $name.' :: '.$desc; ?>">
			<a href="<?php echo JRoute::_($link);?>" target="_top">
				<?php echo $name; ?></a></span>-->
			<a href="<?php echo JRoute::_($link);?>" target="_top">
				<span class="module-name"><?php echo $name; ?></span>
				<span class="module-desc"><?php echo $desc; ?></span>
			</a>
	</li>
<?php endforeach; ?>
</dl>
<!--</ul>-->
