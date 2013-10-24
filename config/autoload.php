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
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'Contao\AjaxUsageWidget'		=> 'system/modules/usage_widget/classes/AjaxUsageWidget.php',
	'Contao\FileUsage'				=> 'system/modules/usage_widget/classes/FileUsage.php',

	// Widgets
	'Contao\UsageWidget'			=> 'system/modules/usage_widget/widgets/UsageWidget.php',
));

/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'be_usage_widget'				=> 'system/modules/usage_widget/templates',
	'be_usage_widget_files'			=> 'system/modules/usage_widget/templates'
));