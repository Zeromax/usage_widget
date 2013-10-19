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
 * Table tl_files
 */
$GLOBALS['TL_DCA']['tl_files']['palettes']['default'] .= ';{usage_legend},fileUsage';

$GLOBALS['TL_DCA']['tl_files']['fields']['fileUsage'] = array
(
	'label'                 => &$GLOBALS['TL_LANG']['tl_files']['fileUsage'],
	'inputType'             => 'usage',
	'exclude'               => true,
	'eval'                  => array('tl_class'=>'clr', 'pickerTitle'=>$GLOBALS['TL_LANG']['tl_files']['fileUsage'][0], 'widgetTemplate'=>'be_usage_widget_files',
		'model' => array
		(
			array
			(
				'table'			=> 'tl_content',
				'label'			=> 'Content Element ID%s',
				'labelValue'	=> array('id', 'id'),
				'column'		=> array('singleSRC=?'),
				'value'			=> array(\FilesModel::findMultipleByPaths(array(\Input::get('id')))->id)
			),
//			array
//			(
//				'table'			=> 'tl_page',
//				'label'			=> '%s (%s' . $GLOBALS['TL_CONFIG']['urlSuffix'] . ')',
//				'labelValue'	=> array('title','alias'),
//				'column'		=> array('layout=? AND includeLayout=1'),
//				'value'			=> array(\Input::get('id'))
//			),
		)
	),
	'sql'                   => "blob NULL"
);