<? include("conf/config.php");
include("inc/header.php");
if(!isset($_GET[id])) {
	echo "Error: No tournament ID supplied";
} else {
	if($_POST[submit]){
		$db->insert("Participant", "Name", "'$_POST[name]'");
		$Id = $db->lastInsertedId(); // get ParticipantID
		$db->insert("Entry", "TournamentID, ParticipantID", "'$_GET[id]', '$Id'");
	}
	$result = $db->select("Tournament", "Name, Description, Rules",
		"TournamentID is '$_GET[id]'", "", "", "1"); // get name, description, and rules
	echo "<h1>Register for " . $result[0] . "</h1>"; // name
	echo "<p>" . $result[1] . "</p>"; // description
	echo "<h3>Rules:</h3><p>" . $result[2] . "</p>";
?>
<form action="#" method="POST">
  <fieldset>
    <legend>Add Participant</legend>
	<input name="name" type="text" placeholder="Participant Name">
	<input type="submit" name="submit" value="Submit Entry" />
  </fieldset>
</form>
<?}include("inc/footer.php");?>