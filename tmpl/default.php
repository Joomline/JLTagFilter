<?php
/**
 * JL Content Fields Filter
 *
 * @version 	1.0.4
 * @author		Joomline
 * @copyright	(C) 2017 Arkadiy Sedelnikov. All rights reserved.
 * @license 	GNU General Public License version 2 or later; see	LICENSE.txt
 */

defined('_JEXEC') or die;
JHtml::_('jquery.framework');
$doc = JFactory::getDocument();
$doc->addScript(JUri::root().'modules/mod_jltagfilter/assets/javascript/jlragfilter.js', array('version' => 'auto'));
$doc->addScriptDeclaration('
	JlTagFilter.init({
	    ajax: \''.$ajax.'\',
	    ajax_selector: \''.$ajax_selector.'\'
	});
');
$submitFunction = $ajax ? ' onclick="JlTagFilter.submit(); return false;"' : '';
?>

<form id="mod-jltagfilter-form" action="<?php echo $action; ?>" method="get" class="form-search">
	<div class="jlcontentfieldsfilter<?php echo $moduleclass_sfx; ?> row-fluid">
        <?php foreach($tags as $level => $tags) : ?>
        <?php $name = $level == 1 ? '' : ''; ?>
            <div class="control-group">
                <div class="controls">
                    <select
                            id="tag-select-<?php echo $level; ?>"
                            class="span12"
                    >
                        <option value=""><?php echo JText::_('JSELECT'); ?></option>

				        <?php
                        foreach($tags as $v) :
                            if($level == 1) {
				                $add = '';
	                            $selected =  $selectedFirstLayer == $v->id ? ' selected="selected"' : '';
                            }
                            else{
	                            $add = 'data-parent-id="'.$v->parent_id.'"';
	                            if($selectedFirstLayer != $v->parent_id){
		                            $add .= ' style="display: none;"';
                                }
	                            $selected =  $filter_tag == $v->id ? ' selected="selected"' : '';
                            }
                            ?>
                            <option value="<?php echo $v->id; ?>" <?php echo $add.$selected; ?>><?php echo $v->title; ?></option>
				        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div style="clear: both;"></div>
        <?php endforeach; ?>
        <input type="hidden" id="tag-select-filter-tag" name="filter_tag" value="">
        <input type="submit" id="tag-select-submit"
               <?php echo $submitFunction; ?>
               title="<?php echo JText::_('MOD_JLTAGFILTER_SUBMIT'); ?>"
               value="<?php echo JText::_('MOD_JLTAGFILTER_SUBMIT'); ?>"
               class="btn btn-primary btn-block"/>

        <button class="btn btn-info btn-block" onclick="return JlTagFilter.clearForm(this);">
            <?php echo JText::_('MOD_JLTAGFILTER_RESET'); ?>
        </button>
	</div>
</form>
