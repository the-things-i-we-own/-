<?php
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
$org = (string)filter_input(INPUT_POST, 'org');
$name = (string)filter_input(INPUT_POST, 'name');
$text = (string)filter_input(INPUT_POST, 'text');
$done = (string)filter_input(INPUT_POST, 'done');

$fp = fopen('list.csv', 'a+b');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    flock($fp, LOCK_EX);
    fputcsv($fp, [$org, $name, $text, $done]);
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

        .org hr {
            margin: 2rem 0 1rem;
            border: none;
            border-bottom: var(--border-style);
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
        
        .org .popup::before {
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
    <ol class="org">
        <h2>搬出</h2>
        <p>2022年8月22日(月) - 8月23日(火)</p>
        <hr/>
        <?php if (!empty($rows)): ?>
        <?php foreach ($rows as $row): ?>
        <li class="list_item list_toggle <?=h($row[3])?>" data-org="<?=h($row[0])?>">
            <p>
                <u><?=h($row[0])?></u>
                <b><?=h($row[1])?></b>
            </p>
            <p><?=h($row[2])?></p>
        </li>
        <?php endforeach; ?>
        <?php else: ?>
        <?php endif; ?>
    </ol>
</body>

</html>
