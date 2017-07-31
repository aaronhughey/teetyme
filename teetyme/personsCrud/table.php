<?php
    interface Table {    
        // Display a table containing details about every record in the database.
        public function displayListScreen();
        
        // Display a form for adding a record to the database.
        public function displayCreateScreen();
        
        // Adds a record to the database.
        public function createRecord();
        
        // Display a form containing information about a specified record in the database.
        public function displayReadScreen();
        
        // Display a form for updating a record within the database.
        public function displayUpdateScreen();
        
        // Updates a record within the database.
        public function updateRecord();
        
        // Display a form for deleting a record from the database.
        public function displayDeleteScreen();
        
        // Removes a record from the database.
        public function deleteRecord();
    }
?>