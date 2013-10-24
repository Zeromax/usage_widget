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
				'labelValue'	=> array('id'),
				'column'		=> array("(type='image' AND singleSRC=?) OR (type='download' AND singleSRC=?) OR (type='text' AND addImage=1 AND singleSRC=?) OR (type='accordionSingle' AND addImage=1 AND singleSRC=?) OR (type='hyperlink' AND useImage=1 AND singleSRC=?) OR multiSRC!=''"),
				'value'			=> array(\FileUsage::getUsedFileId(), \FileUsage::getUsedFileId(), \FileUsage::getUsedFileId(), \FileUsage::getUsedFileId(), \FileUsage::getUsedFileId()),
				'do'			=> 'article'
			),
			array
			(
				'table'			=> 'tl_form_field',
				'label'			=> 'Form Field ID%s',
				'labelValue'	=> array('id'),
				'column'		=> array("type='submit' AND imageSubmit=1 AND singleSRC=?"),
				'value'			=> array(\FileUsage::getUsedFileId()),
				'do'			=> 'form'
			),
			array
			(
				'table'			=> 'tl_module',
				'label'			=> 'Module ID%s',
				'labelValue'	=> array('id'),
				'column'		=> array("(tl_module.type='flash' AND source='internal' AND singleSRC=?) OR (tl_module.type='randomImage' AND multiSRC!='')"),
				'value'			=> array(\FileUsage::getUsedFileId()),
				'do'			=> 'themes'
			),
			array
			(
				'table'			=> 'tl_news',
				'label'			=> 'News ID%s',
				'labelValue'	=> array('id'),
				'column'		=> array("addImage=1 AND singleSRC=?"),
				'value'			=> array(\FileUsage::getUsedFileId()),
				'do'			=> 'news',
				'multiple'		=> true
			),
		)
	),
	'sql'                   => "blob NULL"
);
