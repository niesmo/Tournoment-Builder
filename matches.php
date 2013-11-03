<? include("conf/config.php");
include("inc/header.php");
if(!isset($_GET["id"])) {
	echo "Error: No tournament ID supplied";
} else {
	$result = $db->select("Tournament", "Name, Description",
		"TournamentID = $_GET[id]")[0]; // get name and description
	echo "<h1>Current Matches for " . $result["Name"] . "</h1>";
	echo "<p>" . $result["Description"] . "</p>"; ?>
<table>
	<thead>
		<tr>
			<th>Entrant 1</th>
			<th>Entrant 2</th>
			<th>Winner</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<? 	$matches = $db->select("`Match` as m , Entry as e", "EntryID1, EntryID2, Result",
	"(e.EntryID = m.EntryID1 OR e.EntryID = m.EntryID2) AND e.TournamentID = 2",
	"MatchID");
foreach($matches as $match) {print_r $match["Result"]?>
		<tr>
		<?if($match["Result"] == "") { // match in progress	

		} else {

		}
		</tr>
<?} // end foreach ?>
	</tbody>
</table>
<?} include("inc/footer.php"); ?>
