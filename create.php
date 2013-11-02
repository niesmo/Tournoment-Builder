<? require_once (inc/header.php);
?>

<form action="#">
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
  </fieldset>
</form>

<? require_once (inc/footer.php);
?>