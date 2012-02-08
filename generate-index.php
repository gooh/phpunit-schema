<?php
$iterator = new RegexIterator(
    new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator(__DIR__)
    ),
    '(^(?!             # Match when string
        .*\.git        # excludes .git folder
        |.*\.project   # excludes .project folder
        |.*generate    # excludes this file
        |.*index       # excludes generated index file
    ).*$               # up the end
    )x'
);

$imp = new DOMImplementation;
$dtd = $imp->createDocumentType(
    'html',
    '-//W3C//DTD XHTML 1.0 Transitional//EN',
    'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'
);
$dom = $imp->createDocument(NULL, "html", $dtd);
$dom->encoding = 'UTF-8';

$ul = $dom->documentElement
    ->appendChild($dom->createElement('head'))
        ->appendChild($dom->createElement('title', 'PHPUnit Schema Files'))
            ->parentNode
        ->parentNode
    ->appendChild($dom->createElement('body'))
        ->appendChild($dom->createElement('h1', 'Available PHPUnit Schema Files'))
            ->parentNode
        ->appendChild($dom->createElement('ul'));

foreach ($iterator as $file) {
    $file = ltrim(
        str_replace(
            array(__DIR__, '\\'),
            array('', '/'),
            $file
        ), '/'
    );
    $ul->appendChild($dom->createElement('li'))
        ->appendChild($dom->createElement('a', $file))
            ->setAttribute('href', $file);
}
$dom->formatOutput = true;
$dom->save('index.html');