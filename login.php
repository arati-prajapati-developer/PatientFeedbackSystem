<?php
require dirname(__FILE__) . '/config.php';
session_start();

$adminPath = getBaseUrl().'/admin.php';
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: $adminPath");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link href="<?php echo $indexCssPath;?>" rel="stylesheet" />
    <link href="<?php echo $toastCssPath;?>" rel="stylesheet" />
    <link href="<?php echo $bootstrapCssPath;?>" rel="stylesheet" />
  </head>
  <body>
    <div class="container col-sm-4 mt-5 mb-5 main-dv">
      <h2 class="text-center">Login</h2>
      <form
        id="loginform"
        class="loginform"
        name="loginform"
      >
        <div class="card main-card mb-3">
          <div class="card-body">
            <div class="form-group mb-2">
                <label for="fname">Email</label>
                <input
                class="form-control"
                type="text"
                name="email"
                id="email"
                placeholder="Enter a email address"
                required
                />
            </div>
            <div class="form-group mb-2">
                <label for="sname">Password</label>
                <input
                class="form-control"
                id="password"
                name="password"
                type="password"
                placeholder="Password"
                required
                />
            </div>
            <div class="form-group mb-2">
              <input
                class="btn btn-primary btn-block confirm-button"
                id="submit"
                name="submit"
                type="submit"
              />
              <input
                class="btn btn-secondary btn-block reset-button"
                id="reset"
                name="reset"
                type="reset"
              />
            </div>
          </div>
        </div>
      </form>
    </div>
  </body>
  <footer>
    <script src="<?php echo $jqueryPath;?>" type="text/javascript"></script>
    <script src="<?php echo $toastPath;?>" type="text/javascript"></script>
    <script src="<?php echo $bootstrapPath;?>" type="text/javascript"></script>
    <script src="<?php echo $indexPath;?>"  type="text/javascript"></script>
  </footer>
</html>
