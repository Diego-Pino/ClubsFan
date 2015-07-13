<?php
/**
 ***************************************************************************
 *  Referrer Log plugin (/inc/plugins/clubsteams.php)
 *  Author Code: DiegoPino, diegopino@gmail.com
 *  Website: http://diegopino.blogspot.com/
 *  License: Creative Commons http://creativecommons.org/licenses/by/4.0/legalcode
 *
 *  Fan Clubs Teams to generate stats from MySql Database for example:
 *  Football Clubs, Leagues and Tournaments, Anime, F1 ...etc
 *
 ***************************************************************************​/
 */


// Inicio de MyBB Plugin
define("IN_MYBB", 1);
define('THIS_SCRIPT', 'clubsteams.php');


//  MyBB Template
$templatelist 	= "club_index";
require_once "./global.php";
add_breadcrumb("Clubs Teams Fans", "clubsteams.php");

// MyBB Base Datos Consulta
$teams_query 	= $db->query("SELECT * FROM " . TABLE_PREFIX . "clubteams");
$teams_num		= $db->num_rows($teams_query);

// Algoritmo Consulta 
if ($teams_num > 0)
{
	while ($teams_array = $db->fetch_array($teams_query))
	{
		$team_id	= $teams_array['id'];
		$team_name	= $teams_array['name'];
		$team_image	= $teams_array['image'];
		$team_des	= $teams_array['des'];
		
		$members_query	= $db->query("SELECT * FROM " . TABLE_PREFIX . "clubfans WHERE team = $team_id");
		$members_num	= $db->num_rows($members_query);
		
		if ($members_num > 0)
		{
			while ($members_array = $db->fetch_array($members_query))
			{
				$members_uid	= $members_array['uid'];
				
				$user_query 	= $db->query("SELECT username, avatar FROM " . TABLE_PREFIX . "users WHERE uid = " . $members_uid ."");
						
				while ($user_data = $db->fetch_array($user_query))
				{
					$user_name 		= $user_data['username'];
					$user_avatar 	= $user_data['avatar'];
				}
				
				eval("\$members_bit .= \"".$templates->get("club_user")."\";");
			}
		}
		else
		{
			eval("\$members_bit .= \"".$templates->get("club_user_none")."\";");
		}
		
		eval("\$teams_bit .= \"".$templates->get("club_team")."\";");
		
		$members_bit = "";
	}
}
else
{
	eval("\$teams_bit = \"".$templates->get("club_team_none")."\";");
}

eval("\$clubsteams = \"".$templates->get("club_index")."\";");
output_page($clubsteams);

?>
