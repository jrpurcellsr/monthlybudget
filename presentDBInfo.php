
        <?php
        $q = intval($_GET ['q']);
        
        function monthdayyear($q)
        {
            global $this_datemonthyear;
            global $last_datemonthyear;
            global $lastlast_datemonthyear;
            global $next_datemonthyear;
            global $showmonth;
            global $selectmonth;
            global $selectmonthend;
            
            $this_month = date("m");
            $this_day = date("d");
            $this_year = date("Y");
            $this_monthyear = strtotime($this_month."/".$this_day."/".$this_year);
            $this_datemonthyear = date("M/Y", $this_monthyear);
        
            $last_month = date("m", strtotime("last month"));
            $last_monthyear = strtotime($last_month."/".$this_day."/".$this_year);
            $last_datemonthyear = date("M/Y", $last_monthyear);
            
            $lastlast_month = date('m', strtotime("-2 month"));
            $lastlast_monthyear = strtotime($lastlast_month."/".$this_day."/".$this_year);
            $lastlast_datemonthyear = date("M/Y", $lastlast_monthyear);
        
            $next_month = date("m", strtotime("next month"));
            $next_monthyear = strtotime($next_month."/".$this_day."/".$this_year);
            $next_datemonthyear = date("M/Y", $next_monthyear);
            
            if ($q === 1){
                $showmonth = $lastlast_datemonthyear;
                $smonth = date("m", strtotime("-2 month"));
            }
            if ($q === 2){
                $showmonth = $last_datemonthyear;
                $smonth = date("m", strtotime("-1 month"));
            }
            if ($q === 3){
                $showmonth = $this_datemonthyear;
                $smonth = date("m", strtotime("this month"));
            }
            if ($q === 4){
                $showmonth = $next_datemonthyear;
                $smonth = date("m", strtotime("next month"));
            }
            //echo "this is showmonth ".$showmonth."<br>";
            //echo "this is q ".$q."<br>";
            $selectmonth = $this_year."/".$smonth."/"."1";
            $selectmonthend = $this_year."/".$smonth."/"."31";
        }
        
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
        monthdayyear($q);

        //echo "this is the connect string=".$q;
        ?>
        <div class="column1">
			<div class="title">
				<h2>Monthly Detail</h2>
				<span class="byline"><? echo $showmonth; ?></span>
			</div>
                    <table class="w3-table-all">
                        <thead><th>Payee</th><th>Date</th><th>Amount</th></thead>
<?php
                            $detailquery = "SELECT * FROM mysqldatabase56833.tbl_detail WHERE detail_date >= '".$selectmonth."' and detail_date <= '".$selectmonthend."' order by detail_date";
                            $detailsql = mysqli_query($con, $detailquery);
                            If (mysqli_num_rows($detailsql) > 0)
                            {
                                while ($detailrow = mysqli_fetch_assoc($detailsql))
                                {
                                $detail_monthyear = strtotime($detailrow[detail_date]);
                                $format_detail_monthyear = date("m/d/Y", $detail_monthyear);
                                echo "<tr><td>".$detailrow[comment]."</td><td>".$format_detail_monthyear."</td><td align='right'>$".$detailrow[detail_amount]."</td></tr>";
                                }
                            }
                            $update_detail_url = "update_detail.php?month=".strtotime($selectmonth);
?>
                    </table>
                    <center>
                        <a href="<?php echo $update_detail_url; ?>" target="_self" class="button icon icon-refresh"> UPDATE</a>
                    </center>    
        </div>
		<div class="column2">
			<div class="title">
				<h2>Set Expenses</h2>
                                <span class="byline"><? echo $showmonth; ?></span>
			</div>
                    <table class="w3-table-all">
                        <thead><th>Paid</th><th>Due Date</th><th>Payee</th><th>Amount</th></thead>
<?php
        $billsquery = "SELECT * FROM mysqldatabase56833.tbl_bills where bills_monthyear >= '".$selectmonth."' and bills_monthyear <= '".$selectmonthend."' order by bills_duedate;";
        $billssql = mysqli_query($con, $billsquery);
        If (mysqli_num_rows($billssql) > 0)
        {
          while ($billsrow = mysqli_fetch_assoc($billssql))  
          {
          $monthyear = strtotime($billsrow["bills_monthyear"]);
          $formatmonthyear = date("m/d/Y", $monthyear);
          $formatduedate = strtotime($billsrow["bills_duedate"]);
          $duedatemonthyear = date("m/d/Y", $formatduedate);
          If ($billsrow["bills_paymentmade"]==1) 
          {$PaidYorN = "Y";
          $CellColor = "black";
          }
        Else
          {$PaidYorN = "N";
          $CellColor = "lightgray";
          }
              echo "<tr><td><font color='".$CellColor."'>".$PaidYorN."</font></td><td>".$duedatemonthyear."</td>"."<td>".$billsrow["bills_payee"]."</td>"."<td align='right'>$".$billsrow["bills_amount"]."</td>"."</tr>";
          }
        }
?>
                    </table>
                    <center><a href="#" class="button icon icon-refresh"> Update</a></center>
		</div>
		<div class="column3">
			<div class="title">
                            <h2>Income Sources</h2>
                            <span class="byline"><? echo $showmonth; ?></span>
                        </div>
                    
                    <table class="w3-table-all">
                        <thead><th>Source</th><th>Amount</th><th>Date</th><th>Section of Month</th></thead>
<?php       
        $income_query = "SELECT * FROM mysqldatabase56833.tbl_incomeinput where monthyear >= '".$selectmonth."' and monthyear <= '".$selectmonthend."' order by sectionofmonth;";
        $result = mysqli_query($con,$income_query);
        if (mysqli_num_rows($result) > 0) 
            {
            while($row = mysqli_fetch_assoc($result)) 
            {   
               echo "<tr><td>" . $row["source"]. "</td><td align='right'>$" . $row["amount"]. "</td><td> " . date('M/Y', strtotime($row["monthyear"])) . "</td><td align='right'>".$row["sectionofmonth"] ."</td>". "</tr>";
            }      
            } 
        $update_month_url = "update_month.php?month=".strtotime($selectmonth);
        
?>
                            </table>
                    <center><a href="<?php echo $update_month_url; ?>" target="_self" class="button icon icon-refresh"> Update</a></center>
		</div>
<div class="column4">
    <div class="title">
        <h2>Budgeted Expenses</h2>
        <span class="byline"><? echo $showmonth; ?></span>
    </div>
    <table class="w3-table-all">
        <thead><th>Comment</th><th>Amount</th><th>Section of Month</th><th>Remaining</th></thead>
<!--    php processing goes here-->
<?php
$budgetquery = "select tbl_budget_amount.bud_monthyear, tbl_budget_category.cat_description, tbl_budget_amount.bud_amount, tbl_budget_amount.bud_sectionofmonth
 from tbl_budget_amount left join tbl_budget_category on tbl_budget_amount.bud_category = tbl_budget_category.cat_lookup 
 where tbl_budget_amount.bud_monthyear >= '".$selectmonth."' and tbl_budget_amount.bud_monthyear <= '".$selectmonthend."' order by tbl_budget_amount.bud_sectionofmonth;";

        $result_budget = mysqli_query($con, $budgetquery);
        if (mysqli_num_rows($result_budget) > 0)
            {
            while ($budgetrow = mysqli_fetch_assoc($result_budget))
            {
                echo "<tr><td>".$budgetrow['cat_description']."</td><td>".$budgetrow['bud_amount']."</td><td>".$budgetrow['bud_sectionofmonth']."</td></tr>";
            }
        }

?>
    
    </table>
    <center><a href="#" target="_self" class="button icon icon-refresh">Update</a></center>
</div>
        <?php         
        mysqli_close($con);
        ?>