<nav class="navbar navbar-light">
    <ul class="nav navbar-nav">
    <li><a href="/BuyMe/seller">My Products</a></li>
    <li><a href="customer_order.php">Customer Orders <span class="badge" id="cusorder_notification"></span></a></li>
    <li class="active"><a href="profile.php">My Profile</a></li>
    <li><a href="/BuyMe/logout.php?userID=<?php echo $_SESSION['userid']; ?>">Logout</a></li>
    </ul>
</nav>