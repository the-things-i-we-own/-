<?php
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
$org = (string)filter_input(INPUT_POST, 'org');
$name = (string)filter_input(INPUT_POST, 'name');
$text = (string)filter_input(INPUT_POST, 'text');

$fp = fopen('list.csv', 'a+b');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    flock($fp, LOCK_EX);
    fputcsv($fp, [$org, $name, $text]);
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

        .org {
            position: relative;
            color: var(--list-text);
            background-color: var(--list-bg);
        }

        .org h2 {
            padding: 1rem 1rem 0.25rem;
        }

        .org p {
            font-size: 0.75rem;
            margin: 0;
            padding: 0.25rem 0.5rem;
            font-weight: 500;
            display: block;
            transform: scale(1, 1.25);
        }

        .org p b {
            font-size: 150%;
            display: inline-block;
        }

        .org p u {
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

        .org .update {
            color: var(--update-text);
            padding: 0.25rem 1rem 1.25rem;
        }
    </style>
</head>

<body>
    <ol class="org">
        <h2>2022年8月13日(土)</h2>
        <p class="update">
        Last Modified : 
            <?php
            $mod = filemtime('list.csv');
            date_default_timezone_set('Asia/Tokyo');
            print "".date("r",$mod);
            ?>
        </p>
        <?php if (!empty($rows)): ?>
        <?php foreach ($rows as $row): ?>
        <li class="list_item list_toggle" data-org="<?=h($row[0])?>">
            <p>
                <u><?=h($row[0])?></u>
                <b><?=h($row[1])?></b>
            </p>
            <p><?=h($row[2])?></p>
        </li>
        <?php endforeach; ?>
        <?php else: ?>
        <li class="list_item list_toggle" data-org="test">
            <p>
                <u>品種</u>
                <b>品目</b>
            </p>
            <p>説明文</p>
        </li>
        <?php endif; ?>
    </ol>
</body>

</html>
