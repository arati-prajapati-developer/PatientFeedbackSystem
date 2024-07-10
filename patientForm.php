<?php
require dirname(__FILE__) . '\.\includes/functions.php';
$id="";
if(!isset($_GET['id']) || $_GET['id'] == ""){
    $adminPath = getBaseUrl().'/admin.php';
    header("Location: $adminPath");
    exit();
}else{
    $id=$_GET['id'];
}

$questions = fetchQuestions();
$parientRecords = getPatientRecord($id);
$dob = $parientRecords[0]['dob']->format('Y-m-d');

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Neuromodulation</title>
    <link href="<?php echo $indexCssPath;?>" rel="stylesheet" />
    <link href="<?php echo $toastCssPath;?>" rel="stylesheet" />
    <link href="<?php echo $bootstrapCssPath;?>" rel="stylesheet" />
    <style>
        input[type="range"]::-moz-range-thumb {
            background: #4CAF50;
            cursor: pointer;
        }

        input[type="range"]:disabled::-webkit-slider-thumb {
            background: #bbb;
        }

        input[type="range"]:disabled::-moz-range-thumb {
            background: #bbb;
        }
    </style>
  </head>
  <body>
    <div class="container mt-5 mb-5 main-dv">
      <div class="d-flex justify-content-between">
          <h2 class="text-right px-4">Neuromodulation</h2>
          <a href="<?php echo getBaseUrl() . '/logout.php';?>" class="btn btn-primary btn-block confirm-button align-left" id="logout">Logout</a>
      </div>
      <form
        id="updatePatientdetailsform"
        class="updatePatientdetailsform"
        name="updatePatientdetailsform"
      >
        <div class="card main-card mb-3">
          <div class="card-body">
            <div class="card mb-3 px-1 py-4">
              <div class="card-header">Patient Details</div>
              <div class="card-body">
                <div class="form-group mb-2">
                  <label for="fname">First Name</label>
                  <input
                    class="form-control"
                    type="text"
                    name="fname"
                    id="fname"
                    placeholder="First Name"
                    value="<?php echo $parientRecords[0]['fname']?>"
                    required
                    readonly
                  />
                </div>
                  <input
                    class="form-control d-none"
                    type="text"
                    name="id"
                    id="id"
                    value="<?php echo $id?>"
                    readonly
                  />
                <div class="form-group mb-2">
                  <label for="sname">Surname</label>
                  <input
                    class="form-control"
                    id="sname"
                    name="sname"
                    type="text"
                    placeholder="Surname"
                    value="<?php echo $parientRecords[0]['sname']?>"
                    required
                    readonly
                  />
                </div>
                <div class="form-group mb-2">
                  <label for="dob">Date Of Birth</label>
                  <input
                    class="form-control"
                    id="editDOB"
                    name="dob"
                    type="date"
                    placeholder="Date Of Birth"                    
                    value="<?php echo $dob?>"
                    required
                    readonly
                  />
                </div>
                <div class="form-group mb-2">
                  <label for="dob">Age</label>
                  <input
                    class="form-control"
                    id="age"
                    name="age"
                    type="text"
                    readonly
                    placeholder="Age"
                    value="<?php echo countAge($parientRecords[0]['dob'])?>"
                  />
                </div>
              </div>
            </div>
            <div class="card mb-3 px-1 py-4">
              <div class="card-header">Brief Pain Inventory (BPI)</div>
              <div class="card-body">
                <?php
                   foreach ($questions as $index => $question) {
                    $responseValue = "";
                    if($parientRecords[$index]['question_id'] == $question['id']){
                        $responseValue = $parientRecords[$index]['response'];
                    }
                ?>
                  <div class="form-group questions-fg mb-3">
                    <label for="que-1"
                      ><?php echo ($question['id']);?>. <?php echo $question['Question'];?></label
                    >
                    <div class="answer-range">
                      <input
                        class="form-control questions"
                        type="range"
                        min="<?php echo $question['range_min'];?>"
                        max="<?php echo $question['range_max'];?>"
                        name="que[<?php echo $parientRecords[$index]['response_id'];?>]"
                        id="que-<?php echo $question['id'];?>"
                        value="<?php echo $responseValue;?>"
                        required
                        oninput="this.nextElementSibling.value = this.value"
                        disabled 
                      />
                      <output><?php echo $responseValue;?></output>
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
                    <input type="number" class="form-control" id="answer-totalScore" name="totalScore" 
                    value="<?php echo $parientRecords[0]['total']?>" readonly>
                </div>
            </div>
            <div class="form-group mb-2">
              <input
                class="btn btn-primary btn-block confirm-button"
                id="editPatientRecord"
                name="editPatientRecord"
                type="button"
                value="Edit"
                data-id="<?php echo $id; ?>"
              />
              <input
                class="btn btn-primary btn-block confirm-button d-none"
                id="updatePatientRecord"
                name="updatePatientRecord"
                type="submit"
                value="Update"
                data-id="<?php echo $id; ?>"
              />
              <input
                class="btn btn-danger btn-block deleteRecord confirm-button"
                id="delete"
                name="delete"
                type="button"
                value="Delete"
                data-id="<?php echo $id; ?>"
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
