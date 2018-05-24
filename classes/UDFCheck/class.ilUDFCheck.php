<?php

/**
 * Class ilUDFCheck
 *
 * @author  Fabian Schmid <fs@studer-raimann.ch>
 * @version 1.0.0
 */
class ilUDFCheck extends ActiveRecord {

	const TABLE_NAME = 'usr_def_checks';
	const OP_EQUALS = 1;
	const OP_STARTS_WITH = 2;
	const OP_CONTAINS = 3;
	const OP_ENDS_WITH = 4;
	const OP_NOT_EQUALS = 5;
	const OP_NOT_STARTS_WITH = 6;
	const OP_NOT_CONTAINS = 7;
	const OP_NOT_ENDS_WITH = 8;
	const OP_IS_EMPTY = 9;
	const OP_NOT_IS_EMPTY = 10;
	const OP_REG_EX = 11;
	const STATUS_INACTIVE = 1;
	const STATUS_ACTIVE = 2;
	const TYPE_TEXT = 1;
	const TYPE_SELECT = 2;
	const TYPE_WYSIWYG = 3;
	const CHECK_SPLIT = ' → ';
	/**
	 * @var array
	 */
	public static $operator_text_keys = array(
		self::OP_EQUALS => 'equals',
		self::OP_STARTS_WITH => 'starts_with',
		self::OP_CONTAINS => 'contains',
		self::OP_ENDS_WITH => 'ends_with',
		self::OP_NOT_EQUALS => 'not_equals',
		self::OP_NOT_STARTS_WITH => 'not_starts_with',
		self::OP_NOT_CONTAINS => 'not_contains',
		self::OP_NOT_ENDS_WITH => 'not_ends_with',
		self::OP_IS_EMPTY => 'is_empty',
		self::OP_NOT_IS_EMPTY => 'not_is_empty',
		self::OP_REG_EX => 'reg_ex',
	);
	/**
	 * @var int
	 *
	 * @con_is_primary true
	 * @con_is_unique  true
	 * @con_sequence   true
	 * @con_has_field  true
	 * @con_fieldtype  integer
	 * @con_length     8
	 */
	protected $id = 0;
	/**
	 * @var int
	 *
	 * @con_has_field  true
	 * @con_fieldtype  integer
	 * @con_length     8
	 */
	protected $parent_id = 0;
	/**
	 * @var int
	 *
	 * @con_has_field  true
	 * @con_fieldtype  integer
	 * @con_length     8
	 */
	protected $udf_field_id = 1;
	/**
	 * @var string
	 *
	 * @con_has_field  true
	 * @con_fieldtype  text
	 * @con_length     256
	 */
	protected $check_value = '';
	/**
	 * @var int
	 *
	 * @con_has_field  true
	 * @con_fieldtype  integer
	 * @con_length     1
	 */
	protected $operator = self::OP_EQUALS;
	/**
	 * @var bool
	 *
	 * @con_has_field  true
	 * @con_fieldtype  integer
	 * @con_length     1
	 */
	protected $negated = false;
	/**
	 * @var int
	 *
	 * @con_has_field  true
	 * @con_fieldtype  integer
	 * @con_length     8
	 */
	protected $owner = 6;
	/**
	 * @var int
	 *
	 * @con_has_field  true
	 * @con_fieldtype  integer
	 * @con_length     8
	 */
	protected $status = self::STATUS_ACTIVE;
	/**
	 * @var int
	 *
	 * @db_has_field        true
	 * @db_fieldtype        timestamp
	 * @db_is_notnull       true
	 */
	protected $create_date;
	/**
	 * @var int
	 *
	 * @db_has_field        true
	 * @db_fieldtype        timestamp
	 * @db_is_notnull       true
	 */
	protected $update_date;


	/**
	 * @return string
	 */
	static function returnDbTableName() {
		return self::TABLE_NAME;
	}


	/**
	 * @param       $primary_key
	 * @param array $add_constructor_args
	 *
	 * @return ilUDFCheck
	 */
	public static function find($primary_key, array $add_constructor_args = array()) {
		return parent::find($primary_key, $add_constructor_args); // TODO: Change the autogenerated stub
	}


	public function update() {
		global $DIC;
		$ilUser = $DIC->user();
		$this->setOwner($ilUser->getId());
		$this->setUpdateDate(time());
		parent::update();
	}


	public function create() {
		global $DIC;
		$ilUser = $DIC->user();
		$this->setOwner($ilUser->getId());
		$this->setUpdateDate(time());
		$this->setCreateDate(time());
		parent::create();
	}


	/**
	 * @return string
	 */
	public function getConnectorContainerName() {
		return self::TABLE_NAME;
	}


	/**
	 * @param string $check_value
	 */
	public function setCheckValue($check_value) {
		$this->check_value = $check_value;
	}


	/**
	 * @param string[] $check_values
	 */
	public function setCheckValues(array $check_values) {
		$this->check_value = implode(self::CHECK_SPLIT, array_map(function ($check_value) {
			return trim($check_value);
		}, $check_values));
	}


	/**
	 * @return string
	 */
	public function getCheckValue() {
		return $this->check_value;
	}


	/**
	 * @return string[]
	 */
	public function getCheckValues() {
		return array_map(function ($check_value) {
			return trim($check_value);
		}, explode(self::CHECK_SPLIT, $this->check_value));
	}


	/**
	 * @param int $udf_field_id
	 */
	public function setUdfFieldId($udf_field_id) {
		$this->udf_field_id = $udf_field_id;
	}


	/**
	 * @return int
	 */
	public function getUdfFieldId() {
		return $this->udf_field_id;
	}


	/**
	 * @param int $operator
	 */
	public function setOperator($operator) {
		$this->operator = $operator;
	}


	/**
	 * @return int
	 */
	public function getOperator() {
		return $this->operator;
	}


	/**
	 * @param int $create_date
	 */
	public function setCreateDate($create_date) {
		$this->create_date = $create_date;
	}


	/**
	 * @return int
	 */
	public function getCreateDate() {
		return $this->create_date;
	}


	/**
	 * @param int $id
	 */
	public function setId($id) {
		$this->id = $id;
	}


	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}


	/**
	 * @param int $owner
	 */
	public function setOwner($owner) {
		$this->owner = $owner;
	}


	/**
	 * @return int
	 */
	public function getOwner() {
		return $this->owner;
	}


	/**
	 * @param int $update_date
	 */
	public function setUpdateDate($update_date) {
		$this->update_date = $update_date;
	}


	/**
	 * @return int
	 */
	public function getUpdateDate() {
		return $this->update_date;
	}


	/**
	 * @param int $status
	 */
	public function setStatus($status) {
		$this->status = $status;
	}


	/**
	 * @return int
	 */
	public function getStatus() {
		return $this->status;
	}


	/**
	 * @param int $parent_id
	 */
	public function setParentId($parent_id) {
		$this->parent_id = $parent_id;
	}


	/**
	 * @return int
	 */
	public function getParentId() {
		return $this->parent_id;
	}


	/**
	 * @param $field_name
	 *
	 * @return mixed|null|string
	 */
	public function sleep($field_name) {
		switch ($field_name) {
			case 'create_date':
			case 'update_date':
				return date("Y-m-d H:i:s", $this->{$field_name});
				break;
		}

		return NULL;
	}


	/**
	 * @param $field_name
	 * @param $field_value
	 *
	 * @return mixed|null
	 */
	public function wakeUp($field_name, $field_value) {
		switch ($field_name) {
			case 'create_date':
			case 'update_date':
				return strtotime($field_value);
				break;
		}

		return NULL;
	}


	/**
	 * @param ilObjUser $ilUser
	 *
	 * @return bool
	 */
	public function isValid(ilObjUser $ilUser) {
		$ilUser->readUserDefinedFields();

		$values = array_map(function ($value) {
			return trim($value);
		}, explode(self::CHECK_SPLIT, $ilUser->user_defined_data['f_' . $this->getUdfFieldId()]));

		$check_values = $this->getCheckValues();

		foreach ($check_values as $key => $check_value) {
			$value = $values[$key];

			switch ($this->getOperator()) {
				case self::OP_EQUALS:
					$valid = ($value === $check_value);
					break;

				case self::OP_NOT_EQUALS:
					$valid = ($value !== $check_value);
					break;

				case self::OP_STARTS_WITH:
					$valid = (strpos($value, $check_value) === 0);
					break;

				case self::OP_NOT_STARTS_WITH:
					$valid = (strpos($value, $check_value) !== 0);
					break;

				case self::OP_ENDS_WITH:
					$valid = (strrpos($value, $check_value) === (strlen($value) - strlen($check_value)));
					break;

				case self::OP_NOT_ENDS_WITH:
					$valid = (strrpos($value, $check_value) !== (strlen($value) - strlen($check_value)));
					break;

				case self::OP_CONTAINS:
					$valid = (strpos($value, $check_value) !== false);
					break;

				case self::OP_NOT_CONTAINS:
					$valid = (strpos($value, $check_value) === false);
					break;

				case self::OP_IS_EMPTY:
					$valid = empty($value);
					break;

				case self::OP_NOT_IS_EMPTY:
					$valid = (!empty($value));
					break;

				case self::OP_REG_EX:
					$valid = (preg_match($check_value, $value) === 1);
					break;

				default:
					return false;
			}

			if (!$valid) {
				break;
			}
		}

		$b = (!$this->isNegated() === $valid);

		return $b;
	}


	/**
	 * @return array
	 */
	public static function getAllDefinitions() {
		static $return;
		if (is_array($return)) {
			return $return;
		}
		$return = array();
		/**
		 * @var $ilUserDefinedFields ilUserDefinedFields
		 */
		$ilUserDefinedFields = ilUserDefinedFields::_getInstance();
		foreach ($ilUserDefinedFields->getDefinitions() as $def) {
			/*
			 *
			 if ($def['visib_reg'] == 1) {
			 MST: Load all definitions!
			      it is also possible to make rules on fields without showing at registration
			*/
				$return [$def['field_type']] = $def;
			//}
		}

		return $return;
	}


	/**
	 * @param $id
	 *
	 * @return array
	 */
	public static function getDefinitionForId($id) {
		$definitions = self::getAllDefinitions();

		return $definitions[$id];
	}


	/**
	 * @return array
	 */
	public static function getDefinitionData() {
		$return = array();
		foreach (self::getAllDefinitions() as $def) {
			$return[$def['field_id']] = $def['field_name'];
		}

		return $return;
	}


	/**
	 * @param $udf_field_id
	 *
	 * @return array
	 */
	public static function getDefinitionValuesForId($udf_field_id) {
		$return = array();
		foreach (self::getAllDefinitions() as $def) {
			if ($def['field_id'] == $udf_field_id) {
				foreach ($def['field_values'] as $val) {
					$return[$val] = $val;
				}

				return $return;
			}
		}

		return array();
	}


	/**
	 * @param $udf_field_id
	 *
	 * @return int
	 */
	public static function getDefinitionTypeForId($udf_field_id) {
		foreach (self::getAllDefinitions() as $def) {
			if ($def['field_id'] == $udf_field_id) {
				return $def['field_type'];
			}
		}

		return 0;
	}


	/**
	 * @return boolean
	 */
	public function isNegated() {
		return $this->negated;
	}


	/**
	 * @param boolean $negated
	 */
	public function setNegated($negated) {
		$this->negated = $negated;
	}
}

