<?php
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
$org = (string)filter_input(INPUT_POST, 'org');
$size = (string)filter_input(INPUT_POST, 'size');
$img = (string)filter_input(INPUT_POST, 'img');
$title = (string)filter_input(INPUT_POST, 'title');
$text = (string)filter_input(INPUT_POST, 'text');

$fp = fopen('img.csv', 'a+b');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    flock($fp, LOCK_EX);
    fputcsv($fp, [$org, $size, $img, $title, $text]);
    rewind($fp);
}

flock($fp, LOCK_SH);
while ($row = fgetcsv($fp)) {
    $rows[] = $row;
}
flock($fp, LOCK_UN);
fclose($fp);

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <title>The Things I (We) Own, in 3D</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="author" content="creative-community.space">
    <meta name="description" content="2022年7月23日(土) - 8月21日(日) | ビーエヌエーオルターミュージアムにて | 入場無料／会期中無休">

    <meta property="og:title" content="The Things I (We) Own, in 3D" />
    <meta property="og:description" content="2022年7月23日(土) - 8月21日(日) | ビーエヌエーオルターミュージアムにて | 入場無料／会期中無休" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://creative-community.space/pehu/org/3d/" />
    <meta property="og:site_name" content="creative-community.space" />
    <meta property="og:image" content="logo.png" />
    <meta property="og:locale" content="ja_JP" />

    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="@NLC_update" />
    <meta name="twitter:image" content="logo.png" />

    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://creative-community.space/coding/js/tone/jquery.min.js"></script>
    <script src="https://creative-community.space/coding/js/tone/jquery-ui.min.js"></script>
    <script src="https://creative-community.space/coding/js/tone/Tone.min.js"></script>
    <script src="https://creative-community.space/coding/js/tone/StartAudioContext.js"></script>
    <script src="https://creative-community.space/coding/js/mousedragscrollable/scrollable.js"></script>
    <script src="https://creative-community.space/org/searchBox.js"></script>
    <script src="index.js"></script>
    <script src="3d.js"></script>

    <link rel="stylesheet" href="https://creative-community.space/org/index.css" />
    <link rel="stylesheet" href="https://creative-community.space/org/searchBox.css" />
    <link rel="stylesheet" href="index.css" />
    <link rel="stylesheet" href="/org/cover.css" />
    <style>
        :root {
            --text-color: #111;
            --hover-color: #ccc;
            --border-style: 1px dashed #ccc;
            --list-bg: #fff;
            --list-text: #111;
            --org-text: #111;
            --org-bg: #fff;
            --org-border: solid 1px #111;
            --update-text: #ccc;
        }
        
        @font-face {
            font-family: "ipag";
            src: url("https://creative-community.space/coding/fontbook/family/IPA/ipag.ttf");
        }
        
        #server p,
        #collection li p,
        form,
        .reset-button,
        .collection p,
        marquee {
            font-family: "ipag", monospace;
            transform: scale(1, 1.25);
        }
        
        #greeting #text,
        #collection li p b,
        h1,
        h2,
        .collection h2 {
            font-family: 'Times New Roman', serif;
            font-weight: 500;
            font-stretch: condensed;
            font-variant: common-ligatures tabular-nums;
            transform: scale(1, 1.1);
            letter-spacing: -0.1rem;
            word-spacing: -.1ch;
        }
        
        #about,
        #bon,
        #fin {
            width: 35rem;
            max-width: 95%;
        }

        #img {
            width: 55rem;
            max-width: 75%;
        }
        
        .change .mousedragscrollable {
            display: block;
        }

        input:checked~label {
            text-decoration: double underline;
        }
        
        #server p {
            color: #fff;
        }
        
        #server:hover p {
            text-shadow: 1px 1px 2px #fff, 0 0 1em #fff, 0 0 0.2em #fff;
        }
        
        .change .mousedragscrollable::-webkit-scrollbar-thumb,
        .change .mousedragscrollable li::-webkit-scrollbar-thumb {
            background: #fff;
            border: dashed 2px #ccc;
        }
        
        .change .mousedragscrollable::-webkit-scrollbar-track,
        .change .mousedragscrollable li::-webkit-scrollbar-track {
            background: transparent;
        }
        
        #cover {
            background-image: url("logo.png");
            background-position: center;
            background-size: auto 100%;
            background-repeat: no-repeat;
            overflow: hidden;
        }
        
        #images {
            position: absolute;
            top: 40%;
            left: 50%;
            width: 90%;
            height: 0;
            -webkit-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
        }
        
        #images .list_item {
            position: relative;
            padding: 0;
            margin: 2.5vh 0;
        }

        #bon .none,
        #images li:nth-child(n+26) {
            display: none;
        }
        
        #images img {
            animation: 100s linear infinite spot;
        }

        @keyframes spot {
            0% {
                filter: drop-shadow(1rem 1rem 1rem rgba(50, 50, 50, 0.75));
            }
            25% {
                filter: drop-shadow(1rem -0.5rem 1rem rgba(50, 50, 50, 0.75));
            }
            50% {
                filter: drop-shadow(-1rem -1rem 1.5rem rgba(50, 50, 50, 0.75));
            }
            75% {
                filter: drop-shadow(-0.5rem 2rem 2rem rgba(50, 50, 50, 0.75));
            }
            100% {
                filter: drop-shadow(1rem 1rem 1rem rgba(50, 50, 50, 0.75));
            }
        }

        .org .check:before {
            content:'✓';
            color:red;
            position:absolute;
            z-index:100;
            top:1rem;
            left:1rem;
            font-size:2.5rem;
        }

        .org .check {
            color: var(--update-text);
        }

        body,
        ._more:hover,
        header label:hover,
        footer a:hover,
        #greeting p,
        #server:hover p,
        #collection li {
            color: var(--text-color);
        }
        
        ._more,
        header label,
        footer a {
            color: var(--hover-color);
        }
        
        header marquee:hover {
            color: #fff;
            background: #ccc;
        }
        
        header,
        header marquee {
            border-bottom: var(--border-style);
        }
        
        footer {
            border-top: var(--border-style);
        }
        
        @font-face {
            font-family: "MS Mincho";
            src: url("https://creative-community.space/coding/fontbook/family/MS%20Mincho.ttf");
        }

        .pehu {
            font-family: "MS Mincho", "SimSong", serif;
        }
        
        ._more:hover,
        header label:hover,
        footer a:hover {
            text-decoration: wavy underline;
            cursor: pointer;
        }
        
        #sign {
            position: absolute;
            z-index:-1;
            top:0;
            left:0;
            width:100%;
            height:100%;
        }
        
        #sign .bg,
        #main {
            min-height: 77.5vh;
            max-height: 77.5vh;
        }
        
        #presents {
            margin: 0.5rem 0;
        }
        
        .collection {
            width: 25rem;
            max-width: 75%;
        }
        
        #footer,
        .mousedragscrollable,
        .change #cover,
        .change #greeting,
        .change #server,
        #print {
            display: none;
        }
        
        .collection .sold::before {
            content:'out of stock';
        }
        
        .collection .sold {
            color: #aaa;
        }
        
        @media screen and (max-width: 1250px) {
            #images {
                top: 45%;
            }
            #images .list_item {
                margin: 1.75vh 0;
            }
            #sign .bg,
            #main {
                min-height: 77.5vh;
                max-height: 77.5vh;
            }
        }
        
        @media screen and (max-width: 750px) {
            #images {
                top: 40%;
            }
            #images .list_item {
                margin: 1.25vh 0;
            }
            #sign .bg,
            #main {
                min-height: 75vh;
                max-height: 75vh;
            }
        }
        
        @media print {
            #images {
                top: 42.5%;
            }
            #images .list_item {
                margin: 2.5vh 0;
            }
            #address,
            #server {
                display: none;
            }
            #footer,
            #print {
                display: block;
            }
            #greeting {
                z-index: -1;
            }
            #greeting p {
                font-size: 1rem;
            }
            #sign .bg,
            #main {
                min-height: 87vh;
                max-height: 87vh;
            }
        }
    </style>
</head>

<body id="open">

    <header id="header">
        <a class="_more" onclick="more()">令和四年版　夏の自由研究</a>
        <marquee id="marquee">
            2022年7月23日(土) - 8月21日(日) | ビーエヌエーオルターミュージアムにて | 入場無料／会期中無休
        </marquee>
        <nav id="nav">
            <h1>The Things I (We) Own, in 3D</h1>
            <span id="presents">
                <img src="/pehu/org/qr.png" width="50rem">
            </span>
            <form>
                <ol class="search-box">
                    <li>プログラム</li>
                    <li>
                        <input type="radio" name="org" value="sale" id="sale">
                        <label for="sale" class="label">in 3D</label>
                    </li>
                    <li>
                        <input type="radio" name="org" value="motto" id="motto">
                        <label for="motto" class="label">P E H U is</label>
                    </li>
                    <li>
                        <input type="radio" name="org" value="org" id="org">
                        <label for="org" class="label">所有するもの</label>
                    </li>
                    <li>
                        <input type="radio" name="org" value="website" id="website">
                        <label for="website" class="label">ホームページを作る</label>
                    </li>
                    <li>
                        <input type="radio" name="org" value="print" id="print">
                        <label for="print" class="label">箱を装飾する</label>
                    </li>
                    <li>
                        <input type="radio" name="org" value="map" id="map">
                        <label for="map" class="label">言葉を集める</label>
                    </li>
                    <li class="reset">
                        <input type="reset" name="reset" value="View All" class="reset-button label" onclick="greeting()">
                    </li>
                </ol>
            </form>
        </nav>
    </header>

    <main id="main">
        <div id="sign"></div>
        <div id="cover">
            <ol id="images" class="org">
                <?php if (!empty($rows)): ?>
                <?php foreach ($rows as $row): ?>
                <li class="list_item list_toggle <?=h($row[1])?>" data-org="<?=h($row[0])?>">
                    <img src="<?=h($row[2])?>">
                </li>
                <?php endforeach; ?>
                <?php else: ?>
                <li class="list_item list_toggle min" data-org="test">
                    <img src="/logo.png">
                </li>
                <?php endif; ?>
            </ol>
        </div>
        <div id="greeting">
            <p id="text"></p>
        </div>
        <div id="server">
            <p>
                <?php
                    echo $_SERVER['SERVER_PROTOCOL'];
                ?>
                <?php
                    echo $_SERVER['HTTPS'];
                ?>
                <?php
                    echo $_SERVER['SERVER_ADDR'];
                ?>
                <br/>
                <?php
                    echo $_SERVER['SERVER_NAME'];
                    echo $_SERVER['REQUEST_URI'];
                ?>
            </p>
        </div>
        <ul class="mousedragscrollable">
            <li id="about" class="collection"></li>
            <li id="entrance" class="collection"></li>
            <li id="books" class="collection"></li>
            <li id="music" class="collection"></li>
            <li id="fashion" class="collection"></li>
            <li id="bon" class="collection"></li>
            <li id="one" class="collection"></li>
            <li id="two" class="collection"></li>
            <li id="three" class="collection"></li>
            <li id="four" class="collection"></li>
            <li id="fin" class="collection"></li>
        </ul>
    </main>

    <footer id="footer">
        <address id="print">
            <span class="cc_style">
                <?php
                echo $_SERVER['HTTP_HOST'];
                echo $_SERVER['REQUEST_URI'];
                ?>
            </span>
        </address>
    </footer>

    <script type="text/javascript ">
        let btn = document.querySelector('#greeting');
        let marquee = document.querySelector('#marquee');
        let box = document.querySelector('#open');

        let btnToggleclass = function(el) {
            el.classList.toggle('change');
        }

        btn.addEventListener('click', function() {
            btnToggleclass(box);
        }, false);

        marquee.addEventListener('click', function() {
            btnToggleclass(box);
        }, false);

        $('a[href^="# "]').click(function() {
            var href = $(this).attr("href ");
            var target = $(href == "#" || href == " " ? 'html' : href);
            return false;
        });

        $(function() {
            $("#about").load("about.php");
            $("#entrance").load("entrance.php");
            $("#books").load("books.php");
            $("#fashion").load("fashion.php");
            $("#music").load("music.php");
            $("#bon").load("bon.php");
            $("#one").load("0813/index.php");
            $("#two").load("0814/index.php");
            $("#three").load("0815/index.php");
            $("#four").load("0816/index.php");
            $("#fin").load("0822/index.php");
            $("#sign").load("/sign/bnaaltermuseum/background.php");
        })
    </script>
</body>

</html>
