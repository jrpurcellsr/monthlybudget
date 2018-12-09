<?php 
/* 
 * This program is licensed only to Jim Purcell
 * jrpurcellsr@gmail.com
 * duplication and copying is not permitted
 */

function azureconnect()
{
//connection strings
$host="phptestappjrp-mysqldbserver.mysql.database.azure.com";
$port=3306;
$socket="";
$user="mysqldbuser@phptestappjrp-mysqldbserver";
$password="C@r@v@n53";
$dbname="mysqldatabase56833";

$con = mysqli_connect($host, $user, $password, $dbname, $port, $socket);

        if (mysqli_connect_errno())
            {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
                die();
            }
        mysqli_query($con, 'SET NAMES \'utf8\';');
}
?>