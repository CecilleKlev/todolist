<?php
//Include the 'init.php' file, which initializes database connection and starts the session
require_once 'init.php';

//Check if the 'name' parameter is set in the POST request
if(isset($_POST['name'])){
    $name = trim($_POST['name']);

    //Check if the 'name' is not empty
    if(!empty($name)){
    $addedQuery= $db->prepare("
    INSERT INTO items(name, user, done, created)
    VALUES (:name, :user, 0, NOW())
    ");
    
    //Execute the query, inserting the new item with the user's ID and current timestamp
    $addedQuery->execute([
        'name' => $name,
        'user' => $_SESSION['user_id']
    ]);

    //Check if the query affected any rows (successful insertion)
    if($addedQuery->rowCount()){
        //redirect the user to the 'index.php' page after successfully adding the item
        header('Location: index.php');
        exit;
    }else{
        //If the insertion failed, display an error message
        echo "Failed to insert the item into the database";
    }

    }
}

?>