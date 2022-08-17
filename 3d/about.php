<?php
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
$org = (string)filter_input(INPUT_POST, 'org');
$title = (string)filter_input(INPUT_POST, 'title');
$text = (string)filter_input(INPUT_POST, 'text');
$link = (string)filter_input(INPUT_POST, 'link');

$fp = fopen('about.csv', 'a+b');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    flock($fp, LOCK_EX);
    fputcsv($fp, [$org, $title, $text,]);
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        :root {
            --about-bg: transparent;
            --about-decoration: blue wavy underline;
            --about-a: blue;
        }

        #about {
            position: relative;
            color: var(--text-color);
            background-color: var(--about-bg);
        }

        #about hr {
            margin: 2rem 0 1rem;
            border: none;
            border-bottom: var(--border-style);
        }

        #about h2 {
            padding: 1rem 1rem 0.25rem;
        }

        .none {
            display:none;
        }

        #about p {
            font-size: 0.75rem;
            margin: 0;
            padding: 0.5rem 0.5rem 0.5rem 1rem;
            font-weight: 500;
            display: block;
            transform: scale(1, 1.25);
        }
        
        #about p a {
            display: inline-block;
            margin-left: 0.25rem;
            color: var(--about-a);
            text-decoration: var(--about-decoration);
        }
        
        #about p b {
            font-size: 150%;
            display: inline-block;
        }
        
        #about p u {
            float: right;
            text-transform: uppercase;
            font-size: 75%;
            margin: 0;
            padding: 0.125rem 0.25rem;
            text-decoration: none;
            color: var(--org-text);
            background-color: var(--org-bg);
            border: var(--org-border);
            border-radius: 0.25rem;
            display: block;
        }
    </style>
</head>

<body>
    <ol id="about" class="org">
        <p>2022.7.23 - 8.21<u>BnA Alter Meuseum</u></p>
        <h2><span class="pehu">∧°┐</span> が 所有するもの in 3D</h2>
        <a href="https://bnaaltermuseum.com/event/the-things-i-we-own/" target="_blank"><img src="logo.png" width="100%"></a>
        <br/>
        <p>会場：BnA Alter Museum 
        <a href="https://g.page/BnAAlterMuseum?share" target="_blank">Google Map</a>
        <u>入場無料／会期中無休</u></p>
        <hr/>
        <p><span class="pehu">∧°┐</span> が BnA Alter Museum に滞在／作業する日程</p>
        <br/>
        <?php if (!empty($rows)): ?>
        <?php foreach ($rows as $row): ?>
        <li>
            <p>
                <u><?=h($row[0])?></u>
                <b><?=h($row[1])?></b>
            </p>
            <p><?=h($row[2])?>
        </li>
        <?php endforeach; ?>
        <?php else: ?>
        <?php endif; ?>
    </ol>

    <script src="index.js"></script>
</body>

</html>
