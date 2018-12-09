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
        <title>update monthly detail</title>
    </head>
    <body>
        <div id="grid" class="container">
           <form name="form1" method="post" action="">
            <table class="w3-table-all">
            <thead><th>&nbsp;</th><th>Date</th><th>Comment</th><th>Amount</th><th>Category</th></thead>
            
<?php 
        
        $month = intval($_GET ['month']);
        
        $sql_month = date("m", $month);
        $sql_year = date("Y", $month);
        $sql_day = date("d", $month);
        $sql_date = $sql_year."/".$sql_month."/".$sql_day;
        $selectmonth = $sql_year."/".$sql_month."/"."1";
        $selectmonthend = $sql_year."/".$sql_month."/"."31";
        
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
        
        $detail_query = "SELECT * FROM mysqldatabase56833.tbl_detail left join mysqldatabase56833.tbl_budget_category "
                . "on mysqldatabase56833.tbl_detail.budget_category = mysqldatabase56833.tbl_budget_category.cat_lookup "
                . "where detail_date >= '".$selectmonth."' and detail_date <= '".$selectmonthend."' order by detail_date;";
        $result = mysqli_query($con,$detail_query);
        $count = mysqli_num_rows($result);
        if (mysqli_num_rows($result) > 0) 
            {
            while($row = mysqli_fetch_object($result)) 
            {   
               echo "<tr>
                <td><input type='hidden' name='id[ ]' value=".$row->detail_key." readonly></td>
                <td align='right'><input type='text' name='datetext[ ]' id='datefield' value='". date('m/d/Y', strtotime($row->detail_date))."'></td>
                <td align='right'><input type='text' name='comment[ ]' id='comment' value='".$row->comment."'></td>
                <td align='right'><input type='text' name='itemvalue[ ]' id='itemvalue' value='". $row->detail_amount."'></td>
                <td align='right'><input type='text' name='category [ ]' id='category_value='".$row->cat_description."'></td></tr>";
            }      
            }
            //submit button
            echo "<tr><td colspan='4' align='center'><input type='submit' name='Submit' value='Submit'></td></tr>";
            
        
// if form has been submitted, process it
if($_POST["Submit"])
{
    $counter = 0;
    
       // loop through all array items
$item_value = $_POST['itemvalue'];
$commenttext = $_POST['comment'];
$date_text = $_POST['datetext'];
$categorytext = $_POST['category'];

   foreach($_POST['id'] as $value)
       { 
       // minus value by 1 since arrays start at 0
               $item = $value-1;
     
               $datedate = strtotime($date_text[$counter]);
               //echo $datedate;
               $datesqldate = date('Y-m-d', $datedate);
               //echo $datesqldate;
               //exit();
               
               //update table
               If ($categorytext[$counter] == NULL){
                    $categoryskip = 'skip';
                }
        If ($categoryskip == 'skip') {
            $querys = "UPDATE mysqldatabase56833.tbl_detail set comment='".$commenttext[$counter]."', detail_amount=".$item_value[$counter].", detail_date=".$datesqldate." WHERE detail_key = ".$value.";";
        } else {
        $querys = "UPDATE mysqldatabase56833.tbl_detail set comment='".$commenttext[$counter]."', detail_amount=".$item_value[$counter].", detail_date=".$datesqldate.", budget_category=".$categorytext[$counter]." WHERE detail_key = ".$value.";";
        }
      echo $querys;
       $sql1 = mysqli_query($con, $querys) or die(mysqli_error($con));
   
        $counter = $counter + 1;
       }

// redirect user
$_SESSION['success'] = 'Updated';
header('location:index.php');  
ob_end_flush();
}
// echo "month = ".$selectmonth;
// echo "end = ".$selectmonthend;
?>
            </table>
           </form>
        </div>
    </body>
</html>