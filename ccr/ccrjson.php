<?php
set_include_path(get_include_path() . PATH_SEPARATOR . 'lib/');
include_once("aur.inc");

//include_once 'lib/aur.inc';

$handle = db_connect();

//Packages, Users


$query = "SELECT * FROM Users";

$result = db_query($query, $handle);

if ( $result && (mysql_num_rows($result) > 0) ) {
    $search_data = array();
    while ( $row = mysql_fetch_assoc($result) ) {
        array_push($search_data, $row);
    }

    mysql_free_result($result);
    
    echo json_encode($search_data);
}
else {
    return $this->json_error('No results found');
}


db_disconnect($handle);

?>
