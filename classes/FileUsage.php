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
 * Run in a custom namespace, so the class can be replaced
 */

namespace Contao;

/**
 * Class FileUsage
 *
 * Provide methods methods for the file usage DCA.
 * @package   usage_widget
 * @author    Andreas Nölke
 * @copyright brothers-project 2013
 */
class FileUsage extends \Backend
{

	/**
	 * Return the File ID
	 * @return int
	 */
	static function getUsedFileId()
	{
		$return = 0;
		// check if id is empty see #1 - thx to @MrSmile988
		if (\Input::get('id') != "")
		{
			$objFile = \FilesModel::findMultipleByPaths(array(\Input::get('id')));
			if ($objFile === null)
			{
				return $return;
			}
			if (version_compare(VERSION, '3.2', '>='))
			{
				$return = $objFile->uuid;
			}
			else
			{
				$return = $objFile->id;
			}
		}
		return $return;
	}

}
