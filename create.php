<?
require_once("conf/config.php");
include("inc/header.php");
if($_POST[submit]){
	$db->insert("Tournament", "Name, Type, StartDate, Status, Description, Rules",
		"'$_POST[name]', '$_POST[type]', 'NOW()', 'OPEN', '$_POST[description]', '$_POST[rules]'");
}
?>
<form action="#" method="POST">
  <fieldset>
    <legend>Create Tournament</legend>
	<input name="name" type="text" placeholder="Tournament Name"><br>
	<select name="type">
	  <option value="SINGLE">Single Elimination</option>
	  <option value="DOUBLE">Double Elimination</option>
	  <option value="ELO">Elo Ranking System</option>
	  <option value="MTG">Tournament Inspired by MtG</option>
	</select><br>
	<textarea name="description" rows="3"></textarea><br>
	<textarea name="rules" rows="3"></textarea><br>
	<input type="submit" name="submit" value="Creat Tournament" />
  </fieldset>
</form>
<?include("inc/footer.php");?>
