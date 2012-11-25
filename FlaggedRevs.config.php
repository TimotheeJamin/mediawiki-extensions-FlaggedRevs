<?php

# ######## Configuration variables ########
# IMPORTANT: DO NOT EDIT THIS FILE
# When configuring globals, set them at LocalSettings.php instead

# This will only distinguish "checked", "quality", and unreviewed
# A small icon will show in the upper right hand corner
$wgSimpleFlaggedRevsUI = true; // @TODO: remove when ready
# For visitors, only show tags/icons for unreviewed/outdated pages
$wgFlaggedRevsLowProfile = true; // @TODO: remove with new icon UI?

# Allowed namespaces of reviewable pages
$wgFlaggedRevsNamespaces = array( NS_MAIN, NS_FILE, NS_TEMPLATE );
# Pages exempt from reviewing. No flagging UI will be shown for them.
$wgFlaggedRevsWhitelist = array();
# $wgFlaggedRevsWhitelist = array( 'Main_Page' );

# Is a "stable version" used as the default display
# version for all pages in reviewable namespaces?
$wgFlaggedRevsOverride = true;
# Below are groups that see the current revision by default.
# This makes editing easier since the users always start off
# viewing the latest version of pages.
$wgFlaggedRevsExceptions = array( 'user' ); // @TODO: remove when ready (and expand pref)

# Auto-review settings for edits/new pages:
# FR_AUTOREVIEW_NONE
#   Don't auto-review any edits or new pages
# FR_AUTOREVIEW_CHANGES
#   Auto-review the following types of edits (to existing pages):
#   (a) changes directly to the stable version by users with 'autoreview'/'bot'
#   (b) reversions to old reviewed versions by users with 'autoreview'/'bot'
#   (c) self-reversions back to the stable version by any user
# FR_AUTOREVIEW_CREATION
#   Auto-review new pages as minimally "checked"
# FR_AUTOREVIEW_CREATION_AND_CHANGES
#   Combines FR_AUTOREVIEW_CHANGES and FR_AUTOREVIEW_CREATION
$wgFlaggedRevsAutoReview = FR_AUTOREVIEW_CREATION_AND_CHANGES;

# Define the tags we can use to rate an article, number of levels,
# and set the minimum level to have it become a "quality" or "pristine" version.
# NOTE: When setting up new dimensions or levels, you will need to add some
#       MediaWiki messages for the UI to show properly; any sysop can do this.
$wgFlaggedRevsTags = array(
	'accuracy' => array( 'levels' => 3, 'quality' => 2, 'pristine' => 4 ),
	'depth'    => array( 'levels' => 3, 'quality' => 1, 'pristine' => 4 ),
	'style'    => array( 'levels' => 3, 'quality' => 1, 'pristine' => 4 ),
);
# For each tag, define the highest tag level that is unlocked by
# having certain rights. For example, having 'review' rights may
# allow for "depth" to be rated up to second level.
# NOTE: Users cannot lower revision tags from a level they can't set.
# NOTE: Users with 'validate' (Reviewers) can set all tags to all levels.
$wgFlaggedRevsTagsRestrictions = array(
	'accuracy' => array( 'review' => 1, 'autoreview' => 1 ),
	'depth'    => array( 'review' => 2, 'autoreview' => 2 ),
	'style'    => array( 'review' => 3, 'autoreview' => 3 ),
);
# For each tag, what is the highest level that it can be auto-reviewed to?
# $wgFlaggedRevsAutoReview must be enabled for this to apply.
$wgFlaggedRevsTagsAuto = array(
	'accuracy' => 1, 'depth' => 1, 'style' => 1
);

# Restriction levels for 'autoreview'/'review' rights.
# When a level is selected for a page, an edit made by a user
# will not be auto-reviewed if the user lacks the specified permission.
# Levels are set at the Stabilization special page.
$wgFlaggedRevsRestrictionLevels = array( '', 'sysop' );
# Set this to use FlaggedRevs *only* as a protection-like mechanism.
# This will disable Stabilization and show the above restriction levels
# on the protection form of pages. Each level has the stable version shown by default.
# A "none" level will appear in the form as well, to disable the review process.
# Pages will only be reviewable if manually restricted to a level above "none".
$wgFlaggedRevsProtection = false;

# Define our basic reviewer class of established editors (Editors)
$wgGroupPermissions['editor']['review']          = true;
$wgGroupPermissions['editor']['autoreview']      = true;
$wgGroupPermissions['editor']['autoconfirmed']   = true;
$wgGroupPermissions['editor']['unreviewedpages'] = true;

# Define when users get automatically promoted to Editors. Set as false to disable.
# Once users meet these requirements they will be promoted, unless previously demoted.
$wgFlaggedRevsAutopromote = array(
	'days'                  => 60, # days since registration
	'edits'                 => 250, # total edit count
	'excludeLastDays'       => 1, # exclude the last X days of edits from edit counts
	'benchmarks'            => 15, # number of "spread out" edits
	'spacing'               => 3, # number of days between these edits (the "spread")
	// Either totalContentEdits reqs OR totalCheckedEdits requirements needed
	'totalContentEdits'     => 300, # edits to pages in $wgContentNamespaces
	'totalCheckedEdits'     => 200, # edits before the stable version of pages
	'uniqueContentPages'    => 14, # unique pages in $wgContentNamespaces edited
	'editComments'          => 50, # number of manual edit summaries used
	'userpageBytes'         => 0, # size of userpage (use 0 to not require a userpage)
	'neverBlocked'          => true, # username was never blocked before?
	'maxRevertedEditRatio'  => .03, # max fraction of edits reverted via "rollback"/"undo"
);

# Define when users get to have their own edits auto-reviewed. Set to false to disable.
# This can be used for newer, semi-trusted users to improve workflow.
# It is done by granting some users the implicit 'autoreview' group.
$wgFlaggedRevsAutoconfirm = false;
/* (example usage)
$wgFlaggedRevsAutoconfirm = array(
	'days'                  => 30, # days since registration
	'edits'                 => 50, # total edit count
	'excludeLastDays'       => 2, # exclude the last X days of edits from edit counts
	'benchmarks'            => 7, # number of "spread out" edits
	'spacing'               => 3, # number of days between these edits (the "spread")
	// Either totalContentEdits reqs OR totalCheckedEdits requirements needed
	'totalContentEdits'     => 150, # $wgContentNamespaces edits OR...
	'totalCheckedEdits'     => 50, # ...Edits before the stable version of pages
	'uniqueContentPages'    => 8, # $wgContentNamespaces unique pages edited
	'editComments'          => 20, # how many edit comments used?
	'email'                 => false, # user must be emailconfirmed?
	'neverBlocked'          => true, # Can users that were blocked be promoted?
);
*/

# Defines extra rights for advanced reviewer class (Reviewers)
$wgGroupPermissions['reviewer']['validate']        = true;
# Let this stand alone just in case...
$wgGroupPermissions['reviewer']['review']          = true;
$wgGroupPermissions['reviewer']['autoreview']      = true;
$wgGroupPermissions['reviewer']['autoconfirmed']   = true;
$wgGroupPermissions['reviewer']['unreviewedpages'] = true;

# Sysops have their edits autoreviewed
$wgGroupPermissions['sysop']['autoreview'] = true;
# Stable version selection and default page revision selection can be set per page.
$wgGroupPermissions['sysop']['stablesettings'] = true;
# Sysops can always move stable pages
$wgGroupPermissions['sysop']['movestable'] = true;

# "Auto-checked"/semi-trusted user group
$wgGroupPermissions['autoreview']['autoreview'] = true;

# Special:Userrights settings
# # Basic rights for Sysops
$wgAddGroups['sysop'][] = 'editor'; // promote to basic reviewer (established editors)
$wgRemoveGroups['sysop'][] = 'editor'; // demote from basic reviewer (established editors)
$wgAddGroups['sysop'][] = 'autoreview'; // promote to basic auto-reviewer (semi-trusted users)
$wgRemoveGroups['sysop'][] = 'autoreview'; // demote from basic auto-reviewer (semi-trusted users)

# How far the logs for overseeing quality revisions and depreciations go
$wgFlaggedRevsOversightAge = 30 * 24 * 3600;

# How long before Special:ValidationStatistics is updated.
# Set to false to disable (perhaps using a cron job instead).
$wgFlaggedRevsStatsAge = 2 * 3600; // 2 hours

# Configurable information to collect and display at Special:ValidationStatistics
$wgFlaggedRevsStats = array(
	'topReviewersCount' => 5, # how many top reviewers to list
	'topReviewersHours' => 1, # how many hours of the last reviews to count
);

# How to handle templates and files used in stable versions:
# FR_INCLUDES_CURRENT
#   Always use the current version of templates/files
# FR_INCLUDES_FREEZE
#   Use the version of templates/files that the page used when reviewed
# FR_INCLUDES_STABLE
#   For each template/file, check if a version of it was used when the page was reviewed
#   and if the template/file itself has a stable version; use the newest those versions
# NOTE: We may have templates that do not have stable version. Also, given situational
# inclusion of templates (e.g. parser functions selecting template X or Y based on date),
# there may also be no "review time version" revision ID for a template used on a page.
# In such cases, we select the current (unreviewed) revision. Likewise for files.
$wgFlaggedRevsHandleIncludes = FR_INCLUDES_STABLE;

# Whether to run Validation Statistics updates during Special Page Cache Updates
$wgEnableValidationStatisticsUpdates = true;

# End of configuration variables.
# ########
