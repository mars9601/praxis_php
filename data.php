<?php

//data.php

$connect = new PDO("mysql:host=localhost;dbname=praxis login", "root", "");

if(isset($_POST["action"]))
{
	if($_POST["action"] == 'insert')
	{
		$data = array(
			':geraete_name'		=>	$_POST["geraete_name"]
		);

		$query = "
		INSERT INTO geraete_liste 
		(geraete_name) VALUES (:geraete_name)
		";

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
			srand(ord($row["geraete_name"]));
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
		echo json_encode($data);
		
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
			srand(ord($row["geraete_name"]));
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
		echo json_encode($data);
		
	}
}


?>