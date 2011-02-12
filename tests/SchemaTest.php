<?php
class SchemaTest extends SchemaTestCase
{
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
        $this->_utils->getDom()->load($xmlFile);
        $this->assertTrue($this->_utils->validateDom());
    }
}