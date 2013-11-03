<? include("conf/config.php");
include("inc/header.php");
if(!isset($_GET["id"])) {
	echo "Error: No tournament ID supplied";
} else {
	$result = $db->select("Tournament", "Name, Description",
		"TournamentID = $_GET[id]")[0]; // get name and description
	echo "<h1>Current Matches for " . $result["Name"] . "</h1>";
	echo "<p>" . $result["Description"] . "</p>"; ?>
	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>Entrant 1</th>
				<th>Entrant 2</th>
				<th>Winner</th>
			</tr>
		</thead>
		<tbody>
	<? 	$matches = $db->select("`Match` as m , Entry as e, Participant as p", "EntryID1, EntryID2, Result, p.Name",
		"(e.EntryID = m.EntryID1 OR e.EntryID = m.EntryID2) AND e.TournamentID = '$_GET[id]'",
		"MatchID");
	foreach($matches as $match) {
			$part_1 = $participant->getParticipantInfo($match['EntryID1']);
			$part_2 = $participant->getParticipantInfo($match['EntryID2']);
			?>
			<tr>
			<?if($match["Result"] == "") { // match in progress ?>
				<td><button class="btn"><?echo $part_1['Name']?></button></td>
				<td><button class="btn"><?echo $part_2['Name']?></button></td>
				<td><i>Awaiting Results</i></td>
			<?} else {?>
				<td <?if($match["Result"] == "FIRST") echo "class='success';?>><?echo $part_1['Name']?></td>
				<td <?if($match["Result"] == "SECOND") echo "class='success'";?>><?echo $part_2['Name']?></td>
				<td><?if($match["Result"] == "FIRST") echo $part_1['Name'];
				      elseif($match["Result"] == "SECOND") echo $part_2['Name'];?></td>
				
			<?}?>
			</tr>
	<?} // end foreach ?>
		</tbody>
	</table>
<?}
include("inc/footer.php"); ?>
