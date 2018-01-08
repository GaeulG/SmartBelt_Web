
<!DOCTYPE html>
<?php
$id = $_GET['username'];
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
$ddate = date("Y-m-d");
$duedt = explode("-", $ddate);
$date  = mktime(0, 0, 0, $duedt[1], $duedt[2], $duedt[0]);
//duedt[0] == current year
//duedt[1] == current month
//duedt[2] == current day
$week  = (int)date('W', $date);
//week == current week
function getStartAndEndDate($year, $week)
{
	return [	
		(new DateTime())->setISODate($year, $week)->format('Y-m-d'), //start date
		(new DateTime())->setISODate($year, $week, 7)->format('Y-m-d') //end date
	];
}
function toWeekNum($get_year, $get_month, $get_day){
	$timestamp = mktime(0, 0, 0, $get_month, $get_day, $get_year);
	$w = date('w',mktime(0,0,0,date('n',$timestamp),1,date('Y',$timestamp)));
	return ceil(($w + date('j',$timestamp) - 1)/7);
}

?>

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
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript">
		google.charts.load('current', {'packages':['corechart']});
		google.charts.setOnLoadCallback(drawVisualization);
	
		function drawVisualization() { 
			var data = google.visualization.arrayToDataTable([
					['자세', '올바르지 않은 걸음', '다리꼬기', '척추 휘어짐', '평균'],
					<?php
						for($i = -4; $i<=0; $i++){
							
							$week_array = getStartAndEndDate($duedt[0],$week+$i);
							$week_start = explode("-", $week_array[0]);
							$week_end = explode("-",$week_array[1]);
							//week_start == 주에서 시작하는 날짜 [0] == year [1] == month [2] == day
							//week_end == 주에서 끝나는 날짜
							echo "['".$duedt[0]."/".$week_start[1]."-".toWeekNum($week_start[0],$week_start[1],$week_start[2])."주' ";	
							$total_count = 0;
							for($j = 0;$j<3;$j++){
									
								$sql = "SELECT COUNT(*) FROM WalkState WHERE casenum = '".$j."' AND id='".$_GET['username']."' AND month='".$week_start[1]."' AND day>='".$week_start[2]."' AND day<='".$week_end[2]."'";
	
								$result = $conn->query($sql);
								$count = $result->fetch_assoc();
								echo ", ".$count['COUNT(*)'];
								$total_count = $total_count + $count['COUNT(*)'];
								
							}
							$total_count = $total_count / 3;
							echo ",".$total_count."],";
						}

					?>
									
				]);

			var options = {
					title : '주 별 올바르지 않은 자세 비율',
					vAxis: {title: '비율(%)'},
					hAxis: {title: '자세'}, 
					seriesType: 'bars',
					series: {3: {type: 'line'}}
				};
			
			var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
			chart.draw(data, options);
		}
	</script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

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
            <li><a href="main.php?username=<?php echo $id?>">환자 정보</a></li>
            <li><a href="main_symptoms.php?username=<?php echo $id?>">증상</a></li>
            <li class="active"><a href="main_statistics.php?username=<?php echo $id?>">통계</a></li>
            <li><a href="main_contactToPatient.php?username=<?php echo $id?>">환자에게 메시지 보내기</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="main_statistics.php?username=<?php echo $id?>">일 별</a></li>
            <li class="active"><a href="main_statistics_weekly.php?username=<?php echo $id?>">주 별</a></li>
            <li><a href="main_statistics_monthly.php?username=<?php echo $id?>">월 별</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>


    <div class="container">

      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1> Weekly 통계 </h1>
        <p>주 별 통계입니다. </p>
        <p>
			<div id="chart_div" style="width:900px; height: 500px;"></div>
        </p>
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
