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


            $doctor_data["DocName"] = $doctorname;
            $doctor_data["DocSpeciality"] = $doctorspeciality;
            $doctor_data["DocRating"] = $doctorrating;
            $doctor_data["DocExp"] = $doctorexp;
            $doctor_data["DocQualification"] = $doctorqualification;
            $doctor_data["DocTiming"] = $doctortiming;
            $doctor_data["DocContact"] = $doctorcontact;
            $doctor_data["DocLocation"] = $doctorlocation;

            $doctor_data["DocImage"] = $doctorimage_base64;

            $data[$doctorid] = $doctor_data;
        }

        $data["Result"] = "True";
        $data["Message"] = "Doctors fetched successfully";
    } else {
        $data["Result"] = "False";
        $data["Message"] = "No Doctors Found";
    }

    //Sending response back to the request

} else {
    $data["Result"] = "False";
    $data["Message"] = "Bad Query";
}

echo json_encode($data, JSON_UNESCAPED_SLASHES);
