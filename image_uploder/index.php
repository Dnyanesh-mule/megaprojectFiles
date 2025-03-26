<?php
require 'config.php';

// Handle image deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    
    try {
        $stmt = $pdo->prepare("DELETE FROM images WHERE id = ?");
        $stmt->execute([$id]);
        $success = "Image deleted successfully!";
    } catch (PDOException $e) {
        $error = "Database error: " . $e->getMessage();
    }
}

// Fetch all images
try {
    $stmt = $pdo->query("SELECT id, name, mime_type, size, created_at FROM images ORDER BY created_at DESC");
    $images = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Database error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .thumbnail {
            max-width: 100px;
            max-height: 100px;
        }
        .action-links a {
            margin-right: 10px;
        }
        .success {
            color: green;
            margin: 10px 0;
        }
        .error {
            color: red;
            margin: 10px 0;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Image Management System</h1>
        
        <?php if (isset($success)): ?>
            <div class="success"><?= $success ?></div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
        
        <h2>Upload New Image</h2>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Image Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="image">Select Image:</label>
                <input type="file" id="image" name="image" accept="image/*" required>
            </div>
            <button type="submit">Upload Image</button>
        </form>
        
        <h2>Image Gallery</h2>
        <?php if (count($images) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Thumbnail</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Size (KB)</th>
                        <th>Uploaded</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($images as $image): ?>
                        <tr>
                            <td><?= $image['id'] ?></td>
                            <td><img src="view_image.php?id=<?= $image['id'] ?>" class="thumbnail" alt="Thumbnail"></td>
                            <td><?= htmlspecialchars($image['name']) ?></td>
                            <td><?= $image['mime_type'] ?></td>
                            <td><?= round($image['size'] / 1024, 2) ?></td>
                            <td><?= $image['created_at'] ?></td>
                            <td class="action-links">
                                <a href="view_image.php?id=<?= $image['id'] ?>" target="_blank">View</a>
                                <a href="index.php?delete=<?= $image['id'] ?>" onclick="return confirm('Are you sure you want to delete this image?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No images found in the database.</p>
        <?php endif; ?>
    </div>
</body>
</html>