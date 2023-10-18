<?php
//Include the 'init.php' file, which presumably intializes your database connectiion and starts the session
require_once 'init.php';

//Prepare a SQL query to select items for the current user
$itemsQuery =$db->prepare("
    SELECT id, name, done
    FROM items
    WHERE user = :user
");

//Execute the query, using the user_id from the session as a parameter
$itemsQuery ->execute([
    'user' => $_SESSION['user_id']
]);

//Fetch the results of the query into the $items array
$items = $itemsQuery->rowCount() ? $itemsQuery->fetchAll() : [];


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>To Do</title>

    <!--Link to Google Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel = "stylesheet" href= "main.css">
    
    <meta name="viewport" content= "width=device-width, initial-scale=1.0">
    
</head>
<body>
    <div class="list">
        <h1 class= "header">To do</h1>

       <!--Check if there are any items to display-->
        <?php if(!empty($items)): ?>
        <ul class="items" >
            <?php foreach($items as $item): ?>
            <li>
                

                <!--Display the item and apply the "done" class if it's marked as done-->
                <span class="item<?php echo $item['done']? ' done': ''?>"><?php echo $item['name']; ?></span>
                
                <!--If the item is marked as done, show an "undo" link-->
                <?php if($item['done']):?>
                <a href="mark.php?as=resetdone&item=<?php echo $item['id']?>" class="done-button"> undo </a>
                <?php endif; ?>
                <!--If the item is not done, show a "Mark as done" link-->
                <?php if(!$item['done']):?>
                <a href="mark.php?as=done&item=<?php echo $item['id']?>" class="done-button">Mark as done</a>
                <?php endif; ?>

                <!--Add delete button-->
                <a href="delete.php?item=<?php echo $item['id']; ?>" class="delete-button">Delete</a>
        </li>
            </li>
            <?php endforeach;?>    
         </ul>
         <?php else: ?>
                <p>You haven't added any items yet</p>
         <?php endif; ?>


    <!--Form for adding a new item-->
    <form class="item-add"  action="add.php" method="post">
        <input type="text" name="name" placeholder="Type a new item here" class="input" autocomplete="off" required>
        <input type="submit" value="add" class="submit" >
    </form>

    </div>
    
   
</body>
</html>