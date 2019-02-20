<nav class="navbar navbar-light">
    <ul class="nav navbar-nav">
    <li><a href="/BuyMe">Home</a></li>
    <li class="active"><a href="cart.php">My Cart <span class="badge" id="cart_notification"></span></a></li>
    <li><a href="order.php">My Order <span class="badge" id="order_notification"></span></a></li>
	<li><a href="profile.php">My Profile</a></li>
    <li><a href="/BuyMe/logout.php?userID=<?php echo $_SESSION['userid']; ?>">Logout</a></li>
    </ul>
</nav>