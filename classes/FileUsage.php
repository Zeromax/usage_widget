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
		$objFile = \FilesModel::findMultipleByPaths(array(\Input::get('id')));
		if ($objFile && $objFile->id > 0)
		{
			$return = $objFile->id;
		}
		return $return;
	}

}
