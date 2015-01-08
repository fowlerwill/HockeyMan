<?php

/* = Required Files
-----------------------------------------------------------------------------*/
//require_once(dirname(dirname(dirname(dirname(__FILE__)))).'/wp-load.php'); <-- Hopefully we don't need this?
require_once (ABSPATH . WPINC . '/pluggable.php');
require_once 'TeamManager.php';
require_once 'TeamManager_Team.php';
require_once 'TeamManager_Event.php';
require_once 'TeamManager_Member.php';
require_once 'TeamManager_Email.php';
require_once 'TeamManager_Ajax.php';

/* = Dev Development
-----------------------------------------------------------------------------*/

define("MEMBERS_TABLE", "wp35_teammanager_members");
define("EVENTS_TABLE", "wp35_teammanager_events");
define("TEAMS_TABLE", "wp35_teammanager_teams");

define("THE_PRODUCT_NAME", "Incite Team Manager");
define("TEAMMANAGER_DEBUG_MODE", true);


