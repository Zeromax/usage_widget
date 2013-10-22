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
				'column'		=> array("(type='image' AND singleSRC=?) OR (type='download' AND singleSRC=?) OR (type='text' AND addImage=1 AND singleSRC=?) OR (type='accordionSingle' AND addImage=1 AND singleSRC=?) OR (type='hyperlink' AND useImage=1 AND singleSRC=?)"),
				'value'			=> array(\tl_files_usage::getUsedFileId(), \tl_files_usage::getUsedFileId(), \tl_files_usage::getUsedFileId(), \tl_files_usage::getUsedFileId(), \tl_files_usage::getUsedFileId()),
				'do'			=> 'article'
			),
			array
			(
				'table'			=> 'tl_content',
				'label'			=> 'Content Element ID%s',
				'labelValue'	=> array('id'),
				'column'		=> array("multiSRC!=''"),
				'value'			=> array(\tl_files_usage::getUsedFileId()),
				'do'			=> 'article',
				'multiple'		=> true
			),
		)
	),
	'sql'                   => "blob NULL"
);

/**
 * Class tl_files_usage
 *
 * Provide methods to manipulate the DCA.
 * @package   usage_widget
 * @author    Andreas Nölke
 * @copyright brothers-project 2013
 */
class tl_files_usage extends tl_files
{

	/**
	 * Return the File ID
	 * @return int
	 */
	static function getUsedFileId()
	{
		$return = 0;
		$objFile = \FilesModel::findMultipleByPaths(array(\Input::get('id')));
		if ($objFile && $objFile->id > 0)
		{
			$return = $objFile->id;
		}
		return $return;
	}

}
