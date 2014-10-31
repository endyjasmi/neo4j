#Neo4j for PHP [![Gitter chat](https://badges.gitter.im/endyjasmi/neo4j.png)](https://gitter.im/endyjasmi/neo4j)
[![Build Status](https://travis-ci.org/endyjasmi/neo4j.svg?branch=master)](https://travis-ci.org/endyjasmi/neo4j) [![Coverage Status](https://coveralls.io/repos/endyjasmi/neo4j/badge.png?branch=master)](https://coveralls.io/r/endyjasmi/neo4j?branch=master) [![Latest Stable Version](https://poser.pugx.org/endyjasmi/neo4j/v/stable.svg)](https://packagist.org/packages/endyjasmi/neo4j) [![Total Downloads](https://poser.pugx.org/endyjasmi/neo4j/downloads.svg)](https://packagist.org/packages/endyjasmi/neo4j) [![Latest Unstable Version](https://poser.pugx.org/endyjasmi/neo4j/v/unstable.svg)](https://packagist.org/packages/endyjasmi/neo4j) [![License](https://poser.pugx.org/endyjasmi/neo4j/license.svg)](https://packagist.org/packages/endyjasmi/neo4j)

This is a neo4j cypher only php driver. The aim of this library is to make sending cypher query as easy as sending sql to the server. This library DOES NOT implement every rest endpoint of the server. Ohh, it also support laravel framework natively!

###Why cypher only
Following the development roadmap for neo4j graph database, cypher are going to be playing a huge role in communicating with the database. Hence, cypher query will be the future for neo4j. Hence, this library is designed with that in mind.

For more information about cypher query language, you can [refer to the official cypher query language documentation](http://neo4j.com/docs/stable/cypher-query-lang.html).

Most application programming interface(API) of this library are inspired by laravel database adapter. Hence there are also a query builder and object graph mapper(OGM) on the way.

Head first neo4j library? [go to wiki](https://github.com/endyjasmi/neo4j/wiki).

##TL;DR
1. [Requirement](#requirement)
2. [Installation](#installation)
3. [Quickstart](#quickstart)
4. [Development](#development)
  1. [Testing](#testing)
  2. [Documentation](#documentation)
5. [Hall of fame](#hall-of-fame)
6. [Developer](#developer)
7. [License](#license)
8. [Feedback](#feedback)

##Requirement
1. PHP 5.4 and above
2. Neo4j 2.0 and above
3. PHP Curl extension gi(highly recommended but optional)

If you are going to generate documentation with phpdocumentor (yes, it is integrated into the library) make sure that your machine can run phpdocumentor. [Here is a list of requirement for phpdocumentor](http://phpdoc.org/docs/latest/getting-started/installing.html).

##Installation
This library can be installed through composer. Just add the following to your `composer.json` and run `composer install`.
```json
{
	"require": {
		"endyjasmi/neo4j": "2.*"
	}
}
```

##Quickstart
Here is the easiest way to get started.
```php
require 'vendor/autoload.php';

$neo4j = new \EndyJasmi\Neo4j;

$result = $neo4j->statement('match n return n');

var_dump($result[0]['n']);
```
The `statement` method above will return a result instance which contains an array of rows returned from the server.

`$result[0]['n']` dumped above means that you want to get the first row and column `n` of the result. Columns name are determined from the cypher query where in this case, the query `return n` means return n.

Of course, this is but a basic usage. For more advance feature, do [refer to the wiki](https://github.com/endyjasmi/neo4j/wiki).

##Development
###Testing
In order to test this library, you can `git clone https://github.com/endyjasmi/neo4j.git`. Right at the root, you must `composer install --dev`. After that you can start testing manually by typing `vendor/bin/phpunit`.

In case you want to do a continuous test driven development(TDD), you can `npm install` from the root directory(you'll need nodejs installed). Then you can run `grunt` from the root directory. Then go ahead and play with the source, every time you save, the code will be tested.

###Documentation
If you want to generate documentation, you can run `grunt serve` which will generate a documentation on source first save. This means you just open any source file and save once. The documentation will be generated. Any subsequent save will trigger the documentation generation, which means it will always be latest(maybe slight delay).

##Hall of fame
So much for the title, it really is just the section to list all the people which have contributed to the project one way or another. So if you want your name to be here, you can start contributing to the project in any number of ways like refactoring, documentation, spell check, heck you can even ask me to put your name here.

##Developer
* [Endy Jasmi](mailto:endyjasmi@gmail.com) (Me)

##License
This library is licensed under MIT as shown below. Exact same copy of the license can be found in `LICENSE` file.
```
The MIT License (MIT)

Copyright (c) 2014 Endy Jasmi

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```
This is my first open source library. Be kind to me >.<

##Feedback
Say hello to me or ask me any question at [endyjasmi@gmail.com](mailto:endyjasmi@gmail.com).