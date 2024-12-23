<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>訪れた都道府県</title>
<style>
    body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4; /* 背景色 */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* ビューポートの高さ */
        }
        .title-container {
            display: flex;
            text-align: center;
            justify-content: center;
        }

        h1 {
            text-align: center;
            color: #333; /* 見出しの文字色 */
            size: 10px;
        }
        form {
            background-color: #fff; /* フォーム背景色 */
            padding: 20px;
            border-radius: 8px; /* 角丸 */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* 影を追加 */
            text-align: center;
        }

</style>
</head>
<body>
    <div id="title-container">
    <h1>訪れた都道府県🗾を登録</h1>
    <form action="confirm.php" method="POST"> 
        都道府県：<input type="text" name="prefecture" placeholder="例: 東京都" required> 
        <input type="submit" value="登録"> 
    </form>
    </div>

</body>
</html>
