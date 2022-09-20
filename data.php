<?php

//data.php

$connect = new PDO("mysql:host=localhost;dbname=praxis login", "root", "");

if(isset($_POST["action"]))
{
	if($_POST["action"] == 'insert')
	{
		$data = array(
			':geraete_name'		=>	$_POST["geraete_name"][0],
			':user_id'		=>	$_POST["geraete_name"][1]
		);

		$query = "
		INSERT INTO geraete_liste (geraete_name,user_id) 
		VALUES (:geraete_name,:user_id)"
		;

		$statement = $connect->prepare($query);

		$statement->execute($data);

		echo 'done';
	}



	if($_POST["action"] == 'remove')
	{
		$data = array(
			':geraete_name'		=>	$_POST["geraete_name"]
		);

		$query = "
		DELETE FROM geraete_liste WHERE 
		(geraete_name) = (:geraete_name)
		";

		$statement = $connect->prepare($query);

		$statement->execute($data);

		echo 'done';
	}



	if($_POST["action"] == 'fetch')
	{
		$query = "
		SELECT geraete_name, COUNT(geraete_id) AS Total 
		FROM geraete_liste 
		GROUP BY geraete_name
		";

		$result = $connect->query($query);

		$data = array();
		$list= array();

		foreach($result as $row)
		{

			$a=(str_split($row["geraete_name"],1));
			$x=0;
			foreach ($a as $i) {
				$x = $x + ord($i);
			}
			srand($x);
			$data[] = array(
				'geraete_name'		=>	$row["geraete_name"],
				'total'			=>	$row["Total"],
				'color'			=>	'#' . rand(100000, 999999) . ''
			);
			$list[] = array(
				'geraete_name'		=>	$row["geraete_name"],
			);
		}
		file_put_contents("geraete.json",json_encode($list));
		sleep(0.1);
		echo json_encode($data);
		
	}
	

	if($_POST["action"] == 'fetch_id')
	{

		
		
		
	
		$fill = $_POST["geraete_name"][1];
		$query = "
		SELECT geraete_name, COUNT(geraete_id) AS Total 
		FROM geraete_liste WHERE (user_id) = $fill
		GROUP BY geraete_name
		";

		$result = $connect->query($query);

		$data = array();
		$list= array();

		foreach($result as $row)
		{
			$a=(str_split($row["geraete_name"],1));
			$x=0;
			foreach ($a as $i) {
				$x = $x + ord($i);
			}
			srand($x);
			$data[] = array(
				'geraete_name'		=>	$row["geraete_name"],
				'total'			=>	$row["Total"],
				'color'			=>	'#' . rand(100000, 999999) . ''
			);
			$list[] = array(
				'geraete_name'		=>	$row["geraete_name"],
			);
		}
		/* file_put_contents("geraete.json",json_encode($list));
		sleep(0.1); */
		echo json_encode($data);
		file_put_contents("temp.json",json_encode($data));
	}
	
}


?>