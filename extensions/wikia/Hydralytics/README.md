# Hydralytics

An admin analytics dashboard for communities admins. You need to be in a group with `analytics` right to access `Special:Analytics`.

## WikiFactory

This extension is enabled site-wide, but can be disabled on per-community basis via `$wgEnableHydralyticsExt` WikiFactory variable.

## Feature usage tracking

Google Analytics and internal tracker requests are sent when this special page is visited by an admin:

```
Wikia.Tracker:  trackingevent wikia_analytics/impression/ [analytics track]
```
