<form method="GET" id="filter" action="../shop/">
    <h3>Categories</h3>
    <label><input type='radio' checked id='filter2' name='filtercategory' value='0'> All</label><br>

<?php 
if ($connect1->connect_error) {
    die("Connection failed: ".$connect1->connect_error);

} else {
    $sql = "SELECT category_id, c_name FROM category;";
    $qresult = $connect1->query($sql);

}

if ($qresult->num_rows > 0) {
    while ($endresult = $qresult->fetch_assoc()) {

    if (isset($_GET['filtercategory']) && $_GET['filtercategory'] == $endresult['category_id']) {
        echo "<label><input type='radio' checked id='filter2' name='filtercategory' value='".$endresult["category_id"]."'> ".$endresult["c_name"]."</label><br>";

    } else {
        echo "<label><input type='radio' id='filter2' name='filtercategory' value='".$endresult["category_id"]."'> ".$endresult["c_name"]."</label><br>";
    }
    }
}
?>


<h3>Price</h3>
<?php
if (isset($_GET['minPrice'])) {
    echo "
    <input type='number' min='0' name='minPrice' class='priceInput' placeholder='Min' value='".$_GET['minPrice']."' step='0.01'>
    ";
} else {
    echo "
    <input type='number' min='0' name='minPrice' class='priceInput' placeholder='Min' value='0' step='0.01'>
    ";
}
if (isset($_GET['maxPrice'])) {
    echo "
    - <input name='maxPrice' type='number' class='priceInput' placeholder='Max' value='".$_GET['maxPrice']."' step='0.01'>
    ";
} else {
    echo "
    - <input name='maxPrice' type='number' class='priceInput' placeholder='Max' value='999' step='0.01'>
    ";
}
?>
<input type="submit" value="Filter" id="filter" name="submitfilter">
</form>