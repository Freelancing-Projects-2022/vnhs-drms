<?php
// This class is for the CRUD of the Google OAuth Token
// NOTE: Google generates new Token from time to time.
//      That's why we need to check if the token is still valid.
//      And replace it with new one once it was expired.

class DB {
    // Same DB configuration with the dbcon.php
    private $dbHost     = "localhost";
    private $dbUsername = "root";
    private $dbPassword = "";
    private $dbName     = "vnhs_drms";
 
    // Checks if the database connection is successful
    public function __construct(){
        if(!isset($this->db)){
            // Connect to the database
            $conn = new mysqli($this->dbHost, $this->dbUsername, $this->dbPassword, $this->dbName);
            if($conn->connect_error){
                die("Failed to connect with MySQL: " . $conn->connect_error);
            }else{
                $this->db = $conn;
            }
        }
    }
  
    // Checks if the 'google_oauth' table is empty
    public function is_token_empty() {
        $result = $this->db->query("SELECT id FROM google_oauth WHERE provider = 'google'");
        if($result->num_rows) {
            return false;
        }
        return true;
    }
  
    // Gets token from the 'google_oauth' table
    public function get_access_token() {
        $sql = $this->db->query("SELECT provider_value FROM google_oauth WHERE provider='google'");
        $result = $sql->fetch_assoc();
        return json_decode($result['provider_value']);
    }
  
    
    // Gets refreshed token
    public function get_refersh_token() {
        $result = $this->get_access_token();
        return $result->refresh_token;
    }
  
    // Updates new token to the 'google_oauth' table
    public function update_access_token($token) {
        if($this->is_token_empty()) {
            $this->db->query("INSERT INTO google_oauth(provider, provider_value) VALUES('google', '$token')");
        } else {
            $this->db->query("UPDATE google_oauth SET provider_value = '$token' WHERE provider = 'google'");
        }
    }
}
?>