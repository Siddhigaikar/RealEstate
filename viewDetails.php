<?php
session_start();
include 'db.php';

if (!isset($_SESSION["id"])) {
    header("Location:login.php");
    exit();
}

$id = $_GET["id"];
$sql = $conn->prepare("SELECT * FROM properties WHERE id=?");
$sql->bind_param("i", $id);
$sql->execute();
$result = $sql->get_result();
$row = $result->fetch_assoc();
?>

<!doctype html>
<html lang="en">
<head>
    <title>Property Details</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
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
                                <a class="nav-link" href="addProperty.php">Add Property</a>
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

<div class="container mt-4">
    <h2 class="text-center mb-4">Property Details</h2>

    <?php if ($row) { ?>
    <div class="card">
        <img src="uploads/<?php echo $row["image"]; ?>" width="400" height="400" class="card-img-top">

        <div class="card-body">
            <h3><?php echo $row["property_name"]; ?></h3>
            <p><?php echo $row["description"]; ?></p>
            <h4>₹<?php echo $row["price"]; ?></h4>
            <p><b>Location:</b> <?php echo $row["location"]; ?></p>
            <p><b>Property Type:</b> <?php echo $row["property_type"]; ?></p>
            <p><b>Bedrooms:</b> <?php echo $row["bedrooms"]; ?></p>
            <a href="dashboard.php" class="btn btn-dark">Back</a>
        </div>
    </div>
    <?php } else { ?>
        <h4 class="text-center">Property not found</h4>
    <?php } ?>
</div>

</body>
</html>
