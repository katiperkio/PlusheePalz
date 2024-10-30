/* $sql = "SELECT palz.id, palz.name, palz.description, palz.age, palz.image_url,
COALESCE(COUNT(user_likes.palz_id), 0) AS like_count
FROM palz
LEFT JOIN user_likes ON palz.id = user_likes.palz_id
WHERE palz.status = 'published'
GROUP BY palz.id";

// $sql = "SELECT id, name, description, age, image_url FROM palz WHERE status='published'";
$result = mysqli_query($connection, $sql); */