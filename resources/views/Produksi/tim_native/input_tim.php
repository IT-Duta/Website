<?php
//including the database connection file
include_once("../config.php");

//fetching data in descending order (lastest entry first)

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

    <!--Custom CSS -->
    <link rel="stylesheet" href="../style.css">
    
    <title>STATUS PRODUKSI TERKINI</title>

</head>

<body>
    <div class="container-fluid bg-com">
        <div>
            <button id="side-show" onclick="showNav()" type="button">
            </button>
        </div>
        <div class="row">
             <!-- Left Nav -->
             <div class="col-3 bg-dark text-light sticky-sm-top" id="side-nav">
                <hr>
                <span class="noselect">PRODUKSI</span>
                <a class="icon-close" onclick="closeNav()"><i class="bi bi-x-circle"style="font-size: 1.4rem;cursor:pointer"></i></a>
                <hr>
                <!-- Menu -->
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                          Panel
                        </button>
                        </h2>
                        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <ul class="side-nav text-dark">
                                    <li class="nav-item">
                                        <a href="../panel/index.php" class="nav-link">
                                            List Panel
                                        </a></li>
                                    <li class="nav-item">
                                        <a href="../panel/input_panel.php" class="nav-link">Tambah</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                       Tim
                        </button>
                        </h2>
                        <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <ul class="side-nav text-dark">
                                <li class="nav-item">
                                        <a href="../tim/index.php" class="nav-link">
                                            List Tim
                                        </a></li>
                                    <li class="nav-item">
                                        <a href="../tim/input_tim.php" class="nav-link">Tambah</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Menu -->
            </div>
            <!-- Content -->
            <div class="col">
                <h1 class="text-center text-shadow">Input tim</h1>
                <!-- Start Card -->
                <div class="card mx-5 shadow mt-5">
                    <div class="card-body">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button accesskey="1" class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Main</button>
                            </li>
                        </ul>
                        <form action="insert_tim.php" method="post">
                            <div class="tab-content" id="pills-tabContent">
                                <!-- Menu1 -->
                                <div class="tab-pane fade show active" id="pills-home" role="tabtim" aria-labelledby="pills-home-tab">
                                    <hr>
                                    <div class="mb-3 row">
                                        <label for="no_tim" class="col-sm-4 col-form-label">Nama</label>
                                        <div class="col-sm-8">
                                            <input type="text" required class="form-control" name="tim_nama" id="tim_nama">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="no_cell" class="col-sm-4 col-form-label">Alias</label>
                                        <div class="col-sm-8">
                                            <input type="text" required class="form-control" name="tim_alias" id="tim_alias">
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>

                    </div>
                </div>
                <!-- End Card -->
                <!-- <div class="card">
                    <div class="card-body"> -->
                <div class="d-grid mx-5 my-3">
                    <button class="btn btn-sm btn-primary shadow" type="submit">Submit</button>
                    <button class="btn btn-sm btn-danger shadow mt-2" type="reset">Reset</button>
                </div>
                </form>
                <!-- </div>
                </div> -->
                <!-- <div class="card">
                    <div class="card-body">

                    </div>
                </div> -->
            </div>
            <!-- End Content -->
        </div>

    </div>
    <script>
        function closeNav(){
            let ele=document.getElementById("side-nav");
            // document.getElementById
            ele.style.width="0%";
            ele.style.opacity=0;
            let ele1=document.getElementById("side-show");
            ele1.style.opacity=1;
            // ele.style.display="none";
        }
        function showNav(){
            let ele1=document.getElementById("side-show");
            ele1.style.opacity=0;
            let ele=document.getElementById("side-nav");
            // document.getElementById
            ele.style.width="20%";
            ele.style.opacity=1;
            // ele.style.display="none";
        }
    </script>
</body>

</html>