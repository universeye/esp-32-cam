 
<?php
$port = 3306;
$host = 'localhost';
$user = 'application';
$passwd = '97xYGZhBqreSx7NVzn';
$database = 'production_database';
$datatable = "shrimp_photos";
$results_per_page = 30;
$connect = new mysqli($host, $user, $passwd, $database, $port);
$data=mysqli_query($connect,"SELECT * FROM `shrimp_photos` ORDER BY id DESC");

$data_decode = sprintf("SELECT FROM_BASE64('imageFile') FROM `shrimp_photos`");
$data_tesr = mysqli_query($connect,"SELECT imageFile FROM `shrimp_photos`");
//class="img-thumnail"
//=========check connection==============
/*
if ($connect -> connect_error){
	die ("Connection failed:". $connect -> connect_error);
}
else {
	echo "Sucess";
}
*/
if (isset($_GET["page"])) { 
	$page  = $_GET["page"]; 
} 
else { 
		$page=1; 
};
$start_from = ($page-1) * $results_per_page;
$sql = "SELECT * FROM ".$datatable." ORDER BY id DESC LIMIT $start_from, ".$results_per_page;
$rs_result = $connect->query($sql);

//============testing code==========================
$image_result = array();
$image_decoded = $connect -> query ($data_decode); //execute query
foreach ($image_decoded as $image_final) {
	$image_result[] = $image_final;
}
?>

<!DOCTYPE html>
<html>
<head>	
	<title> PHOTOS</title>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.js"></script>
</head>

<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}

.topnav {
  overflow: hidden;
  background-color: #333;
}

.topnav a {
  float: left;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

.topnav a:hover {
  background-color: #ddd;
  color: black;
}

.topnav a.active {
  background-color: #4CAF50;
  color: white;
}

.page_indicator {

	}

.page_indicator a{
	color: black;
	padding: 15px 16px;
	
	}

.y_r {
	color: black;
}

</style>


<body style="background-color:#ddd">
<!-- Top Navigation function-->
<div class="topnav">
  <a class="active" href="#data" onclick="pig_photos()">圖片</a>
</div>

<!-- Top Navigation Redirect-->
<script type="text/javascript">
	function pig_photos() {
		window.location.href="http://172.104.109.23/2020_A0004/view_image.php"
	}
	function pig_data() {
		window.location.href="http://192.168.64.2/shrimp_data_demo.php"
	}
</script>

	<p>
		<h2 align="center">Photos Taken </h2>
		<!-- table style-->
 	<style>
 		table {
  			border: 1px solid black;
		}
 		th {
 			background-color: #4CAF50;
 			color: white;
 		}
 	
 		th, td {
  			padding: 15px;
  			text-align: center;
		}
		tr:nth-child(odd):hover {
			background-color: #d5d5d5;
		}
		tr:nth-child(even){background-color: #f2f2f2}
		tr:nth-child(even):hover{
				background-color: #d5d5d5;
			};
 	</style>
	</p>
	<table align="center">
		<tr>
			<th>Photo_ID</th>
			<th>Photos</th>
			<th>Date</th>
		
		</tr>
<?php

	for ($i=1;$i<=mysqli_num_rows($data);$i++){
	$rs2=mysqli_fetch_row($data);
	$rs3=mysqli_fetch_row($image_decoded);


?>
		<tr>
			<td><?php echo $rs2[0]?></td>
			<td><?php echo '<img src=data:image/jpeg;base64,'.base64_encode(decode_image($rs2[1])).' height:auto width=auto/>'?>	
			</td>
			<td><?php echo $rs2[2]?></td>
		</tr>
<?php
}

function decode_image($arg){

	$arg1 = explode(',', $arg);

	$arg2 = base64_decode($arg1[1]);

	$arg3 = imageCreateFromString($arg2);

	
	return $arg2;


}
//'<img src=data:image/jpeg;base64,'.decode_image($rs2[1]).' height:auto width=auto/>'
//echo ($image_result[]);
//'<img src=image/'.$rs2[1].' height:auto width=auto/>'
//'<img src=data:image/jpeg;base64,'.base64_encode($rs2[1]).' height:auto width=auto/>'
?>
	</table>

<!-------------- Split data into Pages ----------->
<div align="center" class="page_indicator">
<?php 
$sql = "SELECT COUNT(id) AS total FROM ".$datatable;
$result = $connect->query($sql);
$row = $result->fetch_assoc();
$total_pages = ceil($row["total"] / $results_per_page); // calculate total pages with results
  
for ($i=1; $i<=$total_pages; $i++) {  // print links for all pages
            echo "<a href='view_image.php?page=".$i."'";
            if ($i==$page)  echo " class='curPage'";
            echo ">".$i."</a> "; 
}; 
?>
</div>
</body>
</html>

