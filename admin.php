<div class="col-lg-6">
	<div class="lead">Nejbližší rezervace</div>
	<table class='table table-striped'>
		<thead>
			<tr>
				<th>Jméno</th>
				<th>Kdy</th>
				<th>Počet míst</th>
				<th>Poznámka</th>
				<th>Hotovo</th>
				<th>Zamítnuto</th>
			</tr>
		</thead>
	<?php
		$res = $conn->allResults("SELECT * FROM rezervace WHERE status = 1 ORDER BY date,time ASC");
		for ($i=0; $i <count($res); $i++) { 
			$date = explode("-", $res[$i]["date"]);
			$date = $date[2].".".$date[1].".".$date[0];
			$r .= "<tr><td>".$res[$i]["name"]." ".$res[$i]["surname"]."</td><td>".$date." ".$res[$i]["time"]."</td><td>".$res[$i]["customers"]."</td><td>".$res[$i]["note"]."</td><td><a href='?accept=".$res[$i]["id"]."'><button class='btn btn-sm btn-dark'>Vyřízeno</button></a></td><td><a href='?deny=".$res[$i]["id"]."'><button class='btn btn-sm btn-dark'>Zamítnuto</button></a></td></tr>";
		}
		echo $r;
	?>
	</table>
</div>