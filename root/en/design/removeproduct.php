<form class='admin' name='editremove' method='POST'>
<h2>Edit product</h2>
<table>
    <tr class='tr'>
        <th class='invisMobile invisTablet'>Picture</th>
        <th>Name</th>
        <th class='invisMobile'>Price</th>
        <th>Edit</th>
    </tr>


<?php

if ($connect1->connect_error) {
    die("Connection failed: ".$connect1->connect_error);

} else {
    $sql = "SELECT product.*, category.c_name FROM product INNER JOIN category ON category.category_id = product.category;";

    $qresult = $connect1->query($sql);

}

if ($qresult->num_rows > 0) {
    while ($endresult = $qresult->fetch_assoc()) {
        ?>

        <tr class="tr">
            <td class='invisMobile invisTablet'><img src="../img_products/<?php echo $endresult['image']; ?>"></td>
            <td><?php echo $endresult['name']; ?></td>
            <td class='invisMobile'><?php echo "&euro;".number_format($endresult['price'],2); ?></td>
            <td>
                <a id='settings' href='edit.php?productID=<?php echo $endresult['product_id'];?>'><img src='../img/settings.svg'></a>
                <a id='delete' href='delete.php?productID=<?php echo $endresult['product_id'];?>&img=<?php echo $endresult['image'];?>'>X</a>
            </td>
        </tr>

        <?php
    }
}

?>

</table>
</form>
