<?php
/**
 * @package SP Page Builder
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2016 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
//no direct accees
defined ('_JEXEC') or die ('Restricted access');

$options = $displayData['options'];

$fluid_row = (isset($options->fullscreen) && $options->fullscreen) ? $options->fullscreen : 0;

if(!$fluid_row){
	$html = '</div>';
} else {
}

echo $html;