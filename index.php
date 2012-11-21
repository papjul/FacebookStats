<?php
/**
 * Facebook stats
 * Copyright © 2012 Julien Papasian
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

### Init
define('ROOT', dirname( __FILE__ ));
define('SAFE', true);
header('Content-Type: text/html; charset=utf-8');

require_once ROOT.'/config.php';
$sex = array('male' => 0, 'female' => 0);
$sexPercent = array('male' => 0, 'female' => 0);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
  <meta charset="utf-8" />

  <title>Facebook stats</title>
  <meta name="description" content="Facebook stats shows you some useless stats about your friends on Facebook which you can’t see on the website" />
  <meta name="keywords" content="facebook, stats" />
  <meta name="author" content="Julien Papasian" />
  <meta name="robots" content="noindex, nofollow" />

  <link rel="stylesheet" title="Stats" type="text/css" href="style.css" />
</head>
<body>
  <header><h1>Facebook stats</h1></header>

  <div id="content">
    <?php
    if(!file_exists(FILE) || filemtime(FILE) < intval(NOW - CACHE * ONE_HOUR))
    {
      if(!file_exists(FILE))
      {
        ?>
        <p>Hi there!</p>
        <p>This is probably the first time you execute this script.</p>
        <?php
      }
      else
      {
        ?>
        <p><strong>Oops! It seems your data is a bit old!</strong></p>
        <p>Here’s a little reminder on how to update it:</p>
        <?php
      }
      ?>
      <p>All you have to do is connecting to your Facebook account and <a href="https://developers.facebook.com/docs/reference/fql/friend/">clicking here</a>.</p>
      <p>Look for the link “Try this query”, click it and replace the value of query= in the URL with the following FQL query:</p>
      <pre>SELECT uid, name, sex, pic_square, profile_url, mutual_friend_count, friend_count, wall_count
FROM user
WHERE uid IN (SELECT uid2 FROM friend WHERE uid1=me())
ORDER BY mutual_friend_count DESC</pre>
      <p>Save the file under <strong><?= FILE ?></strong> in the same directory as this application.</p>
      <?php
    }
    if(file_exists(FILE))
    {
      $xml = simplexml_load_file(FILE);
      ?>

      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Picture</th>
            <th>Name</th>
            <th>Mutual friends</th>
            <th>Wall count</th>
          </tr>
        </thead>
        <tbody>
        <?php
        $i = 0;
        foreach($xml->children() as $profile)
        {
          ++$i;

          # Remove yourself from total of friends (or you won’t be able to have 100%)
          $profile->friend_count -= 1;

          $percentMutual = (intval($profile->friend_count) != 0) ? round(($profile->mutual_friend_count / $profile->friend_count) * 100, 2) : 0;

          echo '<tr'.(($percentMutual > 15) ? ' style="background-color: #FFFAAA;"' : '').'>
            <td>'.$i.'</td>
            <td><a href="'.$profile->profile_url.'"><img src="'.$profile->pic_square.'" alt="" /></a></td>
            <td class="name"><a href="'.$profile->profile_url.'">'.$profile->name.'</a></td>
            <td><a href="https://www.facebook.com/browse/mutual_friends/?uid='.$profile->uid.'">'.$profile->mutual_friend_count.' / '.((intval($profile->friend_count) > 0) ? $profile->friend_count.'</a><br />('.$percentMutual.'%)' : '—</a>').'</td>
            <td>'.((intval($profile->wall_count) != 0) ? $profile->wall_count : '—').'</td>
          </tr>';

          if($profile->sex != '') ++$sex[strval($profile->sex)];
        }
        ?>
        </tbody>
      </table>

      <hr />

      <table>
        <thead><tr><th colspan="3">Sex distribution</th></tr></thead>
        <tbody>
          <tr>
            <?php
            $sexPercent['male'] = round($sex['male'] * 100 / $i, 2);
            $sexPercent['female'] = round($sex['female'] * 100 / $i, 2);

            echo '<td>'.$sex['male'].' ('.$sexPercent['male'].'%) male</td>
            <td>'.$sex['female'].' ('.$sexPercent['female'].'%) female</td>
            <td>'.intval($i - ($sex['male'] + $sex['female'])).' ('.round(100 - ($sexPercent['male'] + $sexPercent['female']), 2).'%) not specified</td>';
            ?>
          </tr>
        </tbody>
      </table>
    </div>
    <?php
  }
  ?>
  <hr />

  <footer><p>Copyright © 2012 <a href="https://github.com/Yurienu/FacebookStats">Facebook stats</a></p></footer>
</body>
</html>