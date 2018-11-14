<?php
$conn_string = "host=ec2-23-21-192-179.compute-1.amazonaws.com port=5432 dbname=d2ffj87ve9jfbj user=auxvxlzecfeirx password=3246846dc64d449a9d9a6798839878869d7d72677127cd94ef10f4809d3d7fdd";
$dbconn = pg_connect($conn_string);
if($dbconn){
    echo 'success';
    }
else{
    echo $dbconn;
}
?>