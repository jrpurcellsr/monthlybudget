<!DOCTYPE html>

<html>
    <head>
        <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900|Varela+Round" rel="stylesheet" />
        <link href="default.css" rel="stylesheet" type="text/css" media="all" />
        <link href="fonts.css" rel="stylesheet" type="text/css" media="all" />
        <title>Monthly Budget</title>
        <script>
 function showMonth(str) {
    //var str = document.getElementById("date_select").value;
    if (str == "") {
        document.getElementById("page").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("page").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","presentDBInfo.php?q="+str,true);
        xmlhttp.send();
    }
}
</script>
    </head>
    <body>
        
    <div id="wrapper">
	<div id="header-wrapper">
		<div id="header" class="container">
			<div id="logo">
				<h1><a href="#">monthly budget</a></h1>
				<p>jim purcell</p>
			</div>
<!--                         <div id="social">
				<ul class="contact">
					<li><a href="#" class="icon icon-twitter"><span>Twitter</span></a></li>
					<li><a href="#" class="icon icon-facebook"><span></span></a></li>
					<li><a href="#" class="icon icon-dribbble"><span>Pinterest</span></a></li>
					<li><a href="#" class="icon icon-tumblr"><span>Google+</span></a></li>
					<li><a href="#" class="icon icon-rss"><span>Pinterest</span></a></li>
				</ul>
			</div>-->
		</div>
		<div id="menu" class="container">
                    
			<ul>
				<li class="current_page_item">
        <?php
    Function onscreenmonth()
    {
        global $this_datemonthyear;
        global $last_datemonthyear;
        global $lastlast_datemonthyear;
        global $next_datemonthyear;
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
    }
    onscreenmonth();
        ?>
                                    <a><select name="date_select" onchange="showMonth(this.value);">
                                            <option value="0">Select Month/Year</option>
                                            <option value="1"><?php echo $lastlast_datemonthyear; ?></option>
                                            <option value="2"><?php echo $last_datemonthyear; ?></option>
                                            <option value="3"><?php echo $this_datemonthyear; ?></option>
                                            <option value="4"><?php echo $next_datemonthyear; ?></option>
                                            </select></a></li>
				<li><a href="#" accesskey="1" title="">Services</a></li>
				<li><a href="#" accesskey="2" title="">Our Clients</a></li>
				<li><a href="#" accesskey="3" title="">About Us</a></li>
				<li><a href="#" accesskey="4" title="">Careers</a></li>
				<li><a href="#" accesskey="5" title="">Contact Us</a></li>
			</ul>

		</div>
	</div>
	<div id="page" class="container">
<!--		This is where the presentDBInfo will display-->
	</div>
	<div id="portfolio-wrapper">
		<div id="portfolio" class="container">
			<div class="title">
				<h2>Aenean elementum</h2>
				<span class="byline">Integer sit amet pede vel arcu aliquet pretium</span> </div>
			<div class="column1">
				<div class="box">
					<span class="icon icon-cloud-download"></span>
					<h3>Vestibulum venenatis</h3>
					<p>Fermentum nibh augue praesent a lacus at urna congue rutrum.</p>
					<a href="#" class="button">Etiam posuere</a> </div>
			</div>
			<div class="column2">
				<div class="box">
					<span class="icon icon-coffee"></span>
					<h3>Praesent scelerisque</h3>
					<p>Vivamus fermentum nibh in augue praesent urna congue rutrum.</p>
					<a href="#" class="button">Etiam posuere</a> </div>
			</div>
			<div class="column3">
				<div class="box">
					<span class="icon icon-globe"></span>
					<h3>Donec dictum metus</h3>
					<p>Vivamus fermentum nibh in augue praesent urna congue rutrum.</p>
					<a href="#" class="button">Etiam posuere</a> </div>
			</div>
			<div class="column4">
				<div class="box">
					<span class="icon icon-dashboard"></span>
					<h3>Mauris vulputate dolor</h3>
					<p>Rutrum fermentum nibh in augue praesent urna congue rutrum.</p>
					<a href="#" class="button">Etiam posuere</a> </div>
			</div>
		</div>
	</div>
</div>
<div id="footer">
	<p>&copy; Untitled. All rights reserved. Design by <a href="http://templated.co" rel="nofollow">TEMPLATED</a>. Photos by <a href="http://fotogrph.com/">Fotogrph</a>.</p>
</div>
        
    </body>
</html>
