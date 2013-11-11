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
 * Class AjaxUsageWidget
 *
 * Provide methods to handle input field "usage widget".
 * @package   usage_widget
 * @author    Andreas Nölke
 * @copyright brothers-project 2013
 */
class AjaxUsageWidget extends \Backend
{

	function ajaxUsageWidgetRequest($str, \DataContainer $dc)
	{
		if ($str == 'reloadWidget')
		{
			// Build th{e attributes based on the "eval" array
			$arrAttribs = $GLOBALS['TL_DCA'][$dc->table]['fields'][\Input::post('name')]['eval'];

			$arrAttribs['id'] = \Input::post('name');
			$arrAttribs['strName'] = \Input::post('name');
			$arrAttribs['value'] = \Input::post('value');
			$arrAttribs['strTable'] = $dc->table;
			$arrAttribs['strField'] = \Input::post('field');
			$arrAttribs['type'] = \Input::post('widget');

			$widget = \Input::post('widget');
			$objWidget = new $GLOBALS['BE_FFL'][$widget]($arrAttribs);
			echo $objWidget->generate();
			exit;
		}
	}

}
