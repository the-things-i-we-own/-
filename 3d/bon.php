<?php
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
$org = (string)filter_input(INPUT_POST, 'org');
$title = (string)filter_input(INPUT_POST, 'title');
$text = (string)filter_input(INPUT_POST, 'text');
$link = (string)filter_input(INPUT_POST, 'link');

$fp = fopen('bon.csv', 'a+b');
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

        #bon {
            position: relative;
            color: var(--text-color);
            background-color: var(--about-bg);
        }

        #bon hr {
            margin: 2rem 0 1rem;
            border: none;
            border-bottom: var(--border-style);
        }

        #bon h2 {
            padding: 1rem 1rem 0.25rem;
        }

        .none {
            display:none;
        }

        #bon p {
            font-size: 0.75rem;
            margin: 0;
            padding: 0.5rem 0.5rem 0.5rem 1rem;
            font-weight: 500;
            display: block;
            transform: scale(1, 1.25);
        }
        
        #bon p a {
            display: inline-block;
            margin-left: 0.25rem;
            color: var(--about-a);
            text-decoration: var(--about-decoration);
        }
        
        #bon p b {
            font-size: 150%;
            display: inline-block;
        }
        
        #bon p u {
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
    <ol id="bon" class="org">
        <h2>令和四年版　夏の自由研究</h2>
        <p>2022年8月13日(土) - 16日(火)</p>
        <hr/>
        <p>∧° ┐が BnA Alter Museum に滞在し、夏の自由研究を実施しました。</p>
        <?php if (!empty($rows)): ?>
        <?php foreach ($rows as $row): ?>
        <li class="list_item list_toggle" data-org="<?=h($row[0])?>">
            <p>
                <u><?=h($row[0])?></u>
                <b><?=h($row[1])?></b>
            </p>
            <p><?=h($row[2])?>
            <a class="<?=h($row[4])?>" href="<?=h($row[3])?>" target="_blank">もっと詳しく</a></p>
        </li>
        <?php endforeach; ?>
        <?php else: ?>
        <li class="list_item list_toggle" data-org="test">
            <p>
                <u>ORG</u>
                <b>カテゴリ名</b>
            </p>
            <p>カテゴリの説明</p>
        </li>
        <?php endif; ?>
    </ol>

    <script src="index.js"></script>
</body>

</html>
