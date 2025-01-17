<?php

use MediaWiki\MediaWikiServices;
use MediaWiki\Revision\RenderedRevision;
use MediaWiki\Revision\RevisionRecord;
use MediaWiki\Revision\SlotRecord;

/**
 * Class containing utility functions for a FlaggedRevs environment
 *
 * Class is lazily-initialized, calling load() as needed
 */
class FlaggedRevs {
	/**
	 * The name of the ParserCache to use for stable revisions caching.
	 *
	 * @note This name is used as a part of the ParserCache key, so
	 * changing it will invalidate the parser cache for stable revisions.
	 */
	public const PARSER_CACHE_NAME = 'stable-pcache';

	/** @var string[][] Tag name/level config */
	private static $dimensions = [];
	/** @var int[][] Copy of $wgFlaggedRevsTagsRestrictions */
	private static $tagRestrictions = [];
	/** @var bool */
	private static $binaryFlagging = true;
	/** @var int[] Namespace config, copy of $wgFlaggedRevsNamespaces */
	private static $reviewNamespaces = [];
	/** @var string[] Restriction levels/config, copy from $wgFlaggedRevsRestrictionLevels */
	private static $restrictionLevels = [];
	/** @var int Autoreview config, copy from $wgFlaggedRevsAutoReview */
	private static $autoReviewConfig = 0;

	/** @var bool */
	private static $loaded = false;

	private static function load() {
		if ( self::$loaded ) {
			return;
		}
		if ( !FlaggedRevsSetup::isReady() ) { // sanity
			throw new Exception( 'FlaggedRevs config loaded too soon! Possibly before LocalSettings.php!' );
		}
		self::$loaded = true;

		# Make sure that the restriction levels are unique
		global $wgFlaggedRevsRestrictionLevels;
		self::$restrictionLevels = array_unique( $wgFlaggedRevsRestrictionLevels );
		self::$restrictionLevels = array_filter( self::$restrictionLevels, 'strlen' );

		# Make sure no talk namespaces are in review namespace
		$namespaceInfo = MediaWikiServices::getInstance()->getNamespaceInfo();
		global $wgFlaggedRevsNamespaces;
		foreach ( $wgFlaggedRevsNamespaces as $ns ) {
			if ( $namespaceInfo->isTalk( $ns ) ) {
				throw new Exception( 'FlaggedRevs given talk namespace in $wgFlaggedRevsNamespaces!' );
			} elseif ( $ns === NS_MEDIAWIKI ) {
				throw new Exception( 'FlaggedRevs given NS_MEDIAWIKI in $wgFlaggedRevsNamespaces!' );
			}
		}
		self::$reviewNamespaces = $wgFlaggedRevsNamespaces;

		# Handle $wgFlaggedRevsAutoReview settings
		global $wgFlaggedRevsAutoReview;
		if ( is_int( $wgFlaggedRevsAutoReview ) ) {
			self::$autoReviewConfig = $wgFlaggedRevsAutoReview;
		}

		// When using a simple config, we don't need to initialize the other settings
		if ( self::useOnlyIfProtected() ) {
			return;
		}

		# Handle levelled tags
		global $wgFlaggedRevsTags;
		if ( count( $wgFlaggedRevsTags ) != 1 ) {
			throw new Exception( 'FlaggedRevs given invalid tag name! We only support one dimension now.' );
		}

		$tag = self::getTagName();
		$levels = $wgFlaggedRevsTags[$tag];
		# Define "quality"
		$ratingLevels = $levels['levels'];

		# Set FlaggedRevs tags
		self::$dimensions[$tag] = [];
		for ( $i = 0; $i <= $ratingLevels; $i++ ) {
			self::$dimensions[$tag][$i] = "{$tag}-{$i}";
		}
		if ( $ratingLevels > 1 ) {
			self::$binaryFlagging = false; // more than one level
		}

		# Handle restrictions on tags
		global $wgFlaggedRevsTagsRestrictions;
		self::$tagRestrictions = $wgFlaggedRevsTagsRestrictions;
	}

	# ################ Basic config accessors #################

	/**
	 * Is there only one tag and it has only one level?
	 * @return bool
	 */
	public static function binaryFlagging() {
		self::load();
		return self::$binaryFlagging;
	}

	/**
	 * Get the supported dimension name.
	 * @return string|null
	 */
	public static function getTagName(): ?string {
		global $wgFlaggedRevsTags;
		return array_keys( $wgFlaggedRevsTags )[0] ?? null;
	}

	/**
	 * Allow auto-review edits directly to the stable version by reviewers?
	 * @return bool
	 */
	public static function autoReviewEdits() {
		self::load();
		return ( self::$autoReviewConfig & FR_AUTOREVIEW_CHANGES ) != 0;
	}

	/**
	 * Auto-review new pages with the minimal level?
	 * @return bool
	 */
	public static function autoReviewNewPages() {
		self::load();
		return ( self::$autoReviewConfig & FR_AUTOREVIEW_CREATION ) != 0;
	}

	/**
	 * Auto-review of new pages or edits to pages enabled?
	 * @return bool
	 */
	public static function autoReviewEnabled() {
		return self::autoReviewEdits() || self::autoReviewNewPages();
	}

	/**
	 * Get the maximum level that can be autoreviewed
	 * @return int
	 */
	private static function maxAutoReviewLevel() {
		global $wgFlaggedRevsTagsAuto;
		self::load();
		if ( !self::autoReviewEnabled() ) {
			return 0; // shouldn't happen
		}
		// B/C (before $wgFlaggedRevsTagsAuto)
		return (int)( $wgFlaggedRevsTagsAuto[self::getTagName()] ?? 1 );
	}

	/**
	 * Is a "stable version" used as the default display
	 * version for all pages in reviewable namespaces?
	 * @return bool
	 */
	public static function isStableShownByDefault() {
		global $wgFlaggedRevsOverride;
		if ( self::useOnlyIfProtected() ) {
			return false; // must be configured per-page
		}
		return (bool)$wgFlaggedRevsOverride;
	}

	/**
	 * Are pages reviewable only if they have been manually
	 * configured by an admin to use a "stable version" as the default?
	 * @return bool
	 */
	public static function useOnlyIfProtected() {
		global $wgFlaggedRevsProtection;
		return (bool)$wgFlaggedRevsProtection;
	}

	/**
	 * Return the include handling configuration
	 * @return int
	 */
	public static function inclusionSetting() {
		global $wgFlaggedRevsHandleIncludes;
		return $wgFlaggedRevsHandleIncludes;
	}

	/**
	 * Are there site defined protection levels for review
	 * @return bool
	 */
	public static function useProtectionLevels() {
		global $wgFlaggedRevsProtection;
		return $wgFlaggedRevsProtection && self::getRestrictionLevels();
	}

	/**
	 * Get the autoreview restriction levels available
	 * @return string[] Value from $wgFlaggedRevsRestrictionLevels
	 */
	public static function getRestrictionLevels() {
		self::load();
		return self::$restrictionLevels;
	}

	/**
	 * Get the array of levels messages
	 * @return string[]
	 */
	public static function getLevels() {
		self::load();
		return self::$dimensions[self::getTagName()] ?? [];
	}

	/**
	 * Get the associative array of tag restrictions
	 * ([rights => levels])
	 * @return int[] Value from $wgFlaggedRevsTagsRestrictions
	 */
	private static function getRestrictions() {
		self::load();
		return self::$tagRestrictions[self::getTagName()] ?? [];
	}

	/**
	 * Get the 'diffonly=' value for diff URLs. Either ('1','0','')
	 * @return int[]
	 */
	public static function diffOnlyCGI() {
		$val = trim( wfMessage( 'flaggedrevs-diffonly' )->inContentLanguage()->text() );
		if ( strpos( $val, '&diffonly=1' ) !== false ) {
			return [ 'diffonly' => 1 ];
		} elseif ( strpos( $val, '&diffonly=0' ) !== false ) {
			return [ 'diffonly' => 0 ];
		}
		return [];
	}

	# ################ Permission functions #################

	/**
	 * @param int $value
	 * @return bool
	 */
	private static function valueIsValid( $value ) {
		return $value >= 0 && $value < count( self::getLevels() );
	}

	/**
	 * Check if all of the required site flags have a valid value
	 * @param int[] $flags
	 * @return bool
	 */
	public static function flagsAreValid( array $flags ) {
		if ( self::useOnlyIfProtected() ) {
			return true;
		}
		$tag = self::getTagName();
		if ( !isset( $flags[$tag] ) || !self::valueIsValid( $flags[$tag] ) ) {
			return false;
		}
		return true;
	}

	/**
	 * Returns true if a user can set $value
	 * @param User $user
	 * @param int $value
	 * @return bool
	 */
	public static function userCanSetValue( $user, $value ) {
		$pm = MediaWikiServices::getInstance()->getPermissionManager();
		# Sanity check tag and value
		if ( !self::valueIsValid( $value ) ) {
			return false; // flag range is invalid
		}
		$restrictions = self::getRestrictions();
		# No restrictions -> full access
		if ( !$restrictions ) {
			return true;
		}
		# Validators always have full access
		if ( $pm->userHasRight( $user, 'validate' ) ) {
			return true;
		}
		# Check if this user has any right that lets him/her set
		# up to this particular value
		foreach ( $restrictions as $right => $level ) {
			if ( $value <= $level && $level > 0 && $pm->userHasRight( $user, $right ) ) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Returns true if a user can set $flags for a revision via review.
	 * Requires the same for $oldflags if given.
	 * @param User $user
	 * @param int[] $flags suggested flags
	 * @param int[] $oldflags pre-existing flags
	 * @return bool
	 */
	public static function userCanSetFlags( $user, array $flags, $oldflags = [] ) {
		if ( !MediaWikiServices::getInstance()->getPermissionManager()
			->userHasRight( $user, 'review' )
		) {
			return false; // User is not able to review pages
		}
		if ( self::useOnlyIfProtected() ) {
			return true;
		}

		$qal = self::getTagName();
		if ( !isset( $flags[$qal] ) ) {
			return false; // unspecified
		} elseif ( !self::userCanSetValue( $user, $flags[$qal] ) ) {
			return false; // user cannot set proposed flag
		} elseif ( isset( $oldflags[$qal] )
			&& !self::userCanSetValue( $user, $oldflags[$qal] )
		) {
			return false; // user cannot change old flag
		}
		return true;
	}

	/**
	 * Check if a user can set the autoreview restiction level to $right
	 * @param User $user
	 * @param string $right the level
	 * @return bool
	 */
	public static function userCanSetAutoreviewLevel( $user, $right ) {
		if ( $right == '' ) {
			return true; // no restrictions (none)
		}
		if ( !in_array( $right, self::getRestrictionLevels() ) ) {
			return false; // invalid restriction level
		}
		$pm = MediaWikiServices::getInstance()->getPermissionManager();
		# Don't let them choose levels above their own rights
		if ( $right == 'sysop' ) {
			// special case, rewrite sysop to editprotected
			if ( !$pm->userHasRight( $user, 'editprotected' ) ) {
				return false;
			}
		} elseif ( $right == 'autoconfirmed' ) {
			// special case, rewrite autoconfirmed to editsemiprotected
			if ( !$pm->userHasRight( $user, 'editsemiprotected' ) ) {
				return false;
			}
		} elseif ( !$pm->userHasRight( $user, $right ) ) {
			return false;
		}
		return true;
	}

	# ################ Parsing functions #################

	/**
	 * Get the HTML output of a revision, using PoolCounter in the process
	 *
	 * @param FlaggedRevision $frev
	 * @param ParserOptions $pOpts
	 * @return Status Fatal if the pool is full. Otherwise good with an optional ParserOutput, or
	 *  null if the revision is missing.
	 */
	public static function parseStableRevisionPooled(
		FlaggedRevision $frev, ParserOptions $pOpts
	) {
		$page = WikiPage::factory( $frev->getTitle() );
		$parserCache = MediaWikiServices::getInstance()
			->getParserCacheFactory()
			->getParserCache( self::PARSER_CACHE_NAME );
		$parserCacheMetadata = $parserCache->getMetadata( $page );
		$keyPrefix = $parserCache->makeParserOutputKey(
			$page,
			$pOpts,
			$parserCacheMetadata ? $parserCacheMetadata->getUsedOptions() : null
		);

		$work = new PoolCounterWorkViaCallback(
			'ArticleView', // use standard parse PoolCounter config
			$keyPrefix . ':revid:' . $frev->getRevId(),
			[
				'doWork' => function () use ( $frev, $pOpts ) {
					return Status::newGood( self::parseStableRevision( $frev, $pOpts ) );
				},
				'doCachedWork' => static function () use ( $page, $pOpts, $parserCache ) {
					// Use new cache value from other thread
					return Status::newGood( $parserCache->get( $page, $pOpts ) ?: null );
				},
				'fallback' => static function ( bool $fast ) use ( $page, $pOpts, $parserCache ) {
					// Use stale cache if possible
					return Status::newGood( $parserCache->getDirty( $page, $pOpts ) ?: null );
				},
				'error' => static function ( Status $status ) {
					return $status;
				},
			]
		);

		return $work->execute();
	}

	/**
	 * Get the HTML output of a revision.
	 * @param FlaggedRevision $frev
	 * @param ParserOptions $pOpts
	 * @return ParserOutput|null
	 */
	public static function parseStableRevision( FlaggedRevision $frev, ParserOptions $pOpts ) {
		# Notify Parser if includes should be stabilized
		$resetManager = false;
		$incManager = FRInclusionManager::singleton();
		if ( $frev->getRevId() && self::inclusionSetting() != FR_INCLUDES_CURRENT ) {
			# Use FRInclusionManager to do the template version query
			# up front unless the versions are already specified there...
			if ( !$incManager->parserOutputIsStabilized() ) {
				$incManager->stabilizeParserOutput( $frev );
				$resetManager = true; // need to reset when done
			}
		}
		# Parse the new body
		$content = $frev->getRevisionRecord()->getContent( SlotRecord::MAIN );
		if ( $content === null ) {
			return null; // missing revision
		}

		// Make this parse use reviewed/stable versions of templates
		$oldCurrentRevisionRecordCallback = $pOpts->setCurrentRevisionRecordCallback(
			function ( $title, $parser = null ) use ( &$oldCurrentRevisionRecordCallback, $incManager ) {
				if ( !( $parser instanceof Parser ) ) {
					// nothing to do
					return call_user_func( $oldCurrentRevisionRecordCallback, $title, $parser );
				}
				if ( $title->getNamespace() < 0 || $title->getNamespace() === NS_MEDIAWIKI ) {
					// nothing to do (bug 29579 for NS_MEDIAWIKI)
					return call_user_func( $oldCurrentRevisionRecordCallback, $title, $parser );
				}
				if ( !$incManager->parserOutputIsStabilized() ) {
					// nothing to do
					return call_user_func( $oldCurrentRevisionRecordCallback, $title, $parser );
				}
				$id = false; // current version
				# Check for the version of this template used when reviewed...
				$maybeId = $incManager->getReviewedTemplateVersion( $title );
				if ( $maybeId !== null ) {
					$id = (int)$maybeId; // use if specified (even 0)
				}
				# Check for stable version of template if this feature is enabled...
				if ( self::inclusionSetting() == FR_INCLUDES_STABLE ) {
					$maybeId = $incManager->getStableTemplateVersion( $title );
					# Take the newest of these two...
					if ( $maybeId && $maybeId > $id ) {
						$id = (int)$maybeId;
					}
				}
				# Found a reviewed/stable revision
				if ( $id !== false ) {
					# If $id is zero, don't bother loading it (page does not exist)
					if ( $id === 0 ) {
						return null;
					}
					return MediaWikiServices::getInstance()
						->getRevisionLookup()
						->getRevisionById( $id );
				}
				# Otherwise, fall back to default behavior (load latest revision)
				return call_user_func( $oldCurrentRevisionRecordCallback, $title, $parser );
			}
		);

		$parserOut = $content->getParserOutput( $frev->getTitle(), $frev->getRevId(), $pOpts );
		# Stable parse done!
		if ( $resetManager ) {
			$incManager->clear(); // reset the FRInclusionManager as needed
		}
		$pOpts->setCurrentRevisionRecordCallback( $oldCurrentRevisionRecordCallback );
		return $parserOut;
	}

	# ################ Tracking/cache update update functions #################

	/**
	 * Update the page tables with a new stable version.
	 * @param WikiPage|Title $page
	 * @param FlaggedRevision|null $sv the new stable version (optional)
	 * @param FlaggedRevision|null $oldSv the old stable version (optional)
	 * @param RenderedRevision|null $renderedRevision (optional)
	 * @return bool stable version text changed and FR_INCLUDES_STABLE
	 * @throws Exception
	 */
	public static function stableVersionUpdates(
		object $page, $sv = null, $oldSv = null, $renderedRevision = null
	) {
		/** @var FlaggableWikiPage $article */
		if ( $page instanceof FlaggableWikiPage ) {
			$article = $page;
		} elseif ( $page instanceof WikiPage ) {
			$article = FlaggableWikiPage::getTitleInstance( $page->getTitle() );
		} elseif ( $page instanceof Title ) {
			$article = FlaggableWikiPage::getTitleInstance( $page );
		} else {
			throw new Exception( "First argument must be a Title or WikiPage." );
		}
		$title = $article->getTitle();

		$changed = false;
		if ( $oldSv === null ) { // optional
			$oldSv = FlaggedRevision::newFromStable( $title, FR_MASTER );
		}
		if ( $sv === null ) { // optional
			$sv = FlaggedRevision::determineStable( $title, FR_MASTER );
		}

		if ( !$sv ) {
			# Empty flaggedrevs data for this page if there is no stable version
			$article->clearStableVersion();
			# Check if pages using this need to be refreshed...
			if ( self::inclusionSetting() == FR_INCLUDES_STABLE ) {
				$changed = (bool)$oldSv;
			}
		} else {
			if ( $renderedRevision ) {
				$renderedOutput = $renderedRevision->getRevisionParserOutput();
				$renderedId = $renderedRevision->getRevision()->getId();
			} else {
				$renderedOutput = null;
				$renderedId = null;
			}

			# Update flagged page related fields
			$article->updateStableVersion( $sv, $renderedId );
			# Check if pages using this need to be invalidated/purged...
			if ( self::inclusionSetting() == FR_INCLUDES_STABLE ) {
				$changed = (
					!$oldSv ||
					$sv->getRevId() != $oldSv->getRevId()
				);
			}
			# Update template version cache...
			if (
				$renderedRevision &&
				$sv->getRevId() != $renderedId &&
				self::inclusionSetting() !== FR_INCLUDES_CURRENT
			) {
				FRInclusionCache::setRevIncludes( $title, $renderedId, $renderedOutput );
			}
		}
		# Lazily rebuild dependencies on next parse (we invalidate below)
		self::clearStableOnlyDeps( $title->getArticleID() );
		# Clear page cache unless this is hooked via RevisionDataUpdates, in
		# which case these updates will happen already with tuned timestamps
		if ( !$renderedRevision ) {
			$title->invalidateCache();
			self::purgeSquid( $title );
		}

		return $changed;
	}

	/**
	 * Clear FlaggedRevs tracking tables for this page
	 * @param int|int[] $pageId (int or array)
	 */
	public static function clearTrackingRows( $pageId ) {
		$dbw = wfGetDB( DB_PRIMARY );
		$dbw->delete( 'flaggedpages', [ 'fp_page_id' => $pageId ], __METHOD__ );
		$dbw->delete( 'flaggedrevs_tracking', [ 'ftr_from' => $pageId ], __METHOD__ );
		$dbw->delete( 'flaggedpage_pending', [ 'fpp_page_id' => $pageId ], __METHOD__ );
	}

	/**
	 * Clear tracking table of stable-only links for this page
	 * @param int|int[] $pageId (int or array)
	 */
	public static function clearStableOnlyDeps( $pageId ) {
		$dbw = wfGetDB( DB_PRIMARY );
		$dbw->delete( 'flaggedrevs_tracking', [ 'ftr_from' => $pageId ], __METHOD__ );
	}

	/**
	 * @param Title $title
	 * Updates squid cache for a title. Defers till after main commit().
	 */
	public static function purgeSquid( Title $title ) {
		DeferredUpdates::addCallableUpdate( static function () use ( $title ) {
			$title->purgeSquid();
		} );
	}

	/**
	 * Do cache updates for when the stable version of a page changed.
	 * Invalidates/purges pages that include the given page.
	 * @param Title $title
	 */
	public static function updateHtmlCaches( Title $title ) {
		$jobs = [];
		$jobs[] = HTMLCacheUpdateJob::newForBacklinks( $title, 'templatelinks' );
		JobQueueGroup::singleton()->lazyPush( $jobs );

		DeferredUpdates::addUpdate( new FRExtraCacheUpdate( $title ) );
	}

	/**
	 * Invalidates/purges pages where only stable version includes this page.
	 * @param Title $title
	 */
	public static function extraHTMLCacheUpdate( Title $title ) {
		DeferredUpdates::addUpdate( new FRExtraCacheUpdate( $title ) );
	}

	# ################ Revision functions #################

	/**
	 * Mark a revision as patrolled if needed
	 * @param RevisionRecord $revRecord
	 */
	public static function markRevisionPatrolled( RevisionRecord $revRecord ) {
		$rcid = MediaWikiServices::getInstance()
			->getRevisionStore()
			->getRcIdIfUnpatrolled( $revRecord );
		# Make sure it is now marked patrolled...
		if ( $rcid ) {
			$dbw = wfGetDB( DB_PRIMARY );
			$dbw->update( 'recentchanges',
				[ 'rc_patrolled' => 1 ],
				[ 'rc_id' => $rcid ],
				__METHOD__
			);
		}
	}

	# ################ Other utility functions #################

	/**
	 * @param int[] $flags
	 * @return bool is this revision at basic review condition?
	 */
	private static function isChecked( array $flags ) {
		if ( !$flags ) {
			return false;
		}
		self::load();
		foreach ( self::$dimensions as $f => $x ) {
			if ( !isset( $flags[$f] ) || $flags[$f] < 1 ) {
				return false;
			}
		}
		return true;
	}

	/**
	 * Get the quality tier of review flags
	 * @param int[] $flags
	 * @param int $default Return value if one of the tags has value < 0
	 * @return int flagging tier (FR_CHECKED or default value)
	 */
	public static function getQualityTier( array $flags, $default = -1 ) {
		if ( self::isChecked( $flags ) ) {
			return FR_CHECKED; // 0
		}
		return (int)$default;
	}

	/**
	 * Get minimum level tags for a tier
	 * @return int[]
	 */
	public static function quickTags() {
		self::load();
		if ( self::useOnlyIfProtected() ) {
			return [];
		}
		return [ self::getTagName() => 1 ];
	}

	/**
	 * Get minimum tags that are closest to $oldFlags
	 * given the site, page, and user rights limitations.
	 * @param User $user
	 * @param int[] $oldFlags previous stable rev flags
	 * @return int[]|null array or null
	 */
	private static function getAutoReviewTags( $user, array $oldFlags ) {
		if ( !self::autoReviewEdits() ) {
			return null; // shouldn't happen
		}
		$flags = [];
		if ( self::useOnlyIfProtected() ) {
			return $flags;
		}
		$tag = self::getTagName();
		# Try to keep this tag val the same as the stable rev's
		$val = $oldFlags[$tag] ?? 1;
		$val = min( $val, self::maxAutoReviewLevel() );
		# Dial down the level to one the user has permission to set
		while ( !self::userCanSetValue( $user, $val ) ) {
			$val--;
			if ( $val <= 0 ) {
				return null; // all tags vals must be > 0
			}
		}
		$flags[$tag] = $val;
		return $flags;
	}

	/**
	 * Get the list of reviewable namespaces
	 * @return int[] Value from $wgFlaggedRevsNamespaces
	 */
	public static function getReviewNamespaces() {
		self::load(); // validates namespaces
		return self::$reviewNamespaces;
	}

	/**
	 * Is this page in reviewable namespace?
	 * @param Title $title
	 * @return bool
	 */
	public static function inReviewNamespace( Title $title ) {
		$ns = ( $title->getNamespace() === NS_MEDIA ) ?
			NS_FILE : $title->getNamespace(); // treat NS_MEDIA as NS_FILE
		return in_array( $ns, self::getReviewNamespaces() );
	}

	# ################ Auto-review function #################

	/**
	 * Automatically review an revision and add a log entry in the review log.
	 *
	 * This is called during edit operations after the new revision is added
	 * and the page tables updated, but before LinksUpdate is called.
	 *
	 * $auto is here for revisions checked off to be reviewed. Auto-review
	 * triggers on edit, but we don't want those to count as just automatic.
	 * This also makes it so the user's name shows up in the page history.
	 *
	 * If $flags is given, then they will be the review tags. If not, the one
	 * from the stable version will be used or minimal tags if that's not possible.
	 * If no appropriate tags can be found, then the review will abort.
	 * @param WikiPage $article
	 * @param User $user
	 * @param RevisionRecord $revRecord
	 * @param int[]|null $flags
	 * @param bool $auto
	 * @param bool $approveRevertedTagUpdate Whether to notify the reverted tag
	 *  subsystem that the edit was reviewed. Should be false when autoreviewing
	 *  during page creation, true otherwise. Default is false.
	 * @return bool
	 */
	public static function autoReviewEdit(
		WikiPage $article,
		$user,
		RevisionRecord $revRecord,
		array $flags = null,
		$auto = true,
		$approveRevertedTagUpdate = false
	) {
		$title = $article->getTitle(); // convenience
		# Get current stable version ID (for logging)
		$oldSv = FlaggedRevision::newFromStable( $title, FR_MASTER );
		$oldSvId = $oldSv ? $oldSv->getRevId() : 0;

		if ( self::useOnlyIfProtected() ) {
			$flags = [];
			$quality = FR_CHECKED;
			$tags = '';
		} else {
			# Set the auto-review tags from the prior stable version.
			# Normally, this should already be done and given here...
			if ( !is_array( $flags ) ) {
				if ( $oldSv ) {
					# Use the last stable version if $flags not given
					if ( MediaWikiServices::getInstance()->getPermissionManager()
						->userHasRight( $user, 'bot' )
					) {
						$flags = $oldSv->getTags(); // no change for bot edits
					} else {
						# Account for perms/tags...
						$flags = self::getAutoReviewTags( $user, $oldSv->getTags() );
					}
				} else { // new page?
					$flags = self::quickTags();
				}
				if ( !is_array( $flags ) ) {
					return false; // can't auto-review this revision
				}
			}

			$quality = FR_CHECKED;
			$tags = FlaggedRevision::flattenRevisionTags( $flags );
		}

		# Note: this needs to match the prepareContentForEdit() call WikiPage::doEditContent.
		# This is for consistency and also to avoid triggering a second parse otherwise.
		$editInfo = $article->prepareContentForEdit(
			$revRecord->getContent( SlotRecord::MAIN ), null, $user );
		$poutput  = $editInfo->getOutput(); // revision HTML output

		# Get the "review time" versions of templates.
		# This tries to make sure each template version either came from the stable
		# version of that template or was a "review time" version used in the stable
		# version of this page. If a pending version of a template is currently vandalism,
		# we try to avoid storing its ID as the "review time" version so it won't show up when
		# someone views the page. If not possible, this stores the current template.
		if ( self::inclusionSetting() === FR_INCLUDES_CURRENT ) {
			$tVersions = $poutput->getTemplateIds();
		} else {
			$tVersions = $oldSv ? $oldSv->getTemplateVersions() : [];
			foreach ( $poutput->getTemplateIds() as $ns => $pages ) {
				foreach ( $pages as $dbKey => $revId ) {
					if ( !isset( $tVersions[$ns][$dbKey] ) ) {
						$srev = FlaggedRevision::newFromStable( Title::makeTitle( $ns, $dbKey ) );
						$tVersions[$ns][$dbKey] = $srev ? $srev->getRevId() : $revId;
					}
				}
			}
		}

		# Our review entry
		$flaggedRevision = new FlaggedRevision( [
			'revrecord'    		=> $revRecord,
			'user_id'	       	=> $user->getId(),
			'timestamp'     	=> $revRecord->getTimestamp(), // same as edit time
			'quality'      	 	=> $quality,
			'tags'	       		=> $tags,
			'img_name'      	=> null,
			'img_timestamp' 	=> null,
			'img_sha1'      	=> null,
			'templateVersions' 	=> $tVersions,
			'fileVersions'     	=> [],
			'flags'             => $auto ? 'auto' : '',
		], $title );

		// Insert the flagged revision
		$success = $flaggedRevision->insert();
		if ( !$success ) {
			return false;
		}

		if ( $approveRevertedTagUpdate ) {
			$flaggedRevision->approveRevertedTagUpdate();
		}

		# Update the article review log
		if ( !$auto ) {
			FlaggedRevsLog::updateReviewLog( $title,
				$flags, [], '', $revRecord->getId(), $oldSvId, true, $user );
		}

		# Update page and tracking tables and clear cache
		self::stableVersionUpdates( $article );

		return true;
	}

}
