<?php
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
$org = (string)filter_input(INPUT_POST, 'org');
$size = (string)filter_input(INPUT_POST, 'size');
$img = (string)filter_input(INPUT_POST, 'img');
$title = (string)filter_input(INPUT_POST, 'title');
$text = (string)filter_input(INPUT_POST, 'text');

$fp = fopen('collection.csv', 'a+b');
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
    <title>The Things ∧° ┐ Own</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="author" content="∧° ┐"">
    <meta name="reply-to" content="pehu@creative-community.space">
    <meta name="description" content="∧° ┐ が 所有するもの（出版物・制作物、ウェブドメイン・デジタルツール、メディアファイルなど）を、このページに記録します。">

    <meta property="og:title" content="The Things ∧° ┐ Own" />
    <meta property="og:description" content="∧° ┐ が 所有するもの（出版物・制作物、ウェブドメイン・デジタルツール、メディアファイルなど）を、このページに記録します。" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://creative-community.space/pehu/org/" />
    <meta property="og:site_name" content="creative-community.space" />
    <meta property="og:image" content="card.png" />
    <meta property="og:locale" content="ja_JP" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@NLC_update" />
    <meta name="twitter:image" content="card.png" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="https://creative-community.space/coding/js/tone/jquery.min.js"></script>
    <script src="https://creative-community.space/coding/js/tone/jquery-ui.min.js"></script>
    <script src="https://creative-community.space/coding/js/tone/Tone.min.js"></script>
    <script src="https://creative-community.space/coding/js/tone/StartAudioContext.js"></script>

    <script src="/org/searchBox.js"></script>
    <script src="3d.js"></script>

    <link rel="icon" href="3d/logo.png">
    <link rel="stylesheet" href="/org/cover.css" />
    <link rel="stylesheet" href="/org/index.css" />
    <link rel="stylesheet" href="/org/searchBox.css" />
    <style>
        #bought:checked~label,
        #gift:checked~label,
        #free:checked~label,
        #made:checked~label,
        #collaborations:checked~label,
        #other:checked~label,
        #sale:checked~label {
            text-decoration: double underline;
        }
        
        body,
        ._more:hover,
        header label:hover,
        footer a:hover,
        #greeting p,
        #server:hover p {
            color: #111;
        }
        
        header,
        header marquee {
            border-bottom: 1px dashed #ccc;
        }
        
        footer {
            border-top: 1px dashed #ccc;
        }
        
        ._more,
        header label,
        footer a {
            color: #ccc;
        }
        
        header marquee:hover {
            color: #fff;
            background: #ccc;
        }
        
        ._more:hover,
        header label:hover,
        footer a:hover {
            text-decoration: #ccc wavy underline;
            cursor: pointer;
        }
        
        #server p {
            color: #eee;
        }
        
        #server:hover p {
            text-shadow: 1px 1px 2px #fff, 0 0 1em #fff, 0 0 0.2em #fff;
        }
        
        .change .mousedragscrollable::-webkit-scrollbar-thumb,
        .change .mousedragscrollable li::-webkit-scrollbar-thumb {
            background: #ccc;
        }
        
        .change .mousedragscrollable::-webkit-scrollbar-track,
        .change .mousedragscrollable li::-webkit-scrollbar-track {
            background: transparent;
        }
        
        #main {
            min-height: 77.5vh;
            max-height: 77.5vh;
            overflow: hidden;
        }
        
        #presents {
            margin: 0.5rem 0;
        }
        
        #about {
            width: 35rem;
            max-width: 95%;
        }
        
        .collection {
            width: 25rem;
            max-width: 75%;
        }
        
        .collection .list_item a {
            position: absolute;
            top: 0;
            left: 0;
            z-index: 0;
            width: 100%;
            height: 100%;
            text-indent: -999px;
        }
        
        .collection .popup::before {
            position: absolute;
            z-index: 3;
            display: inline-block;
            top: 0.5rem;
            left: 1rem;
            content:'in 3D';
            color: red;
            font-size: 0.75rem;
            border: solid 1px;
            padding: 0.25rem;
            border-radius: 0.25rem;
        }

        #img {
            width: 55rem;
            max-width: 75%;
        }
        
        #cover {
            background-image: url("3d/logo.png");
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

        #images li:nth-child(n+26) {
            display: none;
        }
        
        #images .list_item {
            position: relative;
            padding: 0;
            margin: 2.5vh 0;
        }
        
        #images .list_item a {
            position: absolute;
            top: 0;
            left: 0;
            z-index: 0;
            width: 100%;
            height: 100%;
            text-indent: -999px;
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
        
        @font-face {
            font-family: "ipag";
            src: url("https://creative-community.space/coding/fontbook/family/IPA/ipag.ttf");
        }
        
        .cc_style,
        form,
        marquee {
            font-family: "ipag", monospace;
            transform: scale(1, 1.25);
        }
        
        .nlc_style,
        h1,
        h2 {
            font-family: 'Times New Roman', serif;
            font-weight: 500;
            font-stretch: condensed;
            font-variant: common-ligatures tabular-nums;
            transform: scale(1, 1.1);
            letter-spacing: -0.1rem;
            word-spacing: -.1ch;
        }
        
        .cc_style,
        .nlc_style {
            display: inline-block;
        }
        
        @font-face {
            font-family: "MS Mincho";
            src: url("https://creative-community.space/coding/fontbook/family/MS%20Mincho.ttf");
        }

        .pehu {
            font-family: "MS Mincho", "SimSong", serif;
        }
        
        .change #main {
            overflow: auto;
        }
        
        .change .mousedragscrollable {
            display: block;
        }
        
        #footer,
        .mousedragscrollable,
        .change #cover,
        .change #greeting,
        .change #server,
        #print {
            display: none;
        }
        
        @media screen and (max-width: 1250px) {
            #images {
                top: 45%;
            }
            #images .list_item {
                margin: 1.75vh 0;
            }
            #main {
                min-height: 77.5vh;
                max-height: 77.5vh;
            }
        }
        
        @media screen and (max-width: 750px) {
            #cover {
                background-size: 100% auto;
            }
            #images {
                top: 40%;
            }
            #images .list_item {
                margin: 1.25vh 0;
            }
            #main {
                min-height: 77.5vh;
                max-height: 77.5vh;
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
            #main {
                min-height: 87vh;
                max-height: 87vh;
            }
        }
    </style>
</head>

<body id="open">

    <header id="header">
        <a class="_more" onclick="more()"><span class="pehu">∧°┐</span> が 所有するもの in 3D</a>
        <marquee id="marquee" onclick="about()">
            ここをクリックすると、<span class="pehu">∧°┐</span> が 所有するもの一覧が表示されます。
        </marquee>
        <nav id="nav">
            <h1>The Things <span class="pehu">∧°┐</span> Own</h1>
            <span id="presents">
                <img src="qr.png" width="50rem">
            </span>
            <form>
                <ol class="search-box">
                    <li>index</li>
                    <li>
                        <input type="radio" name="org" value="bought" id="bought">
                        <label for="bought" class="label">bought</label>
                    </li>
                    <li>
                        <input type="radio" name="org" value="gift" id="gift">
                        <label for="gift" class="label">gift</label>
                    </li>
                    <li>
                        <input type="radio" name="org" value="free" id="free">
                        <label for="free" class="label">free or found</label>
                    </li>
                    <li>
                        <input type="radio" name="org" value="made" id="made">
                        <label for="made" class="label">made</label>
                    </li>
                    <li>
                        <input type="radio" name="org" value="collaborations" id="collaborations">
                        <label for="collaborations" class="label">collaborations</label>
                    </li>
                    <li>
                        <input type="radio" name="org" value="other" id="other">
                        <label for="other" class="label">other</label>
                    </li>
                    <li>
                        <input type="radio" name="org" value="sale" id="sale">
                        <label for="sale" class="label">$$$ FOR SALE $$$</label>
                    </li>
                    <li class="reset">
                        <input type="reset" name="reset" value="View All" class="reset-button cc_style label" onclick="greeting()">
                    </li>
                </ol>
            </form>
        </nav>
    </header>

    <main id="main">
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
            <p class="nlc_style" id="text"></p>
        </div>
        <div id="server">
            <p class="cc_style">
                <?php
                echo 'IP : '. $_SERVER['REMOTE_ADDR']." | ";
                echo 'PORT : '. $_SERVER['REMOTE_PORT']."<br/>";
                echo ''. $_SERVER['HTTP_USER_AGENT'].".";
                ?>
            </p>
        </div>
        <ul class="mousedragscrollable">
            <li id="about" class="collection"></li>
            <li id="entrance" class="collection"></li>
            <li id="books" class="collection"></li>
            <li id="music" class="collection"></li>
            <li id="fashion" class="collection"></li>
            <li id="otobuilding" class="collection"></li>
            <li id="nishitemma" class="collection"></li>
            <li id="niceshopsu" class="collection"></li>
            <li id="img" class="collection"></li>
        </ul>
    </main>

    <footer id="footer">
        <address id="print">
            <span class="cc_style">
                <?php
                echo $_SERVER['SERVER_NAME'];
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
        $("#about").load("3d.html");
        $("#entrance").load("3d/entrance.php");
        $("#books").load("3d/books.php");
        $("#fashion").load("3d/fashion.php");
        $("#music").load("3d/music.php");
        $("#img").load("collection.php");
        $("#otobuilding").load("otobuilding/list.php");
        $("#nishitemma").load("nishitemma/list.php");
        $("#niceshopsu").load("niceshopsu/list.php");
    })

        var volume;
        var synth;
        var notes;

        $(document).ready(function(event) {
            // StartAudioContext(Tone.context, window);  
            $(window).click(function() {
                Tone.context.resume();
            });

            volume = new Tone.Volume(-20);
            synth = new Tone.PolySynth(10, Tone.Synth).chain(volume, Tone.Master);
            notes = Tone.Frequency("E6").harmonize([12, 14, 16, 19, 21, 24]);
        });

    $("#marquee").click(function(e) {
        let randNote = Math.floor(Math.random() * notes.length);
        synth.triggerAttackRelease(notes[randNote], "1");
    });

    $("._more").click(function(e) {
        let randNote = Math.floor(Math.random() * notes.length);
        synth.triggerAttackRelease(notes[randNote], "1");
    });

    $(".label").click(function(e) {
        let randNote = Math.floor(Math.random() * notes.length);
        synth.triggerAttackRelease(notes[randNote], "2n");
    });

    $(".list_item img").hover(function() {
        let randNote = Math.floor(Math.random() * notes.length);
        synth.triggerAttackRelease(notes[randNote], "6n");
    });
</script>
</body>

</html>