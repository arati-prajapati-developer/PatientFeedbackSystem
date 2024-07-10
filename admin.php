<?php
require dirname(__FILE__) . '\.\includes/functions.php';
$allPatients = fetchAllPatients();

session_start();
$loginPath = getBaseUrl() . '/login.php';
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: $loginPath");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin</title>
    <link href="<?php echo $indexCssPath; ?>" rel="stylesheet" />
    <link href="<?php echo $datatableCssPath; ?>" rel="stylesheet" />
    <link href="<?php echo $toastCssPath; ?>" rel="stylesheet" />
    <link href="<?php echo $bootstrapCssPath; ?>" rel="stylesheet" />
</head>

<body>
    <div class="container mt-5 mb-5 main-dv">
        <div class="d-flex justify-content-between">
          <h2 class="text-right px-4">Patient's Completed Forms</h2>
          <a href="<?php echo getBaseUrl() . '/logout.php';?>" class="btn btn-primary btn-block confirm-button align-left" id="logout">Logout</a>
      </div>
        <div class="card main-card mb-3">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="completedFormsTable" class="table">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">Date of Submission</th>
                                <th class="text-center">First Name</th>
                                <th class="text-center">Surname</th>
                                <th class="text-center">Age</th>
                                <th class="text-center">Date of Birth</th>
                                <th class="text-center">Total Score</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($allPatients as $form) : ?>
                                <tr>
                                    <td class="text-center"><?php echo $form['created_at']->format('Y-m-d'); ?></td>
                                    <td class="text-center"><?php echo $form['fname']; ?></td>
                                    <td class="text-center"><?php echo $form['sname']; ?></td>
                                    <td class="text-center"><?php echo countAge($form['dob']); ?></td>
                                    <td class="text-center"><?php echo $form['dob']->format('Y-m-d'); ?></td>
                                    <td class="text-center"><?php echo $form['total']; ?></td>
                                    <td class="text-center">
                                        <button class="viewRecord btn btn-success btn-sm btn-rounded text-white" data-id="<?php echo $form['id']; ?>">View</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
<footer>
    <script src="<?php echo $jqueryPath; ?>" type="text/javascript"></script>
    <script src="<?php echo $datatablePath; ?>" type="text/javascript"></script>
    <script src="<?php echo $toastPath; ?>" type="text/javascript"></script>
    <script src="<?php echo $bootstrapPath; ?>" type="text/javascript"></script>
    <script src="<?php echo $indexPath; ?>" type="text/javascript"></script>
    <script>
        $('#completedFormsTable').DataTable();
    </script>
</footer>

</html>