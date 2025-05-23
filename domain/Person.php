<?php
/*
 * Copyright 2013 by Allen Tucker. 
 * This program is part of RMHC-Homebase, which is free software.  It comes with 
 * absolutely no warranty. You can redistribute and/or modify it under the terms 
 * of the GNU General Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/ for more information).
 * 
 */

/*
 * Created on Mar 28, 2008
 * @author Oliver Radwan <oradwan@bowdoin.edu>, Sam Roberts, Allen Tucker
 * @version 3/28/2008, revised 7/1/2015
 */

// ONLY REQUIRED FIELDS HAVE BEEN ADDED SO FAR.
class Person {

	private $access_level; // normal user = 1, admin = 2, superadmin = 3
	
	// REQUIRED FIELDS
	private $id; // (username)
	private $first_name;
	private $last_name;
	private $minor;
	private $total_hours;
	private $mandated_hours;
	private $remaining_mandated_hours;
	private $checked_in;
	private $phone1;
	private $email;
	private $notes;
	private $type; // admin or volunteer or participant...
	private $password;
	private $street_address;
	private $city;
	private $state;
	private $zip_code;
	private $emergency_contact_first_name;
	private $emergency_contact_last_name;
	private $emergency_contact_phone;
	private $emergency_contact_relation;
	//private $start_date; // (dete of account creation)
	//private $phone1type;
	//private $birthday;
	//private $emergency_contact_phone_type;
	//private $tshirt_size;
	//private $school_affiliation;
	//private $photo_release;
	//private $photo_release_notes;
	//private $status;
	//private $archived;

	// TRAINING REQS
	//private $training_complete;
	//private $training_date;
	//private $orientation_complete;
	//private $orientation_date;
	//private $background_complete;
	//private $background_date;

	// OPTIONAL FIELDS
	//private $how_you_heard_of_stepva;
    //private $preferred_feedback_method;
    //private $hobbies;
    //private $professional_experience;
    //private $disability_accomodation_needs;

	/*
	 * The trimmed down version of the original constructor
	 */
	function __construct(
						$id, $password, $first_name, $last_name, $street_address, $city, $state, $zip_code, $notes,
						$phone1, $email, $minor, $total_hours, $mandated_hours, $remaining_mandated_hours, $emergency_contact_first_name,
						$emergency_contact_last_name, $emergency_contact_phone, $emergency_contact_relation, $type
						) {
		$this->id = $id; // (username)
		$this->first_name = $first_name;
		$this->last_name = $last_name;
		$this->minor = $minor;
		$this->total_hours = $total_hours;
		$this->mandated_hours= $mandated_hours;
		$this->remaining_mandated_hours = $remaining_mandated_hours;
		$this->checked_in = 0;
		$this->phone1 = $phone1;
		$this->email = $email;
		$this->notes = $notes;
		$this->password = $password;
		$this->street_address = $street_address;
		$this->city = $city;
		$this->state = $state;
		$this->zip_code = $zip_code;
		$this->emergency_contact_first_name = $emergency_contact_first_name;
		$this->emergency_contact_last_name = $emergency_contact_last_name;
		$this->emergency_contact_phone = $emergency_contact_phone;
		$this->emergency_contact_relation = $emergency_contact_relation;
		$this->type = $type; // volunteer or participant...

		// access_level = 1 for users, and = 3 for admin
		//if ($id == 'vmsroot') {
		//d.bohn changed this so new staff members will have access to staff features
		  if ($type == 'superadmin') {
			$this->access_level = 3;
		} elseif ($type == 'admin' ) {
			$this->access_level = 2;
		} else {
			$this->access_level = 1;
		}
	}


	/*
	 * The old constructor
	 */
	/*function __construct(
						$id, $password, $start_date, $first_name, $last_name, $birthday, $street_address, $city,
						$state, $zip_code, $phone1, $phone1type, $email, $minor, $total_hours, $remaining_mandated_hours, $emergency_contact_first_name,
						$emergency_contact_last_name, $emergency_contact_phone, $emergency_contact_phone_type,
						$emergency_contact_relation, $tshirt_size, $school_affiliation, $photo_release, $photo_release_notes, $type, $status, $archived,
						$how_you_heard_of_stepva, $preferred_feedback_method, $hobbies, $professional_experience, $disability_accomodation_needs, 
						$training_complete, $training_date, $orientation_complete,
						$orientation_date, $background_complete, $background_date
						) {
		$this->id = $id; // (username)
		$this->password = $password;
		$this->start_date = $start_date; // (dete of account creation)
		$this->first_name = $first_name;
		$this->last_name = $last_name;
		$this->birthday = $birthday;
		$this->street_address = $street_address;
		$this->city = $city;
		$this->state = $state;
		$this->zip_code = $zip_code;
		$this->phone1 = $phone1;
		$this->phone1type = $phone1type;
		$this->email = $email;
		$this->minor = $minor;
		$this->total_hours = $total_hours;
		$this->remaining_mandated_hours = $remaining_mandated_hours;
		$this->emergency_contact_first_name = $emergency_contact_first_name;
		$this->emergency_contact_last_name = $emergency_contact_last_name;
		$this->emergency_contact_phone = $emergency_contact_phone;
		$this->emergency_contact_phone_type = $emergency_contact_phone_type;
		$this->emergency_contact_relation = $emergency_contact_relation;
		$this->tshirt_size = $tshirt_size;
		$this->school_affiliation = $school_affiliation;
		$this->photo_release = $photo_release;
		$this->photo_release_notes = $photo_release_notes;
		$this->type = $type; // volunteer or participant...
		$this->status = $status;
		$this->archived = $archived;
		$this->how_you_heard_of_stepva = $how_you_heard_of_stepva;
		$this->preferred_feedback_method = $preferred_feedback_method;
		$this->hobbies = $hobbies;
		$this->professional_experience = $professional_experience;
		$this->disability_accomodation_needs = $disability_accomodation_needs;
		$this->training_complete = $training_complete;
        $this->training_date = $training_date;
		$this->orientation_complete = $orientation_complete;
        $this->orientation_date = $orientation_date;
		$this->background_complete = $background_complete;
        $this->background_date = $background_date;

		// access_level = 1 for users, and = 3 for admin
		if ($id == 'vmsroot') {
			$this->access_level = 3;
		} else {
			$this->access_level = 1;
		}
	}*/

	function get_id() {
		return $this->id;
	}

	function get_password() {
		return $this->password;
	}

	/*function get_start_date() {
		return $this->start_date;
	}*/

	function get_first_name() {
		return $this->first_name;
	}

	function get_last_name() {
		return $this->last_name;
	}

	function isMinor() {
		return $this->minor;
	}

	function get_total_hours() {
		return $this->total_hours;
	}

	function get_mandated_hours() {
		return $this->mandated_hours;
	}

	function get_remaining_mandated_hours() {
		return $this->remaining_mandated_hours;
	}

	function get_checked_in(){
		return $this->checked_in;
	}



	/*function get_birthday() {
		return $this->birthday;
	}*/

	function get_street_address() {
		return $this->street_address;
	}

	function get_city() {
		return $this->city;
	}

	function get_state() {
		return $this->state;
	}

	function get_zip_code() {
		return $this->zip_code;
	}

	function get_phone1() {
		return $this->phone1;
	}

	/*function get_phone1type() {
		return $this->phone1type;
	}*/

	function get_email() {
		return $this->email;
	}

	function get_emergency_contact_first_name() {
		return $this->emergency_contact_first_name;
	}

	function get_emergency_contact_last_name() {
		return $this->emergency_contact_last_name;
	}

	function get_emergency_contact_phone() {
		return $this->emergency_contact_phone;
	}

	/*function get_emergency_contact_phone_type() {
		return $this->emergency_contact_phone_type;
	}*/

	function get_emergency_contact_relation() {
		return $this->emergency_contact_relation;
	}

	/*function get_tshirt_size() {
		return $this->tshirt_size;
	}

	function get_school_affiliation() {
		return $this->school_affiliation;
	}

	function get_photo_release() {
		return $this->photo_release;
	}

	function get_photo_release_notes() {
		return $this->photo_release_notes;
	}*/

	function get_type() {
		return $this->type;
	}

	/*function get_status() {
		return $this->status;
	}*/

	/*function get_archived() {
		return $this->archived;
	}*/

	function get_access_level() {
		return $this->access_level;
	}

	/*function get_how_you_heard_of_stepva() {
		return $this->how_you_heard_of_stepva;
	}

	function get_preferred_feedback_method() {
		return $this->preferred_feedback_method;
	}

	function get_hobbies() {
		return $this->hobbies;
	}

	function get_professional_experience() {
		return $this->professional_experience;
	}

	function get_disability_accomodation_needs() {
		return $this->disability_accomodation_needs;
	}

	function get_training_complete() {
        return $this->training_complete;
    }

    function get_training_date() {
        return $this->training_date;
    }

	function get_orientation_complete() {
		return $this->orientation_complete;
	}
	
	function get_orientation_date() {
		return $this->orientation_date;
	}
	
	function get_background_complete() {
		return $this->background_complete;
	}
	
	function get_background_date() {
		return $this->background_date;
	}*/

}