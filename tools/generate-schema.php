<?php
$opts = array(
    'http' => array(
        'user_agent' => 'https://github.com/gooh/phpunit-schema',
        'timeout'    => 60
    )
);
$context = stream_context_create($opts);
libxml_set_streams_context($context);

$dom = new DOMDocument;
$dom->preserveWhiteSpace = FALSE;
$dom->load('../src/phpunit.xsd');
foreach (glob('../src/phpunit/*.xsd') as $typeXMLFile) {
    $typeXmlDom = new DOMDocument;
    $typeXmlDom->preserveWhiteSpace = FALSE;
    $typeXmlDom->load($typeXMLFile);
    foreach ($typeXmlDom->documentElement->childNodes as $element) {
        if ('xs:include' !== $element->nodeName) {
            $dom->documentElement->appendChild(
                $dom->importNode($element, TRUE)
            );
        }
    }
}
$remainingInclude = $dom->getElementsByTagNameNS(
	'http://www.w3.org/2001/XMLSchema',
	'include'
);
$remainingInclude->item(0)->parentNode->removeChild($remainingInclude->item(0));

if ($dom->schemaValidate('http://www.w3.org/2001/XMLSchema.xsd')) {
    $dom->formatOutput = TRUE;
    $filename = dirname(__FILE__) . '/phpunit.xsd.' . time();
    $dom->save($filename);
    printf(
    	"Created new validated Schema file at:\n %s\n",
        realpath($filename)
    );
} else {
    trigger_error('Created Schema does not validate', E_USER_ERROR);
}
