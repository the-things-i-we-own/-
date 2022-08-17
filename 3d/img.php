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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="index.js"></script>
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
            -webkit-justify-content: space-between;
            justify-content: space-between;
            -webkit-align-items: stretch;
            align-items: stretch;
            -webkit-flex-wrap: wrap-reverse;
            flex-wrap: wrap-reverse;
            list-style-type: none;
            padding: 0 0 2rem;
        }

        #collection h2 {
            padding: 1rem 1rem 0.25rem;
        }
        
        #collection li {
            text-shadow: 0.1rem 0.1rem 0.1rem #fff;
            font-size: 0.55rem;
            position: relative;
            padding: 0;
            margin: 1rem;
            width: 10rem;
            height: 10rem;
            max-width: 100%;
            max-height: 100%;
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
        
        #collection .update {
            color: var(--update-text);
            padding: 0.25rem 1rem 1.25rem;
        }
        
        @media screen and (max-width: 750px) {
            #collection {
                -webkit-justify-content: center;
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <ol id="collection" class="org">
        <?php if (!empty($rows)): ?>
        <?php foreach ($rows as $row): ?>
        <li class="list_item list_toggle" data-org="<?=h($row[0])?>">
            <img src="<?=h($row[2])?>">
            <p><b><?=h($row[3])?></b><br/><?=h($row[4])?></p>
        </li>
        <?php endforeach; ?>
        <?php else: ?>
        <li class="list_item list_toggle min" data-org="test">
            <img src="/logo.png">
            <p><b>品目</b><br/>説明文</p>
        </li>
        <?php endif; ?>
    </ol>
</body>
</html>