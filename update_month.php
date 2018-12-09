<?php 
ob_start();
session_start();
?>
<!DOCTYPE html>
<!--
This program is licensed only to Jim Purcell
jrpurcellsr@gmail.com
duplication and copying is not permitted
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900|Varela+Round" rel="stylesheet" />
        <link href="default.css" rel="stylesheet" type="text/css" media="all" />
        <link href="fonts.css" rel="stylesheet" type="text/css" media="all" />
        <title>update monthly income</title>
    </head>
    <body>
        <div id="grid" class="container">
           <form name="form1" method="post" action="">
            <table class="w3-table-all">
            <thead><th>&nbsp;</th><th>Source</th><th>Amount</th><th>Date</th><th>Section of Month</th></thead>
            
<?php 
        
        $month = intval($_GET ['month']);
        
        $sql_month = date("m", $month);
        $sql_year = date("Y", $month);
        $sql_day = date("d", $month);
        $sql_date = $sql_year."/".$sql_month."/".$sql_day;
        
        function dbconnect()
            {
            global $con;
                //connection strings
                $host="192.168.1.27";
                $port=3306;
                $socket="/tmp/mysql.sock";
                $user="jrpurcellsr";
                $password="durang02";
                $dbname="mysqldatabase56833";

                $con = mysqli_connect($host, $user, $password, $dbname, $port, $socket);

                        if (mysqli_connect_errno())
                            {
                                echo "Failed to connect to MySQL: " . mysqli_connect_error();
                                die();
                            }
                        mysqli_query($con, 'SET NAMES \'utf8\';');
            }

            
        dbconnect();
        
        $income_query = "SELECT * FROM mysqldatabase56833.tbl_incomeinput where monthyear >= '".$sql_date."' and monthyear <= '".$sql_date."' order by sectionofmonth;";
        $result = mysqli_query($con,$income_query);
        $count = mysqli_num_rows($result);
        if (mysqli_num_rows($result) > 0) 
            {
            while($row = mysqli_fetch_object($result)) 
            {   
               echo "<tr>
                <td><input type='hidden' name='id[ ]' value=".$row->entryid." readonly></td>
                <td><input type='text' name='source[ ]' id='sourcefield' value='".$row->source."'></td>
                <td align='right'><input type='text' name='amount[ ]' id='inputamount' value='".$row->amount."'></td>
                <td>". date('M/Y', strtotime($row->monthyear))."</td>
                <td align='right'>".$row->sectionofmonth."</td></tr>";
            }      
            }
            //submit button
            echo "<tr><td colspan='4' align='center'><input type='submit' name='Submit' value='Submit'></td></tr>";
            
        
// if form has been submitted, process it
if($_POST["Submit"])
{
    $counter = 0;
    
       // loop through all array items
$itemvalue = $_POST['amount'];
$sourcetext = $_POST['source'];

   foreach($_POST['id'] as $value)
       { 
       // minus value by 1 since arrays start at 0
               $item = $value-1;
               //update table
        $querys = "UPDATE tbl_incomeinput set source='".$sourcetext[$counter]."', amount=".$itemvalue[$counter]." WHERE entryid = ".$value.";";
      
       $sql1 = mysqli_query($con, $querys) or die(mysql_error());
   
        $counter = $counter + 1;
       }

// redirect user
$_SESSION['success'] = 'Updated';
header('location:index.php');  
ob_end_flush();
}
?>
            </table>
           </form>
        </div>
    </body>
</html>