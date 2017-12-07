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
JHtml::_('bootstrap.framework');
JHtml::_('bootstrap.loadCss');

$doc = JFactory::getDocument();
$doc->addScript(JUri::root().'modules/mod_jltagfilter/assets/javascript/jlragfilter.js', array('version' => 'auto'));
$doc->addScriptDeclaration('
	JlTagFilter.init({
	    ajax: \''.$ajax.'\',
	    ajax_selector: \''.$ajax_selector.'\'
	});
');
$doc->addStyleDeclaration('
    #mod-jltagfilter-dropdown-menu.dropdown-menu {
    display: block;
    position: static;
    margin-bottom: 5px;
    *width: 180px;
}
');
$tags = ModJlTagFilterHelper::recombineTags($tags);
if(is_array($tags) && count($tags)){
?>
    <div class="dropdown clearfix">
        <ul id="mod-jltagfilter-dropdown-menu" class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
		    <?php foreach ( $tags as $tag ) : ?>
			    <?php if ( !count($tag->children) ) : ?>
				    <?php $active = $tag->id == $selectedFirstLayer ? ' class="active"' : ''; ?>
                    <li<?php echo $active; ?>><a class="final" tabindex="-1" href="#" data-id="<?php echo $tag->id; ?>"><?php echo $tag->title; ?></a></li>
			    <?php else : ?>
				    <?php $active = $tag->id == $selectedFirstLayer ? ' active' : ''; ?>
                    <li class="dropdown-submenu<?php echo $active; ?>">
                        <a tabindex="-1" href="#"><?php echo $tag->title; ?></a>
                        <ul class="dropdown-menu">
						    <?php foreach ( $tag->children as $child ) : ?>
							    <?php $active = $child->id == $filter_tag ? ' class="active"' : ''; ?>
                                <li<?php echo $active; ?>><a class="final" tabindex="-1" href="#" data-id="<?php echo $child->id; ?>"><?php echo $child->title; ?></a></li>
						    <?php endforeach; ?>
                        </ul>
                    </li>
			    <?php endif; ?>
		    <?php endforeach; ?>
        </ul>
    </div>
    <form style="display: none;" id="mod-jltagfilter-form" action="<?php echo $action; ?>" method="get" class="form-search">
        <input type="hidden" id="tag-select-filter-tag" name="filter_tag" value="">
    </form>
<?php }