<?php
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
$org = (string)filter_input(INPUT_POST, 'org');
$jp = (string)filter_input(INPUT_POST, 'jp');
$en = (string)filter_input(INPUT_POST, 'en');
$text = (string)filter_input(INPUT_POST, 'text');

$fp = fopen('about.csv', 'a+b');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    flock($fp, LOCK_EX);
    fputcsv($fp, [$org, $jp, $en, $text,]);
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
    <link rel="stylesheet" href="/org/index.css" />
    <link rel="stylesheet" href="/org/searchBox.css" />
    <style>
        #about {
            position: relative;
        }

        #about h2 {
            padding: 1rem 1rem 0.25rem;
        }

        #about p {
            font-size: 0.75rem;
            margin: 0;
            padding: 1rem;
            font-weight: 500;
            display: block;
            transform: scale(1, 1.25);
        }
        
        #about p b {
            font-size: 150%;
            display: inline-block;
        }
        
        #about p u {
            float: right;
            font-size: 75%;
            margin: 0;
            padding: 0.125rem 0.25rem;
            text-decoration: none;
            color: #000;
            background: #fff;
            border: solid 1px #aaa;
            border-radius: 0.25rem;
            display: block;
        }
        
        #about .update {
            color:#eee;
            padding: 0.25rem 1rem 1.25rem;
        }
        
        #about .popup::before {
            position: relative;
            z-index: 3;
            display: inline-block;
            content:'in 3D';
            color: red;
            font-size: 0.75rem;
            border: solid 1px;
            padding: 0.25rem;
            border-radius: 0.25rem;
        }
    </style>
</head>

<body>
    <ol id="about" class="org">
        <h2><span class="pehu">∧°┐</span> が 所有するもの</h2>
        <p>このページに、∧° ┐ が 所有するもの（出版物・制作物、ウェブドメイン・デジタルツール、メディアファイルなど）を、記録します。</p>
        <hr/>
        <p>右にスクロールし閲覧できるすべてのリスト内の項目は、統一のカテゴリーによって絞り込むことができます。</p>
        <p><i>リスト内の品目を絞り込むカテゴリーについて</i></p>
        <br/>
        <?php if (!empty($rows)): ?>
        <?php foreach ($rows as $row): ?>
        <li class="list_item list_toggle" data-org="<?=h($row[0])?>">
            <p>
                <u><?=h($row[2])?></u>
                <b><?=h($row[1])?></b>
            </p>
            <p><?=h($row[3])?></p>
        </li>
        <?php endforeach; ?>
        <?php else: ?>
        <?php endif; ?>
        <hr/>
        <br/>
        <h2><span class="pehu">∧°┐</span> が 所有するもの in 3D</h2>
        <p>2022.7.23 - 8.21</p>
        <p>このページに記録したリストのうち、<span class="popup"></span> の 表記があるものを、BnA Alter Meuseum で 展示・販売</p>
        <br/>
        <p><a href="https://creative-community.space/pehu/org/3d/" target="_blank">creative-community.space/pehu/org/3d/</a></p>

    </ol>

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

        $(".list_toggle").hover(function() {
            let randNote = Math.floor(Math.random() * notes.length);
            synth.triggerAttackRelease(notes[randNote], "6n");
        });
    </script>
</body>

</html>