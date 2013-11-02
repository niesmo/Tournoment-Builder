<? include("inc/header.php");
if($_POST[submit]){
	print_r($_POST);	
}
?>
<form action="#" method="POST">
  <fieldset>
    <legend>Create Tournament</legend>
	<input name="name" type="text" placeholder="Tournament Name">
	<select name="type">
	  <option value="SINGLE">Single Elimination</option>
	  <option value="DOUBLE">Double Elimination</option>
	  <option value="ELO">Elo Ranking System</option>
	  <option value="MTG">Tournament Inspired by MtG</option>
	</select>
	<textarea name="description" rows="3"></textarea>
	<input type="submit" name="submit" value="Creat Tournament" />
  </fieldset>
</form>
<?include("inc/footer.php");?>
