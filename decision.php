<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Decision Maker</title>
    <link rel="stylesheet" type="text/css" href="Decision.css">
</head>

<body>
    <header>
        <h1><strong>TUGAS AKHIR</strong></h1>
        <nav>
            <ul>
                <li><a href="#">MUHAMMAD FARHAN EFENDI</a></li>
                <li><a href="#">21120123140181</a></li>
            </ul>
        </nav>
        <div class="random-name">
            <nav>
                <ul>
                    <li><a href="team.php">RANDOM TEAM GENERATOR</a></li>
                    <li><a href="decision.php">DECISION MAKER</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <br><br>
    <div class="container">
        <h2>DECISION MAKER</h2>
        <form method="post">
            <label for="userInput">Input Data</label><br><br>
            <textarea name="userInput" spellcheck="false" rows="6" autocomplete="off"></textarea><br><br>
            <input type="submit" name="submit" value="Submit">
            <input type="submit" name="popData" value="Clear Last">
            <input type="submit" name="clearAll" value="Clear All"><br>
            <input type="submit" name="generateDecision" value="Generate Decision">
        </form>

        <?php
session_start();

if (!isset($_SESSION['calon'])) {
    $_SESSION['calon'] = [];
}

function stackPush() {
    if (!empty($_POST['userInput'])) {
        $entries = explode("\n", $_POST['userInput']);
        foreach ($entries as $entry) {
            $entry = trim($entry);
            if (!empty($entry) && !in_array($entry, $_SESSION['calon'])) {
                array_push($_SESSION['calon'], $entry);
            }
        }
    }
}

function stackPop() {
    array_pop($_SESSION['calon']);
}

function clearAll() {
    $_SESSION['calon'] = [];
    unset($_SESSION['winner']);
}

function tampilData() {
    if (!empty($_SESSION['calon'])) {
        echo "<pre>Decision Possible:\n";
        echo implode("\n", $_SESSION['calon']) . "</pre>";
    }
}

function tampilPemenang() {
    if (isset($_SESSION['winner'])) {
        echo "<div id='winnerList'><pre>Decision Terpilih :\n<strong>{$_SESSION['winner']}</strong></pre></div>";
    }
}

function randomFunction() {
    if (!empty($_SESSION['calon'])) {
        // Clear the previous winner
        unset($_SESSION['winner']);

        shuffle($_SESSION['calon']);
        $_SESSION['winner'] = array_pop($_SESSION['calon']);
    } else {
        echo "<pre>Tidak ditemukan input</pre>";
    }
}

if (isset($_POST['submit'])) {
    stackPush();
    tampilData();
}
if (isset($_POST['popData'])) {
    stackPop();
    tampilData();
}
if (isset($_POST['clearAll'])) {
    clearAll();
    tampilData();
}
if (isset($_POST['generateDecision'])) {
    randomFunction();
    tampilPemenang();
}
?>


    </div>
</body>

</html>
