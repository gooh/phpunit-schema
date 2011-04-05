# PHPUnit Schema

The PHPUnit Schema file defines the rules by which a configuration file for
PHPUnit may be structured. Schema aware XML Editors can provide content assist 
to authors. Using the Schema file is optional.  

## Validating your configuration file

The Schema file does not define a target namespace, so you should not need 
to modify your phpunit.xml if you just want to validate it. Just use a tool 
like `xmllint` to read in your configuration and validate it against the 
Schema, e.g.

     xmllint --schema phpunit.xsd phpunit.xml 

If you want to validate from a PHP file, you can use the DOM extension, e.g.

    $dom = new DOMDocument;
    $dom->load('/path/to/your/phpunit.xml');
    if ($dom->schemaValidate('/path/to/phpunit.xsd')) {
        echo 'The document is valid';
    }
    
## Applying the Schema for Authoring

If you are using a Schema aware XML editor, you might want to apply the Schema 
file to your configuration file to get Content Assist and automatic validation 
when authoring the document.

To apply the Schema to a configuration file, you have to declare the Schema 
Namespace and the location of the Schema file in the phpunit.xml file. Since 
PHPUnit does not use a dedicated namespace for the configuration file, the 
following two lines are all that is required:

    <?xml version="1.0" encoding="UTF-8"?>
    <phpunit 
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:noNamespaceSchemaLocation="location of xsd file"
        …

## Getting a Single Schema file

The Schema file is currently split into multiple smaller files. This eases 
maintaining the Schema file during development. However, when working with 
PHPUnit, it might be undesired to have the entire folder structure in your 
project. For this reason, you can create a single phpunit.xsd with the PHP 
script given in the tools folder:

    $ php generate-schema.php
    Created new validated Schema file at:
     F:\Work\code\PHPUnit-Schema\tools\phpunit.xsd.1301999633 

## Additional Resources

The documentation of configuration files can be found in the official PHPUnit 
Manual 

- [http://www.phpunit.de/manual/current/en/appendixes.configuration.html][1]

The class processing the configuration file is

- [https://github.com/sebastianbergmann/phpunit/raw/master/PHPUnit/Util/Configuration.php][2]

[1]: http://www.phpunit.de/manual/current/en/appendixes.configuration.html
[2]: https://github.com/sebastianbergmann/phpunit/raw/master/PHPUnit/Util/Configuration.php
