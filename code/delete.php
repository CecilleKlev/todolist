<?php
require_once 'init.php';

if(isset($_GET['item'])){
    $item = $_GET['item'];
}

//Prepare a query to delete the item for the current user
$deleteQuery = $db->prepare("
    DELETE FROM items
    WHERE id = :item
    AND user = :user
");

//Execute the query, deleting the item for the current user
$deleteQuery->execute([
    'item' => $item,
    'user' => $_SESSION['user_id']
]);

//Redirect the user to the 'index.php' page after processing the request
header('Location: index.php');

?>