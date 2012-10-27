Facebook stats
==========

Description
-------------
Facebook stats shows you some useless stats about your friends on Facebook which you can’t see on the website.


Compatibility
-------------
**Works** under stable versions of PHP : latest *5.3* and *5.4*.


Requirements
-------------
You have to execute the following FQL query :

SELECT uid, name, sex, pic_square, profile_url, mutual_friend_count, friend_count, wall_count
FROM   user
WHERE  uid IN (SELECT uid2 FROM friend WHERE uid1=me())
ORDER BY mutual_friend_count DESC

If you don’t have an app, you can execute it here : https://developers.facebook.com/docs/reference/fql/friend/
Look for the link Try this query, click it and replace the value of query= in the URL with the query below.

Save the file under fql.xml in the same directory as this application.


License
-------------
You can share, modify this application under GNU GPLv2+ terms available in the file LICENSE.