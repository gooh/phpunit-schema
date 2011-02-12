<?php
class SchemaTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var String
     */
    protected $_schemaPath;

    /**
     * @var DOMDocument
     */
    protected $_dom;

    public function setup()
    {
        $this->_dom = new DOMDocument;
        $this->_schemaPath = realpath(__DIR__ . '/../src/phpunit.xsd');
    }

    /**
     * @return Array
     */
    public function provideXmlFiles()
    {
        return array_chunk(glob(__DIR__.'/_files/*.xml'), 1);
    }

    /**
     * @dataProvider provideXmlFiles
     */
    public function testXmlFilesValidateAgainstSchema($xmlFile)
    {
        $this->_dom->load($xmlFile);
        $this->assertTrue($this->_dom->schemaValidate($this->_schemaPath));
    }
}