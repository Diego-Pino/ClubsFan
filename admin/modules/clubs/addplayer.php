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

if(!defined("IN_MYBB"))
{
	die("Direct initialization of this file is not allowed.<br /><br />Please make sure IN_MYBB is defined.");
}

//MyBB Panel Admin, Add Player
$page->add_breadcrumb_item("Add Player", "index.php?module=clubs/addplayer");

if($mybb->input['save']=="save")
{
	if(empty($mybb->input['username']))
	{
		flash_message("One of fields are required. was not correctly. Add Player In Plugin Admin", 'error');
		
		$username = $mybb->input['username'];
		$team = $mybb->input['team'];
	}
	else
	{
		$query 	= $db->simple_select("users", "uid", "username = '".$mybb->input['username']."'");
		$num	= $db->num_rows($query);
		
		if($num < 1)
		{
			flash_message("User MyBB does not exist", 'error');
		}
		else
		{
			while($user = $db->fetch_array($query))
			{
				$userid = $user['uid'];
			}
			
			flash_message("Player MyBB added to team", 'success');
		
			$insert_array = array(
					"uid"			=> $userid,
					"team"			=> addslashes($mybb->input['team']),
					// "position"		=> addslashes($mybb->input['position'])
				);
				
			$db->insert_query("clubfans", $insert_array);
		}
	}
}

// MyBB Panel Plugin, start the page Add Player
$page->output_header("Add Player");

$form = new Form("index.php?module=clubs/addplayer", "post", "", 1);

$form_container = new FormContainer("Add Player");
echo $form->generate_hidden_field("save", "save", array('id' => "save"))."\n";

$form_container->output_row("Username", "The username of MyBB you want to add to the team", $form->generate_text_box('username', $username, array('id' => 'username')), 'username');

$query = $db->simple_select("clubteams", "*", "1=1");
while($team = $db->fetch_array($query))
{
	$teams[$team['id']] = $team['name'];
}

$form_container->output_row("Team", "Team that the user Fan will be added to", $form->generate_select_box('team', $teams, $team, array('id' => 'team')), 'team');


// close the form container
$form_container->end();

// create the save button
$buttons[] = $form->generate_submit_button("Save");

// wrap up the form
$form->output_submit_wrapper($buttons);
$form->end();

// end the page
$page->output_footer();

?>
