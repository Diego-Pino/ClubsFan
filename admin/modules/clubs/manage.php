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

//MyBB Panel Admin, Manage Information in Panel Plugin, start the page
$page->add_breadcrumb_item("Manage Teams", "index.php?module=clubs/manage");

if($mybb->input['action']=="" || $mybb->input['action']=="delete" || $mybb->input['action']=="deleteuser")
{
	if($mybb->input['action']=="delete")
	{	
		$id = $mybb->input['id'];
		$db->delete_query("clubteams","id='$id'");
		$db->delete_query("clubfans","team='$id'");
		$db->delete_query("matches","team_id='$id'");
	}
	
	if($mybb->input['action']=="deleteuser")
	{	
		$id = $mybb->input['id'];
		$db->delete_query("clubfans","id='$id'");
	}	
	
	// start the page
	$page->output_header("Team Management");

	$query 	= $db->simple_select("clubteams", "*");
	while($teams = $db->fetch_array($query))
	{
		$table = new Table;
		$table->construct_header("Members");
		$table->construct_header($lang->controls, array("class" => "align_center", "width" => 150));
		
		$players = $db->simple_select("clubfans", "*", "team = ".$teams['id']);
		while($item = $db->fetch_array($players))
		{	
			// create the "Edit/Delete" popup menu
			$popup = new PopupMenu("project_".$item['id'], $lang->options);
			
			// Add the items
			$popup->add_item("Remove", "index.php?module=clubs/manage&amp;action=deleteuser&amp;id=".$item['id']);
		
			$user_query = $db->simple_select("users", "*", "uid = '".$item['uid']."'");
			while($user = $db->fetch_array($user_query))
			{
				$username = $user['username'];
			}
		
			// create the info cell
			// construct_cell(content, array(html modifiers))
			$table->construct_cell($username);
			// create the menu cell
			$table->construct_cell($popup->fetch(), array("class" => "align_center"));
		
			// output the row
			$table->construct_row();
		}
		
		// display the table with our title
		$table->output($teams['name']);	
		
		print "<a href=index.php?module=clubs/manage&amp;action=delete&amp;id=".$teams['id'].">Delete ".$teams['name']."</a> | <a href=index.php?module=clubs/manage&amp;action=edit&amp;id=".$teams['id'].">Edit ".$teams['name']."</a><br /><br />";
	}	
	
	// end the page
	$page->output_footer();	
}
else if($mybb->input['action']=="edit")
{
	$id = $mybb->input['id'];
		
	if($mybb->input['save']=="save")
	{
		if(empty($mybb->input['name']) || empty($mybb->input['image']) || empty($mybb->input['des']) )
		{
			flash_message("One of the required fields was not correctly filled in", 'error');
		
			$item['name'] = $mybb->input['name'];
			$item['image'] = $mybb->input['image'];
			$item['des'] = $mybb->input['des'];

		}
		else
		{
			$update_array = array(
					"name"			=> addslashes($mybb->input['name']),
					"image"			=> addslashes($mybb->input['image']),
					"des"			=> addslashes($mybb->input['des']),
					
			);
			
			$db->update_query("clubteams", $update_array, "id='$id'");			
			
			flash_message("Your team has been updated", 'success');		
		}	
	}

	$page->add_breadcrumb_item("Edit Team", "index.php?module=clubs/manage&amp;action=edit&amp;id=$id");
	
	// start the page
	$page->output_header("Edit Team Details");
	
	$form = new Form("index.php?module=clubs/manage&amp;action=edit&amp;id=$id", "post", "", 1);
	
	$query = $db->simple_select("clubteams", "*", "id = $id");
	$item = $db->fetch_array($query);
	
	// if the user tried to save, don't wipe all of the entered fields in case of error
	if($mybb->input['save']=="save")
	{
		$item['name'] = $mybb->input['name'];
		$item['image'] = $mybb->input['image'];
		$item['des'] = $mybb->input['des'];

	}
	
	// create a standard form container
	$form_container = new FormContainer("Edit Team");
	
	$form_container->output_row("Name", "The teams name", $form->generate_text_box('name', $item['name'], array('id' => 'name')), 'name');
	$form_container->output_row("Image", "The URL image that will appear on the clubs page", $form->generate_text_box('image', $item['image'], array('id' => 'image')), 'image');
	$form_container->output_row("Description City", "City of the team", $form->generate_text_box('des', $item['des'], array('id' => 'des')), 'des');
	
	
	// create the save flag
	echo $form->generate_hidden_field("save", "save", array('id' => "save"))."\n";
	
	// end the container
	$form_container->end();
	
	// add the save button
	$buttons[] = $form->generate_submit_button("Save Changes");
	
	// display and end
	$form->output_submit_wrapper($buttons);
	$form->end();
		
	
	// end the page
	$page->output_footer();	
}

?>
