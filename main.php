<?php

require_once 'Classes/autoloader.php';
require_once 'config.php';

$db = new Database();

$link = $db->connect(DB_SERVER, DB_USERNAME,DB_PASSWORD, DB_NAME);



$user_arr = array();

$host_name = "sparky";
$ip = '192.168.1.6';
//echo gettype($digit);
$query = "INSERT INTO hosts (name, ip) VALUES ($host_name, $ip)";


$query_new = strip_query($query);
print_r($query_new);

$string1 = get_bind_variables($query_new);

//echo $string1 . PHP_EOL;

foreach($query_new['values'] as $val){
    //echo $query . PHP_EOL;
    if(stristr($query, $val)) {
        echo "Found it!" . PHP_EOL;
        str_replace($val, "?", $query);
        
    }
}

echo $query . PHP_EOL;


function get_bind_variables($array){
    $bind_parameters = '';
    
    // Get the values
    foreach($array['values'] as $val){
        //echo gettype($val) . PHP_EOL;
        if(is_numeric($val)){
            if(preg_match('@\.@', $val)){
                $val = (double)$val;
                $bind_parameters .= 'd'; 
            } else {
                $val = (int)$val;
                $bind_parameters .= 'i';
            }
        } elseif(is_string($val)) {
            $bind_parameters .= 's';
        } else {
            $bind_parameters .= 'b';
        }
    }
    return $bind_parameters;
}




/**
 * TODO: Check that the number of arguments are the same
 * for fields and values and if not throw an exception.
 */
function strip_query($query){

    preg_match_all('@\(.*\)@U', $query, $matches);
    $stripped_query = array();

    foreach($matches as $match){

        foreach($match as $params){
            $fields = explode(",", $match[0]);
            $values = explode(",", $match[1]);  
        }     

        foreach($fields as $fkey => $field){
            $stripped_query['fields'][] = trim(preg_replace("/\'|\"/","", preg_replace("/\(|\)/","", $field)));                   
        }

        foreach($values as $vkey => $value){
            $stripped_query['values'][] = trim(preg_replace("/\'|\"/","", preg_replace("/\(|\)/","", $value)));
        }         
    }
    return $stripped_query;
}


