<?php
    require_once("../database.php");
    require_once("table.php");
    
    class Persons implements Table {
        // DATA MEMBERS
        private $id;
        private $per_id;
        private $perErr;
        private $cou_id;
        private $couErr;
        
        // CONSTRUCTOR
        function __construct($id, $cou_id, $per_id) {
            $this->id     = $id;
            $this->cou_id  = $cou_id;
            $this->per_id  = $per_id;
        }
    
        // Display a table containing details about every record in the database.
        public function displayListScreen() {
            echo "
                <div class='container'>
                    <div class='span10 offset1'>
                        <div class='row'>
                            <h3>Rounds</h3>
                        </div>
                        <div class='row'>
                            <a class='btn btn-primary' onclick='personsRequest(\"displayCreate\")'>Add Round</a>
                            <table class='table table-striped table-bordered' style='background-color: lightgrey !important'>
                                <thead>
                                    <tr>
                                        <th>Course</th>
                                        <th>Person</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>";                                    
            foreach (Database::prepare('SELECT * FROM `tt_rounds`', array()) as $row) {
                echo "
                    <tr>
                        <td>{$row['cou_id']  }</td>
                        <td>{$row['per_id'] }</td>
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
                            <h3>Create Round</h3>
                        </div>
                        <div class='form-horizontal'>
                            <div class='control-group'>
                                <label class='control-label". ((empty($this->couErr))?'':' error') ."'>cou_id</label>
                                <div class='controls'>
                                    <input id='cou_id' type='text' required>
                                    <span class='help-inline'>{$this->couErr}</span>
                                </div>
                            </div>
                            <div class='control-group'>
                                <label class='control-label". ((empty($this->perErr))?'':' error') ."'>per_id</label>
                                <div class='controls'>
                                    <input id='per_id' type='text' placeholder='Person' required>
                                    <span class='help-inline'>{$this->perErr}</span>
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
                    "INSERT INTO tt_rounds (cou_id, per_id) VALUES (?,?)",
                    array($this->cou_id, $this->per_id)
                );
                $this->displayListScreen();
            } else {
                $this->displayCreateScreen();
            }
        }
        
        // Display a form containing information about a specified record in the database.
        public function displayReadScreen() {
            $rec = Database::prepare(
                "SELECT * FROM tt_rounds WHERE id = ?", 
                array($this->id)
            )->fetch(PDO::FETCH_ASSOC);
            echo "
                <div class='container'>
                    <div class='span10 offset1'>
                        <div class='row'>
                            <h3>Rounds Details</h3>
                        </div>
                        <div class='form-horizontal'>
                            <div class='control-group'>
                                <label class='control-label'>cou_id</label>
                                <div class='controls'>
                                    <label class='checkbox'>
                                        {$rec['cou_id']}
                                    </label>
                                </div>
                            </div>
                            <div class='control-group'>
                                <label class='control-label'>per_id</label>
                                <div class='controls'>
                                    <label class='checkbox'>
                                        {$rec['per_id']}
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
                "SELECT * FROM tt_rounds WHERE id = ?", 
                array($this->id)
            )->fetch(PDO::FETCH_ASSOC);
            echo "
                <div class='container'>
                    <div class='span10 offset1'>
                        <div class='row'>
                            <h3>Update Rounds</h3>
                        </div>
                        <div class='form-horizontal'>
                            <div class='control-group'>
                                <label class='control-label". ((empty($this->couErr))?'':' error') ."'>cou_id</label>
                                <div class='controls'>
                                    <input id='cou_id' type='text' value='{$rec['cou_id']}' required>
                                    <span class='help-inline'>{$this->couErr}</span>
                                </div>
                            </div>
                            <div class='control-group'>
                                <label class='control-label". ((empty($this->perErr))?'':' error') ."'>per_id</label>
                                <div class='controls'>
                                    <input id='per_id' type='text' value='{$rec['per_id']}' required>
                                    <span class='help-inline'>{$this->perErr}</span>
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
                    "UPDATE tt_rounds SET cou_id = ?, per_id = ? WHERE id = ?",
                    array($this->cou_id, $this->per_id, $this->id)
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
                            <h3>Delete Round</h3>
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
                "DELETE FROM tt_rounds WHERE id = ?",
                array($this->id)
            );
            $this->displayListScreen();
        }
        
        // Validates user input.
        private function validate() {
            $valid = true;
            // Check for empty input.
            if (empty($this->cou_id)) { 
                $this->couErr = "Please enter a course.";
                $valid = false; 
            }
            if (empty($this->per_id)) { 
                $this->perErr = "Please enter a person.";
                $valid = false; 
            }
            } print_r($valid);
            return $valid;
        }
    }
?>