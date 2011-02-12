<?php
class SchemaTestCase extends PHPUnit_Framework_TestCase
{
    protected $_utils;

	public function __construct ($name = NULL, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->_utils = new TestCaseUtility($this);
    }
}