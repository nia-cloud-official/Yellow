<?php
// fetch_videos.php

require 'config.php';

function fetchYouTubeVideos($query) {
    $apiKey = YOUTUBE_API_KEY;
    $url = "https://www.googleapis.com/youtube/v3/search?part=snippet&q=" . urlencode($query) . "&type=video&key=" . $apiKey;

    $response = file_get_contents($url);
    if ($response === FALSE) {
        die('Error fetching data from YouTube API');
    }
    
    return json_decode($response, true);
}

function storeVideo($pdo, $video) {
    $stmt = $pdo->prepare("INSERT INTO videos (video_id, title, description, thumbnail_url, published_at) VALUES (:video_id, :title, :description, :thumbnail_url, :published_at) ON DUPLICATE KEY UPDATE title = :title, description = :description, thumbnail_url = :thumbnail_url, published_at = :published_at");

    $stmt->execute([
        ':video_id' => $video['id']['videoId'],
        ':title' => $video['snippet']['title'],
        ':description' => $video['snippet']['description'],
        ':thumbnail_url' => $video['snippet']['thumbnails']['high']['url'],
        ':published_at' => date('Y-m-d H:i:s', strtotime($video['snippet']['publishedAt']))
    ]);
}

// Fetch and store videos
$videos = fetchYouTubeVideos('Zimbabwe');
foreach ($videos['items'] as $video) {
    storeVideo($pdo, $video);
}

echo "Videos fetched and stored successfully.";
?>
