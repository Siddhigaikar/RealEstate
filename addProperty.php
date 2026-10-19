<?php
session_start();
include 'db.php';
if(!isset($_SESSION["id"])){
    header("Location:login.php");
    exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $property_name = $_POST["property_name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $location = $_POST["location"];
    $property_type = $_POST["property_type"];
    $bedrooms = $_POST["bedrooms"];
    $image = $_FILES["image"]["name"];
    $user_id = $_SESSION["id"];

    if (!is_dir("uploads")) {
        mkdir("uploads", 0777, true);
    }

    if (move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/" . $image)) {

        $sql = $conn->prepare("INSERT INTO properties(property_name, description, price, location, property_type, bedrooms, image, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        $sql->bind_param("ssdssisi", $property_name, $description, $price, $location, $property_type, $bedrooms, $image, $user_id);

        if ($sql->execute()) {
            header("Location:dashboard.php");
            exit();
        } else {
            die("Insert failed: " . $sql->error);
        }
    }else {
        echo "Image upload failed";
    }

}
?>


<!doctype html>
<html lang="en">
<head>
    <title>Add Menu</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body>

<header>
            <nav
                class="navbar navbar-expand-sm navbar-dark bg-dark"
            >
                <div class="container">
                    <a class="navbar-brand" href="#">RealEstate</a>
                    <button
                        class="navbar-toggler d-lg-none"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapsibleNavId"
                        aria-controls="collapsibleNavId"
                        aria-expanded="false"
                        aria-label="Toggle navigation"
                    >
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="collapsibleNavId">
                        <ul class="navbar-nav me-auto mt-2 mt-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" href="#" aria-current="page"
                                    >Hello <?php echo $_SESSION["name"];?>
                                    <span class="visually-hidden">(current)</span></a
                                >
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="dashboard.php">Home</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link active" href="addProperty.php">Add Property</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="viewProperties.php">View Properties</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="pdf.php">Export Data</a>
                            </li>
                            
                        </ul>
                        <form class="d-flex" action="logout.php">
                            <button class="btn btn-outline-success">Logout</button>
                        </form>
                        
                    </div>
                </div>
            </nav>
            
        </header>

<main>
    <div class="container mt-4">
        <h3 class="text-center">Add Property</h3>

        <div class="container border shadow rounded col-md-6 p-4">
            <form method="POST" enctype="multipart/form-data">

                <div class="mb-3">
                    <label class="form-label">Property Name</label>
                    <input type="text" class="form-control" name="property_name" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" name="description" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Price</label>
                    <input type="number" class="form-control" name="price" step="0.01" min="0.01" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Location</label>
                    <input type="text" class="form-control" name="location" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Property Type</label>
                    <select class="form-select" name="property_type" required>
                        <option value="">Select Property Type</option>
                        <option value="Apartment">Apartment</option>
                        <option value="House">House</option>
                        <option value="Villa">Villa</option>
                        <option value="Commercial">Commercial</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Bedrooms</label>
                    <input type="number" class="form-control" name="bedrooms" min="0" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Property Image</label>
                    <input type="file" class="form-control" name="image" accept="image/*" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Add Property</button>

            </form>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>