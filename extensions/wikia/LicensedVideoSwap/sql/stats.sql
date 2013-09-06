-- Table to collect information about Licensed Video Swap usage across all wikis
CREATE TABLE lvs_usage_stats (
    wiki_id           integer PRIMARY KEY,

    -- When this row was last changed (not including update to 'checked_on')
    updated_on        datetime,

    -- When this wiki was last checked for new videos/suggestions
    checked_on        datetime,

    -- Types of videos on the wiki
    premium_videos    integer,
    external_videos   integer,
    swappable_videos  integer,
    total_suggestions integer,

    -- User actions taken on the wiki
    kept_videos       integer,
    swapped_videos    integer,
    close_swap_videos integer,
    exact_swap_videos integer,

    -- Other data of interest as a JSON
    data              blob,

    index(wiki_id, checked_on, updated_on),
    index(swappable_videos),
    index(swapped_videos),
    index(kept_videos)
);

-- Example queries --

-- Find wikis that aren't in the table yet
SELECT city_id
  FROM city_list LEFT JOIN lvs_usage_stats
    ON city_id = wiki_id
 WHERE wiki_id IS NULL;

-- Find wikis that haven't been checked in a week
SELECT wiki_id
  FROM lvs_usage_stats
 WHERE checked_on < NOW() - INTERVAL 1 WEEK;

-- Find wikis that haven't been checked in a week but have had at least one update in the last month
SELECT wiki_id
FROM lvs_usage_stats
WHERE checked_on < NOW() - INTERVAL 1 WEEK
  AND updated_on < NOW() - INTERVAL 1 MONTH;

-- Find wikis that have more than 10 swappable videos
SELECT wiki_id FROM lvs_usage_stats WHERE swappable_videos > 10;

-- Find wikis that have more than zero swapped videos
SELECT wiki_id FROM lvs_usage_stats WHERE swapped_videos > 0;

-- Find wikis that have more than zero kept videos
SELECT wiki_id FROM lvs_usage_stats WHERE kept_videos > 0;