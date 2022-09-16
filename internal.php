<?php
session_start();
require_once("inc/config.inc.php");
require_once("inc/functions.inc.php");

//Überprüfe, dass der User eingeloggt ist
//Der Aufruf von check_user() muss in alle internen Seiten eingebaut sein
$user = check_user();

include("templates/header.inc.php");
?>

<div class="container main-container">

<h1>Herzlich Willkommen!</h1>

Hallo <?php echo htmlentities($user['vorname']); ?>,<br>
Herzlich Willkommen im internen Bereich!<br><br>
<h2>Liste der Aktiven Benutzer</h2>
<div class="panel panel-default">
 
<table class="table">
<tr>
	<th>Vorname</th>
	<th>Nachname</th>
	<th>E-Mail</th>
</tr>
<?php 
$statement = $pdo->prepare("SELECT * FROM users ORDER BY id");
$result = $statement->execute();
$count = 1;
while($row = $statement->fetch()) {
	echo "<tr>";
	echo "<td>".$row['vorname']."</td>";
	echo "<td>".$row['nachname']."</td>";
	echo '<td><a href="mailto:'.$row['email'].'">'.$row['email'].'</a></td>';
	echo "</tr>";
}
include("templates/footer.inc.php")
?>

<?php
$data = json_decode(file_get_contents('geraete.json'), true);
?>

</table>
</div>


</div>

<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8" />
		<title>How to Create Dynamic Chart in PHP using Chart.js</title>
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		<script	src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>
	</head>
	<body>
		<div class="container">
			<div class="card">
				<div style="border: 1px solid #dddddd; border-radius: 4px; padding:10px 5px 15px 20px;" class="card-body">
					<div class="form-group">
						<h2 class="mb-4">Welches Gerät wurde benutzt ?</h2>
							<div class="form-check">
								<select id="comboA" class="form-check-input" name="programming_geraete_name" class="programming_geraete_name" onchange="getComboA(this)">
									<?php
										foreach($data as $name) 
											echo "<option value='strtolower($name)'>$name[geraete_name] </option>" ;	
									?>
									<option value="">Select combo</option>
									<option value="Value1">Text1</option>
									<option value="Value2">Text2</option>
									<option value="Value3">Text3</option>	
								</select>
								<label class="form-check" for="programming_geraete_name"></label>
							</div>





						<!-- <div class="form-check">
							<input class="form-check-input" type="radio" name="programming_geraete_name" class="programming_geraete_name" id="programming_geraete_name_1" value="Therapie-Liege" checked>
							<label class="form-check" for="programming_geraete_name_1">Therapie-Liege</label>
						</div>
						<div class="form-check">
							<input type="radio" name="programming_geraete_name" id="programming_geraete_name_2" class="form-check-input" value="Medizinball">
							<label class="form-check" for="programming_geraete_name_2">Medizinball</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="radio" name="programming_geraete_name" class="programming_geraete_name" id="programming_geraete_name_3" value="Sprossenwand">
							<label class="form-check" for="programming_geraete_name_3">Sprossenwand</label>
						</div> -->
					</div>
					<div class="form-group">
						<button type="button" name="submit_data" class="btn btn-primary" id="submit_data">Zu Statistik hinzufügen</button>
						<button type="button" name="remove_data" class="btn btn-primary" id="remove_data">Gerät zurücksetzen</button>
					</div>
				</div>
			</div>
		</div>
		<div class="container-fluid">
			<div class="row">
				<!-- <div class="col-md-4" style="border: 1px solid #dddddd; border-radius: 4px; padding:10px 5px 15px 20px; margin: 20px;">
					<div class="card mt-4">
						<div class="card-header">Pie Chart</div>
						<div class="card-body">
							<div class="chart-container pie-chart">
								<canvas id="pie_chart"></canvas>
							</div>
						</div>
					</div>
				</div> -->
				<div class="col-md-4" style="border: 1px solid #dddddd; border-radius: 4px; padding:10px 5px 15px 20px; margin: 20px 10px 20px 230px;"> 
					<div class="card mt-4">
						<div class="card-header">Doughnut Chart</div>
						<div class="card-body">
							<div class="chart-container pie-chart">
								<canvas id="doughnut_chart"></canvas>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4" style="border: 1px solid #dddddd; border-radius: 4px; padding:10px 5px 15px 20px; margin: 20px 10px 30px 40px;">
					<div class="card mt-4 mb-4">
						<div class="card-header">Bar Chart</div>
						<div class="card-body">
							<div class="chart-container pie-chart">
								<canvas id="bar_chart"></canvas>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>

<script>

function getComboA(selectObject) {
  var value = selectObject.value;  
  console.log(value);
}
	
$(document).ready(function(){

	$('#submit_data').click(function(){

		var geraete_name = $('input[name=programming_geraete_name]').val();

		$.ajax({
			url:"data.php",
			method:"POST",
			data:{action:'insert', geraete_name:geraete_name},
			beforeSend:function()
			{
				$('#submit_data').attr('disabled', 'disabled');
			},
			success:function(data)
			{
				$('#submit_data').attr('disabled', false);

				$('#programming_geraete_name');

				/* $('#programming_geraete_name_2').prop('checked', false);

				$('#programming_geraete_name_3').prop('checked', false);

				alert("Eintrag aktualisiert"); */

				makechart();
			}
		})

	});




	$('#remove_data').click(function(){

		var geraete_name = $('input[name=programming_geraete_name]:checked').val();

		$.ajax({
			url:"data.php",
			method:"POST",
			data:{action:'remove', geraete_name:geraete_name},
			beforeSend:function()
			{
				$('#remove_data').attr('disabled', 'disabled');
			},
			success:function(data)
			{
				$('#remove_data').attr('disabled', false);

				$('#programming_geraete_name_1').prop('checked', false);

				$('#programming_geraete_name_2').prop('checked', false);

				$('#programming_geraete_name_3').prop('checked', false);

				/* alert("Eintrag aktualisiert"); */

				makechart();
			}
		})

	});






	makechart();

	function makechart()
	{
		$.ajax({
			url:"data.php",
			method:"POST",
			data:{action:'fetch'},
			dataType:"JSON",
			success:function(data)
			{
				var geraete_name = [];
				var total = [];
				var color = [];

				for(var count = 0; count < data.length; count++)
				{
					geraete_name.push(data[count].geraete_name);
					total.push(data[count].total);
					color.push(data[count].color);
				}

				var chart_data = {
					labels:geraete_name,
					datasets:[
						{
							label:'Nutzung',
							backgroundColor:color,
							color:'#fff',
							data:total
						}
					]
				};

				var options = {
					responsive:true,
					scales:{
						yAxes:[{
							ticks:{
								min:0
							}
						}]
					}
				};

				var group_chart1 = $('#pie_chart');

				var graph1 = new Chart(group_chart1, {
					type:"pie",
					data:chart_data
				});

				var group_chart2 = $('#doughnut_chart');

				var graph2 = new Chart(group_chart2, {
					type:"doughnut",
					data:chart_data
				});

				var group_chart3 = $('#bar_chart');

				var graph3 = new Chart(group_chart3, {
					type:'bar',
					data:chart_data,
					options:options
				});
			}
		})
	}

});

</script>