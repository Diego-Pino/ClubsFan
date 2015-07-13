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

//MyBB Panel Admin, Add Team
$page->add_breadcrumb_item("Create Team", "index.php?module=clubs/addteam");

if($mybb->input['save']=="save")
{
	if(empty($mybb->input['name']) || empty($mybb->input['des']))
	{
		flash_message("One of the required fields was not correctly filled in", 'error');
		
		$title = $mybb->input['name'];
		$image = $mybb->input['image'];
		$des = $mybb->input['des'];
	}
	else
	{
		flash_message("Your team has been created", 'success');
		
		$insert_array = array(
					"name"			=> addslashes($mybb->input['name']),
					"image"			=> addslashes($mybb->input['image']),
					"des"				=> $db->escape_string($mybb->input['des']),
					
				);
				
		$db->insert_query("clubteams", $insert_array);
	}
}

//MyBB Panel Admin, Add Team start the page
$page->output_header("Create Team");

$form = new Form("index.php?module=clubs/addteam", "post", "", 1);

$form_container = new FormContainer("Create Team");
echo $form->generate_hidden_field("save", "save", array('id' => "save"))."\n";

$form_container->output_row("Name", "The teams name", $form->generate_text_box('name', $name, array('id' => 'name')), 'name');
$form_container->output_row("Image", "The image URL that will appear on the clubs page", $form->generate_text_box('image', $image, array('id' => 'image')), 'image');
$form_container->output_row("Description City", "City of the team", $form->generate_text_box('des', $des, array('id' => 'des')), 'des');

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
