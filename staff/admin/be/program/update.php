<?php
	include '../includes/head.php';
	require_once '../database/db_pdo.php';
	
	date_default_timezone_set('Asia/Taipei');

	if(ISSET($_POST['update'])){
		try{
			$id = $_POST['id'];
			$name = $_POST['name'];
			$acronym = $_POST['acronym'];
			$unitID = $_POST['unitID'];

			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE `tbl_course` SET `course_name`='$name',
            `course_acronym`='$acronym', `unit_id`='$unitID' WHERE `course_id` = '$id'";
	
			if($conn->exec($sql)){

				//log this action

				$staff_id = $_POST['staff_id'];
				$staff_username = $_POST['staff_username'];
				$staff_role = 0;
				$log_description = 'Modified the program '.$name;
				$timestamp = date('m/d/Y, g:i:s A');

				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql2 = "INSERT INTO `tbl_logs`(`log_staff_id`, `log_staff_username`, `log_staff_role`, `log_description`, `timestamp`)
	        	VALUES ('$staff_id', '$staff_username', '$staff_role', '$log_description', '$timestamp')";
				$conn->exec($sql2);
			}

		}catch(PDOException $e){
			echo $e->getMessage();
		}
		$conn = null;
		echo '
		<script>

			$(document).ready(function(){

				Swal.fire({
					icon: "success",
					title: "Program Offering Successfully Updated",
					text: "LNU - Student Admission Information System",
					timer: 2000
				}).then(function(){

					window.location.replace("../../program.php");

				});

			});

		</script>
	';
	}
?>