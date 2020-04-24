<?php
    $dir_valik = "./json_files/valikvastused";
    $dir_hotkey = "./json_files/hotkey";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <link href="https://fonts.googleapis.com/css2?family=Bangers&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cuprum:ital@1&display=swap" rel="stylesheet">
    <title>Main</title>
</head>
<body>
    <div class="content">
        <header class="main">
            <div class="logo">
                <img src="assets/logo.png" height="100" width="100">
            </div>
            <div class="title">
                <h1>Driller</h1>
            </div>
        </header>    
    <div class="links">
        <div class="sidenav">
            <a href="addquiz.php">Testide lisamine</a>
            <a href="#">Ajalugu</a>
        </div>
        <div id="valik">
            <h2>Valikvastustega testid</h2>
        <?php if ($handle = opendir($dir_valik)) {

            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    $filename = ucfirst(pathinfo($entry, PATHINFO_FILENAME));
                ?> <a href="./valikvastused.php/?link=<?php echo "$entry"; ?>"> <?php echo "$filename\n"; ?> </a> <?php
                }
            }        
            closedir($handle);
        }?>
        </div>

        <div id="hotkey">
            <h2>Klaviatuurikäskude testid</h2>
        <?php if ($handle = opendir($dir_hotkey)) {

        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != "..") {
                $filename = ucfirst(pathinfo($entry, PATHINFO_FILENAME));
            ?> <a href="./hotkeys.php/?link=<?php echo "$entry"; ?>"> <?php echo "$filename\n"; ?> </a> <?php 
            }
        }
        closedir($handle);
        }?>
        </div>
    </div>
    </div>   
</body>
</html>
