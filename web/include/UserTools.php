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
        session_set_cookie_params(86400000);
        session_start();

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

    public function checkSession() {
        session_set_cookie_params(86400000);
        session_start();


       if(isset($_SESSION) && array_key_exists("logged_in", $_SESSION) && $_SESSION["logged_in"] == 1) {
            return unserialize($_SESSION["user"]);
        } else {
            header("Location: login.php");
        }
    }

    public function getAPick($uid, $gid) {
        $result = $this->db->select("users_betting", "user_id='".$uid."' and game_id='".$gid."'");
        return $result;
    }

    //Log the user out. Destroy the session variables.
    public function logout() {
        session_start();
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
        $result = $this->db->query("select a.game_id, a.time, b.name, b.team_id, c.name, c.team_id, a.tournament_stage,
                                           d.team1_points, d.team2_points, d.draw_points

                                    from fixtures a
                                    join teams b on a.team1=b.team_id
                                    join teams c on a.team2=c.team_id
                                    join odds d on a.game_id=d.game_id

                                    where a.game_id<>64
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
                "stage" => $row[6],
                "team1_points" => $row[7],
                "team2_points" => $row[8],
                "draw_points" => $row[9]
            );

            array_push($games, $game);
        }
        return $games;
    }

    public function getAllGamesForAdmin() {
        $result = $this->db->query("select a.game_id, a.time, b.name, b.team_id, c.name, c.team_id, a.tournament_stage,
                                           d.team1_points, d.team2_points, d.draw_points

                                    from fixtures a
                                    join teams b on a.team1=b.team_id
                                    join teams c on a.team2=c.team_id
                                    join odds d on a.game_id=d.game_id

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
                "stage" => $row[6],
                "team1_points" => $row[7],
                "team2_points" => $row[8],
                "draw_points" => $row[9]
            );

            array_push($games, $game);
        }
        return $games;
    }

    public function getFinalGame() {
        $result = $this->db->query("select a.game_id, a.time, b.name, b.team_id, c.name, c.team_id, a.tournament_stage,
                                           d.team1_points, d.team2_points, d.draw_points

                                    from fixtures a
                                    join teams b on a.team1=b.team_id
                                    join teams c on a.team2=c.team_id
                                    join odds d on a.game_id=d.game_id

                                    where a.game_id=64

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
                "stage" => $row[6],
                "team1_points" => $row[7],
                "team2_points" => $row[8],
                "draw_points" => $row[9]
            );

            array_push($games, $game);
        }
        return $games[0];
    }

    public function getAllGamesByDate($start_time, $end_time) {
        $result = $this->db->query("select a.game_id, a.time, b.name, b.team_id, c.name, c.team_id, a.tournament_stage,
                                           d.team1_points, d.team2_points, d.draw_points

                                    from fixtures a
                                    join teams b on a.team1=b.team_id
                                    join teams c on a.team2=c.team_id
                                    join odds d on a.game_id=d.game_id

                                    where a.time > ".$start_time
                                    ."and a.time < ".$end_time
                                    ."order by a.game_id

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
                "stage" => $row[6],
                "team1_points" => $row[7],
                "team2_points" => $row[8],
                "draw_points" => $row[9]
            );

            array_push($games, $game);
        }
        return $games;
    }

    public function getPredictions($uid) {
        $result = $this->db->query("select a.game_id, a.prediction
                                    from users_betting a
                                    where a.user_id="
                                    .$uid
        );

        $predictions = array();
        while ($row = pg_fetch_row($result)) {
            $predictions[$row[0]] = $row[1];
        }
        return $predictions;
    }

    public function getFinalGamePrediction($uid) {
        $result = $this->db->query("select game_id, team1_score, team2_score
                                    from scoreline_betting a
                                    where game_id=64 and a.user_id="
            .$uid
        );

        $predictions = array(
            "game_id" => 64,
            "team1_score" => "",
            "team2_score" => ""
        );

        while ($row = pg_fetch_row($result)) {

            $predictions = array(
                "game_id" => $row[0],
                "team1_score" => $row[1],
                "team2_score" => $row[2]
            );
            break;
        }
        return $predictions;
    }

    public function getAGame($gid) {
        $result = $this->db->query("select a.game_id, a.time, b.name, b.team_id, c.name, c.team_id, a.tournament_stage,
                                            d.team1_points, d.team2_points, d.draw_points

                                    from fixtures a
                                    join teams b on a.team1=b.team_id
                                    join teams c on a.team2=c.team_id
                                    join odds d on a.game_id=d.game_id

                                    where a.game_id='".$gid."';");

        if ($row = pg_fetch_row($result)) {
            $game = array(
                "game_id" => $row[0],
                "time" => $row[1],
                "team1" => $row[2],
                "team1_id" => $row[3],
                "team2" => $row[4],
                "team2_id" => $row[5],
                "stage" => $row[6],
                "team1_points" => $row[7],
                "team2_points" => $row[8],
                "draw_points" => $row[9]
            );

            return $game;
        }
        return NULL;

    }

    public function saveResult($data) {
        $check = $this->db->query("select game_id from results where game_id=".$data['game_id']);
        if(pg_num_rows($check) >= 1) {
            $this->db->update($data, "results", "game_id=".$data['game_id']);
        } else {
            $this->db->insert($data, "results");
        }
    }

    public function getAllResults() {
        $result = $this->db->query("select c.name,d.name,b.tournament_stage,a.score_team_a,a.score_team_b

                                    from results a
                                    join fixtures b on a.game_id=b.game_id
                                    join teams c on b.team1=c.team_id
                                    join teams d on b.team2=d.team_id

                                    order by b.time
                                    ");
        $games = array();
        while ($row = pg_fetch_row($result)) {
            $game = array(
                "team1_name" => $row[0],
                "team2_name" => $row[1],
                "stage" => $row[2],
                "score_a" => $row[3],
                "score_b" => $row[4]
            );

            array_push($games, $game);
        }
        return $games;
    }

    public function getLeaderboard() {
        $result = $this->db->query("select aa.*, rank() over (order by points desc) as rank from (
                                    select
                                    a.email,
                                    a.nickname,
                                    sum(case when c.points is null then 0
                                             when c.score_team_a_90=pred.team1_score
                                               and c.score_team_b_90=pred.team2_score
                                               and c.game_id=64
                                             then 2*c.points
                                             else c.points
                                        end) points,
                                    sum(case when c.points is null then 0 else 1 end) as correct_guesses,
                                    sum(case when c.points is null then 1 else 0 end) as incorrect_guesses

                                    from users a
                                    left outer join users_betting b on a.user_id=b.user_id
                                    left outer join
                                    (
                                    select
                                    a.game_id,
                                    case
                                    when score_team_a > score_team_b then '1'
                                    when score_team_b > score_team_a then '2'
                                    when score_team_a = score_team_b then 'X'
                                    end final_result,
                                    case
                                    when score_team_a > score_team_b then team1_points
                                    when score_team_b > score_team_a then team2_points
                                    when score_team_a = score_team_b then draw_points
                                    end points,
                                    a.score_team_a_90,
                                    a.score_team_b_90
                                    from results a
                                    join odds b on a.game_id=b.game_id
                                    ) c
                                    on b.game_id=c.game_id
                                      and b.prediction=c.final_result
                                    left outer join scoreline_betting pred on (pred.game_id=c.game_id and pred.user_id=a.user_id)

                                    group by a.user_id
                                    order by points desc, a.nickname asc
                                    ) aa


                                    ;");
        $leaders = array();
        while ($row = pg_fetch_row($result)) {
            $leader = array(
                "user_id" => $row[0],
                "nickname" => $row[1],
                "points" => $row[2],
                "correct_guesses" => $row[3],
                "incorrect_guesses" => $row[4],
                "rank" => $row[5]
            );

            array_push($leaders, $leader);
        }
        return $leaders;
    }

    public function getLastUpdateLeaderboard() {
        $result = $this->db->query("select
                                    max(result_timestamp)
                                    from results;");
        $row = pg_fetch_row($result);
        
        $last_update_leaderboard = $row[0];
        
        return $last_update_leaderboard;
    }

    public function setAPick($uid, $game, $choice) {
        $check = $this->db->query("select user_id,game_id,prediction from users_betting where user_id=".$uid." and game_id=".$game);
        $data = array(
            "user_id" => $uid,
            "game_id" => $game,
            "prediction" => $choice
        );

        if(pg_num_rows($check) >= 1) {
            $this->db->update($data, "users_betting", "game_id=".$game." and user_id=".$uid);
        } else {
            $this->db->insert($data, "users_betting");
        }
    }

    public function unsubscribe($email) {
        $result = $this->db->insert(array("email"=>$email), "email_optout");
    }

    public function getReminders($games) {
        $sql = "select distinct aa.email from users aa join (select a.user_id as user_id_1, c.user_id as user_id_2 from users a left outer join (select a.user_id, b.id from users a left join users_betting b on a.user_id=b.user_id where game_id in (" . implode(",", $games) . ")) c on a.user_id=c.user_id) bb on aa.user_id=bb.user_id_1 left join email_optout ee on aa.email=ee.email where bb.user_id_2 is null and ee.email is null;";

        $result = $this->db->query($sql);
        $users = array();
        while ($row = pg_fetch_row($result)) {
            array_push($users, $row[0]);
        }
        return $users;
    }

    public function setScorelinePrediction($game, $user, $team1_score, $team2_score) {
        $check = $this->db->query("select user_id,game_id,team1_score,team2_score from scoreline_betting where user_id=".$user." and game_id=".$game);
        $data = array(
            "user_id" => $user,
            "game_id" => $game,
            "team1_score" => $team1_score,
            "team2_score" => $team2_score
        );

        if(pg_num_rows($check) >= 1) {
            print("here");
            $this->db->update($data, "scoreline_betting", "game_id=".$game." and user_id=".$user);
        } else {
            $this->db->insert($data, "scoreline_betting");
        }
    }
}
?>
