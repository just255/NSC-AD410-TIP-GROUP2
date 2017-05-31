<?php
	/*
	 * Sends survey JSON object to DB
	*/
	$surveyData = (isset($_POST['saveData'])) ? $_POST['saveData'] : "";
	$surveyName = (isset($_POST['saveName'])) ? $_POST['saveName'] : "";
	$jsonData = JSON_decode($surveyData);
	$table = 'Surveys';
	$col1 = 'surveyID';
	$col2 = 'jsonData';
	$col3 = 'surveyName';
	$valid_json_survey_data = preg_replace('/([\w\d]+): /', '"$1": ', trim(preg_replace('/\s+/', ' ', $surveyData)));
	$sqlstmt = "INSERT INTO $table($col2, $col3) VALUES ('$valid_json_survey_data', '$surveyName');";
	try {
		$conn = new PDO("sqlite:DB/test.sqlite");
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$statement = $conn->prepare($sqlstmt);
		$statement->execute();
		$conn = NULL;
	} catch (PDOException $e) {
		echo "PHP Save error: ".$e->getMessage();
	}
?>
