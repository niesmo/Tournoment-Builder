<? include("conf/config.php");
includeHeader("Administration Panel");?>
<div class="container">
	<div class="row-fluid">
<?if(!isset($_GET["id"])) {
	echo "Error: No tournament ID supplied";
} else {
	$result = $db->select("Tournament", "Name, Description, Status, Winner",
		"TournamentID = $_GET[id]")[0];
	echo "<h1>Administrative options for " . $result["Name"] . "</h1>";
	echo "<p>" . $result["Description"] . "</p>";
	if($result["Status"] == "PROGRESS") { // display current matches?>
	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>Entrant 1</th>
				<th>Entrant 2</th>
			</tr>
		</thead>
		<tbody>
	<? 	$matches = $db->select("`Match` as m , Entry as e, Participant as p", "m.MatchID, EntryID1, EntryID2, Result, p.Name",
		"(e.EntryID = m.EntryID1 OR (e.EntryID = m.EntryID2 OR m.EntryID2 = -1)) AND e.TournamentID = '$_GET[id]'",
		"MatchID");
		echo "<pre>";
		print_r($matches);
		echo "</pre>";
	foreach($matches as $match) {
			$part_1 = $participant->getParticipantInfo($match['EntryID1']);
			$part_2 = $participant->getParticipantInfo($match['EntryID2']);
			?>
			<tr>
			<?if($match["Result"] == "") { // match in progress ?>
				<td><button class="btn" onclick ="submitResult(<?=$match['MatchID']?> , 'FIRST' , <?=$_GET[id]?>)"><?echo $part_1['Name']?></button></td>
				<td><button class="btn" onclick ="submitResult(<?=$match['MatchID']?> , 'SECOND', <?=$_GET[id]?>)"><?echo $part_2['Name']?></button></td>
			<?} else {
				echo $match["Result"];?>
				<td <?if($match["Result"] == "FIRST") echo "style=' background-color: #79F27B; '";?>><?echo $part_1['Name']?></td>
				<td <?if($match["Result"] == "SECOND") echo "style=' background-color: #79F27B; '";?>><?echo $part_2['Name']?></td>
			<?}?>
			</tr>
	<?} // end foreach ?>
		</tbody>
	</table>
<?} elseif($result["Status"] == "OPEN") {?>
	<h1>TODO: Edit Options</h1>
	<button class="btn" onclick="progressTournament(<?=$_GET["id"]?>)">Close Registration</button>
<?} else {?>
	<h3>Tournament has ended</h3>
	<h4>Winner: <?echo $result['Winner']?></h4>
<?}}?>
	</div>
</div>
<?include("inc/footer.php"); ?>
