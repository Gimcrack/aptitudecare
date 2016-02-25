<?php

class PatientInfo extends Dietary {

	protected $table = 'patient_info';


	public function fetchDietInfo($patientid) {
		$sql = "SELECT pi.* FROM {$this->tableName()} pi WHERE pi.patient_id = :patientid LIMIT 1";
		$params[":patientid"] = $patientid;
		$result = $this->fetchOne($sql, $params);

		if (!empty ($result)) {
			return $result;
		} else {
			return $this;
		}
	}




	public function fetchByLocation_allergy($location) {
		$allergy = $this->loadTable("Allergy");
		$schedule = $this->loadTable("Schedule");
		$room = $this->loadTable("Room");
		$patient = $this->loadTable('Patient');
		$pfi = $this->loadTable('PatientFoodInfo');

		$sql = "SELECT 
				r.number, 
				p.id AS patient_id, 
				s.id AS schedule_id, 
				p.last_name, 
				p.first_name, 
				s.location_id, 
				GROUP_CONCAT(a.name separator ', ') as allergy_name
			FROM {$patient->tableName()} AS p 
			INNER JOIN {$schedule->tableName()} s ON s.patient_id = p.id
			INNER JOIN {$room->tableName()} r ON r.id = s.room_id
			LEFT JOIN {$pfi->tableName()} pfi ON pfi.patient_id = p.id
			LEFT JOIN {$allergy->tableName()} a ON a.id = pfi.food_id
			WHERE s.status = 'Approved'
			AND s.location_id = :location_id
			AND (s.datetime_discharge >= :current_date OR s.datetime_discharge IS NULL)
			GROUP BY p.id
			ORDER BY r.number ASC";

		$params[":location_id"] = $location->id;
		$params[":current_date"] = mysql_date();

		return $this->fetchAll($sql, $params);


		//     $sql =

		// <<<EOD
		//   SELECT g.number, p.id patient_id, s.id admit_schedule_id, p.last_name, p.first_name, s.location_id, f.id allergy_id, f.name, p.id
		// 	FROM ac_patient AS p
		// 	INNER JOIN admit_schedule s ON s.patient_id = p.id
		// 	LEFT JOIN dietary_patient_food_info e ON e.patient_id = p.id
		// 	left join dietary_allergy f on e.food_id = f.id
		// 	left join admit_room g on s.room_id = g.id
		// 	WHERE s.status='Approved'
		// 	AND s.location_id = {$location->id}
		// 	AND (s.datetime_discharge >= now() OR s.datetime_discharge IS NULL)
		// 	group by g.number, p.id, s.id, p.last_name, p.first_name, s.location_id, f.id, f.name, p.id
		// 	ORDER BY s.room_id ASC
		// EOD;

		//     $compiled_patients  = array();
		//     $duped_patients = array();


		//     //$params[":location_id"] = 3;
		//     $patients = $this->fetchAll($sql);


		//     foreach ($patients as $key => $value) {
		//       $compiled_patients[$value->patient_id][] = $value;
		//     }


		//     if (!empty ($compiled_patients)) {
		//       return $compiled_patients;
		//     } else {
		//       return $this->fetchColumnNames();
		//     }
	}


	public function fetchPatientInfoByPatient($patient_id, $location_id) {
		$sql = "SELECT * FROM {$this->tableName()} WHERE patient_id = :patient_id AND location_id = :location_id";
		$params = array(":patient_id" => $patient_id, ":location_id" => $location_id);
		return $this->fetchOne($sql, $params);
	}

}
