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
        ->appendChild($dom->createElement('base'))
            ->setAttribute('href', 'http://gooh.github.com/phpunit-schema')
                ->parentNode
            ->parentNode
        ->parentNode
    ->appendChild($dom->createElement('body'))
        ->appendChild($dom->createElement('h1', 'Available PHPUnit Schema Files'))
            ->parentNode
        ->appendChild($dom->createElement('ul'));

foreach ($iterator as $file) {
    $file = str_replace(
        array(__DIR__, '\\'),
        array('', '/'),
        $file
    );
    $li = $ul->appendChild($dom->createElement('li'));
    $a = $dom->createElement('a', $file);
    $a->setAttribute('href', $file);
    $li->appendChild($a);
    unset($li, $a, $file);
}
$dom->formatOutput = true;
$dom->save('index.html');