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

// Definimos MyBB
// Disallow direct access to this file for security reasons
if(!defined("IN_MYBB"))
{
	die("Direct initialization of this file is not allowed.<br /><br />Please make sure IN_MYBB is defined.");
}

// Inicioamos informacion ClubsTeams Plugin
function clubsteams_info()
{

	return array(
		"name"		=> "Clubs Teams Fan",
		"description"	=> "Fan Clubs Teams Plugin to MyBB Board",
		"website"		=> "http://diegopino.besaba.com/we11world/",
		"author"		=> "DiegoPino",
		"authorsite"	=> "http://diegopino.blogspot.com/",
		"version"		=> "1.0",
		"compatibility" => "18*"
	);
}

// Instalacion ClubsTeams
function clubsteams_install()
{
	global $db;

// Creamos Base de Datos MySql
	
	$db->write_query("CREATE TABLE IF NOT EXISTS `".TABLE_PREFIX."clubteams` (
  	`id` int(10) unsigned NOT NULL auto_increment,
  	`name` varchar(240) NOT NULL,
  	`image` text,
  	`des` text,
  	PRIMARY KEY  (`id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;
                     ");


// Volcamos Database MySql con Ejemplos de Equipos, Opcion temporal
	$db->write_query("

	
INSERT INTO `mybb_clubteams` (`id`, `name`, `image`, `des`) VALUES
(2, 'Arsenal', 'https://upload.wikimedia.org/wikipedia/en/5/53/Arsenal_FC.svg', 'England | Londres'),
(3, 'Chelsea', 'https://upload.wikimedia.org/wikipedia/en/c/cc/Chelsea_FC.svg', 'England | Londres'),
(4, 'Manchester United', 'https://upload.wikimedia.org/wikipedia/en/7/7a/Manchester_United_FC_crest.svg', 'England | Manchester'),
(5, 'Manchester City', 'https://upload.wikimedia.org/wikipedia/en/c/cf/Manchester_City.svg', 'England | Manchester'),
(6, 'Real Madrid', 'https://upload.wikimedia.org/wikipedia/en/5/56/Real_Madrid_CF.svg', 'Espana | Madrid'),
(7, 'Barcelona', 'https://upload.wikimedia.org/wikipedia/en/4/47/FC_Barcelona_%28crest%29.svg', 'Espana | Barcelona'),
(8, 'Atletico Madrid', 'https://upload.wikimedia.org/wikipedia/en/c/c1/Atletico_Madrid_logo.svg', 'Espana | Madrid'),
(9, 'Juventus', 'https://upload.wikimedia.org/wikipedia/en/d/d2/Juventus_Turin.svg', 'Italia'),
(10, 'A.C. Milan', 'https://upload.wikimedia.org/wikipedia/en/d/db/AC_Milan.svg', 'Italia | Milan'),
(11, 'Inter Milan', 'https://upload.wikimedia.org/wikipedia/en/2/23/Inter_Milan.png', 'Italia | Milan'),
(12, 'AS Roma', 'https://upload.wikimedia.org/wikipedia/en/5/52/AS_Roma_logo_%282013%29.svg', 'Italia | Roma'),
(13, 'Boca Juniors', 'https://upload.wikimedia.org/wikipedia/commons/d/de/Boca_Juniors_2012.svg', 'Argentina'),
(14, 'River Plate', 'https://upload.wikimedia.org/wikipedia/commons/c/c9/RIVERNORMAL.png', 'Argentina'),
(15, 'Racing', 'https://upload.wikimedia.org/wikipedia/commons/2/29/Racing_Club_%282014%29.svg', 'Argentina'),
(16, 'Paranaense', 'https://upload.wikimedia.org/wikipedia/commons/b/b3/CA_Paranaense.svg', 'Curitiba'),
(17, 'Corinthians', 'https://upload.wikimedia.org/wikipedia/en/1/1f/Sport_Club_Corinthians_Paulista_Logo.png', 'Brasil | Sao Paulo'),
(18, 'Sao Paulo', 'https://upload.wikimedia.org/wikipedia/commons/d/d6/SaoPauloFC.svg', 'B'),
(19, 'Vasco Da Gama', 'https://upload.wikimedia.org/wikipedia/en/1/1a/ClubDeRegatasVascoDaGama.svg', 'Brasil');

				");

	$db->write_query("CREATE TABLE IF NOT EXISTS `".TABLE_PREFIX."clubfans` (
  	`id` int(10) unsigned NOT NULL auto_increment,
  	`uid` int(10) default NULL,
  	`team` int(10) default NULL,
  	PRIMARY KEY  (`id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;
                     ");


// Volcamos Database MySql con Ejemplos de Equipos, Opcion temporal
	$db->write_query("

INSERT INTO `mybb_clubfans` (`id`, `uid`, `team`) VALUES
(2, 6, 2),
(3, 9, 2),
(4, 13, 2),
(5, 14, 2),
(6, 16, 2),
(7, 17, 2),
(8, 10, 2),
(9, 12, 2),
(10, 13, 3),
(11, 19, 3),
(12, 11, 3),
(13, 12, 3),
(14, 13, 3),
(15, 26, 3),
(16, 17, 3),
(17, 20, 3),
(18, 14, 3),
(19, 15, 3),
(20, 16, 3),
(21, 17, 3),
(22, 18, 12),
(23, 19, 13),
(24, 11, 4),
(25, 12, 4),
(26, 21, 4),
(27, 31, 4),
(28, 41, 4),
(29, 42, 4),
(30, 43, 4),
(31, 44, 4),
(32, 45, 4),
(33, 46, 5),
(34, 47, 5),
(35, 48, 5),
(36, 49, 5),
(37, 50, 5),
(38, 51, 5),
(39, 52, 5),
(40, 53, 5),
(41, 54, 10),
(42, 55, 9),
(43, 56, 9),
(44, 57, 9),
(45, 58, 8),
(46, 59, 8),
(47, 60, 8),
(48, 61, 7),
(49, 62, 7),
(50, 50, 7);
		
		");

	clubsteams_templates();
				
	rebuild_settings();	
}

// Funcion Clubsteams es instalado
function clubsteams_is_installed()
{
	global $db;
	
	if($db->table_exists("clubfans") && $db->table_exists("clubteams"))
 	{
 		return true;
	}	
	return false;
}

function clubsteams_uninstall()
{
	global $db;
	
	$db->write_query("DROP TABLE ".TABLE_PREFIX."clubteams");
	$db->write_query("DROP TABLE ".TABLE_PREFIX."clubfans");

// Borramos query de forum software al desinstalar
	
	$db->delete_query("templates","title ='club_index'");
	$db->delete_query("templates","title ='club_team'");
	$db->delete_query("templates","title ='club_team_none'");
	$db->delete_query("templates","title ='club_user'");
	$db->delete_query("templates","title ='club_user_none'");
	
	rebuild_settings();	
}


// Funcion de Templates para el Plugin
function clubsteams_templates()
{
	global $db;

// Template Para MyBB, aunque este apartado no lo encuentro en el front
	$temp = array(
		"sid"		=> "NULL",
		"title"		=> "club_index",
		"template"	=> $db->escape_string('<html>
			<head>
			<title>{$mybb->settings[\'bbname\']}</title>
			{$headerinclude}
			</head>
			<body>

			{$header}

			{$teams_bit}

			{$footer}
			</body>
			</html>'),
		"sid"		=> "-1",
		"version"	=> "1.0",
		"status"	=> "0",
		"dateline"	=> time(),
	);
	
	$db->insert_query("templates", $temp);


// Templante que Muestra la info para MyBB 	
	$temp = array(
		"sid"		=> "NULL",
		"title"		=> "club_team",
		"template"	=> $db->escape_string('
			<TABLE BORDER=0 CELLPADDING=10>
				<TR>
    					<TH ROWSPAN=10 ALIGN=LEFT ><img src="{$team_image}" WIDTH=160 HEIGHT=160 alt="Imagen del Team"><br>{$team_name} <br> {$team_des} <br>Fans Total:<br> $members_num</TH>
    					<TD BGCOLOR="#99CCFF">Clubs Fans</TD> 
    				</TR>
				<TR>
    					<TD>{$members_bit}</TD> 
    				</TR>
    
				</TABLE>					
		<br />'),
		"sid"		=> "-1",
		"version"	=> "1.0",
		"status"	=> "0",
		"dateline"	=> time(),
	);
	
	$db->insert_query("templates", $temp);

// Template MyBB Cuando al Consultar No encuentra Equipos	
	$temp = array(
		"sid"		=> "NULL",
		"title"		=> "club_team_none",
		"template"	=> $db->escape_string('

				<table>
				<tr>
					<td><b>No Teams</b></td>
				</tr>
				<tr>
					<td>There are currently no teams, Please set up in <a href="admin/index.php?module=clubs/addteam">admin/index.php?module=clubs/addteam</a> in your Forum Software</td>
				</tr>
				</table>  
          
          <br />'),
		"sid"		=> "-1",
		"version"	=> "1.0",
		"status"	=> "0",
		"dateline"	=> time(),
	);
	
	$db->insert_query("templates", $temp);

// Template MyBB Temporal para Club_User
	
	$temp = array(
		"sid"		=> "NULL",
		"title"		=> "club_user",
		"template"	=> $db->escape_string('<tr><td class="trow1"><a href="member.php?action=profile&uid={$members_uid}">{$user_name}</a></td><td class="trow1">{$members_pos}</td></tr>'),
		"sid"		=> "-1",
		"version"	=> "1.0",
		"status"	=> "0",
		"dateline"	=> time(),
	);
	
	$db->insert_query("templates", $temp);

//Template MyBB para Users, Informacion Cuando no tiene el Club Fans	
	$temp = array(
		"sid"		=> "NULL",
		"title"		=> "club_user_none",
		"template"	=> $db->escape_string('<tr><td class="trow1" colspan="2">This team does not have any users. Please Set Up Player in <a href="admin/index.php?module=clubs/addplayer">admin/index.php?module=clubs/addplayer</a> </td></tr>'),
		"sid"		=> "-1",
		"version"	=> "1.0",
		"status"	=> "0",
		"dateline"	=> time(),
	);
	
	$db->insert_query("templates", $temp);				
}
 
?>
