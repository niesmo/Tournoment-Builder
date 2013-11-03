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
		"TournamentID = $_GET[id]"); // get name, description, and rules
	print_r($result);
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