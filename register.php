<? include("conf/config.php");
include("inc/header.php");
if(!isset($_GET[id])) {
	echo "Error: No tournament ID supplied";
} else {
	if($_POST[submit]){
		$db->insert("Participant", "Name", "'$_POST[name]'");
		$id = $db->lastInsertedId(); // get ParticipantID
		echo "Test $id <br>";
		$db->insert("Entry", "TournamentID, ParticipantID", "'$_GET[id]', '$id'");
	}
	$result = $db->select("Tournament", "Name, Description, Rules",
		"TournamentID = $_GET[id]")[0]; // get name, description, and rules
	echo "<h1>Register for " . $result[Name] . "</h1>"; // name
	echo "<p>" . $result[Description] . "</p>"; // description
	echo "<h3>Rules:</h3><p>" . $result[Rules] . "</p>";
?>
<form action="#" method="POST">
  <fieldset>
    <legend>Add Participant</legend>
	<input name="name" type="text" placeholder="Participant Name">
	<input type="submit" name="submit" value="Submit Entry" />
  </fieldset>
</form>
<?}include("inc/footer.php");?>
