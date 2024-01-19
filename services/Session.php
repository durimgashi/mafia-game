<?php

namespace Services;


class Session {

    public static function getGame() {
        return $_SESSION['game'];
    }

    public static function getUserId() {
        return $_SESSION['user']['user_id'];
    }

    public static function getMyRole() {
        return $_SESSION['user']['role'];
    }

    public static function setGameOver($winners = '') {
        $_SESSION['game']['game_over'] = true;
        $_SESSION['winners'] = $winners;

        self::setSecondMessage('Game Over');
    }

    public static function isOngoingGame() {
        return $_SESSION['ongoing_game'];
    }

    public static function setGameId($id) {
        $_SESSION['game']['game_id'] = $id;
    }

    public static function getPlayers() {
        return $_SESSION['game']['players'];
    }

    public static function setPlayers($players) {
        $_SESSION['game']['players'] = $players;
    }

    public static function resetProgressMessages() {
        $_SESSION['game']['progress_messages'] = [];
    }

    public static function setProgressInfo($message) {
        $_SESSION['game']['progress_messages'][] = $message;
    }

    public static function setSecondMessage($message) {
        $_SESSION['game']['second_message'] = $message;
    }

    public static function getCycle() {
        return $_SESSION['game']['cycle'];
    }

    public static function toggleGameCycle() {
        if ($_SESSION['game']['cycle'] == "night")
            $_SESSION['game']['cycle'] = "day";
        else
            $_SESSION['game']['cycle'] = "night";

        $_SESSION['game']['round']++;
    }

    public static function setGameSession($players) {
        $my_role = [];

        foreach ($players AS $player) {
            if($player['is_bot'] == "0") {
                $my_role['role'] = $player['role'];
            }
        }

        $_SESSION['ongoing_game'] = true;
        $_SESSION['winners'] = '';
        $_SESSION['user']['role'] = $my_role['role'];
        $_SESSION['game'] = [
            'game_over' => false,
            'cycle' => 'night',
            'round' => 1,
            'players' => $players,
            'second_message' => '',
            'progress_messages' => [],
            'fellow_mafia' => []
        ];

        if ($my_role['role'] === 'Mafia') {
            $_SESSION['game']['fellow_mafia'] = array_values(array_filter($_SESSION['game']['players'], function ($player) {
                return $player['role'] === 'Mafia';
            }));
        }
    }

    public static function resetGameSession() {
        $_SESSION['ongoing_game'] = false;
        $_SESSION['game'] = [];
    }

}