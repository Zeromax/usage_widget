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
 * Class UsageWidget
 *
 * Provide methods to handle input field "usage widget".
 * @package   usage_widget
 * @author    Andreas Nölke
 * @copyright brothers-project 2013
 */
class UsageWidget extends \Widget
{

	/**
	 * Submit user input
	 * @var boolean
	 */
	protected $blnSubmitInput = true;

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'be_widget';

	/**
	 * Template
	 * @var string
	 */
	protected $strWidgetTemplate = 'be_usage_widget';

	/**
	 * Label for list view
	 * @var string
	 */
	protected $strFieldLabel;

	/**
	 * Title for Modal Window
	 * @var string
	 */
	protected $strPickerTitle;

	/**
	 * Multiple flag
	 * @var boolean
	 */
	protected $blnIsMultiple = false;

	/**
	 * Load the database object
	 * @param array
	 */
	public function __construct($arrAttributes = null)
	{
		$this->import('Database');
		parent::__construct($arrAttributes);

		// get eval values
		$arrEval = $GLOBALS['TL_DCA'][$this->strTable]['fields'][$this->strField]['eval'];

		// set custom Template
		if (isset($arrEval['widgetTemplate']) && $arrEval['widgetTemplate'] != "")
		{
			$this->strWidgetTemplate = $arrEval['widgetTemplate'];
		}

		$this->blnIsMultiple = true;
		$this->strPickerTitle = (($this->strPickerTitle != "") ? specialchars($arrEval['pickerTitle']) : 'Usage Wizard');

		$arrModel = array();
		if (isset($arrEval['model']))
		{
			foreach ($arrEval['model'] as $v)
			{
				$model = new \stdClass();
				$model->table = $v['table'];
				$model->model = \Model::getClassFromTable($v['table']);
				$model->label = $v['label'];
				$model->labelValue = $v['labelValue'];
				$model->column = $v['column'];
				if (\Input::get('act') == 'editAll')
				{
					$arrId = explode('_', $this->strId);
					$model->value = end($arrId);
				}
				else
				{
					$model->value = $v['value'];
				}
				$model->do = $v['do'];
				$arrModel[] = $model;
			}
		}
		$this->arrModel = $arrModel;
	}

	/**
	 * Return an array if the "multiple" attribute is set
	 * @param mixed
	 * @return mixed
	 */
	protected function validator($varInput)
	{
		// Return the value as usual
		if ($varInput == '')
		{
			if (!$this->mandatory)
			{
				return '';
			}
			else
			{
				$this->addError(sprintf($GLOBALS['TL_LANG']['ERR']['mandatory'], $this->strLabel));
			}
		}
		elseif (strpos($varInput, ',') === false)
		{
			return $this->blnIsMultiple ? array(intval($varInput)) : intval($varInput);
		}
		else
		{
			$arrValue = array_map('intval', array_filter(explode(',', $varInput)));
			return $this->blnIsMultiple ? $arrValue : $arrValue[0];
		}
	}

	/**
	 * Generate the widget and return it as string
	 * @return string
	 */
	public function generate()
	{
		$arrSet = array();
		$arrValues = array();

		foreach ($this->arrModel as $v)
		{
			$class = $v->model;
			$obj = $class::findBy($v->column, $v->value);

			if ($obj !== null)
			{
				while ($obj->next())
				{
					$current = $obj->current();
					if ($current->multiSRC != "" && !in_array($v->value[0], deserialize($current->multiSRC)))
					{
						continue;
					}
					$modFound = false;
					if ($current->modules != "")
					{
						$mod = deserialize($current->modules);
						if (is_array($mod))
						{
							foreach ($mod as $module)
							{
								if ($module['mod'] == $v->value[0])
								{
									$modFound = true;
									break;
								}
							}
						}
						if (!$modFound)
						{
							continue;
						}
					}
					
					$arrSet[] = $current->id;
					$objClass = new \stdClass();
					$objClass->icon = \Image::getHtml($this->getPageStatusIcon($current));
					$arrLabelValue = array();
					for ($i = 0; $i < count($v->labelValue); $i++)
					{
						$arrLabelValue[] = $current->{$v->labelValue[$i]};
						$objClass->{$v->labelValue[$i]} = $current->{$v->labelValue[$i]};
					}
					$objClass->label = vsprintf($v->label, $arrLabelValue);
					$objClass->table = $v->table;
					$objClass->do = $v->do;
					$arrValues[$current->id] = $objClass;
				}
			}
		}

		$objTemplate = new \BackendTemplate($this->strWidgetTemplate);
		$objTemplate->type = $this->type;
		$objTemplate->isAjaxRequest = \Environment::get('isAjaxRequest');
		$objTemplate->name = $this->strName;
		$objTemplate->id = $this->strId;
		$objTemplate->set = implode(',', $arrSet);
		$objTemplate->class = "";
		$objTemplate->arrValues = $arrValues;
		$objTemplate->do = \Input::get('do');
		$objTemplate->table = $this->strTable;
		$objTemplate->field = $this->strField;
		$objTemplate->getId = \Input::get('id');
		$objTemplate->href = 'contao/main.php?do=page&amp;popup=1';
		$objTemplate->changeSelection = $GLOBALS['TL_LANG']['MSC']['changeSelection'];
		$objTemplate->pickerTitle = $this->strPickerTitle;
		$this->Session->set('filePickerRef', '');

		return $objTemplate->parse();
	}

}