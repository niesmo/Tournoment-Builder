<? include("conf/config.php");
include("inc/header.php");
      <div class="row-fluid">
        <div class="span6">

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

	$participants =$tournament->getparticipants($_GET[id]);
	print_r($participants);

	echo "<h3>Current Participants:</h3><p>" . $participants[] . "</p>";
?>

<form action="#" method="POST">
  <fieldset>
    <h2 class="form-signin-heading">Add Participant</h2>
	<input name="name" type="text" placeholder="Participant Name">
	<input class="btn btn-primary btn-large" type="submit" name="submit" value="Submit Entry" />
  </fieldset>
</form>
</div>
</div>
<?}include("inc/footer.php");?>
