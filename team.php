<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Random Team Generator</title>
    <link rel="stylesheet" type="text/css" href="Team.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <strong><h1>TUGAS AKHIR</h1></strong>
        <h2 class="namaSaya">MUHAMMAD FARHAN EFENDI / 21120123140181</h2>
        <div class="random-name">
            <nav>
                <ul>
                    <li><a href="main.php">RANDOM WINNER GENERATOR</a></li>
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

class TeamManager {
    private $calon;
    private $teams;

    public function __construct() {
        if (!isset($_SESSION['calon'])) {
            $_SESSION['calon'] = [];
        }
        if (!isset($_SESSION['teams'])) {
            $_SESSION['teams'] = [];
        }
        $this->calon = &$_SESSION['calon'];
        $this->teams = &$_SESSION['teams'];
    }

    public function stackPush($input) {
        if (!empty($input)) {
            $entries = explode("\n", $input);
            foreach ($entries as $entry) {
                $entry = trim($entry);
                if (!empty($entry) && !in_array($entry, $this->calon)) {
                    array_push($this->calon, $entry);
                }
            }
        }
    }

    public function stackPop() {
        array_pop($this->calon);
        unset($_SESSION['teams']);
    }

    public function clearAll() {
        $this->calon = [];
        unset($_SESSION['teams']);
    }

    public function tampilData() {
        echo "<pre>Calon Anggota Tim:\n";
        echo implode("\n", $this->calon) . "</pre>";
    }

    public function tampilTim() {
        if (!empty($this->teams)) {
            echo "<div id='winnerList'><pre>Daftar Tim:\n";
            foreach ($this->teams as $index => $team) {
                echo "Tim " . ($index + 1) . " : " . implode(", ", $team) . "\n";
            }
            echo "</pre></div>";
        }
    }

    public function randomFunction($teamCount) {
        if (!empty($this->calon)) {

            if (empty($this->teams)) {
                $this->teams = [];
            }

            $totalMembers = count($this->calon);

            if ($totalMembers < $teamCount) {
                echo "<script>alert('Jumlah kandidat tidak cukup untuk membuat $teamCount tim. Dibutuhkan minimal $teamCount kandidat.');</script>";
                return;
            }

            shuffle($this->calon);

            $teams = array_fill(0, $teamCount, []);
            for ($i = 0; $i < $totalMembers; $i++) {
                $teams[$i % $teamCount][] = $this->calon[$i];
            }

            $this->teams = $teams;
            $this->calon = [];

        } else {
            echo "<pre>Tidak ditemukan kandidat</pre>";
        }
    }
}

$teamManager = new TeamManager();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit'])) {
        $teamManager->stackPush($_POST['userInput']);
        $teamManager->tampilData();

    } elseif (isset($_POST['popData'])) {
        $teamManager->stackPop();
        $teamManager->tampilData();

    } elseif (isset($_POST['generateTeam'])) {
        $teamCount = isset($_POST['teamCount']) ? (int)$_POST['teamCount'] : 1;
        $teamManager->randomFunction($teamCount);
        $teamManager->tampilTim();

    } elseif (isset($_POST['clearAll'])) {
        $teamManager->clearAll();
    }
}
?>
  
  </div>
</body>

</html>