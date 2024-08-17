<?php
// index.php
require 'config.php';

$stmt = $pdo->query("SELECT * FROM videos ORDER BY published_at DESC");
$videos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouTube Videos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
        }
        .container {
            width: 80%;
            max-width: 800px;
        }
        .video {
            margin-bottom: 20px;
            background: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .video h3 {
            margin: 10px 0;
        }
        .video p {
            color: #555;
        }
        .custom-player {
            position: relative;
            width: 100%;
            height: 315px;
            overflow: hidden;
            background: #000;
            border-radius: 8px;
        }
        .custom-player iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }
        .player-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 18px;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>YouTube Videos</h1>

        <?php if (empty($videos)): ?>
            <p>No videos available.</p>
        <?php else: ?>
            <?php foreach ($videos as $video): ?>
                <div class="video">
                    <h3><?= htmlspecialchars($video['title']) ?></h3>
                    <div class="custom-player">
                        <iframe id="player-<?= htmlspecialchars($video['video_id']) ?>" src="https://www.youtube.com/embed/<?= htmlspecialchars($video['video_id']) ?>?autoplay=0&controls=0&modestbranding=1&rel=0" allowfullscreen></iframe>
                        <div class="player-overlay" onclick="playVideo('player-<?= htmlspecialchars($video['video_id']) ?>')">Watch Video</div>
                    </div>
                    <p><?= htmlspecialchars($video['description']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>

    <script>
        function playVideo(playerId) {
            var iframe = document.getElementById(playerId);
            var src = iframe.src;
            iframe.src = src + "&autoplay=1"; // Append autoplay parameter to start video
            document.querySelector(`#${playerId} ~ .player-overlay`).style.display = 'none'; // Hide overlay
        }
    </script>
</body>
</html>
