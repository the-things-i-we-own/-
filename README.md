<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">

    <!--meta-->
    <meta content="website" property="og:type">
    <title>ページタイトル</title>
    <meta content="ページタイトル" property="og:title">
    <meta content="このページについて" name="description">
    <meta content="このページについて" name="og:description">
    <meta content="著者" name="author">
    <meta content="Eメール" name="reply-to">

    <!--meta for Twitter-->
    <meta content="summary_large_image" name="twitter:card">
    <meta content="ページのURL" property="og:url">
    <meta content="カバー画像のURL" property="og:image">
    <meta content="カバー画像のURL" name="twitter:image:src">

    <link rel="icon" href="アイコン画像.png">
    <link rel="stylesheet" type="text/css" href="stylesheet.css">

    <!--https://the-things-i-we-own.github.io/-->
    <link href="https://the-things-i-we-own.github.io/css/org.css" rel="stylesheet" type="text/css">
    <link href="https://the-things-i-we-own.github.io/css/cover.css" rel="stylesheet" type="text/css">
    <link href="https://the-things-i-we-own.github.io/css/index.css" rel="stylesheet" type="text/css">
    <script src="https://the-things-i-we-own.github.io/js/script.js"></script>
    <script src="https://the-things-i-we-own.github.io/js/org.js"></script>
    <script src="https://the-things-i-we-own.github.io/js/cover.js"></script>
    <script src="https://the-things-i-we-own.github.io/index.js"></script>
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function () {
            headToBody();
            coverJson('json/cover.json');
            readmeMD('README.md', '#readme');

            thingsJSON('〇〇.json');
        });
    </script>
</head>

<body>
    <header>
        <h1 id="title">The Things I (We) Own</h1>
        <h2 id="description" onclick="changeMain()">所有するもの を カテゴリー・状態 ごとに 整理して記録する</h2>
        <nav id="org">
            <input id="all" value="all" type="radio" name="org" checked>
            <label for="all" data-txt="絞り込み項目について">Index</label>
        </nav>
    </header>
    <main id="cover">
        <h3 id="readme"></h3>
        <ul id="img"></ul>
    </main>
    <main id="things" hidden>
        <ul id="about"></ul>
    </main>
    <footer>
        <p>
            <span>Author</span> <b id="author"></b><br />
            <span>Email</span> <a id="email"></a>
        </p>
        <p id="lastModified">
            <span>Last Modified</span> <time></time><br />
            <span>Links</span>
            <a href="https://github.com/the-things-i-we-own/" target="_blank">GitHub</a>
        </p>
    </footer>
</body>

</html>
