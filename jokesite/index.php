<?php
 include_once $_SERVER['DOCUMENT_ROOT'] . 'chapter6/includes/magicquotes.inc.php';



if (isset($_GET['addjoke'])) {
	include 'form.html.php';
	exit();
}



if (isset($_POST['joketext'])) {
	include $_SERVER['DOCUMENT_ROOT'] . 'chapter6/includes/db.inc.php';
	$joketext = mysqli_real_escape_string($link, $_POST['joketext']);

	$sql = 'INSERT INTO joke SET
	joketext="' . $_POST['joketext'] . '",
	jokedate=CURDATE()';

	if (!mysqli_query($link, $sql))
	{
		
		$error = 'Error adding submitted joke: ' . mysqli_error($link);
		include 'error.html.php';
		
		exit();
	
	}

	

	header('Location: .');
	
	exit();

}


if  (isset($_GET['deletejoke'])) {

	include $_SERVER['DOCUMENT_ROOT'] . 'chapter6/includes/db.inc.php';
	$id = mysqli_real_escape_string($link, $_POST['id']);

	$sql = "DELETE FROM joke WHERE id='$id'";

	
	if (!mysqli_query($link, $sql))
 {
		$error = 'Error deleting joke: ' . mysqli_error($link);
	
		include 'error.html.php';

		exit();
	
	}



	header('Location: .');

	exit();

}

include $_SERVER['DOCUMENT_ROOT'] . 'chapter6/includes/db.inc.php';

$result = mysqli_query($link,'SELECT joke.id, joketext, name, email FROM joke INNER JOIN author ON authorid = author.id');

if (!$result) {
	$error = 'Error fetching jokes: ' . mysqli_error($link);
	include 'error.html.php';
	exit ();
}


while ($row = mysqli_fetch_array($result)) {
	$jokes[] = array('id' => $row['id'], 'text' => $row['joketext'],
	'name' => $row['name'], 'email' => $row['email']);
}

include 'jokes.html.php';

?>
