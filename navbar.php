<nav class="navbar navbar-expand-lg navbar-light bg-light">
<a class="navbar-brand" href="#">LOLTOURNAMENTS</a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarSupportedContent">
<ul class="navbar-nav mr-auto">
<li class="nav-item"><a class="nav-link" href="tournaments.php">Tournaments</a></li>
<li class="nav-item"><a class="nav-link" href="createTournament.php">Create Tournament</a></li>
<li class="nav-item"><a class="nav-link" onclick="removeSessionID()">Logout</a></li>
    </ul>
  </div>
</nav>
<script>
	function removeSessionID()
	{
		localStorage.removeItem("sessionid");
	}
</script>