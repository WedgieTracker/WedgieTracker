<?php

  // Include Listener
  include './twitter/listener.php';

  // Get Number of Wedgies from listener
  $wedgies = $wedgiesfromtwitter;

  // Estimated number of games to be played this season - Playoffs included
  $gamesnumber = '1166';

  // GET current season NBA standings
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => 'http://data.nba.net/10s/prod/v1/current/standings_conference.json',
    CURLOPT_RETURNTRANSFER => true, CURLOPT_ENCODING => '', CURLOPT_MAXREDIRS => 10, CURLOPT_TIMEOUT => 0, CURLOPT_FOLLOWLOCATION => true, CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
  ));
  $response = curl_exec($curl);
  curl_close($curl);

  // Standings from JSON to Array
  $standings = array();
  $standings = json_decode($response, 1);

  // Create Array with wins and losses for each team
  $tosum = array();
  foreach($standings as $s1){
  	foreach($s1['standard']['conference'] as $s2){
  		foreach($s2 as $s3 ){
  			foreach($s3 as $s4  => $s4v) {
          if ($s4 == "win") {
            array_push($tosum, $s4v);
          }
          if ($s4 == "loss") {
            array_push($tosum, $s4v);
          }
  			}
  		}
  	}
  }

  // Caclulate total number of games played
  $totalwinsandlosses = array_sum($tosum);
  $gamesplayed = $totalwinsandlosses / 2;

  // Stats
  $wedgiespg = $wedgies / $gamesplayed; // Wedgies per Game
  $wedgies_remaing = 50 - $wedgies; // Wedgies remaining to get to 50
  $games_remaining = $gamesnumber - $gamesplayed; // Numbers of games to be played
  $wedgiespg_remaining = $wedgies_remaing / $games_remaining;  // Wedgies per game needed to get to 50
  $percentage = ($wedgies / 50) * 100;  // Percentage relative to a goal of 50 wedgies in a season
  $percentage_remaining = 100 - $percentage; // Percentage relative to a goal of 50 wedgies in a season - negative

  // Pace Projected in estimated number of games ($gamesnumber) to be played
  $paceprojected = $gamesnumber * $wedgiespg;
  $roundedpace = round($paceprojected, 0); // Round number of pace projected

?>
