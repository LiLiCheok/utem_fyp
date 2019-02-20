<form class="form-inline pull-xs-right" method="post" action="search.php">
    <select type="text" class="form-control" id="selectCategory" name="categoryID" readonly >
        <option value="all">All Categories</option>
        <?php include('categoryOption.php'); echo selectdata(); ?>
    </select>
    <button class="btn btn-success" name="searchCat" type="submit">Search</button>
</form>