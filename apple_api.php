<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>App Store API</title>
    </head>
    <body>
        <h1>Apple - App Store API</h1>
        <hr>
        <?php
        $params = Array(
            'country' => 'jp',
            'entity' => 'software',
            'term' => 'todo',
        );
        $data = api('https://itunes.apple.com/search?', $params);

        /**
         * APIを叩いてJSONリターン
         */
        function api($uri, $params) {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $uri . http_build_query($params));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $res = curl_exec($curl);
            $header = curl_getinfo($curl);
            if ($header["http_code"] >= 400) {
                echo $res;
                exit();
            }

            return json_decode($res, true);
        }
        ?>
        <h2>所持カラム</h2>
        <div>
            <?php foreach ($data['results'][0] as $key => $value): ?>
                <p><?php echo $key; ?></p>
            <?php endforeach; ?>
        </div>
        <hr>

        <h3>該当件数：<?php echo $data['resultCount']; ?>件</h3>
        <?php foreach ($data['results'] as $value): ?>
            <div style="float: left;">
                <img src="<?php echo $value['artworkUrl60']; ?>" style="width:64px; height:64px; vertical-align: middle;">
            </div>
            <div style="float: left;">
                <?php echo "【{$value['genres'][0]}】" . ($value['price'] == 0 ? "(無料)" : '(' . $value['price'] . '円)'); ?><br />

                <?php echo "{$value['trackName']}"; ?>
            </div>
            <div style="clear: both;"></div>
        <?php endforeach; ?>
    </body>
</html>
