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
	foreach $matches as $match { 
		print_r $match;
	?>
		
	<?} // end foreach ?>
	</tbody>
</table>
<?} include("inc/footer.php"); ?>
