
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>너의 자세는</title>

    <!-- Bootstrap core CSS -->
    <link href="../dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../ccs/navbar-static-top.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

<?php
$servername = "localhost";
$username = "root";
$password = "111111";
$dbname = "db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
	echo "error";
}

$sql = "SELECT * FROM UserInfo WHERE id='".$_GET['username']."'";
$result = $conn->query($sql);
$user_num = "";
$id = "";
$password = "";
$name = "";
if ($result->num_rows > 0) {
    // output data of each row
	
    while($row = $result->fetch_assoc()) {
        $user_num = $row['USERNUM'];
	$id = $row['id'];
	$password = $row['password'];
	$name = $row['name'];
    }
} else {
    
}
$sql = "SELECT * FROM detailinfo WHERE id='".$_GET['username']."'";
$result = $conn->query($sql);
$height = "";
$weight = "";
$blood = "";
$phonenum = "";
if ($result->num_rows > 0) {
    // output data of each row
	
    while($row = $result->fetch_assoc()) {
        $height = $row['height'];
	$weight = $row['weight'];
	$blood = $row['blood'];
	$phonenum = $row['phonenum'];
    }
} else {
    
}
$conn->close();
?>
    <!-- Static navbar -->
    <nav class="navbar navbar-default navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="login.php">너의 자세는</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="main.php?username=<?php echo $id?>">환자 정보</a></li>
            <li><a href="main_symptoms.php?username=<?php echo $id?>">증상</a></li>
            <li><a href="main_statistics.php?username=<?php echo $id?>">통계</a></li>
            <li><a href="main_contactToPatient.php?username=<?php echo $id?>">환자에게 메시지 보내기</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>


    <div class="container">

      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1> 환자 정보 </h1>
		
        <div>
			<div style="float: left; width: 20%; padding:10px;">
				<img src="image/user.png" width='150' height='150'>
			</div>
			<div>
			  <table class="table">
				<thead>
				  <tr>
					<th>분류</th>
					<th>내용</th>
					<th>비고</th>
				  </tr>
				</thead>
				<tbody>
				  <tr>
					<td>이름</td>
					<td><?php echo $name ?></td>
					<td></td>
				  </tr>
				  <tr>
					<td>환자번호</td>
					<td><?php echo $user_num ?></td>
					<td></td>
				  </tr>
				  <tr>
					<td>신장(cm)</td>
					<td><?php echo $height ?></td>
					<td></td>
				  </tr>
				  <tr>
					<td>몸무게(kg)</td>
					<td><?php echo $weight ?></td>
					<td></td>
				  </tr>
				  <tr>
					<td>혈액형</td>
					<td><?php echo $blood ?></td>
					<td></td>
				  </tr>
				  <tr>
					<td>전화번호</td>
					<td><?php echo $phonenum ?></td>
					<td></td>
				  </tr>
				</tbody>
			  </table>
			</div>
       </div>
      </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
