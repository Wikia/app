# Image Review Tool

## Overview
The Image Review Tool is used to review, flag, and remove inappropriate
images which have been uploaded to Fandom. The review process has 2 stages:

First, when an image is uploaded to Fandom it enters an "unreviewed" queue.
Fandom uses a group of contractors to do a first pass on all these images
and filter them into "approved", "rejected", or "questionable" images.
Images marked as approved are done, no more work is needed for them.
Images marked as rejected or questionable move into the second stage of
the review.

At the second stage, Fandom staff evaluates the rejected and questionable
images and makes the final call about whether to approve or delete them.
Images marked for deletion spawn a new ImageReviewTask which removes the
offending image from the wiki where it was uploaded.

## Technical Overview
### Database
The image review tool uses 2 tables found in the dataware database. Those
tables are `image_review` and `image_review_stats`.

`image_review` holds the queue of images to be reviewed, as well as the
current state of the image (states are described in more detail below).

`image_review_stat` holds a log of all review actions an image goes through.
This includes when image being is approved, deleted, marked as questionable
or reverted to a previous state.

### States
The image review tool relies heavily on the concept of image states. These
states can be found in the ImageStates.php class and correspond to values
in the database. The most significant states are the following:
```
UNREVIEWED = 0;
IN_REVIEW = 1;
APPROVED = 2;
DELETED = 3;
REJECTED = 4;
QUESTIONABLE = 5;
QUESTIONABLE_IN_REVIEW = 6;
REJECTED_IN_REVIEW = 7;
```
Images start their life-cycle in the `UNREVIEWD` state and work their
way towards either the `APPROVED` or `DELETED` state.

As described above, there are 2 general stages a newly uploaded image
goes through. First, when an image is uploaded to a wiki, a reference to
it is added to the `image_review` table in the `UNREVIEWED` state. When
a contractor starts a review the image review tool will fetch 20 of these
`UNREVIEWED` images and move them into the `IN_REVIEW` state. This prevents
more than 1 contractor from reviewing the same image. After reviewing the
image, the contractor can decide to either approve the image, reject it,
or mark it as questionable. If approved, the image moves into the `APPROVED`
state and no more actions are taken. If the image is marked as rejected or
questionable, it moves into the `REJECTED` or `QUESTIONABLE` state respectively.
Every time an image moves to a new state (be it `APPROVED`, `REJECTED` or
`QUESTIONABLE`) a log entry is added for it in the `image_review_stats` 
table indicating who made the decision, what decision was made, and when.

Those images that move into into the `REJECTED` and `QUESTIONABLE` state
are then reviewed by a staff member who makes the final decision on whether
to approve or reject them. Rejected and questionable images each have their
own areas in the image review tool. When the staff member browses to the
"rejected" area, the tool will fetch 20 images in the `REJECTED` state
and move them into the `REJECTED_IN_REVIEW` state. This is again to prevent
an image from being reviewed by more than 1 person. The staff member then
either approves the image, which moves it into the `APPROVED` state, or
deletes the image which moves it into the `DELETED` state. Marking an image
as deleted also  kicks of the ImageReviewTask which removes the image from
the wiki. The process for questionable images is identical except using
the the `QUESTIONABLE` and `QUESTIONABLE_IN_REVIEW` states.
