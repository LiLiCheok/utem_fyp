<nav class="navbar navbar-light">
    <ul class="nav navbar-nav">
    <li class="active"><a href="/BuyMe/seller">My Products</a></li>
    <li><a href="customer_order.php">Customer Orders <span class="badge" id="cusorder_notification"></span></a></li>
    <li><a href="profile.php">My Profile</a></li>
    <li><a href="/BuyMe/logout.php?userID=<?php echo $_SESSION['username']; ?>">Logout</a></li>
    </ul>
</nav>