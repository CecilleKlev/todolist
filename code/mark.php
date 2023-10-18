<?php 

//Include the 'init.php file, which intitializes your database connection and starts the session
require_once 'init.php';

//Check if 'as' and 'item' parameters are set in the GET request
if(isset($_GET['as'], $_GET['item'])){
    $as = $_GET['as'];
    $item = $_GET['item'];

    switch($as){
        case 'done':
            //Prepare a query to mark an item as done (set 'done' to 1) for the current user
            $doneQuery = $db->prepare("
                UPDATE items
                SET done = 1
                WHERE id = :item
                AND user = :user
            ");

            
            //Execute the query, updating the item as done for the current user
            $doneQuery->execute([
                'item' => $item,
                'user' => $_SESSION['user_id']
            ]);

            

            break;
        case 'resetdone';
            //Execute the query, resetting the item as not done for the current user
            $resetdoneQuery = $db->prepare("
                UPDATE items
                SET done = 0
                WHERE id = :item
                AND user = :user
            ");

            $resetdoneQuery->execute([
                'item' => $item,
                'user' => $_SESSION['user_id']
            ]);
            break;

    }
}
//Redirect the user to the 'index.php' page after processing the request 
header('Location: index.php');
?>