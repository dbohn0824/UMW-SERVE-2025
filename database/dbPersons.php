<?php
/*
 * Copyright 2013 by Jerrick Hoang, Ivy Xing, Sam Roberts, James Cook, 
 * Johnny Coster, Judy Yang, Jackson Moniaga, Oliver Radwan, 
 * Maxwell Palmer, Nolan McNair, Taylor Talmage, and Allen Tucker. 
 * This program is part of RMH Homebase, which is free software.  It comes with 
 * absolutely no warranty. You can redistribute and/or modify it under the terms 
 * of the GNU General Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/ for more information).
 * 
 */

/**
 * @version March 1, 2012
 * @author Oliver Radwan and Allen Tucker
 */
include_once('dbinfo.php');
include_once(dirname(__FILE__).'/../domain/Person.php');

/*
 * add a person to dbpersons table: if already there, return false
 */

 function add_person($person) {
    if (!$person instanceof Person)
        die("Error: add_person type mismatch");

    $con = connect();

    $stmt = $con->prepare("SELECT * FROM dbpersons WHERE id = ?");
    $id = $person->get_id();
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result == null || $result->num_rows == 0) {
        // Assign values to variables before passing by reference
        $id = $person->get_id();
        $first_name = $person->get_first_name();
        $last_name = $person->get_last_name();
        $minor = $person->isMinor();
        $total_hours = $person->get_total_hours();
        $remaining_hours = $person->get_remaining_mandated_hours();
        $checked_in = $person->get_checked_in();
        $phone1 = $person->get_phone1();
        $email = $person->get_email();
        $notes = "n/a";
        $type = $person->get_type();
        $password = $person->get_password();
        $street_address = $person->get_street_address();
        $city = $person->get_city();
        $state = $person->get_state();
        $zip_code = $person->get_zip_code();
        $ec_first = $person->get_emergency_contact_first_name();
        $ec_last = $person->get_emergency_contact_last_name();
        $ec_phone = $person->get_emergency_contact_phone();
        $ec_relation = $person->get_emergency_contact_relation();

        $stmt = $con->prepare("INSERT INTO dbpersons (
            id, first_name, last_name, minor, total_hours, 
            remaining_mandated_hours, checked_in, phone1, email, notes, 
            type, password, street_address, city, state, zip_code, 
            emergency_contact_first_name, emergency_contact_last_name, 
            emergency_contact_phone, emergency_contact_relation
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param(
            "sssiiissssssssssssss",
            $id, $first_name, $last_name, $minor, $total_hours,
            $remaining_hours, $checked_in, $phone1, $email, $notes,
            $type, $password, $street_address, $city, $state, $zip_code,
            $ec_first, $ec_last, $ec_phone, $ec_relation
        );

        $stmt->execute();
        $stmt->close();
        $con->close();
        return true;
    }

    $stmt->close();
    $con->close();
    return false;
}


function add_staff($person) {
    if (!$person instanceof Person)
        die("Error: add_person type mismatch");

    $con = connect();

    // Secure SELECT
    $stmt = $con->prepare("SELECT * FROM dbpersons WHERE id = ?");
    $id = $person->get_id();
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result == null || $result->num_rows == 0) {
        // Assign values to variables first
        $id = $person->get_id();
        $first_name = $person->get_first_name();
        $last_name = $person->get_last_name();
        $minor = $person->isMinor();
        $total_hours = 0;
        $remaining_hours = $person->get_remaining_mandated_hours();
        $checked_in = 0;
        $phone1 = $person->get_phone1();
        $email = $person->get_email();
        $notes = "n/a";
        $type = $person->get_type();
        $password = $person->get_password();
        $street_address = $person->get_street_address();
        $city = $person->get_city();
        $state = $person->get_state();
        $zip_code = $person->get_zip_code();
        $ec_first = $person->get_emergency_contact_first_name();
        $ec_last = $person->get_emergency_contact_last_name();
        $ec_phone = $person->get_emergency_contact_phone();
        $ec_relation = $person->get_emergency_contact_relation();

        $insert = $con->prepare("INSERT INTO dbpersons (
            id, first_name, last_name, minor, total_hours, 
            remaining_mandated_hours, checked_in, phone1, email, notes, 
            type, password, street_address, city, state, zip_code, 
            emergency_contact_first_name, emergency_contact_last_name, 
            emergency_contact_phone, emergency_contact_relation
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $insert->bind_param(
            "sssiiissssssssssssss",
            $id, $first_name, $last_name, $minor, $total_hours,
            $remaining_hours, $checked_in, $phone1, $email, $notes,
            $type, $password, $street_address, $city, $state, $zip_code,
            $ec_first, $ec_last, $ec_phone, $ec_relation
        );

        $insert->execute();
        $insert->close();
        $stmt->close();
        $con->close();
        return true;
    }

    $stmt->close();
    $con->close();
    return false;
}

/*
 * remove a person from dbpersons table.  If already there, return false
 */

 function remove_person($id) {
    $con = connect();

    // Prepare SELECT query
    $stmt = $con->prepare("SELECT * FROM dbpersons WHERE id = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result == null || $result->num_rows == 0) {
        $stmt->close();
        $con->close();
        return false;
    }

    $stmt->close();

    // Prepare DELETE query
    $stmt = $con->prepare("DELETE FROM dbpersons WHERE id = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();

    $stmt->close();
    $con->close();
    return true;
}


/*
 * @return a Person from dbpersons table matching a particular id.
 * if not in table, return false
 */

 function retrieve_person($id) {
    $con = connect();

    // Use the correct column name if it's really a username
    $stmt = $con->prepare("SELECT * FROM dbpersons WHERE id = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows !== 1) {
        $stmt->close();
        $con->close();
        return false;
    }

    $result_row = $result->fetch_assoc();
    $stmt->close();
    $con->close();

    $thePerson = make_a_person($result_row);
    return $thePerson;
}


// Name is first concat with last name. Example 'James Jones'
// return array of Persons.
function retrieve_persons_by_name($name) {
    $persons = array();
    if (!isset($name) || trim($name) === "") return $persons;

    $con = connect();

    $name_parts = explode(" ", $name, 2);
    $first_name = $name_parts[0];
    $last_name = isset($name_parts[1]) ? $name_parts[1] : "";

    // Safe prepared statement
    $stmt = $con->prepare("SELECT * FROM dbpersons WHERE first_name = ? AND last_name = ?");
    $stmt->bind_param("ss", $first_name, $last_name);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($result_row = $result->fetch_assoc()) {
        $the_person = make_a_person($result_row);
        $persons[] = $the_person;
    }

    $stmt->close();
    $con->close();

    return $persons;
}


function change_password($id, $newPass) {
    $con = connect();

    $stmt = $con->prepare("UPDATE dbpersons SET password = ? WHERE id = ?");
    $stmt->bind_param("ss", $newPass, $id);
    $result = $stmt->execute();

    $stmt->close();
    $con->close();

    return $result;
}


function reset_password($id, $newPass) {
    $con = connect();

    $stmt = $con->prepare("UPDATE dbpersons SET password = ?, force_password_change = 1 WHERE id = ?");
    $stmt->bind_param("ss", $newPass, $id);
    $result = $stmt->execute();

    $stmt->close();
    $con->close();

    return $result;
}


function update_hours($id, $new_hours) {
    $con = connect();

    $stmt = $con->prepare("UPDATE dbpersons SET total_hours = ? WHERE id = ?");
    $stmt->bind_param("is", $new_hours, $id); // i = integer, s = string
    $result = $stmt->execute();

    $stmt->close();
    $con->close();

    return $result;
}


/*function update_birthday($id, $new_birthday) {
	$con=connect();
	$query = 'UPDATE dbpersons SET birthday = "' . $new_birthday . '" WHERE id = "' . $id . '"';
	$result = mysqli_query($con,$query);
	mysqli_close($con);
	return $result;
}*/

function update_volunteer_checkIn($entry_id, $Time_in, $id, $date) {
    $con = connect();

    // Prepare the statement
    $stmt = $con->prepare("UPDATE dbpersonhours SET Time_in = ? WHERE personID = ? AND date = ?");

    // Bind the parameters (all as strings: 's')
    $stmt->bind_param("sss", $Time_in, $entry_id, $date);

    // Execute the statement
    $result = $stmt->execute();

    // Close statement and connection
    $stmt->close();
    $con->close();

    return $result;
}


function update_volunteer_checkOut($entry_id, $Time_out, $id, $date) {
    $con = connect();
    $stmt = $con->prepare("UPDATE dbpersonhours SET Time_out = ? WHERE personID = ? AND date = ?");
    $stmt->bind_param("sss", $Time_out, $entry_id, $date);
    $result = $stmt->execute();
    $stmt->close();
    $con->close();

    return $result;
}


function get_hours_volunteered_by($id) {
    $con = connect();
    $stmt = $con->prepare("SELECT personID, date, Time_in, Time_out FROM dbpersonhours WHERE personID = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $entries = [];

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $entries[] = $row;
        }
    }
    $stmt->close();
    $con->close();

    return $entries;
}

/*@@@ Thomas */

/* Check-in a user by adding a new row and with start_time to dbpersonhours */
function check_in($personID, $start_time) {
    $con = connect();

    if (!can_check_in($personID)) {
        mysqli_close($con);
        echo '<script>
                alert("Already Checked In");
              </script>';
        return false;
    }

    $current_date = date('Y-m-d');

    $stmt = $con->prepare("INSERT INTO dbpersonhours (personID, date, Time_in) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $personID, $current_date, $start_time);
    $result = $stmt->execute();

    if ($result) {
        $update_stmt = $con->prepare("UPDATE dbpersons SET checked_in = 1 WHERE id = ?");
        $update_stmt->bind_param("s", $personID);
        $update_stmt->execute();
        $update_stmt->close();

        mysqli_close($con);

        echo '<script>
                alert("Successfully checked in!");
              </script>';
        return true;
    } else {
        echo "Error: Failed to record check-in time.";
        mysqli_close($con);
        return false;
    }
}


/* Check-out a user by adding their end_time to dbpersonhours */
function check_out($personID, $end_time) {
    $con = connect();
    $current_date = date('Y-m-d');

    if (!can_check_out($personID)) {
        echo '<script>
                alert("You are not checked in.");
              </script>';
        mysqli_close($con);
        return false;
    }

    $stmt = $con->prepare("SELECT Time_in FROM dbpersonhours WHERE personID = ? AND date = ? ORDER BY Time_in DESC LIMIT 1");
    $stmt->bind_param("ss", $personID, $current_date);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $Time_in = $row['Time_in'];
    $stmt->close();

    $stmt = $con->prepare("UPDATE dbpersonhours SET Time_out = ? WHERE personID = ? AND date = ? AND Time_in = ?");
    $stmt->bind_param("ssss", $end_time, $personID, $current_date, $Time_in);
    $update_result = $stmt->execute();
    $stmt->close();

    if ($update_result) {
        $stmt = $con->prepare("UPDATE dbpersons SET checked_in = 0 WHERE id = ?");
        $stmt->bind_param("s", $personID);
        $stmt->execute();
        $stmt->close();

        synchronize_hours($personID);

        $stmt = $con->prepare("SELECT remaining_mandated_hours FROM dbpersons WHERE id = ?");
        $stmt->bind_param("s", $personID);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $remaining_mandated_hours = $row['remaining_mandated_hours'];
        $stmt->close();

        $stmt = $con->prepare("SELECT Total_hours FROM dbpersonhours WHERE personID = ? AND date = ? AND Time_in = ?");
        $stmt->bind_param("sss", $personID, $current_date, $Time_in);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $hours = $row['Total_hours'];
        $stmt->close();

        $remaining_mandated_hours -= $hours;
        if ($remaining_mandated_hours < 0) {
            $remaining_mandated_hours = 0;
        }

        $stmt = $con->prepare("UPDATE dbpersons SET remaining_mandated_hours = ? WHERE id = ?");
        $stmt->bind_param("ds", $remaining_mandated_hours, $personID);
        $stmt->execute();
        $stmt->close();

        mysqli_close($con);

        echo '<script>
                alert("Successfully checked out!");
              </script>';
        return true;
    } else {
        echo "Error: Failed to check out. Please try again.";
        mysqli_close($con);
        return false;
    }
}

function can_check_in($personID) {
    $con = connect();

    $stmt = $con->prepare("SELECT checked_in FROM dbpersons WHERE id = ?");
    $stmt->bind_param("s", $personID);
    $stmt->execute();
    $result = $stmt->get_result();
    $person = $result->fetch_assoc();

    $stmt->close();
    $con->close();

    if ($person && $person['checked_in'] == 1) {
        return false;
    }

    return true;
}


function can_check_out($personID) {
    $con = connect();

    $stmt = $con->prepare("SELECT checked_in FROM dbpersons WHERE id = ?");
    $stmt->bind_param("s", $personID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        $person = $result->fetch_assoc();
        if ($person && $person['checked_in'] == 1) {
            $stmt->close();
            $con->close();
            return true;
        } else {
            echo "No active session found for personID: $personID";
        }
    } else {
        echo "Error: Query failed to execute.";
    }

    $stmt->close();
    $con->close();
    return false;
}


/* Return number of seconds a volunteer worked for a specific event */
function fetch_volunteering_hours($personID) {
    $con = connect();

    $stmt = $con->prepare("SELECT start_time, end_time FROM dbpersonhours WHERE personID = ? AND end_time IS NOT NULL");
    $stmt->bind_param("s", $personID);
    $stmt->execute();
    $result = $stmt->get_result();

    $total_time = 0;

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $start_time = strtotime($row['start_time']);
            $end_time = strtotime($row['end_time']);
            $total_time += $end_time - $start_time;
        }
        $stmt->close();
        $con->close();
        return $total_time;
    }

    $stmt->close();
    $con->close();
    return -1;
}


/* Return number of seconds a volunteer worked for a specific date range */
function get_hours_for_range($personID, $startDate, $endDate) {
    $con = connect();

    $stmt = $con->prepare("SELECT date, total_hours FROM dbpersonhours WHERE personID = ? AND Time_out IS NOT NULL");
    $stmt->bind_param("s", $personID);
    $stmt->execute();
    $result = $stmt->get_result();

    $total_time = 0;

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            if ($row['date'] >= $startDate && $row['date'] <= $endDate) {
                $total_time += $row['total_hours'];
            }
        }
        $stmt->close();
        $con->close();
        return $total_time;
    }

    $stmt->close();
    $con->close();
    return -1;
}


function get_first_date($personID) {
    $con = connect();

    $stmt = $con->prepare("SELECT date FROM dbpersonhours WHERE personID = ? AND Time_out IS NOT NULL ORDER BY date LIMIT 1");
    $stmt->bind_param("s", $personID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $row = $result->fetch_assoc()) {
        $stmt->close();
        $con->close();
        return $row['date'];
    }

    $stmt->close();
    $con->close();
    return -1;
}

function get_last_date($personID) {
    $con = connect();

    $stmt = $con->prepare("SELECT date FROM dbpersonhours WHERE personID = ? AND Time_out IS NOT NULL ORDER BY date DESC LIMIT 1");
    $stmt->bind_param("s", $personID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $row = $result->fetch_assoc()) {
        $stmt->close();
        $con->close();
        return $row['date'];
    }

    $stmt->close();
    $con->close();
    return -1;
}


// Loose function that automatically re-sums total volunteering hours
function synchronize_hours($personID){
    $currentDate = date('Y-m-d');
    $tot = get_hours_for_range($personID, 1979-01-01, $currentDate);
    update_hours($personID, $tot);

    return -1;
}

/* Delete a single check-in/check-out pair as defined by the given parameters */
function delete_check_in($userID, $eventID, $start_time, $end_time) {
    $con = connect();

    $stmt = $con->prepare("DELETE FROM dbpersonhours WHERE personID = ? AND eventID = ? AND start_time = ? AND end_time = ? LIMIT 1");
    $stmt->bind_param("ssss", $userID, $eventID, $start_time, $end_time);
    $stmt->execute();

    $stmt->close();
    $con->close();
}


/*@@@ end Thomas */


/*
 * Updates the profile picture link of the corresponding
 * id.
*/

/*function update_profile_pic($id, $link) {
  $con = connect();
  $query = 'UPDATE dbpersons SET profile_pic = "'.$link.'" WHERE id ="'.$id.'"';
  $result = mysqli_query($con, $query);
  mysqli_close($con);
  return $result;
}*/

/*
 * Returns the age of the person by subtracting the 
 * person's birthday from the current date
*/

/*function get_age($birthday) {

  $today = date("Ymd");
  // If month-day is before the person's birthday,
  // subtract 1 from current year - birth year
  $age = date_diff(date_create($birthday), date_create($today))->format('%y');

  return $age;
}

function update_start_date($id, $new_start_date) {
	$con=connect();
	$query = 'UPDATE dbpersons SET start_date = "' . $new_start_date . '" WHERE id = "' . $id . '"';
	$result = mysqli_query($con,$query);
	mysqli_close($con);
	return $result;
}*/

/*
 * @return all rows from dbpersons table ordered by last name
 * if none there, return false
 

function getall_dbpersons($name_from, $name_to, $venue) {
    $con=connect();
    $query = "SELECT * FROM dbpersons";
    $query.= " WHERE venue = '" .$venue. "'"; 
    $query.= " AND last_name BETWEEN '" .$name_from. "' AND '" .$name_to. "'"; 
    $query.= " ORDER BY last_name,first_name";
    $result = mysqli_query($con,$query);
    if ($result == null || mysqli_num_rows($result) == 0) {
        mysqli_close($con);
        return false;
    }
    $result = mysqli_query($con,$query);
    $thePersons = array();
    while ($result_row = mysqli_fetch_assoc($result)) {
        $thePerson = make_a_person($result_row);
        $thePersons[] = $thePerson;
    }

    return $thePersons;
}
    */

/*
  @return all rows from dbpersons

*/
function getall_volunteers() {
    $con = connect();

    $stmt = $con->prepare('SELECT * FROM dbpersons WHERE id != ?');
    $excludedID = 'vmsroot';
    $stmt->bind_param("s", $excludedID);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result || $result->num_rows === 0) {
        $stmt->close();
        $con->close();
        return false;
    }

    $thePersons = array();
    while ($result_row = $result->fetch_assoc()) {
        $thePersons[] = make_a_person($result_row);
    }

    $stmt->close();
    $con->close();
    return $thePersons;
}


function getall_volunteer_names() {
    $con = connect();
    $type = '%volunteer%';

    $stmt = $con->prepare("SELECT first_name, last_name FROM dbpersons WHERE type LIKE ?");
    $stmt->bind_param("s", $type);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result || $result->num_rows === 0) {
        $stmt->close();
        $con->close();
        return false;
    }

    $names = array();
    while ($row = $result->fetch_assoc()) {
        $names[] = $row['first_name'] . ' ' . $row['last_name'];
    }

    $stmt->close();
    $con->close();
    return $names;
}


function make_a_person($result_row) {
	/*
	 ($f, $l, $v, $a, $c, $s, $z, $p1, $p1t, $p2, $p2t, $e, $ts, $comp, $cam, $tran, $cn, $cpn, $rel,
			$ct, $t, $st, $cntm, $pos, $credithours, $comm, $mot, $spe,
			$convictions, $av, $sch, $hrs, $bd, $sd, $hdyh, $notes, $pass)
	 */
    $thePerson = new Person(
        $result_row['id'],                           // $id
        $result_row['password'],                     // $password
        $result_row['first_name'],                   // $first_name
        $result_row['last_name'],                    // $last_name
        $result_row['street_address'],               // $street_address
        $result_row['city'],                         // $city
        $result_row['state'],                        // $state
        $result_row['zip_code'],                     // $zip_code
        $result_row['notes'],                        // $notes
        $result_row['phone1'],                       // $phone1
        $result_row['email'],                        // $email
        $result_row['minor'],                        // $minor
        $result_row['total_hours'],                  // $total_hours
        $result_row['remaining_mandated_hours'],     // $remaining_mandated_hours
        $result_row['emergency_contact_first_name'], // $emergency_contact_first_name
        $result_row['emergency_contact_last_name'],  // $emergency_contact_last_name
        $result_row['emergency_contact_phone'],      // $emergency_contact_phone
        $result_row['emergency_contact_relation'],   // $emergency_contact_relation
        $result_row['type']             
        /*$result_row['id'],
        $result_row['first_name'],
        $result_row['last_name'],
        $result_row['minor'],
        $result_row['total_hours'],
        $result_row['remaining_mandated_hours'],
        $result_row['checked_in'],
        $result_row['phone1'],
        $result_row['email'],
        $result_row['notes'],
        $result_row['password'],
        $result_row['street_address'],
        $result_row['city'],
        $result_row['state'],
        $result_row['zip_code'],
        $result_row['emergency_contact_first_name'],
        $result_row['emergency_contact_last_name'],
        $result_row['emergency_contact_phone'],
        $result_row['emergency_contact_relation']*/
        /*$result_row['start_date'],
        $result_row['birthday'],
        $result_row['phone1type'],
        $result_row['tshirt_size'],
        $result_row['emergency_contact_phone_type'],
        $result_row['school_affiliation'],
        $result_row['photo_release'],
        $result_row['photo_release_notes'],
        $result_row['type'],
        $result_row['status'],
        $result_row['archived'],
        $result_row['how_you_heard_of_stepva'],
        $result_row['preferred_feedback_method'],
        $result_row['hobbies'],
        $result_row['professional_experience'],
        $result_row['disability_accomodation_needs'],
        $result_row['training_complete'],
        $result_row['training_date'],
        $result_row['orientation_complete'],
        $result_row['orientation_date'],
        $result_row['background_complete'],
        $result_row['background_date']*/
    );

    return $thePerson;
}

function getall_names($status, $type, $venue) {
    $con = connect();

    $type = '%' . $type . '%';
    $stmt = $con->prepare("SELECT id, first_name, last_name, type FROM dbpersons WHERE venue = ? AND status = ? AND type LIKE ? ORDER BY last_name, first_name");
    $stmt->bind_param("sss", $venue, $status, $type);
    $stmt->execute();
    $result = $stmt->get_result();

    $stmt->close();
    $con->close();

    return $result;
}


/*
 * @return all active people of type $t or subs from dbpersons table ordered by last name
 */

 function getall_type($t) {
    $con = connect();

    $type = '%' . $t . '%';
    $sub = '%sub%';

    $stmt = $con->prepare("SELECT * FROM dbpersons WHERE (type LIKE ? OR type LIKE ?) AND status = 'active' ORDER BY last_name, first_name");
    $stmt->bind_param("ss", $type, $sub);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result || $result->num_rows === 0) {
        $stmt->close();
        $con->close();
        return false;
    }

    $stmt->close();
    $con->close();
    return $result;
}


/*
 *   get all active volunteers and subs of $type who are available for the given $frequency,$week,$day,and $shift
 */

/*function getall_available($type, $day, $shift, $venue) {
    $con=connect();
    $query = "SELECT * FROM dbpersons WHERE (type LIKE '%" . $type . "%' OR type LIKE '%sub%')" .
            " AND availability LIKE '%" . $day .":". $shift .
            "%' AND status = 'active' AND venue = '" . $venue . "' ORDER BY last_name,first_name";
    $result = mysqli_query($con,$query);
    mysqli_close($con);
    return $result;
}

function getvolunteers_byevent($id){
	 $con = connect();
	 $query = 'SELECT * FROM dbeventpersons JOIN dbpersons WHERE eventID = "' . $id . '"' .
	 			"AND dbeventpersons.userID = dbpersons.id";
	 $result = mysqli_query($con, $query);
	 $thePersons = array();
    while ($result_row = mysqli_fetch_assoc($result)) {
       $thePerson = make_a_person($result_row);
       $thePersons[] = $thePerson;
   }
   mysqli_close($con);
   return $thePersons;
}*/


// retrieve only those persons that match the criteria given in the arguments
function getonlythose_dbpersons($type, $status, $name, $day, $shift, $venue) {
    $con = connect();

    $type = '%' . $type . '%';
    $status = '%' . $status . '%';
    $name = '%' . $name . '%';
    $day = '%' . $day . '%';
    $shift = '%' . $shift . '%';

    $stmt = $con->prepare(
        "SELECT * FROM dbpersons 
         WHERE type LIKE ? 
         AND status LIKE ? 
         AND (first_name LIKE ? OR last_name LIKE ?) 
         AND availability LIKE ? 
         AND availability LIKE ? 
         AND venue = ?
         ORDER BY last_name, first_name"
    );

    $stmt->bind_param("sssssss", $type, $status, $name, $name, $day, $shift, $venue);
    $stmt->execute();
    $result = $stmt->get_result();

    $thePersons = array();
    while ($result_row = $result->fetch_assoc()) {
        $thePersons[] = make_a_person($result_row);
    }

    $stmt->close();
    $con->close();
    return $thePersons;
}


function phone_edit($phone) {
    if ($phone!="")
		return substr($phone, 0, 3) . "-" . substr($phone, 3, 3) . "-" . substr($phone, 6);
	else return "";
}

function get_people_for_export($attr, $first_name, $last_name, $type, $status, $start_date, $city, $zip, $phone, $email) {
    $con = connect();

    $first_name = $first_name !== "." ? $first_name : ".*";
    $last_name = $last_name !== "." ? $last_name : ".*";
    $city = $city !== "." ? $city : ".*";
    $zip = $zip !== "." ? $zip : ".*";
    $phone = $phone !== "." ? $phone : ".*";
    $email = $email !== "." ? $email : ".*";

    if (!isset($type) || count($type) === 0) {
        $type_query = ".*";
    } else {
        $type_query = implode("|", array_map('preg_quote', $type));
        $type_query = ".*($type_query).*";
    }

    $query = "
        SELECT $attr FROM dbpersons 
        WHERE first_name REGEXP ? 
          AND last_name REGEXP ? 
          AND type REGEXP ? 
          AND city REGEXP ? 
          AND zip REGEXP ? 
          AND (phone1 REGEXP ? OR phone2 REGEXP ?) 
          AND email REGEXP ? 
        ORDER BY last_name, first_name
    ";

    $stmt = $con->prepare($query);
    $stmt->bind_param("ssssssss", $first_name, $last_name, $type_query, $city, $zip, $phone, $phone, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    $stmt->close();
    $con->close();
    return $result;
}

//return an array of "last_name:first_name:birth_date", and sorted by month and day
/*function get_birthdays($name_from, $name_to, $venue) {
	$con=connect();
   	$query = "SELECT * FROM dbpersons WHERE availability LIKE '%" . $venue . "%'" . 
   	//$query.= " AND last_name BETWEEN '" .$name_from. "' AND '" .$name_to. "'";
    //$query.= " ORDER BY birthday";
	//$result = mysqli_query($con,$query);
	$thePersons = array();
	while ($result_row = mysqli_fetch_assoc($result)) {
    	$thePerson = make_a_person($result_row);
        $thePersons[] = $thePerson;
	}
   	mysqli_close($con);
   	return $thePersons;
}*/

//return an array of "last_name;first_name;hours", which is "last_name;first_name;date:start_time-end_time:venue:totalhours"
// and sorted alphabetically
function get_logged_hours($from, $to, $name_from, $name_to, $venue) {
    $con = connect();

    $stmt = $con->prepare(
        "SELECT first_name, last_name, hours, venue 
         FROM dbpersons 
         WHERE venue = ? 
           AND last_name BETWEEN ? AND ? 
         ORDER BY last_name, first_name"
    );

    $stmt->bind_param("sss", $venue, $name_from, $name_to);
    $stmt->execute();
    $result = $stmt->get_result();

    $thePersons = array();

    while ($row = $result->fetch_assoc()) {
        if (!empty($row['hours'])) {
            $shifts = explode(',', $row['hours']);
            $goodshifts = array();

            foreach ($shifts as $shift) {
                $shiftDate = substr($shift, 0, 8);
                if (($from === "" || $shiftDate >= $from) && ($to === "" || $shiftDate <= $to)) {
                    $goodshifts[] = $shift;
                }
            }

            if (count($goodshifts) > 0) {
                $newshifts = implode(",", $goodshifts);
                $thePersons[] = $row['last_name'] . ";" . $row['first_name'] . ";" . $newshifts;
            }
        }
    }

    $stmt->close();
    $con->close();
    return $thePersons;
}


/*
            $person->get_id() . '","' .
            $person->get_start_date() . '","' .
            "n/a" . '","' . /* ("venue", we don't use this) 
            $person->get_first_name() . '","' .
            $person->get_last_name() . '","' .
            $person->get_street_address() . '","' .
            $person->get_city() . '","' .
            $person->get_state() . '","' .
            $person->get_zip_code() . '","' .
            $person->get_phone1() . '","' .
            $person->get_phone1type() . '","' .
            $person->get_emergency_contact_phone() . '","' .
            $person->get_emergency_contact_phone_type() . '","' .
            $person->get_birthday() . '","' .
            $person->get_email() . '","' .
            $person->get_emergency_contact_first_name() . '","' .
            'n/a' . '","' . /* ("contact_num", we don't use this) 
            $person->get_emergency_contact_relation() . '","' .
            'n/a' . '","' . /* ("contact_method", we don't use this) 
            $person->get_type() . '","' .
            $person->get_status() . '","' .
            'n/a' . '","' . /* ("notes", we don't use this) 
            $person->get_password() . '","' .
            'n/a' . '","' . /* ("profile_pic", we don't use this) 
            'gender' . '","' .
            $person->get_tshirt_size() . '","' .
            'how_you_heard_of_stepva' . '","' .
            'sensory_sensitivities' . '","' .
            'disability_accomodation_needs' . '","' .
            $person->get_school_affiliation() . '","' .
            'race' . '","' .
            'preferred_feedback_method' . '","' .
            'hobbies' . '","' .
            'professional_experience' . '","' .
            $person->get_archived() . '","' .
            $person->get_emergency_contact_last_name() . '","' .
            $person->get_photo_release() . '","' .
            $person->get_photo_release_notes() . '");'
*/
    // updates the required fields of a person's account
    function update_person_required(
        $id, $first_name, $last_name, $birthday, $street_address, $city, $state,
        $zip_code, $email, $phone1,
        $emergency_contact_first_name, $emergency_contact_last_name,
        $emergency_contact_phone, $emergency_contact_relation, $type
    ) {
        $connection = connect();
    
        $stmt = $connection->prepare(
            "UPDATE dbpersons SET 
                first_name = ?, last_name = ?, birthday = ?, street_address = ?, city = ?, state = ?, 
                zip_code = ?, email = ?, phone1 = ?, 
                emergency_contact_first_name = ?, emergency_contact_last_name = ?, emergency_contact_phone = ?, 
                emergency_contact_relation = ?, type = ?
             WHERE id = ?"
        );
    
        $stmt->bind_param(
            "sssssssssssssss",
            $first_name, $last_name, $birthday, $street_address, $city, $state,
            $zip_code, $email, $phone1,
            $emergency_contact_first_name, $emergency_contact_last_name, $emergency_contact_phone,
            $emergency_contact_relation, $type,
            $id
        );
    
        $result = $stmt->execute();
        $stmt->close();
        mysqli_commit($connection);
        mysqli_close($connection);
    
        return $result;
    }
    

    /**
     * Searches the database and returns an array of all volunteers
     * that are eligible to attend the given event that have not yet
     * signed up/been assigned to the event.
     * 
     * Eligibility criteria: availability falls within event start/end time
     * and start date falls before or on the volunteer's start date.
     */
    /*function get_unassigned_available_volunteers($eventID) {
        $connection = connect();
        $query = "select * from dbEvents where id='$eventID'";
        $result = mysqli_query($connection, $query);
        if (!$result) {
            mysqli_close($connection);
            return null;
        }
        $event = mysqli_fetch_assoc($result);
        $event_start = $event['startTime'];
        $event_end = $event['startTime'];
        $date = $event['date'];
        $dateInt = strtotime($date);
        $dayofweek = strtolower(date('l', $dateInt));
        $dayname_start = $dayofweek . 's_start';
        $dayname_end = $dayofweek . 's_end';
        $query = "select * from dbpersons
            where 
            $dayname_start<='$event_start' and $dayname_end>='$event_end'
            and start_date<='$date'
            and id != 'vmsroot' 
            and status='Active'
            and id not in (select userID from dbEventVolunteers where eventID='$eventID')
            order by last_name, first_name";
        $result = mysqli_query($connection, $query);
        if ($result == null || mysqli_num_rows($result) == 0) {
            mysqli_close($connection);
            return null;
        }
        $thePersons = array();
        while ($result_row = mysqli_fetch_assoc($result)) {
            $thePerson = make_a_person($result_row);
            $thePersons[] = $thePerson;
        }
        mysqli_close($connection);
        return $thePersons;
    }*/

    function find_self($name) {
        if (!$name) {
            return [];
        }
    
        $connection = connect();
    
        if (strpos($name, ' ') !== false) {
            [$first, $last] = explode(' ', $name, 2);
            $first = '%' . $first . '%';
            $last = '%' . $last . '%';
            $stmt = $connection->prepare("SELECT * FROM dbpersons WHERE first_name LIKE ? AND last_name LIKE ? ORDER BY last_name, first_name");
            $stmt->bind_param("ss", $first, $last);
        } else {
            $pattern = '%' . $name . '%';
            $stmt = $connection->prepare("SELECT * FROM dbpersons WHERE first_name LIKE ? OR last_name LIKE ? ORDER BY last_name, first_name");
            $stmt->bind_param("ss", $pattern, $pattern);
        }
    
        $stmt->execute();
        $result = $stmt->get_result();
    
        if (!$result) {
            $stmt->close();
            $connection->close();
            return [];
        }
    
        $raw = $result->fetch_all(MYSQLI_ASSOC);
        $persons = [];
    
        foreach ($raw as $row) {
            if ($row['id'] === 'vmsroot') {
                continue;
            }
            $persons[] = make_a_person($row);
        }
    
        $stmt->close();
        $connection->close();
        return $persons;
    }
    

    function find_users($name, $id, $phone, $zip, $type, $status, $photo_release) {
        if (!($name || $id || $phone || $zip || $type || $status || $photo_release)) {
            return [];
        }
    
        $connection = connect();
        $conditions = [];
        $params = [];
        $types = '';
    
        if ($name) {
            if (strpos($name, ' ') !== false) {
                [$first, $last] = explode(' ', $name, 2);
                $conditions[] = "first_name LIKE ? AND last_name LIKE ?";
                $params[] = '%' . $first . '%';
                $params[] = '%' . $last . '%';
                $types .= 'ss';
            } else {
                $conditions[] = "(first_name LIKE ? OR last_name LIKE ?)";
                $params[] = '%' . $name . '%';
                $params[] = '%' . $name . '%';
                $types .= 'ss';
            }
        }
    
        if ($id) {
            $conditions[] = "id LIKE ?";
            $params[] = '%' . $id . '%';
            $types .= 's';
        }
    
        if ($phone) {
            $conditions[] = "phone1 LIKE ?";
            $params[] = '%' . $phone . '%';
            $types .= 's';
        }
    
        if ($zip) {
            $conditions[] = "zip LIKE ?";
            $params[] = '%' . $zip . '%';
            $types .= 's';
        }
    
        if ($type) {
            $conditions[] = "type = ?";
            $params[] = $type;
            $types .= 's';
        }
    
        if ($status) {
            $conditions[] = "status = ?";
            $params[] = $status;
            $types .= 's';
        }
    
        if ($photo_release) {
            $conditions[] = "photo_release = ?";
            $params[] = $photo_release;
            $types .= 's';
        }
    
        $where = implode(' AND ', $conditions);
        $query = "SELECT * FROM dbpersons WHERE $where ORDER BY last_name, first_name";
    
        $stmt = $connection->prepare($query);
        if ($types !== '') {
            $stmt->bind_param($types, ...$params);
        }
    
        $stmt->execute();
        $result = $stmt->get_result();
    
        if (!$result) {
            $stmt->close();
            $connection->close();
            return [];
        }
    
        $raw = $result->fetch_all(MYSQLI_ASSOC);
        $persons = [];
    
        foreach ($raw as $row) {
            if ($row['id'] === 'vmsroot') {
                continue;
            }
            $persons[] = make_a_person($row);
        }
    
        $stmt->close();
        $connection->close();
        return $persons;
    }
    

    function find_user_names($name) {
        if (!$name) {
            return [];
        }
    
        $connection = connect();
    
        if (strpos($name, ' ') !== false) {
            [$first, $last] = explode(' ', $name, 2);
            $first = '%' . $first . '%';
            $last = '%' . $last . '%';
            $stmt = $connection->prepare(
                "SELECT * FROM dbpersons WHERE first_name LIKE ? AND last_name LIKE ? ORDER BY last_name, first_name"
            );
            $stmt->bind_param("ss", $first, $last);
        } else {
            $pattern = '%' . $name . '%';
            $stmt = $connection->prepare(
                "SELECT * FROM dbpersons WHERE first_name LIKE ? OR last_name LIKE ? ORDER BY last_name, first_name"
            );
            $stmt->bind_param("ss", $pattern, $pattern);
        }
    
        $stmt->execute();
        $result = $stmt->get_result();
    
        if (!$result) {
            $stmt->close();
            $connection->close();
            return [];
        }
    
        $raw = $result->fetch_all(MYSQLI_ASSOC);
        $persons = [];
    
        foreach ($raw as $row) {
            if ($row['id'] === 'vmsroot') {
                continue;
            }
            $persons[] = make_a_person($row);
        }
    
        $stmt->close();
        $connection->close();
        return $persons;
    }
    

    function update_type($id, $role) {
        $con = connect();
    
        $stmt = $con->prepare("UPDATE dbpersons SET type = ? WHERE id = ?");
        $stmt->bind_param("ss", $role, $id);
        $result = $stmt->execute();
    
        $stmt->close();
        $con->close();
    
        return $result;
    }
    
    
    function update_status($id, $new_status) {
        $con = connect();
    
        $stmt = $con->prepare("UPDATE dbpersons SET status = ? WHERE id = ?");
        $stmt->bind_param("ss", $new_status, $id);
        $result = $stmt->execute();
    
        $stmt->close();
        $con->close();
    
        return $result;
    }
    
    function update_notes($id, $new_notes) {
        $con = connect();
    
        $stmt = $con->prepare("UPDATE dbpersons SET notes = ? WHERE id = ?");
        $stmt->bind_param("ss", $new_notes, $id);
        $result = $stmt->execute();
    
        $stmt->close();
        $con->close();
    
        return $result;
    }
    
    
    function get_dbtype($id) {
        $con = connect();
    
        $stmt = $con->prepare("SELECT type FROM dbpersons WHERE id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $stmt->close();
        $con->close();
    
        return $result;
    }
    
    date_default_timezone_set("America/New_York");

    /*function get_events_attended_by($personID) {
        $today = date("Y-m-d");
        $query = "select * from dbeventpersons, dbevents
                  where userID='$personID' and eventID=id
                  and date<='$today'
                  order by date asc";
        $connection = connect();
        $result = mysqli_query($connection, $query);
        if ($result) {
            require_once('include/time.php');
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
            mysqli_close($connection);
            foreach ($rows as &$row) {
                $row['duration'] = calculateHourDuration($row['startTime'], $row['endTime']);
            }
            unset($row); // suggested for security
            return $rows;
        } else {
            mysqli_close($connection);
            return [];
        }
    }

    function get_event_from_id($eventID) {
        // Connect to the database
        $connection = connect();
    
        // Escape the eventID to prevent SQL injection
        $eventID = mysqli_real_escape_string($connection, $eventID);
    
        // Prepare the SQL query with the eventID directly
        $query = "SELECT name FROM dbevents WHERE id = '$eventID'";
    
        // Execute the query
        $result = mysqli_query($connection, $query);
    
        // Check if there are results
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            mysqli_close($connection);
    
            return $row['name'];  // Return only the name as a string
        } else {
            mysqli_close($connection);
            return null;  // Return null if there is no result
        }
    }*/
    

    /* @@@ Thomas
     * 
     * This funcion returns a list of eventIDs that a given user has attended.
     */
    /*function get_attended_event_ids($personID) {
        $con=connect();
        $query = "SELECT DISTINCT eventID FROM dbpersonhours WHERE personID = '" .$personID. "' ORDER BY eventID DESC";            
        $result = mysqli_query($con, $query);


        if ($result) {
            $rows = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $rows[] = $row['eventID']; // Collect only the event IDs
            }
            mysqli_free_result($result);
            mysqli_close($con);
            return $rows;  // Return an array of event IDs
        } else {
            mysqli_close($con);
            return []; // Return an empty array if no results are found
        }
    }

    function get_check_in_outs($personID, $event) {
        $con=connect();
        $query = "SELECT start_time, end_time FROM dbpersonhours WHERE personID = '" .$personID. "' and eventID = '" .$event. "' AND end_time IS NOT NULL";            
        $result = mysqli_query($con, $query);


        if ($result) {
            $row = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $rows[] = $row; // Collect only the event IDs
            }
            mysqli_free_result($result);
            mysqli_close($con);
            return $rows;  // Return an array of event IDs
        } else {
            mysqli_close($con);
            return []; // Return an empty array if no results are found
        }
    }*/
    /*@@@ end Thomas */

    
    /*function get_events_attended_by_2($personID) {
        // Prepare the SQL query to select rows where personID matches
        $query = "SELECT personID, eventID, start_time, end_time FROM dbpersonhours WHERE personID = ?";
        
        // Connect to the database
        $connection = connect();
        
        // Prepare the statement to prevent SQL injection
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "s", $personID);
        
        // Execute the query
        mysqli_stmt_execute($stmt);
        
        // Get the result
        $result = mysqli_stmt_get_result($stmt);
        
        // Check if there are results
        if ($result) {
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
            mysqli_close($connection);
    
            return $rows;  // Return the rows as they are from the database
        } else {
            mysqli_close($connection);
            return [];
        }
    }*/

    /*function get_events_attended_by_and_date($personID,$fromDate,$toDate) {
        $today = date("Y-m-d");
        $query = "select * from dbEventVolunteers, dbEvents
                  where userID='$personID' and eventID=id
                  and date<='$toDate' and date >= '$fromDate'
                  order by date desc";
        $connection = connect();
        $result = mysqli_query($connection, $query);
        if ($result) {
            require_once('include/time.php');
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
            mysqli_close($connection);
            foreach ($rows as &$row) {
                $row['duration'] = calculateHourDuration($row['startTime'], $row['endTime']);
            }
            unset($row); // suggested for security
            return $rows;
        } else {
            mysqli_close($connection);
            return [];
        }
    }

    function get_events_attended_by_desc($personID) {
        $today = date("Y-m-d");
        $query = "select * from dbEventVolunteers, dbEvents
                  where userID='$personID' and eventID=id
                  and date<='$today'
                  order by date desc";
        $connection = connect();
        $result = mysqli_query($connection, $query);
        if ($result) {
            require_once('include/time.php');
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
            mysqli_close($connection);
            foreach ($rows as &$row) {
                $row['duration'] = calculateHourDuration($row['startTime'], $row['endTime']);
            }
            unset($row); // suggested for security
            return $rows;
        } else {
            mysqli_close($connection);
            return [];
        }
    }*/

    /*function get_hours_volunteered_by($personID) {
        $events = get_events_attended_by($personID);
        $hours = 0;
        foreach ($events as $event) {
            $duration = $event['duration'];
            if ($duration > 0) {
                $hours += $duration;
            }
        }
        return $hours;
    }

    function get_hours_volunteered_by_and_date($personID,$fromDate,$toDate) {
        $events = get_events_attended_by_and_date($personID,$fromDate,$toDate);
        $hours = 0;
        foreach ($events as $event) {
            $duration = $event['duration'];
            if ($duration > 0) {
                $hours += $duration;
            }
        }
        return $hours;
    }*/

    function get_tot_vol_hours($type,$stats,$dateFrom,$dateTo,$lastFrom,$lastTo){
        $con = connect();
        $type1 = "volunteer";
        //$stats = "Active";
        if(($type=="general_volunteer_report" || $type == "total_vol_hours") && ($dateFrom == NULL && $dateTo == NULL && $lastFrom == NULL && $lastTo == NULL)){
	    if ($stats == 'Active' || $stats == 'Inactive') 
            	$query = $query = "SELECT * FROM dbpersons WHERE type='$type1' AND status='$stats'";
            else
            	$query = $query = "SELECT * FROM dbpersons WHERE type='$type1'";
	    $result = mysqli_query($con,$query);
            $totHours = array();
            while($row = mysqli_fetch_assoc($result)){
                $hours = get_hours_volunteered_by($row['id']);
                $totHours[] = $hours;
            }
            $sum = 0;
            foreach($totHours as $hrs){
                $sum += $hrs;
            }
            return $sum;
        }
        elseif(($type=="general_volunteer_report" || $type == "total_vol_hours") && ($dateFrom && $dateTo && $lastFrom && $lastTo)){
            $today = date("Y-m-d");
	    if ($stats == 'Active' || $stats == 'Inactive') 
		$query = "SELECT dbpersons.id,dbpersons.first_name,dbpersons.last_name, SUM(HOUR(TIMEDIFF(dbEvents.endTime, dbEvents.startTime))) as Dur
                FROM dbpersons JOIN dbEventVolunteers ON dbpersons.id = dbEventVolunteers.userID
                JOIN dbEvents ON dbEventVolunteers.eventID = dbEvents.id
                WHERE date >= '$dateFrom' AND date<='$dateTo' AND dbpersons.status='$stats' GROUP BY dbpersons.first_name,dbpersons.last_name
                ORDER BY Dur";            
	    else
                $query = "SELECT dbpersons.id,dbpersons.first_name,dbpersons.last_name, SUM(HOUR(TIMEDIFF(dbEvents.endTime, dbEvents.startTime))) as Dur
                FROM dbpersons JOIN dbEventVolunteers ON dbpersons.id = dbEventVolunteers.userID
                JOIN dbEvents ON dbEventVolunteers.eventID = dbEvents.id
		WHERE date >= '$dateFrom' AND date<='$dateTo'
		GROUP BY dbpersons.first_name,dbpersons.last_name
                ORDER BY Dur";
                $result = mysqli_query($con,$query);
                try {
                    // Code that might throw an exception or error goes here
                    $dd = getBetweenDates($dateFrom, $dateTo);
                    $nameRange = range($lastFrom,$lastTo);
                    $bothRange = array_merge($dd,$nameRange);
                    $dateRange = @fetch_events_in_date_range_as_array($dateFrom, $dateTo)[0];
                    $totHours = array();
                    while($row = mysqli_fetch_assoc($result)){
                        foreach ($bothRange as $both){
                            if(in_array($both,$dateRange) && in_array($row['last_name'][0],$nameRange)){
                                $hours = $row['Dur'];   
                                $totHours[] = $hours;
                            }
                        }
                    }
                    $sum = 0;
                    foreach($totHours as $hrs){
                        $sum += $hrs;
                    }
                } catch (TypeError $e) {
                    // Code to handle the exception or error goes here
                    echo "No Results found!"; 
                }
                return $sum; 
            }
            elseif(($type == "general_volunteer_report" ||$type == "total_vol_hours") && ($dateFrom && $dateTo && $lastFrom == NULL  && $lastTo == NULL)){
	    if ($stats == 'Active' || $stats == 'Inactive') 
                $query = $query = "SELECT dbpersons.id,dbpersons.first_name,dbpersons.last_name, SUM(HOUR(TIMEDIFF(dbEvents.endTime, dbEvents.startTime))) as Dur
                FROM dbpersons JOIN dbEventVolunteers ON dbpersons.id = dbEventVolunteers.userID
                JOIN dbEvents ON dbEventVolunteers.eventID = dbEvents.id
		WHERE date >= '$dateFrom' AND date<='$dateTo' AND dbpersons.status='$stats' GROUP BY dbpersons.first_name,dbpersons.last_name
                ORDER BY Dur";
	    else
		$query = $query = "SELECT dbpersons.id,dbpersons.first_name,dbpersons.last_name, SUM(HOUR(TIMEDIFF(dbEvents.endTime, dbEvents.startTime))) as Dur
                FROM dbpersons JOIN dbEventVolunteers ON dbpersons.id = dbEventVolunteers.userID
                JOIN dbEvents ON dbEventVolunteers.eventID = dbEvents.id
                WHERE date >= '$dateFrom' AND date<='$dateTo'
		GROUP BY dbpersons.first_name,dbpersons.last_name
                ORDER BY Dur";
                $result = mysqli_query($con,$query);
                try {
                    // Code that might throw an exception or error goes here
                    $dd = getBetweenDates($dateFrom, $dateTo);
                    $dateRange = @fetch_events_in_date_range_as_array($dateFrom, $dateTo)[0];
                    $totHours = array();
                    while($row = mysqli_fetch_assoc($result)){
                        foreach ($dd as $date){
                            if(in_array($date,$dateRange)){
                                $hours = $row['Dur'];   
                                $totHours[] = $hours;
                            }
                        }
                    }
                    $sum = 0;
                    foreach($totHours as $hrs){
                        $sum += $hrs;
                    }
                }catch (TypeError $e) {
                    // Code to handle the exception or error goes here
                    echo "No Results found!"; 
                }
                return $sum;
            }
            elseif(($type == "general_volunteer_report" ||$type == "total_vol_hours") && ($dateFrom == NULL && $dateTo ==NULL && $lastFrom && $lastTo)){
	    if ($stats == 'Active' || $stats == 'Inactive') 
		$query = "SELECT dbpersons.id,dbpersons.first_name,dbpersons.last_name, SUM(HOUR(TIMEDIFF(dbEvents.endTime, dbEvents.startTime))) as Dur
                FROM dbpersons JOIN dbEventVolunteers ON dbpersons.id = dbEventVolunteers.userID
                JOIN dbEvents ON dbEventVolunteers.eventID = dbEvents.id
                WHERE dbpersons.status='$stats'
		GROUP BY dbpersons.first_name,dbpersons.last_name
                ORDER BY Dur";
	    else
		$query = "SELECT dbpersons.id,dbpersons.first_name,dbpersons.last_name, SUM(HOUR(TIMEDIFF(dbEvents.endTime, dbEvents.startTime))) as Dur
                FROM dbpersons JOIN dbEventVolunteers ON dbpersons.id = dbEventVolunteers.userID
                JOIN dbEvents ON dbEventVolunteers.eventID = dbEvents.id
                GROUP BY dbpersons.first_name,dbpersons.last_name
                ORDER BY Dur";
                //$query = "SELECT * FROM dbpersons WHERE dbpersons.status='$stats'";
                $result = mysqli_query($con,$query);
                $nameRange = range($lastFrom,$lastTo);
                $totHours = array();
                while($row = mysqli_fetch_assoc($result)){
                    foreach ($nameRange as $a){
                        if($row['last_name'][0] == $a){
                            $hours = get_hours_volunteered_by($row['id']);   
                            $totHours[] = $hours;
                        }
                    }
                }
                $sum = 0;
                foreach($totHours as $hrs){
                    $sum += $hrs;
                }
                return $sum;
            }
    }

    function remove_profile_picture($id) {
        $con=connect();
        $query = 'UPDATE dbpersons SET profile_pic="" WHERE id="'.$id.'"';
        $result = mysqli_query($con,$query);
        mysqli_close($con);
        return True;
    }

    function get_name_from_id($id) {
        if ($id === 'vmsroot') {
            return 'System';
        }
    
        $connection = connect();
    
        $stmt = $connection->prepare("SELECT first_name, last_name FROM dbpersons WHERE id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if (!$result || $result->num_rows === 0) {
            $stmt->close();
            $connection->close();
            return null;
        }
    
        $row = $result->fetch_assoc();
        $stmt->close();
        $connection->close();
    
        return $row['first_name'] . ' ' . $row['last_name'];
    }
    

    function update_email($id, $email){
        $con=connect();
        $stmt = $con->prepare('UPDATE dbpersons SET email = ? WHERE id = ?');
        $stmt->bind_param('ss', $email, $id); // 'ss' = both strings
        $stmt->execute();

        mysqli_close($con);
        return True;
    }    

    function update_phone($id, $phone){
        $con=connect();
        $stmt = $con->prepare('UPDATE dbpersons SET phone1 = ? WHERE id = ?');
        $stmt->bind_param('ss', $phone, $id); // 'ss' = both strings
        $stmt->execute();

        mysqli_close($con);
        return True;
    }    

    function update_mandated_hours($id, $hours){
        $con=connect();
        $stmt = $con->prepare('UPDATE dbpersons SET remaining_mandated_hours = ? WHERE id = ?');
        $stmt->bind_param('ss', $hours, $id); // 'ss' = both strings
        $stmt->execute();

        mysqli_close($con);
        return True;
    }    

    function update_minor_status($id, $status){
        $con=connect();
        $stmt = $con->prepare('UPDATE dbpersons SET minor = ? WHERE id = ?');
        $stmt->bind_param('ss', $status, $id); // 'ss' = both strings
        $stmt->execute();

        mysqli_close($con);
        return True;
    }    

    function update_first_name($id, $first_name){
        $con=connect();
        $stmt = $con->prepare('UPDATE dbpersons SET first_name = ? WHERE id = ?');
        $stmt->bind_param('ss', $first_name, $id); // 'ss' = both strings
        $stmt->execute();

        mysqli_close($con);
        return True;
    }  

    

    function update_last_name($id, $last_name){
        $con=connect();
        $stmt = $con->prepare('UPDATE dbpersons SET last_name = ? WHERE id = ?');
        $stmt->bind_param('ss', $last_name, $id); // 'ss' = both strings
        $stmt->execute();

        mysqli_close($con);
        return True;
    }  

    function update_address($id, $address){
        $con=connect();
        $stmt = $con->prepare('UPDATE dbpersons SET street_address = ? WHERE id = ?');
        $stmt->bind_param('ss', $address, $id); // 'ss' = both strings
        $stmt->execute();

        mysqli_close($con);
        return True;
    }  

    function update_state($id, $state){
        $con=connect();
        $stmt = $con->prepare('UPDATE dbpersons SET state = ? WHERE id = ?');
        $stmt->bind_param('ss', $state, $id); // 'ss' = both strings
        $stmt->execute();

        mysqli_close($con);
        return True;
    } 

    function update_zip($id, $zip){
        $con=connect();
        $stmt = $con->prepare('UPDATE dbpersons SET zip_code = ? WHERE id = ?');
        $stmt->bind_param('ss', $zip, $id); // 'ss' = both strings
        $stmt->execute();

        mysqli_close($con);
        return True;
    } 

    function update_emergency_first($id, $first){
        $con=connect();
        $stmt = $con->prepare('UPDATE dbpersons SET emergency_contact_first_name = ? WHERE id = ?');
        $stmt->bind_param('ss', $first, $id); // 'ss' = both strings
        $stmt->execute();

        mysqli_close($con);
        return True;
    } 

    function update_emergency_last($id, $last){
        $con=connect();
        $stmt = $con->prepare('UPDATE dbpersons SET emergency_contact_last_name = ? WHERE id = ?');
        $stmt->bind_param('ss', $last, $id); // 'ss' = both strings
        $stmt->execute();

        mysqli_close($con);
        return True;
    } 

    function update_emergency_phone($id, $phone){
        $con=connect();
        $stmt = $con->prepare('UPDATE dbpersons SET emergency_contact_phone = ? WHERE id = ?');
        $stmt->bind_param('ss', $phone, $id); // 'ss' = both strings
        $stmt->execute();

        mysqli_close($con);
        return True;
    } 