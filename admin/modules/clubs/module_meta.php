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

// Disallow direct access to this file for security reasons
if(!defined("IN_MYBB"))
{
	die("Direct initialization of this file is not allowed.<br /><br />Please make sure IN_MYBB is defined.");
}

function clubs_meta()
{
	// get access to everything we want
	global $page, $lang, $plugins, $db;

	// this is a list of sub menus
	$sub_menu = array();
	$sub_menu['10'] = array("id" => "addteam", "title" => "Create Team", "link" => "index.php?module=clubs/addteam");
	$sub_menu['20'] = array("id" => "manage", "title" => "Manage Teams", "link" => "index.php?module=clubs/manage");
	$sub_menu['30'] = array("id" => "addplayer", "title" => "Add Player", "link" => "index.php?module=clubs/addplayer");
	
	// custom plugin hooks!
	//$plugins->run_hooks_by_ref("admin_forum_menu", $sub_menu);
	
	$page->add_menu_item("Clubs Manager", "Clubs", "index.php?module=clubs", 81, $sub_menu);

	if($db->table_exists("clubteams"))
	{	// plugin installed, so show this module's link
		// add_menu_item(title, name, link, display order, submenus)
		return true;
	}
	// I assume returning false means "don't do anything"
	// no adverse effects so far.
	return false;
}

function clubs_action_handler($action)
{
	global $page, $lang, $plugins;
	
	// our module's name
	$page->active_module = "clubs";
	
	// the available actions and their pages
	$actions = array(
		'addteam' => array('active' => 'addteam', 'file' => 'addteam.php'),
		'manage' => array('active' => 'manage', 'file' => 'manage.php'),
		'addplayer' => array('active' => 'addplayer', 'file' => 'addplayer.php'),
	);
	
	// more custom plugin hooks!
	//$plugins->run_hooks_by_ref("admin_roster_action_handler", $actions);
	
	if(isset($actions[$action]))
	{	// set the action and return the page
		$page->active_action = $actions[$action]['active'];
		return $actions[$action]['file'];
	}
	else
	{	// return the default page
		$page->active_action = "manage";
		return "manage.php";
	}
}
