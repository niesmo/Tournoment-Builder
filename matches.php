<? include("conf/config.php");
include("inc/header.php");
if(!isset($_GET[id])) {
	echo "Error: No tournament ID supplied";
} else {
	$result = $db->select("Tournament", "Name, Description",
		"TournamentID = $_GET[id]")[0]; // get name and description
	echo "<h1>Current Matches for " . $result[Name] . "</h1>";
	echo "<p>" . $result[Description] . "</p>"; ?>
<table>
	<thead>
		<tr>
			<th>Entrant 1</th>
			<th>Entrant 2</th>
			<th>Winner</th>
		</tr>
	</thead>
	<tbody>
<? $matches = $db->select("`Match`", "EntryID1, EntryID2, Result",
		"TournamentID = $_GET[id]");
	foreach $matches as $match { ?>
		<tr>
			<td><?echo $match[0]?></td>
			<td><?echo $match[1]?></td>
			<td><?	if($match[Result] == "FIRST") echo $match[0];
					elseif($match[Result] == "SECOND") echo $match[1];
					else echo "Draw";?></td>
		</tr>
	<?} // end foreach ?>
	</tbody>
</table>
<?} include("inc/footer.php"); ?>
