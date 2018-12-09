<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
	<div class="container">
		<a class="navbar-brand" href="index.php">Simple Blog</a>
		<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
			Menu
			<i class="fas fa-bars"></i>
		</button>
		<div class="collapse navbar-collapse" id="navbarResponsive">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item">
					<a class="nav-link" href="index.php">Home</a>
				</li>

				<?php if(!$user->isLoggedIn()): ?>
					<li class="nav-item">
						<a class="nav-link" href="register.php">Become a member</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="login.php">Sign in</a>
					</li>
				<?php else: ?>
					<li class="nav-item">
						<a class="nav-link" href="posts.php">My Posts</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="profile.php">Profile</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="logout.php">Logout</a>
					</li>
				<?php endif; ?>
			</ul>
		</div>
	</div>
</nav>