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

require_once JPATH_ROOT. '/administrator/components/com_fields/helpers/fields.php';

class ModJlTagFilterHelper
{
	public static function getTags($params)
	{
		$app = JFactory::getApplication();
		$tags = array(1 => array(), 2 => array());
        $enabledTags = $params->get('searchfields', array());

        if(!is_array($enabledTags) && !count($enabledTags))
        {
            return $tags;
        }

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('id, parent_id, level, title, path, alias')
              ->from('#__tags')
              ->where('published = 1')
              ->where('id IN ('.implode(',', $enabledTags).') OR parent_id IN ('.implode(',', $enabledTags).')')
	        ->order('title')
        ;

		$result = $db->setQuery($query)->loadObjectList();

		foreach ( $result as $item ) {
			$tags[$item->level][] = $item;
		}

		return $tags;
	}

	public static function getSelectedFirstLayer($tags, $filter_tag){
		$selectedFirstLayer = 0;
		if($filter_tag == 0 || !count($tags[2])){
			return $selectedFirstLayer;
		}

		foreach ( $tags[2] as $tag )
		{
			if($tag->id == $filter_tag){
				$selectedFirstLayer = $tag->parent_id;
				break;
			}
		}

		return $selectedFirstLayer;
	}

	public static function recombineTags($tags){
		if(!is_array($tags) || !count($tags)){
			return $tags;
		}
		$levels = array_keys($tags);

		$newTags = array();
		foreach ( $levels as $level ) {
			foreach ($tags[$level] as $tag){
				if($level == 1){
					$newTags[$tag->id] = $tag;
					$newTags[$tag->id]->children = array();
				}
				else if(isset($newTags[$tag->parent_id]->children)){
					$newTags[$tag->parent_id]->children[] = $tag;
				}
			}
		}

		return $newTags;
	}
}
