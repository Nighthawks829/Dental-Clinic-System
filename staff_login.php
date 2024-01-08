<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link rel="stylesheet" href="style/admin_login.css">

    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <script src="https://kit.fontawesome.com/3a4d23485c.js" crossorigin="anonymous"></script>

    <title>Staff Login</title>
</head>

<body>

    <main>
        <div class="container content justify-content-center d-flex vh-100 align-items-center">
            <div class="col-10 login-box p-5">

                <h1 class="text-center mb-5">Staff Log In</h1>


                <form action="./include/staff_login_action.php" method="POST" class="h-100 d-flex align-items-center">
                    <div class="col-12">

                        <div class="col-21 mb-5">
                            <label for="email" class="mb-1">Email</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>

                        <div class="col-12 mb-5">
                            <label for="password" class="mb-1">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Log In</button>
                    </div>
                </form>
            </div>
        </div>
    </main>


</body>

</html>