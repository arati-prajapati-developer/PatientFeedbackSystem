<?php
require dirname(__FILE__) . '\.\includes/functions.php';
$questions = fetchQuestions();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Neuromodulation</title>
  <link href="<?php echo $indexCssPath; ?>" rel="stylesheet" />
  <link href="<?php echo $toastCssPath; ?>" rel="stylesheet" />
  <link href="<?php echo $bootstrapCssPath; ?>" rel="stylesheet" />
</head>

<body>
  <div class="container mt-5 mb-5 main-dv">
    <h2 class="text-center">Neuromodulation</h2>
    <form id="patientdetailsform" class="patientdetailsform" name="patientdetailsform">
      <div class="card main-card mb-3">
        <div class="card-body">
          <div class="card mb-3 px-1 py-4">
            <div class="card-header">Patient Details</div>
            <div class="card-body">
              <div class="form-group mb-2">
                <label for="fname">First Name</label>
                <input class="form-control" type="text" name="fname" id="fname" placeholder="First Name" required />
              </div>
              <div class="form-group mb-2">
                <label for="sname">Surname</label>
                <input class="form-control" id="sname" name="sname" type="text" placeholder="Surname" required />
              </div>
              <div class="form-group mb-2">
                <label for="dob">Date Of Birth</label>
                <input class="form-control" id="dob" name="dob" type="date" placeholder="Date Of Birth" required />
              </div>
              <div class="form-group mb-2">
                <label for="dob">Age</label>
                <input class="form-control" id="age" name="age" type="text" readonly placeholder="Age" />
              </div>
            </div>
          </div>
          <div class="card mb-3 px-1 py-4">
            <div class="card-header">Brief Pain Inventory (BPI)</div>
            <div class="card-body">
              <?php
              foreach ($questions as $index => $question) {
              ?>
                <div class="form-group questions-fg mb-3">
                  <label for="que-1"><?php echo ($question['id']); ?>. <?php echo $question['Question']; ?></label>
                  <div class="answer-range">
                    <input class="form-control" type="range" min="<?php echo $question['range_min']; ?>" max="<?php echo $question['range_max']; ?>" name="que[<?php echo $question['id']; ?>]" id="que-<?php echo $question['id']; ?>" value="0" required oninput="this.nextElementSibling.value = this.value" />
                    <output>0</output>
                  </div>
                </div>

              <?php
              }
              ?>
            </div>
          </div>
          <div class="card mb-3 px-1 py-4">
            <div class="card-header">Total Score</div>
            <div class="card-body">
              <input type="number" class="form-control" id="answer-totalScore" name="totalScore" readonly>
            </div>
          </div>
          <div class="form-group mb-2">
            <input class="btn btn-primary btn-block confirm-button" id="submit" name="submit" type="submit" />
            <input class="btn btn-secondary btn-block reset-button" id="reset" name="reset" type="reset" />
          </div>
        </div>
      </div>
    </form>
  </div>
</body>
<footer>
  <script src="<?php echo $jqueryPath; ?>" type="text/javascript"></script>
  <script src="<?php echo $toastPath; ?>" type="text/javascript"></script>
  <script src="<?php echo $bootstrapPath; ?>" type="text/javascript"></script>
  <script src="<?php echo $indexPath; ?>" type="text/javascript"></script>
</footer>

</html>