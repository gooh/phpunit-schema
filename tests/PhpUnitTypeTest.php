<?php
class PhpUnitTypeTest extends SchemaTestCase
{
    /**
     * Creates XML DOM with phpunit root element
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    public function setUp()
    {
        $this->_utils->appendNewDomElement('phpunit', $this->_utils->getDom());
    }

    /**
     * @return Array elementName, children
     */
    public function provideGroupNamesAndExpectedChildren()
    {
        return array(
            array('testsuites', array('testsuite')),
            array('groups', array('include', 'exclude')),
            array('filter', array('blacklist', 'whitelist')),
            array('logging', array('log')),
            array('listeners', array('listener')),
            array('selenium', array('browser'))
        );
    }

    public function testTypeAllowsConfigGroupElementsOnly()
    {
        $elementName = uniqid('x');
        $this->_utils
            ->appendNewDomElement($elementName)
            ->expectElementIsUnexpected($elementName);
    }

    /**
     * @dataProvider provideGroupNamesAndExpectedChildren
     */
    public function testConfigGroupElementsCannotAppearWithoutChildren($elementName, $children)
    {
        $this->_utils
            ->appendNewDomElement($elementName)
            ->expectElementToHaveChildren($elementName, $children);
    }

}