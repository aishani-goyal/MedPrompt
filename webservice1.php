<?php

$search_param = $_POST["search"];
$search_area = $_POST["area"];

if (isset($_POST["search"]) && isset($_POST["area"])) {

  //Connect to database
  $host = "localhost";
  $dbuser = "id22268516_doctor_admin";
  $dbpass = "Docadmin@2024";
  $dbname = "id22268516_doctor_info";

  // Create connection
  $conn = new mysqli($host, $dbuser, $dbpass, $dbname);

  $sql = "SELECT * FROM doctors WHERE DoctorLocation like '%" . $search_area . "%' and DoctorSpeciality like '%" . $search_param . "%'";

  $result = $conn->query($sql);

  if ($result->num_rows > 0) {

    $data = '<b class="doctors-matching-your"
          >“Doctors Matching Your Search Criteria”</b
        >';
    $doctor_data = "";
    while ($row = $result->fetch_assoc()) {
      $doctorid = $row["ID"];

      $doctorname = $row["DoctorName"];
      $doctorspeciality = $row["DoctorSpeciality"];
      $doctorrating = $row["DoctorRating"];
      $doctorexp = $row["DoctorExperience"];
      $doctorqualification = $row["DoctorQualification"];
      $doctortiming = $row["DoctorTiming"];
      $doctorcontact = $row["DoctorContact"];
      $doctorlocation = $row["DoctorLocation"];

      // Fetch the binary image data
      $doctorimage = $row["DoctorImage"];
      // Encode the binary data to base64
      $doctorimage_base64 = base64_encode($doctorimage);

      $doctor_data = $doctor_data . '<div class="expertbox1">
          <div class="expertbox1bg"></div>
         <img class="docimg1" src="data:image/jpeg;base64,' . $doctorimage_base64 . '" alt="' . $doctorname . '">
          <div class="doctornamedoc1">' . $doctorname . '</div>
          <div class="specialitydoc1">' . $doctorspeciality . '</div>
          <div class="ratingdoc1">' . $doctorrating . '</div>
          <div class="experiencedoc1">' . $doctorexp . '</div>
          <div class="qualificationdoc1">' . $doctorqualification . '</div>
          <div class="timingdoc1">' . $doctortiming . '</div>
          <div class="contactdoc1">' . $doctorcontact . '</div>
          <div class="locationdoc1">' . $doctorlocation . '</div>
        </div>';
    }
  } else {
    $data = '<b class="doctors-matching-your" style="display: block; text-align: center; margin: 80px auto 30px;">“No Doctor found in your area”</b>';
  }

  //Sending response back to the request
} else {
  $data = '<b class="doctors-matching-your"
          >Bad Query</b
        >';
}

$data = $data . $doctor_data;

echo $data;
