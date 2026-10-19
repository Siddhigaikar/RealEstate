<?php
session_start();
include 'db.php';
if(!isset($_SESSION["id"])){
    header("Location:login.php");
    exit();
}
$search = "";

if (isset($_GET["search"])) {
    $search = $_GET["search"];
    $sql = $conn->prepare("SELECT * FROM properties WHERE property_name LIKE ? OR location LIKE ?");
    $search = "%".$search."%";
    $sql->bind_param("ss", $search, $search);
    $sql->execute();
    $result = $sql->get_result();
} else {
    $result = $conn->query("SELECT * FROM properties");
}


?>

<!doctype html>
<html lang="en" data-bs-theme="light">
    <head>
        <title>Title</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <!-- Bootstrap CSS v5.3.8 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
            crossorigin="anonymous"
        />
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
        <main>
            <div
                class="container mt-3"
            >
                
                <div id="carouselId" class="carousel slide" data-bs-ride="carousel">
                    <ol class="carousel-indicators">
                        <li
                            data-bs-target="#carouselId"
                            data-bs-slide-to="0"
                            class="active"
                            aria-current="true"
                            aria-label="First slide"
                        ></li>
                        <li
                            data-bs-target="#carouselId"
                            data-bs-slide-to="1"
                            aria-label="Second slide"
                        ></li>
                        <li
                            data-bs-target="#carouselId"
                            data-bs-slide-to="2"
                            aria-label="Third slide"
                        ></li>
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active">
                            <img
                                src="https://thearchitectsdiary.com/wp-content/uploads/2020/06/Property-.jpg"
                                class="w-100 d-block"
                                alt="First slide"
                                height=500
                                width=900
                            />
                            <div class="carousel-caption">
                                <h3>Beautiful Houses</h3>
                                <p>Find your dream home!</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img
                                src="https://www.avighnagroup.com/assets/images/services/luxury-apartments-in-mumbai.jpg"
                                class="w-100 d-block"
                                alt="Second slide"
                                height=500
                                width=900
                            />
                            <div class="carousel-caption">
                                <h3>Luxury Apartments</h3>
                                <p>Explore modern apartments!</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img
                                src="https://yugeninfra.com/uploads/projects/best_villas_for_sale_in_north_goa_for_luxury_living_and_investment-1776923684952-sk0c7m.png"
                                class="w-100 d-block"
                                alt="Third slide"
                                height=500
                                width=900
                            />
                            <div class="carousel-caption">
                                <h3>Luxury Villas</h3>
                                <p>Discover your perfect property!</p>
                            </div>

                        </div>
                    </div>
                    <button
                        class="carousel-control-prev"
                        type="button"
                        data-bs-target="#carouselId"
                        data-bs-slide="prev"
                    >
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button
                        class="carousel-control-next"
                        type="button"
                        data-bs-target="#carouselId"
                        data-bs-slide="next"
                    >
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
                
            </div>

            <div
                class="container mt-4"
            >
                <div
                    class="row g-2"
                >
                <div class="container mt-4">
                <form method="GET" action="dashboard.php" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control"
                        placeholder="Search by property name or location"
                        required>
                    <button type="submit" class="btn btn-dark">Search</button>
                    <a href="dashboard.php" class="btn btn-secondary">Reset</a>
                </form>
            </div>
                <?php
                
                
                while($row=$result->fetch_assoc()){ ?>
                    <div class="col-md-3 mb-3">
                        <div class="card h-100 border shadow rounded mt-3">
                            <img class="card-img-top" src="uploads/<?php echo $row["image"];?>" alt="Title" />
                            <div class="card-body p-2">
                                <h4><?php echo $row["property_name"];?></h4>
                                <p>Price:$<?php echo $row["price"];?></p>
                                <p>Location: <?php echo $row["location"]; ?></p>
                                <p>Type: <?php echo $row["property_type"]; ?></p>
                                <p>Bedrooms: <?php echo $row["bedrooms"]; ?></p>
                                <a
                                    name=""
                                    id=""
                                    class="btn btn-warning"
                                    href="editProperty.php?id=<?php echo $row['id'];?>"
                                    role="button"
                                    >Edit</a
                                >

                                <a
                                    name=""
                                    id=""
                                    class="btn btn-danger"
                                    href="deleteProperty.php?id=<?php echo $row['id'];?>"
                                    role="button"
                                    >Delete</a
                                >

                                <a
                                    name=""
                                    id=""
                                    class="btn btn-primary"
                                    href="viewDetails.php?id=<?php echo $row['id']; ?>"
                                    role="button"
                                    >View Details</a
                                >


                                
                                
                            </div>
                        </div>
                        
                    </div>
                    <?php } ?>
                    
                </div>
                
            </div>
            
            
        </main>
        <footer>
            <!-- place footer here -->
        </footer>
        <!-- Bootstrap JavaScript Bundle (includes Popper) -->
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
            crossorigin="anonymous"
        ></script>
    </body>
</html>
