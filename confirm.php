<?php
// セッション開始
session_start();

// POST データを受け取り
$selectedPrefecture = $_POST['prefecture']?? null;

// セッションに登録済みの都道府県を保持。それをJava Script に渡す
if ($selectedPrefecture) {
    // 既に登録済みなら訪問回数を増加
    if (isset($_SESSION['visited_prefectures'][$selectedPrefecture])) {
        $_SESSION['visited_prefectures'][$selectedPrefecture] ++;
    } else {
        $_SESSION['visited_prefectures'][$selectedPrefecture] = 1;
    }
}

// 都道府県名とID 対応リスト
$prefectureIdMap = [
    "北海道" => "hokkaido",
    "青森" => "aomori",
    "岩手" => "iwate",
    "宮城" => "miyagi",
    "秋田" => "akita",
    "山形" => "yamagata",
    "福島" => "fukushima",
    "茨城" => "ibaraki",
    "栃木" => "tochigi",
    "群馬" => "gunma",
    "埼玉" => "saitama",
    "千葉" => "chiba",
    "東京" => "tokyo",
    "神奈川" => "kanagawa",
    "新潟" => "niigata",
    "富山" => "toyama",
    "石川" => "ishikawa",
    "福井" => "fukui",
    "山梨" => "yamanashi",
    "長野" => "nagano",
    "岐阜" => "gifu",
    "静岡" => "shizuoka",
    "愛知" => "aichi",
    "三重" => "mie",
    "滋賀" => "shiga",
    "京都" => "kyoto",
    "大阪" => "osaka",
    "兵庫" => "hyogo",
    "奈良" => "nara",
    "和歌山" => "wakayama",
    "鳥取" => "tottori",
    "島根" => "shimane",
    "岡山" => "okayama",
    "広島" => "hiroshima",
    "山口" => "yamaguchi",
    "徳島" => "tokushima",
    "香川" => "kagawa",
    "愛媛" => "ehime",
    "高知" => "kochi",
    "福岡" => "fukuoka",
    "佐賀" => "saga",
    "長崎" => "nagasaki",
    "熊本" => "kumamoto",
    "大分" => "oita",
    "宮崎" => "miyazaki",
    "鹿児島" => "kagoshima",
    "沖縄" => "okinawa"
];

// 初期化
$selectedPrefectureId = null;

// POST で受け取った都道府県を対応リストで変換
if ($selectedPrefecture && isset ($prefectureIdMap[$selectedPrefecture])) {
    $selectedPrefectureId = $prefectureIdMap[$selectedPrefecture];
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>訪れた都道府県</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        #map {
            width: 80%;
            height: 500px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <h1>登録された都道府県: <?= htmlspecialchars($selectedPrefecture) ?></h1>
    <p><a href="index.php">登録フォームに戻る</a></p>

    <!-- 地図表示用のdiv -->
    <div id="map"></div>

    <script>
        // PHPからJava Script へ渡す処理
        var visitedPrefectures = <?= json_encode($_SESSION['visited_prefectures'] ?? []) ?>;

        // 地図を初期化
        var map = L.map('map').setView([36.2048, 138.2529], 5); // 日本の中心

        // タイルレイヤーを追加
       L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // 都道府県のGeoJSONデータを読み込む
        fetch('japan.geojson')
            .then(response => response.json())
            .then(data => {
                L.geoJSON(data, {
                    onEachFeature: function (feature, layer) {
                        // 都道府県名
                        var prefectureName = feature.properties.nam_ja;

                        // 訪問回数に応じて色の濃さを変える
                        if (visitedPrefectures[prefectureName]) {
                            var visitCount = visitedPrefectures[prefectureName];
                            var opacity = Math.min(0.3 + visitCount * 0.1, 1); //Max1

                            layer.setStyle({
                                fillColor: "pink",
                                weight: 1,
                                fillOpacity: opacity
                            });
                        }
                    }
                }).addTo(map);
            })
            .catch(error => console.error("GeoJSONの読み込みエラー:", error));
    </script>


</body>
</html>