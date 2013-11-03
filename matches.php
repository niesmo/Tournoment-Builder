<? include("conf/config.php");
include("inc/header.php");
if(!isset($_GET[id])) {
	echo "Error: No tournament ID supplied";
} else {
	$result = $db->select("Tournament", "Name, Description",
		"TournamentID = $_GET[id]")[0]; // get name and description
	echo "<h1>Current Matches for " . $result[Name] . "</h1>";
	echo "<p>" . $result[Description] . "</p>"; ?>
<?} include("inc/footer.php"); ?>
