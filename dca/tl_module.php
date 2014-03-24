<?php

/**
 * usage_widget
 *
 * Copyright (C) 2013 Andreas Nölke
 *
 * @package   usage_widget
 * @author    Andreas Nölke
 * @license
 * @copyright brothers-project 2013
 */
/**
 * Table tl_module
 */
foreach ($GLOBALS['TL_DCA']['tl_module']['palettes'] as $key => $value)
{
	if (!is_array($value))
	{
		$GLOBALS['TL_DCA']['tl_module']['palettes'][$key] .= ';{usage_legend},moduleUsage';
	}
	
}

$GLOBALS['TL_DCA']['tl_module']['fields']['moduleUsage'] = array
(
	'label'                 => &$GLOBALS['TL_LANG']['tl_module']['moduleUsage'],
	'inputType'             => 'usage',
	'exclude'               => true,
	'eval'                  => array('tl_class'=>'clr', 'pickerTitle'=>$GLOBALS['TL_LANG']['tl_module']['moduleUsage'][0], 'widgetTemplate'=>'be_usage_widget_files',
		'model' => array(
			array(
				'table'			=> 'tl_content',
				'label'			=> 'Content Element ID%s',
				'labelValue'	=> array('id'),
				'column'		=> array("type='module' AND module=?"),
				'value'			=> array(\Input::get('id')),
				'do'			=> 'article'
			),
			array(
				'table'			=> 'tl_layout',
				'label'			=> '%s (Layout ID%s)',
				'labelValue'	=> array('name', 'id'),
				'column'		=> array("modules!=''"),
				'value'			=> array(\Input::get('id')),
				'do'			=> 'themes'
			),
		)
	),
	'sql'                   => "blob NULL"
);