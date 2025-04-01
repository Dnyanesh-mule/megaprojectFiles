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
            cursor: pointer;
        }
        .no-images {
            text-align: center;
            padding: 20px;
            color: #666;
            font-style: italic;
        }

        /* Lightbox Modal Style */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            max-width: 90%;
            max-height: 90%;
        }
        .modal img {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }
        .modal-close {
            position: absolute;
            top: 20px;
            right: 20px;
            color: white;
            font-size: 30px;
            cursor: pointer;
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
                        <a href="javascript:void(0);" onclick="openModal('<?php echo 'data:'.$row['mime_type'].';base64,'.base64_encode($row['image_data']); ?>')">
                            <img src="data:<?php echo $row['mime_type']; ?>;base64,<?php echo base64_encode($row['image_data']); ?>" class="image-preview" alt="<?php echo htmlspecialchars($row['name']); ?>">
                        </a>
                        <h3><?= htmlspecialchars($row['name']) ?></h3>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="no-images">
                <p>No images found in the database.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Lightbox Modal -->
    <div id="imageModal" class="modal">
        <span class="modal-close" onclick="closeModal()">&times;</span>
        <div class="modal-content">
            <img id="modalImage" src="" alt="Large Image">
        </div>
    </div>

    <script>
        // Open the modal and display the clicked image
        function openModal(imageData) {
            const modal = document.getElementById("imageModal");
            const modalImage = document.getElementById("modalImage");
            modal.style.display = "flex";
            modalImage.src = imageData;
        }

        // Close the modal
        function closeModal() {
            const modal = document.getElementById("imageModal");
            modal.style.display = "none";
        }

        // Close the modal if clicked outside the image
        window.onclick = function(event) {
            const modal = document.getElementById("imageModal");
            if (event.target === modal) {
                modal.style.display = "none";
            }
        }
    </script>

    <?php 
    // Close connection
    if (isset($conn)) {
        $conn->close();
    }
    ?>
</body>
</html>
