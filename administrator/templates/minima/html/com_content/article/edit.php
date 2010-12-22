<?php
/**
 * @version     0.8
 * @package     Minima
 * @author      Marco Barbosa
 * @copyright   Copyright (C) 2010 Webnific. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');

// Load the tooltip behavior.
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
?>

<script type="text/javascript">
    Joomla.submitbutton = function(task)
    {
        if (task == 'article.cancel' || document.formvalidator.isValid(document.id('item-form'))) {
            <?php echo $this->form->getField('articletext')->save(); ?>
            Joomla.submitform(task, document.getElementById('item-form'));
        }
        else {
            alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
        }
    }
</script>
<ul id="submenu">
    <li class="item-content"><a href="#" class="active"><?php echo JText::_('TPL_MINIMA_CONTENT_LABEL_CONTENT'); ?></a></li>
    <li class="item-parameters"><a href="#"><?php echo JText::_('TPL_MINIMA_CONTENT_LABEL_PARAMETERS'); ?></a></li>
    <li class="item-permissions"><a href="#"><?php echo JText::_('TPL_MINIMA_CONTENT_LABEL_PERMISSIONS'); ?></a></li>
</ul>
<form action="<?php JRoute::_('index.php?option=com_content'); ?>" method="post" name="adminForm" id="item-form" class="form-validate">
    <div id="item-basic">
        <fieldset id="form-left" class="adminform">
            <legend><?php echo empty($this->item->id) ? JText::_('COM_CONTENT_NEW_ARTICLE') : JText::sprintf('COM_CONTENT_EDIT_ARTICLE', $this->item->id); ?></legend>
            <ol class="adminformlist">
                <li class="article-title">
                    <?php echo $this->form->getLabel('title'); ?>
                    <?php echo $this->form->getInput('title'); ?>
                </li>
                <li class="article-text">
                    <?php echo $this->form->getInput('articletext'); ?>
                </li>
            </ol>
        </fieldset>
        <fieldset id="form-right" class="adminform">
            <legend><?php echo JText::_('TPL_MINIMA_CONTENT_LABEL_INFORMATION'); ?></legend>
            <ol class="adminformlist">
                <li><?php echo $this->form->getLabel('alias'); ?>
                <?php echo $this->form->getInput('alias'); ?></li>

                <li><?php echo $this->form->getLabel('catid'); ?>
                <?php echo $this->form->getInput('catid'); ?></li>

                <li><?php echo $this->form->getLabel('state'); ?>
                <?php echo $this->form->getInput('state'); ?></li>

                <li><?php echo $this->form->getLabel('access'); ?>
                <?php echo $this->form->getInput('access'); ?></li>

                <li><?php echo $this->form->getLabel('language'); ?>
                <?php echo $this->form->getInput('language'); ?></li>

                <li><?php echo $this->form->getLabel('featured'); ?>
                <?php echo $this->form->getInput('featured'); ?></li>

                <li><?php echo $this->form->getLabel('id'); ?>
                <?php echo $this->form->getInput('id'); ?></li>
            </ol>
        </fieldset>
    </div><!-- #item-basic -->

    <div id="item-advanced">
        <ul id="advanced-tabs">
            <li class="publishing"><a href="#" class="active"><?php echo JText::_('COM_CONTENT_FIELDSET_PUBLISHING'); ?></a></li>
            <li class="details"><a href="#"><?php echo JText::_('JDETAILS'); ?></a></li>
            <li class="rules"><a href="#"><?php echo JText::_('COM_CONTENT_FIELDSET_RULES'); ?></a></li>
            <li class="metadata"><a href="#"><?php echo JText::_('JGLOBAL_FIELDSET_METADATA_OPTIONS'); ?></a></li>
        </ul>
        <div id="tabs">
            <fieldset id="publishing" class="panelform">
                <ol class="adminformlist">
                    <li><?php echo $this->form->getLabel('created_by'); ?>
                    <?php echo $this->form->getInput('created_by'); ?><br /><br /></li>
                    <!--<hr class="space" />-->

                    <li><?php echo $this->form->getLabel('created_by_alias'); ?>
                    <?php echo $this->form->getInput('created_by_alias'); ?></li>

                    <li><?php echo $this->form->getLabel('created'); ?>
                    <?php echo $this->form->getInput('created'); ?></li>

                    <li><?php echo $this->form->getLabel('publish_up'); ?>
                    <?php echo $this->form->getInput('publish_up'); ?></li>

                    <li><?php echo $this->form->getLabel('publish_down'); ?>
                    <?php echo $this->form->getInput('publish_down'); ?></li>

                    <li><?php echo $this->form->getLabel('modified'); ?>
                    <?php echo $this->form->getInput('modified'); ?></li>

                    <li><?php echo $this->form->getLabel('version'); ?>
                    <?php echo $this->form->getInput('version'); ?></li>

                    <li><?php echo $this->form->getLabel('hits'); ?>
                    <?php echo $this->form->getInput('hits'); ?></li>
                </ol>
            </fieldset>

            <?php
            $fieldSets = $this->form->getFieldsets('attribs');
            foreach ($fieldSets as $name => $fieldSet) :
                    if (isset($fieldSet->description) && trim($fieldSet->description)) :
                        echo '<p class="tip">'.$this->escape(JText::_($fieldSet->description)).'</p>';
                    endif;
                    ?>
                <fieldset id="details" class="panelform">
                    <?php
                    // 2 lists, one for the "Show" stuff and the other with the rest
                    $listLeft = "<ol class=\"adminformlist fltlft\">"; $listRight = "<ol class=\"adminformlist fltlft\">"; $showIntro = "";

                    foreach ($this->form->getFieldset($name) as $field):

                        if (strpos($field->name, "show") !== false):
                                $listLeft .= "<li>".$field->label.$field->input."</li>";
                        else:
                                $listRight .= "<li>".$field->label.$field->input."</li>";
                        endif;

                    endforeach;

                    $listLeft .= $showIntro."</ol>"; $listRight .= "</ol>";

                    echo $listLeft; echo $listRight;
                    ?>
                </fieldset>
            <?php endforeach; ?>

            <fieldset id="rules" class="panelform">
                <?php echo $this->form->getInput('rules'); ?>
            </fieldset>

            <fieldset id="metadata" class="panelform">
                <ol class="adminformlist">
                    <li><?php echo $this->form->getLabel('metadesc'); ?>
                    <?php echo $this->form->getInput('metadesc'); ?></li>

                    <li><?php echo $this->form->getLabel('metakey'); ?>
                    <?php echo $this->form->getInput('metakey'); ?></li>

                    <?php
                    $fieldSets = $this->form->getFieldsets('metadata');

                    foreach ($fieldSets as $name => $fieldSet) :
                        echo JHtml::_('sliders.panel',JText::_($label), $name.'-options');
                            if (isset($fieldSet->description) && trim($fieldSet->description)) :
                                echo '<p class="tip">'.$this->escape(JText::_($fieldSet->description)).'</p>';
                            endif;
                            ?>
                        <fieldset class="panelform">
                        <ol class="adminformlist">
                            <?php foreach ($this->form->getFieldset($name) as $field) : ?>
                                <li><?php echo $field->label; ?>
                                <?php echo $field->input; ?></li>
                            <?php endforeach; ?>
                        </ol>
                        </fieldset>
                    <?php endforeach; ?>

                    <li><?php echo $this->form->getLabel('xreference'); ?>
                    <?php echo $this->form->getInput('xreference'); ?></li>
                </ol>
            </fieldset>
        </div><!-- /#tabs -->
    </div><!-- /#item-advanced -->

    <div id="item-permissions">
    <?php if ($this->canDo->get('core.admin')): ?>
        <div class="width-100 fltlft">
                <fieldset class="adminform">
                    <?php echo $this->form->getLabel('rules'); ?>
                    <?php echo $this->form->getInput('rules'); ?>
                </fieldset>
        </div>
    <?php endif; ?>
    </div>

    <input type="hidden" name="task" value="" />
        <?php echo JHtml::_('form.token'); ?>
</form>
