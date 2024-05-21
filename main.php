<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Random Winner Generator</title>
    <link rel="stylesheet" type="text/css" href="Main.css">
    <script>
        function validateInput(event) {
            var inputType = document.querySelector('input[name="inputType"]:checked').value;
            var key = event.keyCode || event.which;
            var charStr = String.fromCharCode(key);
            if (inputType === 'letters' && /\d/.test(charStr)) {
                event.preventDefault();
                alert("Please enter letters only!");
            } else if (inputType === 'numbers' && /[a-zA-Z]/.test(charStr)) {
                event.preventDefault();
                alert("Please enter numbers only!");
            }
        }
    </script>
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
                    <li><a href="decision.php">DECISION MAKER</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <br><br>
    <div class="container">
        <h2>RANDOM WINNER GENERATOR</h2>
        <form method="post" onsubmit="return validateForm()">
            <label for="inputType">Choose Input Type:</label><br><br>
            <input type="radio" id="letters" name="inputType" value="letters">
            <label for="letters">Letters</label>
            <input type="radio" id="numbers" name="inputType" value="numbers">
            <label for="numbers">Numbers</label><br><br>

            <label for="userInput">Input Data</label><br><br>
            <textarea name="userInput" spellcheck="false" rows="6" autocomplete="off" onkeypress="validateInput(event)"></textarea><br><br>
            <input type="submit" name="submit" value="Submit">
            <input type="submit" name="popData" value="Clear">
            <input type="submit" name="clearAll" value="Clear All"><br>
            <input type="submit" name="generateWinner" value="Generate Pemenang">
        </form>
    </div>
</body>

</html>


        <?php
        session_start();

        // Initialize data and GUI
        if (!isset($_SESSION['calon'])) {
            $_SESSION['calon'] = [];
        }

        // Push data to stack
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

        // Pop data from stack
        function stackPop() {
            array_pop($_SESSION['calon']);
            unset($_SESSION['winners']);
        }

        // Clear all data
        function clearAll() {
            $_SESSION['calon'] = [];
            unset($_SESSION['winners']);
        }

        if (isset($_POST['clearAll'])) {
            clearAll();
        }

        // Display stack data
        function tampilData() {
            echo "<pre>Calon Pemenang :\n";
            echo implode("\n", $_SESSION['calon']) . "</pre>";
        }

        // Display winners
        function tampilPemenang() {
            if (isset($_SESSION['winners'])) {
                echo "<div id='winnerList'><pre>Daftar Pemenang :\n";
                echo implode("\n", $_SESSION['winners']) . "</pre></div>";
            }
        }

        // Random function with loading bar
        function randomFunction() {
            if (!empty($_SESSION['calon'])) {
                echo "<script>showLoadingBar();</script>";

                if (!isset($_SESSION['winners'])) {
                    $_SESSION['winners'] = [];
                }

                shuffle($_SESSION['calon']);
                $winner = array_pop($_SESSION['calon']);
                $_SESSION['winners'][] = $winner;

                echo "<pre>Selamat Kepada :\n<strong>$winner</strong></pre>";
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
        if (isset($_POST['generateWinner'])) {
            randomFunction();
            tampilPemenang();
        }
        ?>
    </div>
</body>

</html>
