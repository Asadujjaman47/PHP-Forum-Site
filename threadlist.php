<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <style>
    #ques {
        min-height: 450px;
    }
    </style>
    <title>Welcome to iDiscuss - Coding Forums</title>
</head>

<body>
    <?php include 'partials/_header.php'; ?>
    <?php include 'partials/_dbconnect.php'; ?>


    <?php

    $id = $_GET['catid'];

    $sql = "SELECT * FROM `categories` WHERE category_id=$id";
    $result = mysqli_query($conn,$sql);

    while($row = mysqli_fetch_assoc($result)){
        $catname = $row['category_name'];
        $catdes = $row['category_description'];
    }

    ?>


    <?php
    $showAlert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    if($method == 'POST'){
        // Insert intot thread db
        $th_title = $_POST['title'];
        $th_desc = $_POST['desc'];
        $sql = "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ('$th_title', '$th_desc', '$id', '0', CURRENT_TIMESTAMP)";
        $result = mysqli_query($conn, $sql);
        
        $showAlert= true;
        
        if($showAlert){
            echo '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> Your thread has been added! Please wait for community to response.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            ';
        }
    }
    ?>



    <!-- Category container starts here -->
    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4">Welcome to <?php echo $catname; ?> forums</h1>
            <p class="lead"><?php echo $catdes; ?></p>
            <hr class="my-4">
            <p>This is a peer to peer forum. No Spam / Advertising / Self-promote in the forums is not allowed. Do not
                post copyright-infringing material. Do not post “offensive” posts, links or images. Do not cross post
                questions. Remain respectful of other members at all times.</p>
            <a class="btn btn-success btn-lg" href="#" role="button">Learn more</a>
        </div>
    </div>


    <div class="container">
        <h1 class="py-2">Start a Discussion</h1>

        <!-- <form action="/forum/threadlist.php?catid=$id" method="post"> -->
        <form action="<?php $_SERVER['REQUEST_URI'] ?>" method="post">

            <div class="form-group">
                <label for="title">Problem Title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby=" emailHelp">
                <small id="emailHelp" class="form-text text-muted">Keep your title as short and crip as
                    possible</small>
            </div>
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Elaborate Your Concern</label>
                <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>


    <div class="container" id="ques">
        <h1 class="py-2">Browse Questions</h1>

        <?php

        $id = $_GET['catid'];

        $sql = "SELECT * FROM `threads` WHERE thread_cat_id=$id";
        
        $result = mysqli_query($conn,$sql);
        
        $noResult = true;

        while($row = mysqli_fetch_assoc($result)){
            $noResult = false;

            $id = $row['thread_id'];
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
        
            echo '
                <div class=" media my-3">
                    <img src="img/userdefault.png" width="54px" class=" mr-3" alt="...">
                    <div class="media-body">
                        <h5 class="mt-0"><a class="text-dark" href="thread.php?threadid='. $id .'">'. $title .'</a></h5>
                        <p>'. $desc .'</p>
                    </div>
                </div>';
        }

        // echo var_dump($noResult);
        if($noResult){
            echo '<div class="jumbotron jumbotron-fluid">
                    <div class="container">
                    <p class="display-4">No Threads Found</p>
                    <p class="lead">Be the first person to ask a question</p>
                    </div>
                </div>';
        }
        ?>

    </div>



    <?php include 'partials/_footer.php'; ?>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    -->
</body>

</html>