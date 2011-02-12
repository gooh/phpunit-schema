<?php
set_include_path(
    sprintf(
    	'%s;%s',
        realpath(__DIR__ . '/..'),
        get_include_path()
    )
);
include_once 'tests/TestCaseUtility.php';
include_once 'tests/SchemaTestCase.php';