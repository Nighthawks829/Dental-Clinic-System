<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <title>Document</title>
</head>

<body>
    <section>
        <div class="d-flex align-items-center justify-content-center" style="height:100vh">
            <div class="container text-center">
                <?php
                echo "<h1 style=\"margin-bottom:20px;\" >$message</h1>";
                ?>

                <a href="../index.php" class="btn btn-primary">Go Back</a>
            </div>
        </div>
    </section>

</body>

</html>