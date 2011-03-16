<?php
/*
 * This script can be used to generate a single phpunit.xsd from
 * the separate XSD files in the source folder. The script will
 * create a new file phpunit.xsd.[timestamp] in the tools folder.
 */
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
if ($dom->schemaValidate('http://www.w3.org/2001/XMLSchema.xsd')) {
    $dom->formatOutput = TRUE;
    $filename = __DIR__ . '/phpunit.xsd.' . time();
    $dom->save($filename);
    printf('Created new validated Schema file at %s%s', $filename, PHP_EOL);
} else {
    trigger_error('Created Schema does not validate', E_USER_ERROR);
}
