<?php
session_start();
include 'db.php';

if (!isset($_SESSION["id"])) {
    header("Location:login.php");
    exit();
}

if (isset($_GET["id"])) {

    $id = $_GET["id"];

    $sql = $conn->prepare("SELECT * FROM properties WHERE id=? AND user_id=?");
    $sql->bind_param("ii", $id, $_SESSION["id"]);
    $sql->execute();

    $result = $sql->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        die("Property not found");
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id = $_POST["id"];
    $property_name = $_POST["property_name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $location = $_POST["location"];
    $property_type = $_POST["property_type"];
    $bedrooms = $_POST["bedrooms"];
    $image = $_POST["old_image"];

    if ($_FILES["image"]["name"] != "") {

        $image = $_FILES["image"]["name"];

        if (move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/" . $image)) {

            if ($_POST["old_image"] != "" && file_exists("uploads/" . $_POST["old_image"])) {
                unlink("uploads/" . $_POST["old_image"]);
            }

        } else {
            die("Image upload failed");
        }
    }

    $sql = $conn->prepare("UPDATE properties SET property_name=?, description=?, price=?, location=?, property_type=?, bedrooms=?, image=? WHERE id=? AND user_id=?");
    $sql->bind_param("ssdssisii", $property_name, $description, $price, $location, $property_type, $bedrooms, $image, $id, $_SESSION["id"]);

    if ($sql->execute()) {
        header("Location:dashboard.php");
        exit();
    } else {
        die("Update failed: " . $sql->error);
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <title>Edit Menu Item</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-4">
    <h3 class="text-center">Edit Property</h3>

    <div class="border shadow rounded col-md-6 p-4 mx-auto">
        <form method="POST" enctype="multipart/form-data">

            <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
            <input type="hidden" name="old_image" value="<?php echo $row["image"]; ?>">

            <div class="mb-3">
                <label class="form-label">Property Name</label>
                <input type="text" class="form-control" name="property_name"
                       value="<?php echo $row["property_name"]; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea class="form-control" name="description" required><?php echo $row["description"]; ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Price</label>
                <input type="number" class="form-control" name="price"
                       value="<?php echo $row["price"]; ?>" step="0.01" min="0.01" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Property Type</label>
                <select class="form-select" name="property_type" required>
                    <option value="Apartment" <?php if ($row["property_type"] == "Apartment") echo "selected"; ?>>Apartment</option>
                    <option value="House" <?php if ($row["property_type"] == "House") echo "selected"; ?>>House</option>
                    <option value="Villa" <?php if ($row["property_type"] == "Villa") echo "selected"; ?>>Villa</option>
                    <option value="Commercial" <?php if ($row["property_type"] == "Commercial") echo "selected"; ?>>Commercial</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Bedrooms</label>
                <input type="number" class="form-control" name="bedrooms"
                       value="<?php echo $row["bedrooms"]; ?>" min="0" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Current Image</label><br>
                <img src="uploads/<?php echo $row["image"]; ?>" width="100" alt="Current property image">
            </div>

            <div class="mb-3">
                <label class="form-label">Change Image (Optional)</label>
                <input type="file" class="form-control" name="image" accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary w-100">Update Property</button>
            <a href="dashboard.php" class="btn btn-secondary w-100 mt-2">Cancel</a>

        </form>
    </div>
</div>

</body>
</html>