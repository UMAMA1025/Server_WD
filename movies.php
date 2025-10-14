<?php
// Movies list
$Movies = [
    '12345678' => ['name' => 'Superman', 'year' => '1948', 'punctuation' => '8'],
    '23456789' => ['name' => 'Superman', 'year' => '1978', 'punctuation' => '9'],
    '34567890' => ['name' => 'Batman vs Superman', 'year' => '2016', 'punctuation' => '7'],
    '45678901' => ['name' => 'Superman & Lois', 'year' => '2021', 'punctuation' => '8'],
];

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isan = trim($_POST['isan'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $year = trim($_POST['year'] ?? '');
    $punctuation = trim($_POST['punctuation'] ?? '');

    if ($isan === '' && $name === '') {
        $message = "⚠️ Please enter ISAN or Name.";
    } elseif ($isan === '') {
        // Search by name
        $found = [];
        foreach ($Movies as $id => $movie) {
            if (stripos($movie['name'], $name) !== false) {
                $found[] = "{$movie['name']} from {$movie['year']}.";
            }
        }
        $message = $found ? implode("<br>", $found) : "No movies found.";
    } elseif (isset($Movies[$isan])) {
        // ISAN found
        if ($name === '') {
            unset($Movies[$isan]);
            $message = "🗑️ Movie deleted (temporarily, only for this request).";
        } elseif ($year && $punctuation) {
            $Movies[$isan] = ['name'=>$name, 'year'=>$year, 'punctuation'=>$punctuation];
            $message = "✅ Movie updated.";
        } else {
            $message = "⚠️ Fill all fields to update.";
        }
    } elseif (preg_match('/^\d{8}$/', $isan)) {
        // New ISAN
        if ($name && $year && $punctuation) {
            $Movies[$isan] = ['name'=>$name, 'year'=>$year, 'punctuation'=>$punctuation];
            $message = "✅ Movie added.";
        } else {
            $message = "⚠️ Fill all fields to add.";
        }
    } else {
        $message = "⚠️ Invalid ISAN.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Movie Manager (No Storage)</title>
    <meta charset="utf-8">
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
    </style>
</head>
<body>

    <h1>List of Movies</h1>

    <table>
        <tr><th>ISAN</th><th>Name</th><th>Year</th><th>Punctuation</th></tr>
        <?php foreach($Movies as $id => $m): ?>
        <tr>
            <td><?= htmlspecialchars($id) ?></td>
            <td><?= htmlspecialchars($m['name']) ?></td>
            <td><?= htmlspecialchars($m['year']) ?></td>
            <td><?= htmlspecialchars($m['punctuation']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <?php if ($message): ?>
        <div class="message"><?= $message ?></div>
    <?php endif; ?>

    <div class="divv">
        <h2>Add / Update / Delete Movie</h2>
    
        <form method="post">
            ISAN: <input type="text" name="isan"><br>
            Name: <input type="text" name="name"><br>
            Year: <input type="text" name="year"><br>
            Punctuation: 
            <select name="punctuation">
                <option value="">--Select--</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select><br>
            <input type="submit" value="Submit">
        </form>
    </div>

</body>
</html>
