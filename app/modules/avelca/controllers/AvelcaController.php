<?php namespace App\Modules\Avelca\Controllers;

use View;
use Validator;
use Redirect;
use Sentry;
use Input;
use DB;
use Permission;
use Form;
use URL;

use ZipArchive;
use File;

use App\Modules\Avelca_User\Models\Group;

class AvelcaController extends \BaseController
{
	/*
	|--------------------------------------------------------------------------
	| Variables
	|--------------------------------------------------------------------------
	|
	*/

	protected $Model;

	protected $bladeLayout = 'layouts/default';

	protected $structure = array();

	protected $viewDir = 'avelca::';

	protected $title = '';

	protected $routeName = '';

	protected $modalDialog = '';

	protected $defaultStructure = array(
		'type' 		=> 'text'
		,'label' 		=> null
		,'onIndex' 		=> false
		,'fillable' 	=> true
		,'editable' 	=> true
		,'attributes' 	=> array()
		,'values' 		=> array()
		);

	protected $trigger = '';

	protected $triggerFields = array();

	protected $formulaResult = '';

	protected $operator = '*';

	protected $operands = array();

	protected $rules = array();

	/*
	|--------------------------------------------------------------------------
	| Views
	|--------------------------------------------------------------------------
	|
	*/

	public function __construct($Model)
	{
		$this->setModel($Model);
		$this->structure = $Model->structure();
		$this->routeName = $this->Model->route;
	}

	/* Index */
	public function getIndex()
	{
		return $this->makeView('index');
	}

	/* Create */
	public function getCreate()
	{
		$customView = 'admin.'.$this->routeName.'.create';

		if(View::exists($customView))
		{
			return View::make($customView);
		}

		return Redirect::to('admin/'.$this->routeName);
	}

	public function postCreate()
	{
		$formItem = $this->formItem();
		$formParent = $this->formParent();

		$input = Input::all();

		$validation = \Validator::make($input, $this->getRules());
		
		if($validation->passes())
		{
			DB::beginTransaction();

			$record = $this->Model->create($input);

			/* Khusus Master Detail */
			if( ! empty($formItem) )
			{
				$Model = '\\'.str_singular(studly_case($formItem));

				foreach ($Model::$rules as $field => $rules) {
					$fields1[$field] = $field;
				}

				foreach ($input as $field => $value) {
					$fields2[$field] = $field;
				}

				$fields = array_intersect($fields1, $fields2);

				$parent = str_singular($Model::$formParent).'_id';

				for($y = 0; $y < count($input[$field]); $y++) {
					if( empty($input[$field][$y]) )
					{
						DB::rollback();
						return \Redirect::to(URL::previous())->with('status_error', 'Please fill all fields.');
					}
					$x = new $Model;
					$x->$parent = $record->id;

					foreach ($fields as $field) {
						$x->$field = $input[$field][$y];
					}
					$x->save();

				}
			}
			/* End Khusus Master Detail */

			DB::commit();



			return \Redirect::to(URL::previous())->with('status', $this->modelName($this->Model).' successfully created.');
		}

		return \Redirect::to(URL::previous())->withErrors($validation)->withInput();
	}

	/* Edit */
	public function getEdit()
	{
		$customView = 'admin.'.$this->routeName.'.edit';

		if(View::exists($customView))
		{
			return View::make($customView);
		}

		return Redirect::to('admin/'.$this->routeName);
	}

	public function postEdit($id)
	{
		$input = \Input::all();

		$validation = \Validator::make($input, $this->getRules());

		if($validation->passes())
		{
			DB::beginTransaction();

			$record = $this->Model->find($id)->update($input);

			$formItem = $this->formItem();

			/* Khusus Master Detail */
			if( ! empty($formItem))
			{
				$Model = str_singular(studly_case($formItem));

				foreach ($Model::$rules as $field => $rules) {
					$fields1[$field] = $field;
				}

				foreach ($input as $field => $value) {
					$fields2[$field] = $field;
				}

				$fields = array_intersect($fields1, $fields2);
				$parent = str_singular($Model::$formParent).'_id';

				$last = count($input[end($fields1)]);
				$total = $Model::where($parent,'=',$id)->get()->count();

				/* Update Biasa */

				for($y = 0; $y < $last; $y++) {
					if( empty($input[$field][$y]) )
					{
						DB::rollback();
						return \Redirect::to(URL::previous())->with('status_error', 'Please fill all fields.');
					}


					if( ! empty($input['id'][$y]))
					{
						$record_id = $input['id'][$y];

						$record_item = $Model::find($record_id);
						foreach ($fields as $field) {
							$record_item->$field = $input[$field][$y];
						}
						$record_item->save();
					}
				}

				/* Penambahan */
				if($last > $total)
				{
					for($z = $total; $z < $last; $z++)
					{
						$record_item = new $Model();
						$record_item->$parent = $id;
						foreach ($fields as $field) {
							$record_item->$field = $input[$field][$z];
						}
						$record_item->save();
					}
				}


				/* Pengurangan */
				if($last < $total)
				{
					$record_items = $Model::where($parent,'=',$id)->get();
					foreach ($record_items as $record_item)
					{
						$existing_ids[] = $record_item->id;
					}

					foreach ($input['id'] as $submited_id) {
						$submited_ids[] = (int) $submited_id;
					}

					$missing_ids = array_diff($existing_ids, $submited_ids);

					foreach ($missing_ids as $missing_id) {
						$record = $Model::where($parent,'=', $id)
						->where('id','=', $missing_id)
						->delete();
					}
				}				
			}
			/* End Khusus Master Detail */

			DB::commit();

			return \Redirect::to(URL::previous())->with('status', $this->modelName($this->Model).' successfully updated.');
		}

		return \Redirect::to(URL::previous())->withErrors($validation);

	}

	/* Delete */
	public function getDelete()
	{
		$customView = 'admin.'.$this->routeName.'.delete';

		if(View::exists($customView))
		{
			return View::make($customView);
		}

		return Redirect::to('admin/'.$this->routeName);
	}

	public function postDelete($id)
	{
		$formItem = $this->formItem();

		DB::beginTransaction();

		/* Khusus Master Detail */
		if( ! empty($formItem))
		{
			$this->Model->find($id)->$formItem()->delete();
		}
		/* End Khsusus Master Detail */

		$this->Model->findOrFail($id)->delete();

		DB::commit();

		return \Redirect::to(URL::previous())->with('status', get_class($this->Model).' successfully deleted.');
	}

	/* AJAX Data */

	public function postData($id)
	{
		if($this->Model->find($id))
		{
			return \Response::json($this->Model->find($id));	
		}
		return \Response::json();
	}

	public function getData($id = null)
	{
		/* Start Query */
		$table_name = $this->Model->table;
		$records = \DB::table($table_name);

		/* Fields */
		$fields = array();
		$indexFields = $this->getIndexFields();

		if(Input::has('fields'))
		{
			$indexFields = explode(',', Input::get('fields'));
			foreach ($indexFields as $field) {
				$fields[] = $field;
			}
		}
		else
		{
			foreach ($indexFields as $field => $structure) {
				$fields[] = $field;
			}
		}

		$records = $records->select($fields);

		/* Limit */
		if(Input::has('limit'))
		{
			$records = $records->take(Input::get('limit'));			
		}

		/* Offset */
		if(Input::has('offset'))
		{
			$records = $records->skip(Input::get('offset'));			
		}

		/* Column Conditional */
		foreach ($fields as $field)
		{
			$fieldName = $field;
			$field = Input::get($field);
			$field = urldecode($field);

			if( ! empty($field))
			{
				$records = $records->where($fieldName, '=', $field);
			}
		}

		/* Soft Delete */
		if( ! Input::has('withTrashed') )
		{
			$records = $records->whereNull('deleted_at');
		}

		/* Grouping */
		if( Input::has('groupBy') )
		{
			$records = $records->groupBy(Input::get('groupBy'));
		}

		/* Sorting */
		if( Input::has('orderBy') )
		{
			$columns = Input::get('orderBy');
			$columns = explode(',', $columns);
			$records = $records->orderBy($columns[0], $columns[1]);
		}

		/* Finaly Get */
		if( ! empty($id))
		{
			$records = $records->whereId($id)->get();
		}
		else
		{
			$records = $records->get();
		}

		/* Result */
		$result = array();

		foreach ($records as $record) {
			$rows = array();
			foreach ($fields as $field) {
				$rows[$field] = $record->$field;	
			}
			$result[] = $rows;
		}

		if( empty($result))
		{
			$result = array('result' => 'null');
		}

		return json_encode($result);
	}

	/*
	|--------------------------------------------------------------------------
	| Functions
	|--------------------------------------------------------------------------
	|
	*/

	protected function modelName($model)
	{
		$parts = preg_split('/(?=[A-Z])/', get_class($model), -1, PREG_SPLIT_NO_EMPTY);
		$name = '';

		for($i = 0; $i < count($parts); $i++)
		{
			$name .= $parts[$i];

			if($i != (count($parts) - 1) )
			{
				$name .= ' ';
			}
		}
		return $name = trim($name);
	}

	protected function getModalDialog()
	{
		$modalDialog = $this->modalDialog;

		$c = get_class($this->Model);

		if(isset($c::$modalDialog))
		{
			$modalDialog = $c::$modalDialog;

			switch ($modalDialog) {
				case 'small':
				$modalDialog = 'modal-sm';
				break;

				case 'large':
				$modalDialog = 'modal-lg';
				break;
				
				default:
				$modalDialog = '';
				break;
			}
		}

		return $modalDialog;
	}

	protected function getTrigger()
	{
		$c = get_class($this->Model);

		if(isset($c::$formItem))
		{
			$formItem = $c::$formItem;
			$Model = str_singular(studly_case($formItem));

			if(isset($Model::$trigger))
			{
				return $Model::$trigger;				
			}
		}
		
		return $this->trigger;
	}

	protected function getTriggerFields()
	{
		$c = get_class($this->Model);

		if(isset($c::$formItem))
		{
			$formItem = $c::$formItem;
			$Model = str_singular(studly_case($formItem));

			if(isset($Model::$triggerFields))
			{
				return $Model::$triggerFields;				
			}
		}
		
		return $this->triggerFields;
	}

	protected function getFormulaResult()
	{
		$c = get_class($this->Model);

		if(isset($c::$formItem))
		{
			$formItem = $c::$formItem;
			$Model = str_singular(studly_case($formItem));

			$fields = $Model::structure()['fields'];

			foreach ($fields as $field => $structure) {
				if($structure['type'] == 'formula')
				{
					return $field;
				}
			}
		}
		
		return $this->formulaResult;
	}

	protected function getOperator()
	{
		$c = get_class($this->Model);

		if(isset($c::$formItem))
		{
			$formItem = $c::$formItem;
			$Model = str_singular(studly_case($formItem));

			$fields = $Model::structure()['fields'];

			foreach ($fields as $field => $structure) {
				if($structure['type'] == 'formula')
				{
					return $structure['operator'];
				}
			}
		}
		
		return $this->operator;
	}

	protected function getOperands()
	{
		$c = get_class($this->Model);

		if(isset($c::$formItem))
		{
			$formItem = $c::$formItem;
			$Model = str_singular(studly_case($formItem));

			$fields = $Model::structure()['fields'];

			foreach ($fields as $field => $structure) {
				if($structure['type'] == 'formula')
				{
					foreach ($structure['operands'] as $operand) {
						$this->operands[] = $operand;
					}
				}
			}
		}
		
		return $this->operands;
	}

	protected function getRules()
	{
		$c = get_class($this->Model);

		if(isset($c::$formItem))
		{
			$formItem = $c::$formItem;
			$Model = str_singular(studly_case($formItem));
			$new_rules = array_merge($c::$rules, $Model::$rules);
			return $new_rules;
		}

		return isset($c::$rules) ? $c::$rules : array();
	}

	protected function getModel()
	{
		return $this->Model;
	}

	protected function setModel($Model)
	{
		$this->Model = $Model;
	}

	protected function getViewFields()
	{
		return array_filter($this->structure['fields'], function($fields)
		{
			foreach ($fields as $field => $value)
			{
				return true; 
			}
		});
	}

	protected function getIndexFields()
	{
		return array_filter($this->structure['fields'], function($fields)
		{
			foreach ($fields as $field => $value)
			{
				if($this->parseStructure($fields)['onIndex'])
				{
					return true;
				} 
			}
		});
	}

	protected function getCreateFields()
	{
		return array_filter($this->structure['fields'], function($fields)
		{
			foreach ($fields as $field => $value)
			{
				if($this->parseStructure($fields)['fillable'])
				{
					return $this->parseStructure($fields)['fillable'];
				} 
			}
		});
	}

	protected function getEditFields()
	{
		return array_filter($this->structure['fields'], function($fields)
		{
			foreach ($fields as $field => $value)
			{
				if($this->parseStructure($fields)['editable'])
				{
					return $this->parseStructure($fields)['editable'];
				}
			}
		});
	}

	protected function getEnctype()
	{
		$enctype = 'application/x-www-form-urlencoded';
		foreach ($this->structure['fields'] as $field => $structure)
		{
			if($structure['type'] == 'file')
			{
				$enctype = 'multipart/form-data';
			}
		}
		return $enctype;
	}

	protected function getActionButtons()
	{
		$c = get_class($this->Model);
		return isset($c::$actionButtons) ? $c::$actionButtons : array();
	}

	protected function getMainButtons()
	{
		$c = get_class($this->Model);
		return isset($c::$mainButtons) ? $c::$mainButtons : array();
	}

	protected function getDisabledActions()
	{
		$c = get_class($this->Model);
		return isset($c::$disabledActions) ? $c::$disabledActions : array();
	}

	protected function parseStructure($fields)
	{
		return array_merge($this->defaultStructure, $fields);
	}

	protected function makeView($view, array $data = array())
	{
		$default = array(
			'title' 			=> $this->title
			,'Model' 			=> $this->Model
			,'routeName' 		=> $this->routeName
			,'viewDir' 			=> $this->viewDir
			,'bladeLayout' 		=> $this->bladeLayout
			,'viewName' 		=> $view
			,'indexFields' 		=> $this->getIndexFields()
			,'fields' 			=> $this->getViewFields()
			,'createFields' 	=> $this->getCreateFields()
			,'editFields' 		=> $this->getEditFields()
			,'records' 			=> $this->retrieveRecords()
			,'actionButtons' => $this->getActionButtons()
			,'mainButtons' => $this->getMainButtons()
			,'disabledActions' => $this->getDisabledActions()
			,'formItem' => $this->formItem()
			,'formParent' => $this->formParent()
			,'trigger' => $this->getTrigger()
			,'triggerFields' => $this->getTriggerFields()
			,'formulaResult' => $this->getFormulaResult()
			,'operands' => $this->getOperands()
			,'operator' => $this->getOperator()
			,'name' => $this->modelName($this->Model)
			,'enctype' => $this->getEnctype()
			,'rules' => $this->getRules()
			,'modalDialog' => $this->getModalDialog()
			);

$data = array_merge($default, $data);

return View::make($this->viewDir . $view, $data);
}

protected function formItem()
{
	$c = get_class($this->Model);
	return isset($c::$formItem) ? $c::$formItem : null;
}

protected function formParent()
{
	$c = get_class($this->Model);
	return isset($c::$formParent) ? $c::$formParent : null;
}

protected function retrieveRecords()
{
	$c = get_class($this->Model);

	if( ! empty($c::$index_conditions) )
	{
		if ( count($c::$index_conditions) > 0)
		{
			$records = $this->Model; 
			foreach ($c::$index_conditions as $condition => $properties) {

				switch ($condition) {
					case 'where':
					$records = $records->where($properties[0], $properties[1], $properties[2]);
					break;

					case 'where_user':
					$records = $records->where($properties[0], $properties[1], Sentry::getUser()->$properties[2]);
					break;

					case 'where_group':
					$records = $records->where($properties[0], $properties[1], Sentry::getUser()->groups()->first()->$properties[2]);
					break;

					case 'auth_user':
					$records = $records->where($properties, '=', Sentry::getUser()->id);
					break;

					case 'auth_group':
					$records = $records->where($properties, '=', Sentry::getUser()->groups()->first()->id);
					break;
				}
			}
			return $records->orderBy('id','desc')->get();
		}
	}

	$indexFields = $this->getIndexFields();
	$records = $this->Model;
	foreach ($indexFields as $field => $structure) {
		if (Input::has($field)) {
			$records = $records->where($field, '=', Input::get($field));
		}
	}
	return $records->orderBy('id','DESC')->get();
}

	/*
	|--------------------------------------------------------------------------
	| HTML Form
	|--------------------------------------------------------------------------
	|
	*/

	public static function tableHeader($field, $structure)
	{
		$label = empty($structure['label']) ? $field :  $structure['label'];
		$label = substr($label, -3) == '_id' ? substr($label, 0, strlen($label) - 3) : $label;
		return ucwords(str_replace('_',' ',$label));
	}

	public static function viewIndexContent($record, $structure, $field)
	{
		if($structure['type'] == 'select')
		{
			if( ! empty($structure['table']) )
			{
				$id = $record->id;

				if(substr($field, -3) == '_id')
				{
					$id = $record->$field;
				}

				$Model = ucfirst(str_singular($structure['table']));

				$identifier = self::getIdentifier($structure['table'], $structure);

				$Model = str_replace('_',' ',str_singular($structure['table']));
				$parts = preg_split('/(?=[A-Z])/', $Model, -1, PREG_SPLIT_NO_EMPTY);
				$name = '';

				for($i = 0; $i < count($parts); $i++)
				{
					$name .= $parts[$i];

					if($i != (count($parts) - 1) )
					{
						$name .= ' ';
					}
				}
				$Model = str_replace(' ','',ucwords($name));

				return $Model::find($id)->$identifier;
			}
		}

		if($structure['type'] == 'radio')
		{
			if( ! empty($structure['values']) )
			{
				return $structure['values'][$record->$field];
			}
		}

		if($structure['type'] == 'url')
		{
			$attributes = array();
			if( ! empty($structure['newTab']) )
			{
				$attributes = array('target' => '_blank');
			}

			$title = null;
			if( ! empty($structure['title']) )
			{
				$title = $structure['title'];
			}

			$url = $record->$field;

			$initial = substr($url, 0, 5);
			switch ($initial) {
				case 'https':
				case 'http:':
				$url = $record->$field;
				break;
				
				default:
				$url = 'http://'.$record->$field;
				break;
			}

			return \HTML::link($url, $title, $attributes);
		}

		if($structure['type'] == 'email')
		{
			return \HTML::link('mailto:'.$record->$field, $record->$field);
		}

		if($structure['type'] == 'number')
		{
			return number_format($record->$field,0,',','.');
		}

		if($structure['type'] == 'decimal')
		{
			return $record->$field;
		}

		if($structure['type'] == 'file')
		{
			$ext = pathinfo($record->$field, PATHINFO_EXTENSION);
			if(in_array(strtolower($ext), array('jpg', 'gif', 'png', 'jpeg')))
			{
				$attributes = array('class' => 'img-responsive');

				if( ! empty($structure['max-width']) || ! empty($structure['max-height']) )
				{
					$css_style = '';
					if( ! empty($structure['max-width']) )
					{
						$css_style .= 'max-width: '.$structure['max-width'].'px; ';
					}
					if( ! empty($structure['max-height']) )
					{
						$css_style .= 'max-height: '.$structure['max-height'].'px; ';
					}
					$css_style .= 'margin: 0px auto;';

					$attributes['style'] = $css_style;
				}

				return \HTML::image($record->$field, null, $attributes);
			}

			return \HTML::link($record->$field, substr($record->$field,0,30).'...', array('Title' => $record->$field));
		}

		if($structure['type'] == 'formula')
		{
			$operator = $structure['operator'];
			$operands = $structure['operands'];

			$value = 1;

			foreach ($operands as $operand) {
				switch ($operator) {
					default:
					$value = $value * $record->$operand;
					break;
				}
			}

			return number_format($value,0,',','.');
		}

		return $record->$field;
	}

	public static function label($field, $structure, $rules = array())
	{
		$label = empty($structure['label']) ? $field :  $structure['label'];
		$label = substr($label, -3) == '_id' ? substr($label, 0, strlen($label) - 3) : $label;
		$label = ucwords(str_replace('_',' ',$label));

		$attributes = empty($structure['attributes']) ? array() :  $structure['attributes'];
		
		$attributes = array_merge($attributes, array('class' => 'control-label col-md-3'));

		if(array_key_exists($field, $rules))
		{
			$label .= ' *';
		}

		return Form::label($field, $label, $attributes);
	}

	/* Field - Table */

	/* Field - Form */
	public static function field($field, $structure, $rules = array())
	{
		$value = empty($structure['value']) ? Input::old($field) :  $structure['value'];
		$attributes = empty($structure['attributes']) ? array() :  $structure['attributes'];
		$attributes = array_merge($attributes, array('class' => 'form-control'));

		if (array_key_exists($field, $rules))
		{
			$attributes = array_merge($attributes, array('required'));
		}

		$type = $structure['type'];

		$editable = empty($structure['editable']) ? true :  $structure['editable'];

		if($editable === false)
		{
			$structure['attributes']['readonly'] = 'readonly';
		}

		$element = '<div class="col-md-4">';

		$inline = empty($structure['inline']) ? $inline = false :  $inline = true;

		switch($type)
		{
			case 'select':
			$table = empty($structure['table']) ? null : ucwords($structure['table']);

			if( ! empty($table))
			{
				$table_model = str_replace('_',' ',str_singular(ucfirst($structure['table'])));
				$parts = preg_split('/(?=[A-Z])/', $table_model, -1, PREG_SPLIT_NO_EMPTY);
				$name = '';

				for($i = 0; $i < count($parts); $i++)
				{
					$name .= $parts[$i];

					if($i != (count($parts) - 1) )
					{
						$name .= ' ';
					}
				}
				$table_model = str_replace(' ','',ucwords($name));

				$rows = $table_model::orderBy('id');

				/* Scopes */
				if ( ! empty($structure['scopes']) )
				{
					foreach ($structure['scopes'] as $scope) {
						$rows = $rows->$scope();
					}
				}
				else
				{
					/* Conditions */
					if ( ! empty($structure['conditions']) )
					{
						foreach ($structure['conditions'] as $condition => $property) {
							$rows = $rows->where($property[0],$property[1],$property[2]);
						}
					}
				}

				$rows = $rows->get();

				$identifier = self::getIdentifier($table, $structure);

				unset($structure['values']);


				foreach ($rows as $row) {
					$optionDisplay = '';
					if ( ! empty($structure['identifier']))
					{
						$i = 1;
						foreach ($structure['identifier'] as $display) {
							$optionDisplay .= $row->$display;
							if($i < count($structure['identifier'])) {
								$optionDisplay .= ' - ';
								$i++;
							}
						}
					}
					else
					{
						$optionDisplay = $row->$identifier;
					}

					$structure['values'][$row->id] = $optionDisplay;
				}
			}

			$selected = empty($structure['selected']) ? null :  $structure['selected'];

			$structure['values'] = empty($structure['values']) ? array() :  $structure['values'];

			$attributes = array_merge($attributes, array('class' => 'selectpicker'));

			$element .= Form::select($field, $structure['values'], $selected, $attributes);
			$element .= '</div>';
			return $element;
			break;

			case 'radio':

			unset($attributes['class']);

			if($inline)
			{
				$inline = '-inline';
			}

			$radios = array();
			foreach($structure['values'] as $value => $display)
			{
				$radios[] = '<div class="radio'.$inline.'"><label>'.Form::radio($field, $value, null, $attributes) . ' ' . $display.'</label></div>';
			}

			$element .= implode("\n", $radios);
			$element .= '</div>';
			return $element;
			break;

			case 'checkbox':

			unset($attributes['class']);

			if($inline)
			{
				$inline = '-inline';
			}

			$checkboxes = array();
			foreach($structure['values'] as $value => $display)
			{
				$checkboxes[] = '<div class="checkbox'.$inline.'"><label>'.Form::checkbox($field, $value, null, $attributes) . ' ' . $display.'</label></div>';
			}

			$element .= implode("\n", $checkboxes);
			$element .= '</div>';
			return $element;
			break;

			case 'textarea':
			$attributes = array_merge($attributes, array('class' => 'form-control'));
			$element = '<div class="col-md-9">';
			if ( ! empty($structure['width']) ) {
				$attributes = array_merge($attributes, array('style' => 'width: '.$structure['width'].'px'));
			}
			if ( ! empty($structure['rows']) ) {
				$attributes = array_merge($attributes, array('rows' => $structure['rows']));
			}
			$element .= Form::textarea($field, $value, $attributes);
			$element .= '</div>';
			return $element;
			break;

			case 'longtext':
			$attributes = array_merge($attributes, array('id' => 'editor'));
			$element = '<div class="col-md-9">';
			$element .= Form::textarea($field, $value, $attributes);
			$element .= '</div>';
			return $element;
			break;

			case 'longtext-simple':
			$attributes = array_merge($attributes, array('id' => 'basic_editor'));
			$element = '<div class="col-md-9">';
			$element .= Form::textarea($field, $value, $attributes);
			$element .= '</div>';
			return $element;
			break;

			case 'file':
			$element = '<div class="col-md-4">';

			if ( ! empty($structure['url']) )
			{
				$attributes['placeholder'] = 'URL';
				$element .= Form::text($field.'_direct_url', $value, $attributes);
				$element .= '</div><div class="col-md-4">';
			}

			$element .= Form::file($field, $value, $attributes);
			$element .= '</div>';
			return $element;
			break;

			case 'datepicker':
			$element = '<div class="col-md-3"><div class="input-group datepicker" data-date-format="YYYY-MM-DD">';
			$element .= Form::text($field, $value, $attributes);
			$element .= '<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>';
			$element .= '</div></div>';
			return $element;
			break;

			case 'timepicker':
			$element = '<div class="col-md-2"><div class="input-group timepicker" data-date-format="H:m">';
			$element .= Form::text($field, $value, $attributes);
			$element .= '<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>';
			$element .= '</div></div>';
			return $element;
			break;

			case 'datetimepicker':
			$element = '<div class="col-md-3"><div class="input-group date datepicker" data-date-format="YYYY-MM-DD hh:mm">';
			$value = date('Y-m-d H:i');
			$element .= Form::text($field, $value, $attributes);
			$element .= '<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>';
			$element .= '</div></div>';
			return $element;
			break;

			case 'number':
			case 'bignumber':
			case 'decimal':
			$element = '<div class="col-md-2">';
			$element .= Form::text($field, $value, $attributes);
			$element .= '</div>';
			return $element;
			break;

			case 'colorpicker':
			$attributes = array_merge($attributes, array('id' => 'colorpicker'));
			$element = '<div class="col-md-2">';
			$element .= Form::text($field, $value, $attributes);
			$element .= '</div>';
			return $element;
			break;

			case 'section':
			$element = '<div class="col-md-9">';
			$element .= '<hr><br>';
			$element .= '</div>';
			return $element;
			break;

			case 'formula':
			$attributes = array_merge($attributes, array('disabled'));
			$element .= Form::text($field, $value, $attributes);
			$element .= '</div>';
			return $element;
			break;

			default:
			$element .= Form::text($field, $value, $attributes);
			$element .= '</div>';
			return $element;
			break;
		}		
	}

	/* Field - Form */
	public static function fieldFormItem($field, $structure, $multi = false, $record = null)
	{
		if( ! is_null($record))
		{
			$value = $record->$field;
		}
		else
		{
			$value = empty($structure['value']) ? null :  $structure['value'];
		}

		$attributes = empty($structure['attributes']) ? array() :  $structure['attributes'];
		$attributes = array_merge($attributes, array('class' => 'form-control'));


		$type = $structure['type'];

		$editable = empty($structure['editable']) ? true :  $structure['editable'];

		if($editable === false)
		{
			$structure['attributes']['readonly'] = 'readonly';
		}

		$element = '<div class="col-md-12">';

		$inline = empty($structure['inline']) ? $inline = false :  $inline = true;

		if($multi)
		{
			$field = $field.'[]';
		}

		switch($type)
		{
			case 'select':
			$table = empty($structure['table']) ? null : ucwords($structure['table']);

			if( ! empty($table))
			{
				$table_model = str_singular(ucfirst($structure['table']));

				$rows = $table_model::orderBy('id');

				/* Scopes */
				if ( ! empty($structure['scopes']) )
				{
					foreach ($structure['scopes'] as $scope) {
						$rows = $rows->$scope();
					}
				}
				else
				{
					/* Conditions */
					if ( ! empty($structure['conditions']) )
					{
						foreach ($structure['conditions'] as $condition => $property) {
							$rows = $rows->where($property[0],$property[1],$property[2]);
						}
					}
				}

				$rows = $rows->get();

				$identifier = self::getIdentifier($table, $structure);

				unset($structure['values']);

				foreach ($rows as $row) {
					$optionDisplay = '';
					if ( ! empty($structure['identifier']))
					{
						$i = 1;
						foreach ($structure['identifier'] as $display) {
							$optionDisplay .= $row->$display;
							if($i < count($structure['identifier'])) {
								$optionDisplay .= ' - ';
								$i++;
							}
						}
					}
					else
					{
						$optionDisplay = $row->$identifier;
					}

					$structure['values'][$row->id] = $optionDisplay;
				}
			}

			$structure['values'] = empty($structure['values']) ? array() :  $structure['values'];

			$selected = null;
			if( ! is_null($record))
			{
				$selected = $value;
			}

			$attributes = array_merge($attributes, array('class' => 'selectpicker'));

			$element .= Form::select($field, $structure['values'], $selected, $attributes);
			$element .= '</div>';
			return $element;
			break;

			case 'radio':

			unset($attributes['class']);

			if($inline)
			{
				$inline = '-inline';
			}

			$radios = array();
			foreach($structure['values'] as $value => $display)
			{
				$radios[] = '<div class="radio'.$inline.'"><label>'.Form::radio($field, $value, null, $attributes) . ' ' . $display.'</label></div>';
			}

			$element .= implode("\n", $radios);
			$element .= '</div>';
			return $element;
			break;

			case 'checkbox':

			unset($attributes['class']);

			if($inline)
			{
				$inline = '-inline';
			}

			$checkboxes = array();
			foreach($structure['values'] as $value => $display)
			{
				$checkboxes[] = '<div class="checkbox'.$inline.'"><label>'.Form::checkbox($field, $value, null, $attributes) . ' ' . $display.'</label></div>';
			}

			$element .= implode("\n", $checkboxes);
			$element .= '</div>';
			return $element;
			break;

			case 'textarea':
			$attributes = array_merge($attributes, array('class' => 'form-control'));
			$element = '<div class="col-md-9">';
			if ( ! empty($structure['width']) ) {
				$attributes = array_merge($attributes, array('style' => 'width: '.$structure['width'].'px'));
			}
			if ( ! empty($structure['rows']) ) {
				$attributes = array_merge($attributes, array('rows' => $structure['rows']));
			}
			$element .= Form::textarea($field, $value, $attributes);
			$element .= '</div>';
			return $element;
			break;

			case 'longtext':
			$attributes = array_merge($attributes, array('id' => 'editor'));
			$element = '<div class="col-md-9">';
			$element .= Form::textarea($field, $value, $attributes);
			$element .= '</div>';
			return $element;
			break;

			case 'longtext-simple':
			$attributes = array_merge($attributes, array('id' => 'basic_editor'));
			$element = '<div class="col-md-9">';
			$element .= Form::textarea($field, $value, $attributes);
			$element .= '</div>';
			return $element;
			break;

			case 'file':
			$element = '<div class="col-md-4">';

			if ( ! empty($structure['url']) )
			{
				$attributes['placeholder'] = 'URL';
				$element .= Form::text($field.'_direct_url', $value, $attributes);
				$element .= '</div><div class="col-md-4">';
			}

			$element .= Form::file($field, $value, $attributes);
			$element .= '</div>';
			return $element;
			break;

			case 'datepicker':
			$element = '<div class="col-md-3"><div class="input-group datepicker" data-date-format="YYYY-MM-DD">';
			$value = date('Y-m-d');
			$element .= Form::text($field, $value, $attributes);
			$element .= '<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>';
			$element .= '</div></div>';
			return $element;
			break;

			case 'timepicker':
			$element = '<div class="col-md-2"><div class="input-group timepicker" data-date-format="H:m">';
			$value = date('H:i');
			$element .= Form::text($field, $value, $attributes);
			$element .= '<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>';
			$element .= '</div></div>';
			return $element;
			break;

			case 'datetimepicker':
			$element = '<div class="col-md-3"><div class="input-group date datepicker" data-date-format="YYYY-MM-DD hh:mm">';
			$value = date('Y-m-d H:i');
			$element .= Form::text($field, $value, $attributes);
			$element .= '<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>';
			$element .= '</div></div>';
			return $element;
			break;

			case 'colorpicker':
			$attributes = array_merge($attributes, array('id' => 'colorpicker'));
			$element = '<div class="col-md-2">';
			$element .= Form::text($field, $value, $attributes);
			$element .= '</div>';
			return $element;
			break;

			case 'section':
			$element = '<div class="col-md-9">';
			$element .= '<hr><br>';
			$element .= '</div>';
			return $element;
			break;

			case 'formula':

			$operator = $structure['operator'];
			$operands = $structure['operands'];

			foreach ($operands as $operand) {
				switch ($operator) {
					case '*':
					$value = $value * $operand;
					break;
				}
			}

			$attributes = array_merge($attributes, array('disabled'));

			$element .= Form::text($field, $value, $attributes);
			$element .= '</div>';
			return $element;
			break;

			default:
			$element .= Form::text($field, $value, $attributes);
			$element .= '</div>';
			return $element;
			break;
		}		
	}

	protected static function getIdentifier($table, $structure)
	{
		$table = strtolower($table);
		$identifier = 'id';

		if(\Schema::hasColumn($table, 'code'))
		{
			$identifier = 'code';
		}
		if(\Schema::hasColumn($table, 'title'))
		{
			$identifier = 'title';
		}
		if(\Schema::hasColumn($table, 'last_name'))
		{
			$identifier = 'last_name';
		}
		if(\Schema::hasColumn($table, 'first_name'))
		{
			$identifier = 'first_name';
		}
		if(\Schema::hasColumn($table, 'full_name'))
		{
			$identifier = 'full_name';
		}
		if(\Schema::hasColumn($table, 'name'))
		{
			$identifier = 'name';
		}

		return $identifier;
	}

	public static function autoRoutes()
	{
		$files = \File::files(app_path().'/controllers');
		//$filelist = implode("<br>", $files);
		//echo($filelist);

		$standard_controllers = array(
			'HomeController',
			'BaseController',
			'DashboardController'
			);

		foreach ($files as $file) {
			$name = explode("/", $file);

			$name = end($name);
			$name = str_replace(".php", "", $name);
			$routeName = str_replace("Controller", '', $name);

			$parts = preg_split('/(?=[A-Z])/', $routeName, -1, PREG_SPLIT_NO_EMPTY);
			$routeName = '';

			for($i = 0; $i < count($parts); $i++)
			{
				$routeName .= $parts[$i];

				if($i != (count($parts) - 1) )
				{
					$routeName .= '-';
				}
			}

			$routeName = strtolower($routeName);
			

			
			if( ! in_array($name, $standard_controllers))
			{
				\Route::controller($routeName, $name);
			}
		}
	}

	public static function mainNavigation()
	{
		$files = \File::files(app_path().'/models');
		$user = Sentry::getUser();

		$master = '';
		$transaction = '';

		foreach($files as $file) {

			$name = str_replace('.php','',basename($file));
			$Model = '\\'.$name;

			$parts = preg_split('/(?=[A-Z])/', $name, -1, PREG_SPLIT_NO_EMPTY);
			$name = '';
			$url = '';

			for($i = 0; $i < count($parts); $i++)
			{
				$name .= $parts[$i];
				$url .= $parts[$i];

				if($i != (count($parts) - 1) )
				{
					$name .= ' ';
					$url .= '-';
				}
			}
			$name = trim($name);
			$url = 'admin/'.strtolower(trim($url));

			if(substr($name, -5) != ' Item' ) {
				if( $user->hasAccess(str_replace(' ','-',strtolower($name))) ) {
					if( ! isset($Model::$formItem) )
					{
						$master .= '
						<li>
						<a href="'.URL::to($url).'">'.$name.'</a>
						</li>
						';
					}
					else
					{
						$transaction .= '
						<li>
						<a href="'.URL::to($url).'">'.$name.'</a>
						</li>
						';
					}
				}
			}
		}

		?>
		
			<li>
				<a href="#"><i class="glyphicon glyphicon-th-large"></i> Master<span class="fa arrow"></span></a>
				<ul class="nav nav-second-level">'
					.$master.'
				</ul>
			</li>');
		
		<li>
			<a href="#"><i class="glyphicon glyphicon-list-alt"></i> Transaction<span class="fa arrow"></span></a>
			<ul class="nav nav-second-level">
				<?php echo $transaction; ?>
			</ul>
		</li>

	<?php

	}

	/* End HTML Form */

	/* Avelca Artisan Command */
	public static function avelcaInstall($cmd)
	{
		$logo = "
		_______  __   __  _______  ___      _______  _______ 
		|   _   ||  | |  ||       ||   |    |       ||   _   |
		|  |_|  ||  |_|  ||    ___||   |    |       ||  |_|  |
		|       ||       ||   |___ |   |    |       ||       |
		|       ||       ||    ___||   |___ |      _||       |
		|   _   | |     | |   |___ |       ||     |_ |   _   |
		|__| |__|  |___|  |_______||_______||_______||__| |__|
		";

		$cmd->comment($logo);
		$cmd->comment("Welcome to Avelca Application Installer.\n");

		$value = $cmd->option('nokey');

		if( empty($value) )
		{
			$cmd->info("1) Generate application secret key.");
			\Artisan::call('key:generate');			
		}
		else
		{
			$cmd->info("1) Do not generate application secret key.");
		}


		$cmd->info("2) Migrate, seed and publish user configuration file.");
		\Artisan::call('migrate', array('--path' => "app/modules/avelca_user/migrations"));

		\Artisan::call('config:publish', array('package' => 'cartalyst/sentry'));

		$cmd->info("3) Seed avelca module permission.");
		\Artisan::call('migrate', array('--path' => "app/modules/avelca_module/migrations"));

		$cmd->info("4) Migrate and seed avelca setting.");
		\Artisan::call('migrate', array('--path' => "app/modules/avelca_setting/migrations"));

		$seed = new \App\Modules\Avelca_User\Seeds\DatabaseSeeder;
		$seed->run();

		$seed = new \App\Modules\Avelca_Setting\Seeds\DatabaseSeeder;
		$seed->run();

		$seed = new \App\Modules\Avelca_Module\Seeds\DatabaseSeeder;
		$seed->run();

		$cmd->info("5) Migrate and seed.");
		\Artisan::call('migrate');
		\Artisan::call('db:seed');

		$cmd->comment("\nInstallation ................. [SUCCESS]\n");
		$cmd->info("Continue installation at http://[your_app_url]/install to create administrator user.\n");
	}

	public static function createAdministratorPermissions()
	{
		Group::truncate();

		$permissions = Permission::all();
		$all_permission = array();

		foreach ($permissions as $permission) {
			$all_permission[$permission->name] = 1;
		}

		Sentry::getGroupProvider()->create(array(
			'name'        => 'Administrator',
			'permissions' => $all_permission
			));

		return true;
	}
}