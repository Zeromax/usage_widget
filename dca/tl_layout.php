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
 * Table tl_layout
 */
$GLOBALS['TL_DCA']['tl_layout']['palettes']['default'] = str_replace(',static', ',static;{usage_legend},layoutUsage,mobileLayoutUsage', $GLOBALS['TL_DCA']['tl_layout']['palettes']['default']);

$GLOBALS['TL_DCA']['tl_layout']['fields']['layoutUsage'] = array
(
	'label'                 => &$GLOBALS['TL_LANG']['tl_layout']['layoutUsage'],
	'inputType'             => 'usage',
	'exclude'               => true,
	'eval'                  => array('tl_class'=>'clr', 'pickerTitle'=>$GLOBALS['TL_LANG']['tl_layout']['layoutUsage'][0],
		'model' => array(array(
			'table'			=>'tl_page',
			'label'			=>'%s (%s' . $GLOBALS['TL_CONFIG']['urlSuffix'] . ')',
			'labelValue'	=>array('title','alias'),
			'column'		=>array('layout=? AND includeLayout=1'),
			'value'=>array(\Input::get('id'))
		))

	),
	'sql'                   => "blob NULL",
	'relation'              => array('type'=>'hasOne', 'load'=>'lazy')
);
$GLOBALS['TL_DCA']['tl_layout']['fields']['mobileLayoutUsage'] = array
(
	'label'                 => &$GLOBALS['TL_LANG']['tl_layout']['mobileLayoutUsage'],
	'inputType'             => 'usage',
	'exclude'               => true,
	'eval'                  => array('tl_class'=>'clr', 'pickerTitle'=>$GLOBALS['TL_LANG']['tl_layout']['mobileLayoutUsage'][0],
		'model' => array(array(
			'table'			=>'tl_page',
			'label'			=>'%s (%s' . $GLOBALS['TL_CONFIG']['urlSuffix'] . ')',
			'labelValue'	=>array('title','alias'),
			'column'		=>array('mobileLayout=? AND includeLayout=1'),
			'value'			=>array(\Input::get('id'))
		))
	),
	'sql'                     => "blob NULL",
	'relation'                => array('type'=>'hasOne', 'load'=>'lazy')
);