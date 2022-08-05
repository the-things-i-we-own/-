<?php
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
$org = (string)filter_input(INPUT_POST, 'org');
$size = (string)filter_input(INPUT_POST, 'size');
$img = (string)filter_input(INPUT_POST, 'img');
$title = (string)filter_input(INPUT_POST, 'title');
$text = (string)filter_input(INPUT_POST, 'text');

$fp = fopen('popup.csv', 'a+b');
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
    <title>Things that I (We) owned, in 3D</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="popup.css" />
    <style>
        body,
        ol,
        li {
            padding: 0;
            margin: 0;
        }
        
        #collection {
            display: -webkit-flex;
            display: flex;
            -webkit-justify-content: center;
            justify-content: center;
            -webkit-align-items: center;
            align-items: center;
            -webkit-flex-wrap: wrap;
            flex-wrap: wrap;
            list-style-type: none;
        }
        
        #collection li p b {
            font-family: 'Times New Roman', serif;
            font-weight: 500;
            font-stretch: condensed;
            font-variant: common-ligatures tabular-nums;
            transform: scale(1, 1.1);
            letter-spacing: -0.1rem;
            word-spacing: -.1ch;
        }
        
        #infomation,
        #collection li p {
            font-family: "ipag", monospace;
            transform: scale(1, 1.25);
        }
        
        #infomation {
            font-size: 0.75rem;
            line-height: 150%;
            padding: 0.5rem 1rem;
        }
        
        #collection {
            padding: 1rem 0 2.5rem;
        }
        
        #collection li {
            color: #333;
            text-shadow: 0.1rem 0.1rem 0.1rem #fff;
            font-size: 0.55rem;
            position: relative;
            padding: 0;
            margin: 1vw;
            width: 10rem;
            height: 10rem;
            max-width: 95vw;
            max-height: 95vw;
            transition: all 1000ms ease;
        }
        
        #collection li img {
            width: 75%;
            position: absolute;
            top: 50%;
            left: 50%;
            -webkit-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
            pointer-events: none;
            user-select: none;
        }
        
        #collection li p {
            padding: 0.25rem;
            margin: 0;
            position: absolute;
            z-index: 5;
            bottom: 0;
            left: 0;
            pointer-events: none;
            user-select: none;
        }
        
        #collection li p b {
            font-size: 150%;
            display: inline-block;
            padding: 0;
            margin: 0.5rem 0;
        }
        
        #collection li:hover p {
            display: block;
        }
    </style>
</head>

<body>
    <p id="infomation">
        <u>The Things I (We) Own, in 3D</u><br/>
        <sup>※ メインビジュアルに掲載した所有するもの一覧</sup>
    </p>
        <ol id="collection" class="org">
            <?php if (!empty($rows)): ?>
            <?php foreach ($rows as $row): ?>
            <li class="list_item list_toggle" data-org="<?=h($row[0])?>">
                <img src="<?=h($row[2])?>">
                <p>
                    <b><?=h($row[3])?></b>
                    <br/>
                    <?=h($row[4])?>
                </p>
            </li>
            <?php endforeach; ?>
            <?php else: ?>
            <li class="list_item list_toggle min" data-org="test">
                <img src="/logo.png">
            </li>
            <?php endif; ?>
        </ol>
    <p id="infomation">
        <sup>※ ポップアップ「The Things I (We) Own, in 3D」では、この一覧（メインビジュアル）に掲載したもの以外にも、たくさんのものを発表／展示／販売します。</sup>
    </p>

<script type="text/javascript ">
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

    $(".list_item").hover(function() {
        let randNote = Math.floor(Math.random() * notes.length);
        synth.triggerAttackRelease(notes[randNote], "6n");
    });
</script>
</body>
</html>