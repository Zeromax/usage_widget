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
 * Hook
 */
$GLOBALS['TL_HOOKS']['executePostActions'][] = array('AjaxUsageWidget', 'ajaxUsageWidgetRequest');

/*
 * Back end Form Fields
 */
$GLOBALS['BE_FFL']['usage'] = 'UsageWidget';

/**
 * Add JavaScript
 */
if (TL_MODE == 'BE')
{
	$GLOBALS['TL_JAVASCRIPT']['UW'] = 'system/modules/usage_widget/assets/js/UsageWidget.js';
}