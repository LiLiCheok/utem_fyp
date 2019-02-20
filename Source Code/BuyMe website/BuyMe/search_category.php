<form class="form-inline" id="category" method="post" action="#"><!-- search.php -->
    <select class="form-control" name="category">
        <option value="all">All Categories</option>
        <?php include('category.php');?>
    </select>
    <button class="btn btn-success" name="search" type="submit">Search</button>
</form>