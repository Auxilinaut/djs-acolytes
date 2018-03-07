<nav class="navbar navbar-expand-lg navbar-light bg-light">
<a class="navbar-brand" href="#">LOLTOURNAMENTS</a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarSupportedContent">
<ul class="navbar-nav mr-auto">
<li class="nav-item active">
<a class="nav-link" href="index.php">Home</a>
</li>
<li class="nav-item">
<a class="nav-link" href="tournaments.php">Tournaments</a>
</li>
<?php
if(isset($_SESSION['sessionId']))
{
	echo '<li class="nav-item"><a class="nav-link" href="create.php">Create Tournament</a></li>';
	echo '<li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>';
	echo '<li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>';
}
else
{
	echo '<li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>';
	echo '<li class="nav-item"><a class="nav-link" href="">Register</a></li>';
}
?>
    </ul>
  </div>
</nav>
