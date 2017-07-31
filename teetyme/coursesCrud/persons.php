<?php
    require_once("../database.php");
    require_once("table.php");
    
    class Persons implements Table {
        // DATA MEMBERS
        private $id;
        private $name;
        private $nameErr;
        private $phone;
        private $phoneErr;
        private $address;
        private $addressErr;
        
        // CONSTRUCTOR
        function __construct($id, $name, $phone, $address) {
            $this->id     = $id;
            $this->name   = $name;
            $this->phone  = $phone;
            $this->address = $address;
        }
    
        // Display a table containing details about every record in the database.
        public function displayListScreen() {
            echo "
                <div class='container'>
                    <div class='span10 offset1'>
                        <div class='row'>
                            <h3>Courses</h3>
                        </div>
                        <div class='row'>
                            <a class='btn btn-primary' onclick='personsRequest(\"displayCreate\")'>Add Course</a>
                            <table class='table table-striped table-bordered' style='background-color: lightgrey !important'>
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>";                                    
            foreach (Database::prepare('SELECT * FROM `tt_courses`', array()) as $row) {
                echo "
                    <tr>
                        <td>{$row['name']  }</td>
                        <td>{$row['phone'] }</td>
                        <td>{$row['address']}</td>
                        <td>
                            <button class='btn' onclick='personsRequest(\"displayRead\", {$row['id']})'>Read</button><br>
                            <button class='btn btn-success' onclick='personsRequest(\"displayUpdate\", {$row['id']})'>Update</button><br>
                            <button class='btn btn-danger' onclick='personsRequest(\"displayDelete\", {$row['id']})'>Delete</button>
                        </td>
                    </tr>";
            }
            echo "</tbody></table></div></div></div>";
        }
        
        // Display a form for adding a record to the database.
        public function displayCreateScreen() {
            echo "
                <div class='container'>
                    <div class='span10 offset1'>
                        <div class='row'>
                            <h3>Create Persons</h3>
                        </div>
                        <div class='form-horizontal'>
                            <div class='control-group'>
                                <label class='control-label". ((empty($this->nameErr))?'':' error') ."'>name</label>
                                <div class='controls'>
                                    <input id='name' type='text' required>
                                    <span class='help-inline'>{$this->nameErr}</span>
                                </div>
                            </div>
                            <div class='control-group'>
                                <label class='control-label". ((empty($this->phoneErr))?'':' error') ."'>phone</label>
                                <div class='controls'>
                                    <input id='phone' type='text' placeholder='name@svsu.edu' required>
                                    <span class='help-inline'>{$this->phoneErr}</span>
                                </div>
                            </div>
                            <div class='control-group'>
                                <label class='control-label". ((empty($this->addressErr))?'':' error') ."'>address</label>
                                <div class='controls'>
                                    <input id='address' type='text' placeholder='555-5555-555' required>
                                    <span class='help-inline'>{$this->addressErr}</span>
                                </div>
                            </div>
                            <div class='form-actions'>
                                <button class='btn btn-success' onclick='personsRequest(\"createRecord\")'>Create</button>
                                <a class='btn' onclick='personsRequest(\"displayList\")'>Back</a>
                            </div>
                        </div>
                    </div>
                </div>";
        }
        
        // Adds a record to the database.
        public function createRecord() {
            if ($this->validate()) {
                Database::prepare(
                    "INSERT INTO persons (name, phone, address) VALUES (?,?,?)",
                    array($this->name, $this->phone, $this->address)
                );
                $this->displayListScreen();
            } else {
                $this->displayCreateScreen();
            }
        }
        
        // Display a form containing information about a specified record in the database.
        public function displayReadScreen() {
            $rec = Database::prepare(
                "SELECT * FROM tt_courses WHERE id = ?", 
                array($this->id)
            )->fetch(PDO::FETCH_ASSOC);
            echo "
                <div class='container'>
                    <div class='span10 offset1'>
                        <div class='row'>
                            <h3>Person Details</h3>
                        </div>
                        <div class='form-horizontal'>
                            <div class='control-group'>
                                <label class='control-label'>name</label>
                                <div class='controls'>
                                    <label class='checkbox'>
                                        {$rec['name']}
                                    </label>
                                </div>
                            </div>
                            <div class='control-group'>
                                <label class='control-label'>phone</label>
                                <div class='controls'>
                                    <label class='checkbox'>
                                        {$rec['phone']}
                                    </label>
                                </div>
                            </div>
                            <div class='control-group'>
                                <label class='control-label'>address</label>
                                <div class='controls'>
                                    <label class='checkbox'>
                                        {$rec['address']}
                                    </label>
                                </div>
                            </div>
                            <div class='form-actions'>
                                <a class='btn' onclick='personsRequest(\"displayList\")'>Back</a>
                            </div>
                        </div>
                    </div>
                </div>";
        }
        
        // Display a form for updating a record within the database.
        public function displayUpdateScreen() {
            $rec = Database::prepare(
                "SELECT * FROM tt_courses WHERE id = ?", 
                array($this->id)
            )->fetch(PDO::FETCH_ASSOC);
            echo "
                <div class='container'>
                    <div class='span10 offset1'>
                        <div class='row'>
                            <h3>Update Person</h3>
                        </div>
                        <div class='form-horizontal'>
                            <div class='control-group'>
                                <label class='control-label". ((empty($this->nameErr))?'':' error') ."'>name</label>
                                <div class='controls'>
                                    <input id='name' type='text' value='{$rec['name']}' required>
                                    <span class='help-inline'>{$this->nameErr}</span>
                                </div>
                            </div>
                            <div class='control-group'>
                                <label class='control-label". ((empty($this->phoneErr))?'':' error') ."'>phone</label>
                                <div class='controls'>
                                    <input id='phone' type='text' value='{$rec['phone']}' required>
                                    <span class='help-inline'>{$this->phoneErr}</span>
                                </div>
                            </div>
                            <div class='control-group'>
                                <label class='control-label". ((empty($this->addressErr))?'':' error') ."'>address</label>
                                <div class='controls'>
                                    <input id='address' type='text' value='{$rec['address']}' required>
                                    <span class='help-inline'>{$this->addressErr}</span>
                                </div>
                            </div>
                            <div class='form-actions'>
                                <button class='btn btn-success' onclick='personsRequest(\"updateRecord\", {$this->id})'>Update</button>
                                <a class='btn' onclick='personsRequest(\"displayList\")'>Back</a>
                            </div>
                        </div>
                    </div>
                </div>";
        }
        
        // Updates a record within the database.
        public function updateRecord() {
            if ($this->validate()) {
                Database::prepare(
                    "UPDATE persons SET name = ?, phone = ?, address = ? WHERE id = ?",
                    array($this->name, $this->phone, $this->address, $this->id)
                );
                $this->displayListScreen();
            } else {
                $this->displayUpdateScreen();
            }
        }
        
        // Display a form for deleting a record from the database.
        public function displayDeleteScreen() {
            echo "
                <div class='container'>
                    <div class='span10 offset1'>
                        <div class='row'>
                            <h3>Delete Course</h3>
                        </div>
                        <div class='form-horizontal'>
                            <p class='alert alert-error'>Are you sure you want to delete ?</p>
                            <div class='form-actions'>
                                <button id='submit' class='btn btn-danger' onClick='personsRequest(\"deleteRecord\", {$this->id});'>Yes</button>
                                <a class='btn' onclick='personsRequest(\"displayList\")'>Back</a>
                            </div>
                        </div>
                    </div>
                </div>";
        }
        
        // Removes a record from the database.
        public function deleteRecord() {
            Database::prepare(
                "DELETE FROM tt_courses WHERE id = ?",
                array($this->id)
            );
            $this->displayListScreen();
        }
        
        // Validates user input.
        private function validate() {
            $valid = true;
            // Validate Phone
            if (!preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $this->phone)) {
                $this->phoneErr = "Please enter a valid phone number.";
                $valid = false;
            }
            // Validate Address
            if (!filter_var($this->address, FILTER_VALIDATE_EMAIL)) {
                $this->addressErr = "Please enter a valid address.";
                $valid = false;
            }
            // Check for empty input.
            if (empty($this->name)) { 
                $this->nameErr = "Please enter a name.";
                $valid = false; 
            }
            if (empty($this->address)) { 
                $this->emailErr = "Please enter an Address.";
                $valid = false; 
            }
            if (empty($this->phone)) { 
                $this->phoneErr = "Please enter a phone number.";
                $valid = false; 
            } print_r($valid);
            return $valid;
        }
    }
?>