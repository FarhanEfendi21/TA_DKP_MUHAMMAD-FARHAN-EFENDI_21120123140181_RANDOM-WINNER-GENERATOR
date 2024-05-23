<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Random Team Generator</title>
    <link rel="stylesheet" type="text/css" href="Team.css">
</head>

<body>
    <header>
        <strong><h1>TUGAS AKHIR</h1></strong>
        <h2 class="namaSaya">MUHAMMAD FARHAN EFENDI / 21120123140181</h2>
        <div class="random-name">
            <nav>
                <ul>
                    <li><a href="main.php">RANDOM WINNER PICKER</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <br><br>

    <div class="container">
        <h2>RANDOM TEAM GENERATOR</h2>
        <form method="post">
            <label for="userInput">Input Data:</label><br><br>
            <textarea name="userInput" spellcheck="false" rows="6" autocomplete="off"></textarea><br><br>
            <label for="teamCount">Jumlah Tim:</label><br><br>
            <input type="number" name="teamCount" min="1" value="1"><br><br>
            <input type="submit" name="submit" value="Submit">
            <input type="submit" name="popData" value="Clear">
            <input type="submit" name="clearAll" value="Clear All"><br>
            <input type="submit" name="generateTeam" value="Generate Team">
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
            unset($_SESSION['teams']);
        }

        function clearAll() {
            $_SESSION['calon'] = [];
            unset($_SESSION['teams']);
        }

        if (isset($_POST['clearAll'])) {
            clearAll();
        }

        function tampilData() {
            echo "<pre>Calon Anggota Tim:\n";
            echo implode("\n", $_SESSION['calon']) . "</pre>";
        }

        function tampilTim() {
            if (isset($_SESSION['teams'])) {
                echo "<div id='winnerList'><pre>Daftar Tim:\n";
                foreach ($_SESSION['teams'] as $index => $team) {
                    echo "Tim " . ($index + 1) . ": " . implode(", ", $team) . "\n";
                }
                echo "</pre></div>";
            }
        }

        function randomFunction() {
            if (!empty($_SESSION['calon'])) {
                echo "<script>showLoadingBar();</script>";

                if (!isset($_SESSION['teams'])) {
                    $_SESSION['teams'] = [];
                }

                $teamCount = isset($_POST['teamCount']) ? (int)$_POST['teamCount'] : 1;
                $totalMembers = count($_SESSION['calon']);

                if ($totalMembers < $teamCount) {
                    echo "<script>alert('Jumlah kandidat tidak cukup untuk membuat $teamCount tim. Dibutuhkan minimal $teamCount kandidat.');</script>";
                    return;
                }

                shuffle($_SESSION['calon']);

                $teams = array_fill(0, $teamCount, []);
                for ($i = 0; $i < $totalMembers; $i++) {
                    $teams[$i % $teamCount][] = $_SESSION['calon'][$i];
                }

                $_SESSION['teams'] = $teams;
                $_SESSION['calon'] = [];

                echo "<script>hideLoadingBar();</script>";
            } else {
                echo "<pre>Tidak ditemukan kandidat</pre>";
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
        if (isset($_POST['generateTeam'])) {
            randomFunction();
            tampilTim();
        }
        ?>
    </div>
</body>

</html>
