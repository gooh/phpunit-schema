<?php
class TestCaseUtility
{
    /**
     * @var String
     */
    protected $_schemaPath = '/../src/phpunit.xsd';

    /**
     * @var DOMDocument
     */
    protected $_dom;

    /**
     * @var PHPUnit_Framework_TestCase
     */
    protected $_testCase;

    /**
     * @param  PHPUnit_Framework_TestCase	$testCase
     */
    public function __construct(PHPUnit_Framework_TestCase $testCase)
    {
        $this->_schemaPath = realpath(__DIR__ . $this->_schemaPath);
        $this->_dom = new DOMDocument('1.0', 'utf-8');
        $this->_testCase = $testCase;
    }

    /**
     * @return DOMDocument
     */
    public function getDom()
    {
        return $this->_dom;
    }

    /**
     * @param	String	$elementName
     * @param	DOMNode	$contextNode	Defaults to Root element
     * @return	TestCaseUtility
     */
    public function appendNewDomElement($elementName, DOMNode $contextNode = NULL)
    {
        $contextNode = $contextNode ?: $this->_dom->documentElement;
        $contextNode->appendChild(
            $this->_dom->createElement($elementName)
        );
        return $this;
    }

    /**
     * @param	String	$message	String fit for vsprintf
     * @param	Mixed	$args		Optional number of additional arguments
     * @return	TestCaseUtility
     */
    protected function setExpectedValidationError($message)
    {
        $arguments = func_get_args();
        array_shift($arguments);
        $this->_testCase->setExpectedException(
            'PHPUnit_Framework_Error',
            vsprintf($message, $arguments)
        );
        return $this;
    }

    /**
     * @param	String	$elementName
     * @return	TestCaseUtility
     */
    public function expectElementIsUnexpected($elementName)
    {
        $this->setExpectedValidationError(
            "Element '%s': This element is not expected.",
            $elementName
        );
        $this->validateDom();
        return $this;
    }

    /**
     * @param	String	$elementName
     * @param	Array	$children
     * @return	TestCaseUtility
     */
    public function expectElementToHaveChildren($elementName, $children)
    {
        $this->setExpectedValidationError(
        	"Element '%s': Missing child element(s). Expected is %s( %s ).",
            $elementName,
            count($children) > 1 ? 'one of ' : '',
            implode(', ', $children)
        );
        $this->validateDom();
        return $this;
    }

    /**
     * Validates the document in the current testcase
     * @return	Boolean
     */
    public function validateDom()
    {
        return $this->_dom->schemaValidate($this->_schemaPath);
    }
}
