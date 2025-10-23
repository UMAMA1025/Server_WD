<?php
session_start();
require_once 'Movie.php';
require_once 'MovieManager.php';

//Check login
if (isset($_SESSION['username'])) {
    $user = $_SESSION['username'];
} elseif (isset($_COOKIE['username'])) {
    $user = $_COOKIE['username'];
    $_SESSION['username'] = $user;
} else {
    header("Location: index.php");
    exit;
}

$manager = new MovieManager(array(
    new Movie("Superman", "00000001", 1948, 4),
    new Movie("Superman", "00000002", 1978, 5),
    new Movie("Batman vs. Superman", "00000003", 2016, 3),
    new Movie("Superman & Lois", "00000004", 2021, 4)
));

$message = "";
$searchResults = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $isan = $_POST["isan"];
    $year = intval($_POST["year"]);
    $score = intval($_POST["score"]);

    if ($name == "" && $isan == "") {
        $message = "Name and ISAN cannot both be empty.";
    } elseif ($isan == "" && $name != "") {
        $searchResults = $manager->searchByName($name);
        $message = "Search results for '$name'";
    } elseif ($isan != "") {
        if ($manager->exists($isan) && $name == "") {
            $manager->deleteMovie($isan);
            $message = "Movie deleted.";
        } elseif ($name != "" && strlen($isan) == 8) {
            $manager->addMovie(new Movie($name, $isan, $year, $score));
            $message = "Movie added or updated.";
        } else {
            $message = "Invalid data or ISAN must be 8 characters.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?php echo htmlspecialchars($user); ?> - TOP Movies</title>
<style>
    body {
        background: linear-gradient(to right, #db8585ff, #9ea2ceff);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        font-family: Arial, sans-serif;
    }
    .divv {
        padding: 10px;
        border: 3px solid #a1a4c0ff;
        margin-top: 20px;
        border-radius: 10px;
        background: white;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .div{
        padding: 10px;
        margin-top: 20px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    table {
        border-collapse: collapse;
        background: white;
        border-radius: 10px;
        overflow: hidden;
        margin-top: 20px;
    }
    th, td {
        border: 1px solid #ccc;
        padding: 6px 12px;
        text-align: center;
    }
    h1 {
        color: #fff;
    }
    .message {
        background: #fff;
        border-radius: 8px;
        padding: 10px;
        margin-top: 15px;
        max-width: 500px;
    }
    input, select {
        padding: 6px;
        margin: 5px;
        border-radius: 5px;
        border: 1px solid #aaa;
    }
    button {
        padding: 6px 12px;
        border-radius: 5px;
        border: none;
        background: #9ea2ceff;
        color: white;
        cursor: pointer;
    }
    button:hover {
        background: #7d80b5ff;
    }
</style>
</head>
<body>


<h1>Welcome <?php echo htmlspecialchars($user); ?>! Your TOP Movies</h1>


<?php if ($message != ""): ?>
<div class="message"><?php echo htmlspecialchars($message); ?></div>
<?php endif; ?>


<div class="divv">
    <table>
        <tr><th>Name</th><th>ISAN</th><th>Year</th><th>Score</th></tr>
        <?php foreach ($manager->movies as $movie): ?>
        <tr>
            <td><?php echo htmlspecialchars($movie->name); ?></td>
            <td><?php echo htmlspecialchars($movie->isan); ?></td>
            <td><?php echo htmlspecialchars($movie->year); ?></td>
            <td><?php echo htmlspecialchars($movie->score); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

<div class="div">
    <form method="post">
        Name: <input type="text" name="name" placeholder="Movie name" value="<?php echo htmlspecialchars($_POST["name"] ?? ""); ?>"><br>
        ISAN: <input type="text" name="isan" placeholder="ISAN" value="<?php echo htmlspecialchars($_POST["isan"] ?? ""); ?>"><br>
        Year: <input type="number" name="year" placeholder="Year" value="<?php echo htmlspecialchars($_POST["year"] ?? ""); ?>"><br>
        Score:
        <select name="score">
            <?php for ($i = 0; $i <= 5; $i++):
                $selected = (($_POST["score"] ?? "") == $i) ? "selected" : "";
            ?>
            <option value="<?php echo $i; ?>" <?php echo $selected; ?>><?php echo $i; ?></option>
            <?php endfor; ?>
        </select><br>
        <button type="submit">Send</button>
    </form>
</div>

</body>
</html>
