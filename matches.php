<? include("conf/config.php");
includeHeader("Administration Panel");?>
<div class="container">
	<div class="row-fluid">
<?if(!isset($_GET["id"])) {
	echo "Error: No tournament ID supplied";
} else {
	$result = $db->select("Tournament", "Name, Description, Status",
		"TournamentID = $_GET[id]")[0];
	echo "<h1>Administrative options for " . $result["Name"] . "</h1>";
	echo "<p>" . $result["Description"] . "</p>";
	echo $result["Status"];
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
		"(e.EntryID = m.EntryID1 OR e.EntryID = m.EntryID2) AND e.TournamentID = '$_GET[id]'",
		"MatchID");
	foreach($matches as $match) {
			$part_1 = $participant->getParticipantInfo($match['EntryID1']);
			$part_2 = $participant->getParticipantInfo($match['EntryID2']);
			?>
			<tr>
			<?if($match["Result"] == "") { // match in progress ?>
				<td><button class="btn" onclick ="submitResult(<?=$match['MatchID']?> , 'FIRST')"><?echo $part_1['Name']?></button></td>
				<td><button class="btn" onclick ="submitResult(<?=$match['MatchID']?> , 'SECOND')"><?echo $part_2['Name']?></button></td>
			<?} else {?>
				<td <?if($match["Result"] == "FIRST") echo "class='bg-green'";?>><?echo $part_1['Name']?></td>
				<td <?if($match["Result"] == "SECOND") echo "class='bg-green'";?>><?echo $part_2['Name']?></td>
			<?}?>
			</tr>
	<?} // end foreach ?>
		</tbody>
	</table>
<?} elseif($result["Status"] == "OPEN") {?>
	<h1>Edit Options, Close Registration</h1>
<?} else {?>
	<h3>Tournament has ended</h3>
	<h4>Winner: </h4
<?}}?>
	</div>
</div>
<?include("inc/footer.php"); ?>
