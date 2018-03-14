<!DOCTYPE html>
<html>
<head>
	<title>Create Your Tournament</title>
</head>
<body>
	<h1>Tournament Creation</h1>
	<form>
		Name of your tournament: <br>
		<input type="text" name="tournamentname"><br>
		Number of teams (min. 2): <br>
		<input type="number" name="numberOfTeams" min="2" max="8"><br>
		Description for tournament: <br>
		<input type="text" name="description"><br>
		What time will your tourney start? <br>
		<input type="datetime" name="startTime">
	</form>
</body>
</html>
