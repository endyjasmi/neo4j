#Neo4j Cypher [![Build Status](https://travis-ci.org/endyjasmi/neo4j.svg?branch=master)](https://travis-ci.org/endyjasmi/neo4j)

Cypher is a PHP adapter for Neo4j ReST API cypher endpoint. Cypher aims to take the pain out of sending cypher query to Neo4j server. I believe that cypher will be a major part of Neo4j in near future. In short, this library focus solely on sending query to Neo4j database. For those looking for adapter on all of Neo4j ReST API can try this [great library](https://github.com/jadell/neo4jphp).

For those that dont know, Neo4j is a graph database. More information about Neo4j can be found [here](http://neo4j.com/) and information for cypher can be found [here](http://neo4j.com/docs/2.1.3/cypher-query-lang/). It is licensed under MIT so you can do whatever you want with it.

##Requirment
1. PHP 5.3 and above
2. Neo4j 2.0 and above

##Installation
This library is available through [composer](https://packagist.org/packages/endyjasmi/neo4j). If you dont know how to use composer, a tutorial can be found [here](http://code.tutsplus.com/tutorials/easy-package-management-with-composer--net-25530).

##Quickstart
###Basic
```
$neo4j = new \EndyJasmi\Neo4j;

$response = $neo4j->statement('create (n:Person {name: ?}) return n', array('Endy Jasmi'))
	->execute();

echo $response[0][0]['n']['name']; // Endy Jasmi
```

###Multiple statement in single request
```
$neo4j = new \EndyJasmi\Neo4j;
$query = 'create (n:Person {name: {name}}) return n.name';

$response = $neo4j->statement($query, array('name' => 'Jeffrey Jasmi')) // Notice how I use named parameter
	->statement($query, array('name' => 'Endy Jasmi'))
	->execute();

echo $response[0][0]['n.name']; // Jeffrey Jasmi
echo $response[1][0]['n.name']; // Endy Jasmi
```

###Transaction
```
$neo4j = new \EndyJasmi\Neo4j;
$query = 'create (n:Person {name: {name}}) return n.name';

$neo4j->beginTransaction();

$neo4j->statement($query, array('name' => 'Jeffrey Jasmi'))
	->execute();

$neo4j->statement($query, array('name' => 'Endy Jasmi'))
	->execute();

$neo4j->commit();
// or
$neo4j->rollback();
```

###Error handling
In the event that the server return error status codes, the library will convert it to inherited exception. For example when the server return `Neo.ClientError.Statement.InvalidSyntax` status code.
```
$neo4j = new \EndyJasmi\Neo4j;

try {
	$neo4j->statement('invalid syntax')
		->execute();
}

catch(\EndyJasmi\Neo4j\StatusCodes\Neo $error) {
	echo $error->getMessage();
}
// or
catch(\EndyJasmi\Neo4j\StatusCodes\Neo\ClientError $error) {
	echo $error->getMessage();
}
// or
catch(\EndyJasmi\Neo4j\StatusCodes\Neo\ClientError\Statement $error) {
	echo $error->getMessage();
}
// or
catch(\EndyJasmi\Neo4j\StatusCodes\Neo\ClientError\Statement\InvalidSyntax $error) {
	echo $error->getMessage();
}

```
This enable you to have better way of handling error. Either you want it to be specific or general.

###Tip #1
Here is how you can configure the library. The library by default support multiple profile.
```
$config = array(
	'default' => array(
		'host' => 'http://localhost:7474',
		'driver' => \EndyJasmi\Neo4j\Connection::CURL
	),
	'write' = array(
		'host' => 'https://localhost:7473',
		'driver' => \EndyJasmi\Neo4j\Connection::STREAM
	)
);

$neo4j = new \EndyJasmi\Neo4j($config);

$neo4j->connection('default')
	->statement('match (n) return n')
	->execute();
// is the same with
$neo4j->statement('match (n) return n')
	->execute();

// Selecting other profile
$neo4j->connection('write')
	->statement('create (n) return n')
	->execute();
```

###Tip #2
In case your query dont need to use parameter, you can omit it
```
$neo4j->statement('match (n) return n')
	->execute();
```

###Tip #3
You can embed statement to all the execution method.
```
$neo4j->statement('match (n) return n')
	->beginTransaction();
// or
$neo4j->statement('match (n) return n')
	->commit();
```

##Feedback
If you have any feature request, bug report, proposal, comment, or anything related to this library. Do not hesitate to [open a new issues](https://github.com/endyjasmi/neo4j/issues/new) or [email me](mailto:endyjasmi@gmail.com).