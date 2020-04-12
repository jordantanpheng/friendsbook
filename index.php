<html>
<head>
<title>My friends book</title>
</head>
<body>
<br>
<form action="index.php" method="post">
	Name: <input type="text" name="name">
	<input type="submit" value="Send a name">
</form>

<h1>My best friends:</h1>
<form action="index.php" method="post">
<?php
$filename = 'friends.txt';
$nameFilter = "";
if (isset($_POST['nameFilter'])) {
    $nameFilter = $_POST['nameFilter'];
}
$startingWith = "";
if (isset($_POST['startingWith'])) {
	$startingWith = $_POST['startingWith'];
}
// delete name from file
if (isset($_POST['delete'])) {
	$indexToBeRemoved = $_POST['delete'];
	$names = file($filename);
	unset($names[$indexToBeRemoved]);
	$file = fopen($filename, "w");
	foreach ($names as $name) {
		fwrite($file, "$name");
	}
	fclose($file);
}

// show name on webpage
$i = 0;
echo "<ul>";
$file = fopen($filename, "r");
if ($file != false) {
    while (!feof($file)) {
        $names = fgets($file);
		if (!empty($names)) {
			if ($nameFilter == "" || strpos($names, $nameFilter) !== FALSE) {
				if ($startingWith == "" || strpos($names, $nameFilter) === 0) {
					echo "<li>$names<button type='submit' name='delete' value='$i'>Delete</button></li>";
					$i++;
				}
			}
		}
    }
    fclose( $file );
}

// write name to file
if (isset($_POST['name']) && strlen($_POST['name']) > 0) {
    $name = $_POST['name']; 
    $file = fopen($filename, "a+");
    if($file != false) {
        echo "<li><b>$name</b><button type='submit' name='delete' value='$i'>Delete</button></li></li>";
        fwrite($file, "$name\n");
        fclose($file);
    }
}
echo "</ul>";
?>
	<input type="text" name="nameFilter" value="<?php echo $nameFilter?>">
	<input type="checkbox" name="startingWith" <?php if ($startingWith == 'TRUE') echo "checked"?> value = "TRUE">Only names starting with</input>
	<input type="submit" value="Filter list">
</form>
</body>
</html>