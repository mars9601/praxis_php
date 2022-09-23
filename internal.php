<?php
session_start();
require_once("inc/config.inc.php");
require_once("inc/functions.inc.php");

//ueberprueft, dass der user eingeloggt ist

$user = check_user();

include("templates/header.inc.php");
?>

<div class="container main-container">

<h1>Herzlich Willkommen!</h1>

Hallo <?php echo htmlentities($user['vorname']); ?>,<br>
Herzlich Willkommen im internen Bereich!<br><br>
<h2>Liste der Aktiven Benutzer</h2>
<div class="panel panel-default">
 <!-- listet angemeldete user auf -->
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
<!-- listet schon erfasste geraete fuer selection auf -->
<?php
$data = json_decode(file_get_contents('geraete.json'), true);
sleep(0.1);
?>

</table>
</div>


</div>

<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Create Charts</title>
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		<script	src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>
		<style>
		.grid-container {
		display: grid;
		justify-content: center;
		grid-template-columns: repeat(2, 570px);
		grid-template-rows: repeat(2, 370px);
		grid-column-gap: 0px;
		grid-row-gap: 0px;
		}
		.grid-item {
		border: 1px solid rgba(0, 0, 0, 0.8);
		padding: 20px;
		font-size: 30px;
		text-align: center;
		}
		.card-header{
			font-size: 20px;
			text-decoration: underline;
		}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="card">
				<div style="border: 1px solid #dddddd; border-radius: 4px; padding:10px 5px 15px 20px;" class="card-body">
					<div class="form-group">
						<h2 class="mb-4">Welches Gerät wurde benutzt ?</h2>
							<div class="form-check">
								<!-- einlesen der geraete aus geraete.json (für option value von select) -->
								<label>Auswahl:</label>
									<select id="list">
										<?php
											foreach($data as $name) 
												echo '<option value=' . $name['geraete_name']. '>'. $name['geraete_name'] . '</option>';
										?>	
									</select>
								<label>Gerät hinzufügen:</label>
								<input id="textfill" type="text" value="" placeholder="Bitte Gerätename eingeben">
							</div>
					</div>
					<div class="form-group">
						<button type="button"  class="btn btn-primary" id="submit_data">Auswahl hinzufügen</button>
						<button type="button"  class="btn btn-primary" id="add_data">Gerät hinzufügen</button>
						<button type="button"  class="btn btn-primary" id="remove_data">Gerät zurücksetzen</button>
					</div>
				</div>
			</div>
		</div>
		<div class="container-fluid">
			<div class="grid-container">
				<!-- platzieren der 4 graphen -->
				<div class="grid-item" style="border: 1px solid #dddddd; border-radius: 4px;">
					<div class="card mt-4 mb-4">
						<div class="card-header">Persönliche Nutzung</div>
						<div class="card-body">
							<div class="chart-container pie-chart">
								<canvas id="doughnut_chart_2"></canvas>
							</div>
						</div>
					</div>
				</div>
				<div class="grid-item" style="border: 1px solid #dddddd; border-radius: 4px;">
					<div class="card mt-4 mb-4">
						<div class="card-header">Persönliche Nutzung</div>
						<div class="card-body">
							<div class="chart-container pie-chart">
								<canvas id="bar_chart"></canvas>
							</div>
						</div>
					</div>
				</div>
				<div class="grid-item" style="border: 1px solid #dddddd; border-radius: 4px;"> 
					<div class="card mt-4">
						<div class="card-header">Allgemeine Nutzung</div>
						<div class="card-body">
							<div class="chart-container pie-chart">
								<canvas id="doughnut_chart"></canvas>
							</div>
						</div>
					</div>
				</div>
				<div class="grid-item" style="border: 1px solid #dddddd; border-radius: 4px;">
					<div class="card mt-4 mb-4">
						<div class="card-header">Allgemeine Nutzung</div>
						<div class="card-body">
							<div class="chart-container pie-chart">
								<canvas id="bar_chart_2"></canvas>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>

<script>


//startet beim laden der seite
$(document).ready(function(){
	
	//schickt die benoetigten daten an die data.php (ajax libary)
	//funktion fuer die select auswahl
	$('#submit_data').click(function(){

		var geraete_name = [document.getElementById("list").value,"<?php echo $user['id'] ?>"];

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
				makechart();
				makechart_id();
			}
		})

	});
	//schickt die benoetigten daten an die data.php (ajax libary)
	//funktion fuer eingabe "neues neraet hinzufuegen"
	$('#add_data').click(function(){
		
		var geraete_name = [document.getElementById("textfill").value,"<?php echo $user['id'] ?>"];

		$.ajax({
			url:"data.php",
			method:"POST",
			data:{action:'insert', geraete_name:geraete_name},
			beforeSend:function()
			{
				$('#add_data').attr('disabled', 'disabled');
			},
			success:function(data)
			{
				$('#add_data').attr('disabled', false);
				alert("Gerät erfolgreich hinzugefügt!");
				window.location.reload();

				makechart();
				makechart_id();
			}
		})

	});



	//schickt die benoetigten daten an die data.php (ajax libary)
	//funktion zum entfernen von eintraegen"
	$('#remove_data').click(function(){

		var geraete_name = document.getElementById("list").value;

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
				makechart();
				makechart_id();
			}
		})

	});



	//beim laden der seite ausgefuehrt
	//die funktionen erstellen die graphen (makechart_id = personen bezogen, makechart = gesammte daten) 
	makechart_id();
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

				var group_chart1 = $('#bar_chart_2');

				var graph1 = new Chart(group_chart1, {
					type:"bar",
					data:chart_data,
					options:options
				});

				var group_chart2 = $('#doughnut_chart');

				var graph2 = new Chart(group_chart2, {
					type:"doughnut",
					data:chart_data
				});
			}
		})
	}


	function makechart_id(){

		var geraete_name = [document.getElementById("list").value,"<?php echo $user['id'] ?>"];

		$.ajax({
			url:"data.php",
			method:"POST",
			data:{action:'fetch_id', geraete_name:geraete_name},
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
				var group_chart3 = $('#bar_chart');

				var graph3 = new Chart(group_chart3, {
					type:'bar',
					data:chart_data,
					options:options
				});

				var group_chart2 = $('#doughnut_chart_2');

				var graph2 = new Chart(group_chart2, {
					type:"doughnut",
					data:chart_data
				});
			}
		})
	}


});

</script>
