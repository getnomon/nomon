<meta charset="utf-8">

<?php

// connect
$m = new Mongo();

// select a database
$db = $m->tamber;

// select a collection (analogous to a relational database's table)
$collection = $db->artists;

/*
// add a record
$obj = array( "title" => "Calvin and Hobbes", "author" => "Bill Watterson" );
$collection->insert($obj);

// add another record, with a different "shape"
$obj = array( "title" => "XKCD", "online" => true );
$collection->insert($obj);
*/
// find everything in the collection

//db.users.find({last_name: 'Smith'}, {'ssn': 1}); NOT ACTUALLY PHP... DHuuuuu
$cursor = $collection->findOne(array("name" => "Kaskade"));
var_dump($cursor);



// iterate through the results
foreach ($cursor as $obj) {
    echo $obj["name"] . "<br>";
}

?>
