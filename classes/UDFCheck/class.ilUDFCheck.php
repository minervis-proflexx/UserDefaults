<?php
require_once('./Customizing/global/plugins/Libraries/ActiveRecord/class.ActiveRecord.php');
require_once('./Services/User/classes/class.ilUserDefinedFields.php');

/**
 * Class ilUDFCheck
 *
 * @author  Fabian Schmid <fs@studer-raimann.ch>
 * @version 1.0.0
 */
class ilUDFCheck extends ActiveRecord {

	const TABLE_NAME = 'usr_def_checks';
	const OP_EQUALS = 1;
	const STATUS_INACTIVE = 1;
	const STATUS_ACTIVE = 2;
	const TYPE_TEXT = 1;
	const TYPE_SELECT = 2;
	const TYPE_WYSIWYG = 3;
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
		global $ilUser;
		$this->setOwner($ilUser->getId());
		$this->setUpdateDate(time());
		parent::update();
	}


	public function create() {
		global $ilUser;
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
	 * @return string
	 */
	public function getCheckValue() {
		return $this->check_value;
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
				return date(DATE_ISO8601, $this->{$field_name});
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
		$value = $ilUser->user_defined_data['f_' . $this->getUdfFieldId()];

		switch ($this->getOperator()) {
			case self::OP_EQUALS:
				return $value == $this->getCheckValue();
		}
	}


	/**
	 * @return array
	 */
	public static function getAllDefinitions() {
		$return = array();
		/**
		 * @var $ilUserDefinedFields ilUserDefinedFields
		 */
		$ilUserDefinedFields = ilUserDefinedFields::_getInstance();
		foreach ($ilUserDefinedFields->getDefinitions() as $def) {
			if ($def['visib_reg'] == 1) {
				$return [] = $def;
			}
		}

		return $return;
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
	 * @return array
	 */
	public static function getDefinitionTypeForId($udf_field_id) {
		foreach (self::getAllDefinitions() as $def) {
			if ($def['field_id'] == $udf_field_id) {
				return $def['field_type'];
			}
		}

		return 0;
	}
}

?>
