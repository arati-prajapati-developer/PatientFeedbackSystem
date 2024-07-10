$(document).ready(function () {
  var baseUrl = window.location.href.split("/").slice(0, -1).join("/");

  $("#dob").change(function () {
    const dob = new Date($(this).val());
    const today = new Date();
    if (dob > today) {
	showToastMessage("Error Message", "The date of birth cannot be in the future.", "error");
      $(this).val("");
      $("#age").val("");
    } else {
      let age = today.getFullYear() - dob.getFullYear();
      const m = today.getMonth() - dob.getMonth();
      if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
        age--;
      }
      $("#age").val(age);
    }
  });

  let oldDobValue;
  let oldAge;
  $("#editDOB").focus(function () {
    oldDobValue = $(this).val();
	oldAge = $("#age").val();
  });

  $("#editDOB").change(function () {
    const dob = new Date($(this).val());
    const today = new Date();
    
    if (dob > today) {
      showToastMessage("Error Message", "The date of birth cannot be in the future.", "error");
      $(this).val(oldDobValue);
	    $("#age").val(oldAge);
    } else {
      let age = today.getFullYear() - dob.getFullYear();
      const m = today.getMonth() - dob.getMonth();
      if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
        age--;
      }
      $("#age").val(age);
    }
  });

  $("#patientdetailsform,#updatePatientdetailsform").change(function () {
    let totalScore = 0;
    for (let i = 2; i <= 12; i++) {
      totalScore += parseInt($("#que-" + i).val()) || 0;
    }
    $("#answer-totalScore").val(totalScore);
  });

  $("#patientdetailsform").on("submit", function (e) {
    e.preventDefault();
    var actionUrl = baseUrl + "/includes/insertRecord.php";
    $.ajax({
      url: actionUrl,
      type: "POST",
      data: $("#patientdetailsform").serialize(),
      dataType: "json",
      success: function (response) {
        if (response.status === "success") {
          $("#reset").click();
          showToastMessage("Success Message", response.message, "success");
        } else {
          showToastMessage("Error Message", response.message, "error");
        }
      },
      error: function (xhr, status, error) {
        showToastMessage("Error Message", error, "error");
      },
    });
  });

  $("#loginform").on("submit", function (e) {
    e.preventDefault();
    var actionUrl = baseUrl + "/includes/login.php";
    $.ajax({
      url: actionUrl,
      type: "POST",
      data: $("#loginform").serialize(),
      dataType: "json",
      success: function (response) {
        if (response.status === "success") {
          	$("#reset").click();
        	showToastMessage("Success Message", response.message, "success");
        	window.location.href = baseUrl + "/admin.php";
        } else {
			$("#reset").click();
          	showToastMessage("Error Message", response.message, "error");
        }
      },
      error: function (xhr, status, error) {
        showToastMessage("Error Message", error, "error");
      },
    });
  });

  $(".deleteRecord").on("click", function (e) {
    e.preventDefault();
    var id = $(this).data("id");

    var actionUrl = baseUrl + "/includes/deletePatient.php";
    if (confirm("Are you sure you want to delete this patient entry?")) {
      $.ajax({
        url: actionUrl,
        type: "POST",
        data: { id: id },
        dataType: "json",
        success: function (response) {
          if (response.status === "success") {
			showToastMessage("Success Message", response.message, "success");
			window.location.href = baseUrl + "/admin.php";
          } else {
            showToastMessage("Error Message", response.message, "error");
          }
        },
        error: function (xhr, status, error) {
          showToastMessage("Error Message", error, "error");
        },
      });
    }
  });

  $(".viewRecord").on("click", function (e) {
    e.preventDefault();
    var id = $(this).data("id");
    var actionUrl = baseUrl + "/patientForm.php?id=" + id;
    window.location.href = actionUrl;
  });

  $("#updatePatientdetailsform").on("submit", function (e) {
    e.preventDefault();
    var actionUrl = baseUrl + "/includes/updatePatient.php";
    console.log($("#updatePatientdetailsform").serialize());
    $.ajax({
      url: actionUrl,
      type: "POST",
      data: $("#updatePatientdetailsform").serialize(),
      dataType: "json",
      success: function (response) {
        if (response.status === "success") {
          showToastMessage("Success Message", response.message, "success");
          window.location.href = baseUrl + "/admin.php";
        } else {
          showToastMessage("Error Message", response.message, "error");
        }
      },
      error: function (xhr, status, error) {
        showToastMessage("Error Message", error, "error");
      },
    });
  });

  $("#editPatientRecord").on("click", function (e) {
    $("#fname").removeAttr("readonly");
    $("#sname").removeAttr("readonly");
    $("#editDOB").removeAttr("readonly");
    $("#editPatientRecord").hide();
    $(".questions").removeAttr("disabled");
    $(".questions").each(function () {
      $(this).prop("disabled", false);
    });
    $("#updatePatientRecord").removeClass("d-none");
  });

  function showToastMessage(title, message, type) {
    $.Toast(title, message, type, {
      has_icon: true,
      has_close_btn: true,
      stack: true,
      fullscreen: false,
      width: 250,
      timeout: 5000,
      sticky: false,
      has_progress: true,
      position_class: "toast-top-right",
      rtl: false,
    });
  }
});
