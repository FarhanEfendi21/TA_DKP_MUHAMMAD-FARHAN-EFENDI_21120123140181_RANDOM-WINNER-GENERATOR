<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Random Winner Generator</title>
    <link rel="stylesheet" type="text/css" href="Main.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <strong>
            <h1>TUGAS AKHIR</h1>
        </strong>
        <h2 class="namaSaya">MUHAMMAD FARHAN EFENDI / 21120123140181</h2>
        <div class="random-name">
            <nav>
                <ul>
                    <li><a href="team.php">RANDOM TEAM GENERATOR</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <br><br>

    <div class="container">
        <h2>RANDOM WINNER GENERATOR</h2>
        <?php
        session_start();
        class CandidateManager {
            private $calon;
            private $winners;
        
            public function __construct() {
                if (!isset($_SESSION['calon'])) {
                    $_SESSION['calon'] = [];
                }
                if (!isset($_SESSION['winners'])) {
                    $_SESSION['winners'] = [];
                }
                $this->calon = &$_SESSION['calon'];
                $this->winners = &$_SESSION['winners'];
            }
        
            public function stackPush($input) {
                if (!empty($input)) {
                    $entries = array_filter(array_map('trim', explode("\n", $input)));
                    foreach ($entries as $entry) {
                        if (!in_array($entry, $this->calon)) {
                            $this->calon[] = $entry;
                        }
                    }
                }
            }
        
            public function stackPop() {
                array_pop($this->calon);
                unset($_SESSION['winners']);
            }
        
            public function clearAll() {
                $this->calon = [];
                unset($_SESSION['winners']);
            }
        
            public function tampilData() {
                $output = "<pre>Calon Pemenang :\n";
                foreach ($this->calon as $calon) {
                    $output .= ($calon) . "\n";
                }
                $output .= "</pre>";
                return $output;
            }
        
            public function tampilPemenang() {
                $output = '';
                if (!empty($this->winners)) {
                    $output .= "<div id='winnerList'><pre>Daftar Pemenang :\n";
                    foreach ($this->winners as $winner) {
                        $output .= ($winner) . "\n";
                    }
                    $output .= "</pre></div>";
                }
                return $output;
            }
        
            public function randomFunction() {
                $output = '';
                if (!empty($this->calon)) {
                    shuffle($this->calon);
                    $winner = array_pop($this->calon);
                    $this->winners[] = $winner;
                    $output .= "<pre>Selamat Kepada :\n<strong>" . ($winner) . "</strong></pre>";
                } else {
                    $output .= "<pre>Tidak ditemukan kandidat</pre>";
                }
                return $output;
            }
        }
        
        $inputType = isset($_POST['inputType']) ? $_POST['inputType'] : 'letters';
        $pattern = $inputType == 'letters' ? '/^[a-zA-Z\s]+$/' : '/^[0-9\s]+$/';
        $inputError = '';
        $results = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $candidateManager = new CandidateManager();
        
            if (isset($_POST['submit'])) {
                if (preg_match($pattern, $_POST['userInput'])) {
                    $candidateManager->stackPush($_POST['userInput']);
                    $results = $candidateManager->tampilData();
                } else {
                    $inputError = '<span style="color: red; font-weight: bold; display: block; text-align: center;">Input does not match the selected type</span>';

                }
            } elseif (isset($_POST['popData'])) {
                $candidateManager->stackPop();
                $results = $candidateManager->tampilData();
            } elseif (isset($_POST['generateWinner'])) {
                $results = $candidateManager->randomFunction();
                $results .= $candidateManager->tampilPemenang();
            } elseif (isset($_POST['clearAll'])) {
                $candidateManager->clearAll();
            }
        }
        ?>
        
                
        <form method="post">
            <label for="inputType">Choose Input Type:</label><br><br>
            <input type="radio" id="letters" name="inputType" value="letters" <?= $inputType == 'letters' ? 'checked' : '' ?>>
            <label for="letters">Letters</label>
            <input type="radio" id="numbers" name="inputType" value="numbers" <?= $inputType == 'numbers' ? 'checked' : '' ?>>
            <label for="numbers">Numbers</label><br><br>

            <label for="userInput">Input Data</label><br><br>
            <textarea id="userInput" name="userInput" spellcheck="false" rows="6" autocomplete="off" pattern="<?= $pattern ?>"></textarea><br><br>
            <input type="submit" name="submit" value="Submit">
            <input type="submit" name="popData" value="Clear">
            <input type="submit" name="clearAll" value="Clear All"><br>
            <input type="submit" name="generateWinner" value="Generate Pemenang">
        </form>
        <?php
        if (!empty($inputError)) {
            echo "<p style='color: red;'>$inputError</p>";
        }

        echo $results;
        ?>
    </div>
</body>
</html>
