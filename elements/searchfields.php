<?php
/**
 * JL Content Fields Filter
 *
 * @version 	1.0.4
 * @author		Joomline
 * @copyright	(C) 2017 Arkadiy Sedelnikov. All rights reserved.
 * @license 	GNU General Public License version 2 or later; see	LICENSE.txt
 */

defined('_JEXEC') or die('Restricted access');

class JFormFieldSearchfields extends JFormField
{
    public $type = 'Searchfields';

    protected function getInput()
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('id AS value, title  AS text')
              ->from('#__tags')
              ->where('parent_id = 1')
              ->where('published = 1')
        ;
	    $options = $db->setQuery($query)->loadObjectList();

        if(!is_array($options))
        {
	        $options = array();
        }

        $ctrl = $this->name;
        $value = empty($this->value) ? '' : $this->value;

        return JHTML::_('select.genericlist', $options, $ctrl, 'class="inputbox" size="10" multiple="multiple"', 'value', 'text', $value);
    }
}

?>
