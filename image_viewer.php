<?php
// Include the database configuration file
require 'img_con.php';

// Fetch Images
$sql = "SELECT * FROM images";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Gallery</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        .image-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }
        .image-card {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            text-align: center;
        }
        .image-preview {
            max-width: 100%;
            height: auto;
            border-radius: 4px;
        }
        .no-images {
            text-align: center;
            padding: 20px;
            color: #666;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Image Gallery</h1>
        
        <?php if ($result && $result->num_rows > 0): ?>
            <div class="image-gallery">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="image-card">
                        <?php 
                        // Display the image directly from BLOB data
                        echo '<img src="data:'.$row['mime_type'].';base64,'.base64_encode($row['image_data']).'" class="image-preview" alt="'.$row['name'].'">';
                        ?>
                        <h3><?= htmlspecialchars($row['name']) ?></h3>
                        <!-- <p>Type: <?= htmlspecialchars($row['mime_type']) ?></p>
                        <p>Size: <?= round($row['size'] / 1024, 2) ?> KB</p> -->
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="no-images">
                <p>No images found in the database.</p>
            </div>
        <?php endif; ?>
    </div>
    <?php 
    // Close connection
    if (isset($conn)) {
        $conn->close();
    }
    ?>
</body>
</html>