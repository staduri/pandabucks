<?php
//UserTools.class.php

require_once 'DB.php';

class UserTools {

    private $db;

    public function __construct() {
        $this->db = new DB();
    }

    //Log the user in. First checks to see if the
    //username and password match a row in the database.
    //If it is successful, set the session variables
    //and store the user object within.
    public function login($username, $password) {
        $hashedPassword = md5($password);
        $result = $this->db->query("SELECT * FROM users WHERE email = '$username' AND password = '$hashedPassword'");

        if(pg_num_rows($result) == 1) {
            $_SESSION["user"] = serialize(pg_fetch_assoc($result));
            $_SESSION["login_time"] = time();
            $_SESSION["logged_in"] = 1;
            return true;
        } else {
            return false;
        }
    }

    //Log the user out. Destroy the session variables.
    public function logout() {
        unset($_SESSION['user']);
        unset($_SESSION['login_time']);
        unset($_SESSION['logged_in']);
        session_destroy();
    }

    //Check to see if a username exists.
    //This is called during registration to make sure all user names are unique.
    public function checkUsernameExists($username) {
        $result = $this->db->query("select user_id from users where email='$username'");
        if(pg_num_rows($result) == 0) {
            return false;
        } else {
            return true;
        }
    }

    public function checkUserNotAllowedAccess($username) {
        $result = $this->db->query("select email from allowed_users where email='$username'");
        if(pg_num_rows($result) >= 1) {
            return false;
        }

        return true;
    }

    public function createUser($data) {
        $id = $this->db->insert($data, 'users');
    }

    public function getAllFlags() {
        $result = $this->db->query("select team_id, absolute_flag_url from teams");

        $flags = array();

        while($row = pg_fetch_row($result)) {
            $flags[$row[0]] = $row[1];

        }

        return $flags;
    }

    public function getAllGames() {
        $result = $this->db->query("select a.game_id, a.time, b.name, b.team_id, c.name, c.team_id, a.tournament_stage

                                    from fixtures a
                                    join teams b on a.team1=b.team_id
                                    join teams c on a.team2=c.team_id

                                    order by a.game_id
                                    ");
        $games = array();
        while ($row = pg_fetch_row($result)) {
            $game = array(
                "game_id" => $row[0],
                "time" => $row[1],
                "team1" => $row[2],
                "team1_id" => $row[3],
                "team2" => $row[4],
                "team2_id" => $row[5],
                "stage" => $row[6]
            );

            array_push($games, $game);
        }
        return $games;
    }
}
?>
