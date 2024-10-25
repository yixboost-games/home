<?php
$jsonData = file_get_contents('games.json');
$games = json_decode($jsonData, true);
?>

<!DOCTYPE html>
<html>

<head>
    <script src="https://kit.fontawesome.com/6948f435f5.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="header-push">
            <a>⚠️ IMPORTANT! Submit a <a href='http://yixboost.nl.eu.org/yixboost/suggest-game/'>suggestion for a game</a>, you will receive a response within 3 (working) days! ⚠️</a>
    </div>
    <div class='header'>
        <?php
        $jsonData = file_get_contents('games.json');
        $games = json_decode($jsonData, true);

        $categories = array_unique(array_column($games, 'cat'));

        if (!empty($categories)) {
            foreach ($categories as $category) {
                $iconClass = '';

                if ($category === 'Platformer') {
                    $iconClass = 'fas fa-gamepad';
                }

                if ($category === 'Dodge') {
                    $iconClass = 'fa-solid fa-wand-magic-sparkles';
                }

                if ($category === 'Car') {
                    $iconClass = 'fa-solid fa-truck-monster';
                }

                if ($category === 'Racing') {
                    $iconClass = 'fa-solid fa-car';
                }

                if ($category === 'Arcade') {
                    $iconClass = 'fa-solid fa-ghost';
                }

                if ($category === 'IO Game') {
                    $iconClass = 'fa-regular fa-heart';
                }

                if ($category === 'Puzzle') {
                    $iconClass = 'fa-solid fa-puzzle-piece';
                }

                if ($category === 'Building') {
                    $iconClass = 'fa-solid fa-city';
                }

                if ($category === 'Stickman') {
                    $iconClass = 'fa-solid fa-person-running';
                }

                if ($category === 'Kids') {
                    $iconClass = 'fa-solid fa-children';
                }

                if ($category === 'Battle') {
                    $iconClass = 'fa-solid fa-gun';
                }

                if ($category === 'Sport') {
                    $iconClass = 'fa-solid fa-basketball';
                }

                echo "<a href='#{$category}'><i class='{$iconClass}'></i> {$category}</a>";
            }
        } else {
            echo "No categories found.";
        }
        ?>
        <div class='right'>
            <a><i class="fa-solid fa-magnifying-glass"></i></a>
            <a> </a>
            <a href='http://yixboost.nl.eu.org/yixboost/login'><i class="fa-solid fa-user"></i></a>
        </div>
    </div>
<div class="game-field">
    <div class='game-container'>
        <?php
        $jsonData = file_get_contents('games.json');
        $games = json_decode($jsonData, true);

        $categories = array_unique(array_column($games, 'cat'));

        if (!empty($categories)) {
            foreach ($categories as $category) {
                echo "<div id='{$category}' class='section'>";
                echo "</div>";
                echo "<h2>{$category}</h2>";
                echo "<hr>";
                echo "<div class='game-container'>";

                foreach ($games as $gameId => $game) {
                    if ($game['cat'] == $category) {
                        $newClass = ($game['new'] == '1') ? 'button-new' : '';
                        $newTag = ($game['new'] == '1') ? "<div class='new-tag high-z'>New</div>" : '';
                        $gameUrl = "http://yixboost.nl.eu.org/yixboost/games/" . urlencode($gameId);
                        $gameImg = "http://yixboost.nl.eu.org/yixboost/games/" . urlencode($gameId) . "/" . urlencode($gameId) . ".png";

                        echo "<div class='game'>{$newTag}<a href='{$gameUrl}'><img src='{$gameImg}'><div class='button-container'><button class='button {$newClass}'>{$game['name']}</button></div></a></div><br><br>";
                    }
                }

                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "No categories found.";
        }
        ?>
        </div>
    </div>
    <div class="search-popup">
        <p class="hide-search"><i class="fa-solid fa-xmark"></i></p>
        <div class='search'>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
                <input type="text" name="search" placeholder="Search your favorite game...">
                <input type="submit" value="Search">
            </form>
            <div class='result-container'>
                <?php
                $jsonData = file_get_contents('games.json');
                $games = json_decode($jsonData, true);

                if (!empty($games)) {
                    $searchQuery = isset($_GET['search']) ? $_GET['search'] : 'Jumping Henk';
                    $filteredGames = array_filter($games, function ($game) use ($searchQuery) {
                        $gameName = strtolower($game['name']);
                        $gameCategory = strtolower($game['cat']);
                        $searchQuery = strtolower($searchQuery);
                        return strpos($gameName, $searchQuery) !== false || strpos($gameCategory, $searchQuery) !== false;
                    });

                    if (!empty($filteredGames)) {
                        echo "</div>";
                        echo "<h2>Search Result:</h2>";
                        echo "<div class='result-container'>";
                        $sameCategoryCount = 0;
                        foreach ($filteredGames as $gameId => $game) {
                            $newClass = ($game['new'] == '1') ? 'button-new' : '';
                            $newTag = ($game['new'] == '1') ? "<div class='new-tag high-z'>New</div>" : '';
                            $gameUrl = "http://yixboost.nl.eu.org/yixboost/games/" . urlencode($gameId);
                            $gameImg = "http://yixboost.nl.eu.org/yixboost/games/" . urlencode($gameId) . "/" . urlencode($gameId) . ".png";

                            echo "<div class='game-result'>{$newTag}<a href='{$gameUrl}'><img src='{$gameImg}'><div class='button-container-result'><button class='button {$newClass}'>{$game['name']}</button></div></a></div><br><br>";
                            $sameCategoryCount++;
                            if ($sameCategoryCount >= 8) {
                                break;
                            }
                        }

                        $searchedCategory = $filteredGames[array_key_first($filteredGames)]['cat'];
                        $sameCategoryGames = array_filter($games, function ($game) use ($searchedCategory) {
                            $gameCategory = strtolower($game['cat']);
                            return $gameCategory === strtolower($searchedCategory);
                        });

                        foreach ($sameCategoryGames as $gameId => $game) {
                            if (!isset($filteredGames[$gameId]) && $sameCategoryCount < 10) {
                                $newClass = ($game['new'] == '1') ? 'button-new' : '';
                                $newTag = ($game['new'] == '1') ? "<div class='new-tag high-z'>New</div>" : '';
                                $gameUrl = "http://yixboost.nl.eu.org/yixboost/games/" . urlencode($gameId);
                                $gameImg = "http://yixboost.nl.eu.org/yixboost/games/" . urlencode($gameId) . "/" . urlencode($gameId) . ".png";

                                echo "<div class='game-result'>{$newTag}<a href='{$gameUrl}'><img src='{$gameImg}'><div class='button-container-result'><button class='button {$newClass}'>{$game['name']}</button></div></a></div><br><br>";
                                $sameCategoryCount++;
                            }
                        }
                    } else {
                        echo "No games found.";
                    }
                } else {
                    echo "No games found.";
                }
                ?>

            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const hideSearch = document.querySelector('.hide-search');
            const searchPopup = document.querySelector('.search-popup');
            const magnifyingGlass = document.querySelector('.fa-magnifying-glass');

            if (!window.location.href.includes('search')) {
                searchPopup.style.display = 'none';
            }

            hideSearch.addEventListener('click', function () {
                searchPopup.style.display = 'none';
            });

            magnifyingGlass.addEventListener('click', function () {
                searchPopup.style.display = 'block';
            });
        });
    </script>
    <button id="scrollToTopButton">
        <i class="fas fa-arrow-up"></i>
    </button>
    <script>
        window.addEventListener("scroll", function () {
            var scrollToTopButton = document.getElementById("scrollToTopButton");
            if (window.pageYOffset > 100) {
                scrollToTopButton.classList.add("show");
            } else {
                scrollToTopButton.classList.remove("show");
            }
        });

        document.getElementById("scrollToTopButton").addEventListener("click", function () {
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
        });
    </script>
</body>

</html>