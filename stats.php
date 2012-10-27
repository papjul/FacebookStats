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

### Initialisation
$xml = simplexml_load_file('fql.xml');
$profile = array();
$sex = array('male' => 0, 'female' => 0, 'alien' => 0);
$sexPercent = array('male' => 0, 'female' => 0, 'alien' => 0);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="content-style-type" content="text/css" />
        <meta http-equiv="content-language" content="english" />
        <meta name="robots" content="noindex,nofollow" />

        <title>Facebook stats</title>

        <link href="style.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <h2>Facebook stats</h2>

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
            foreach($xml->children() as $child)
            {
                foreach($child->children() as $child2)
                    $profile[$child2->getName()] = $child2;

                ++$i;

                $percentMutual = (intval($profile['friend_count']) != 0) ? round(($profile['mutual_friend_count'] / $profile['friend_count']) * 100, 2) : 0;

                echo '<tr'.(($percentMutual > 15) ? ' style="background-color: #FFFAAA;"' : '').'>
                    <td class="number">'.$i.'</td>
                    <td class="pic_square"><a href="'.$profile['profile_url'].'"><img src="'.$profile['pic_square'].'" alt="" /></a></td>
                    <td class="name"><a href="'.$profile['profile_url'].'">'.$profile['name'].'</a></td>
                    <td class="friends">'.$profile['mutual_friend_count'].' / '.((intval($profile['friend_count']) != 0) ? $profile['friend_count'].'<br />('.$percentMutual.'%)' : '—').'</td>
                    <td class="wall">'.((intval($profile['wall_count']) != 0) ? $profile['wall_count'] : '—').'</td>
                </tr>';
                if($profile['sex'] == 'male') ++$sex['male'];
                else if($profile['sex'] == 'female') ++$sex['female'];
                else ++$sex['alien'];
            }

            $sexPercent['male'] = round($sex['male'] * 100 / $i, 2);
            $sexPercent['female'] = round($sex['female'] * 100 / $i, 2);
            $sexPercent['alien'] = round(100 - ($sexPercent['male'] + $sexPercent['female']), 2);
            ?>
            </tbody>
        </table>

        <p>&nbsp;</p>

        <table>
            <thead><tr><th colspan="3">Sex distribution</th></tr></thead>
            <tbody>
                <tr>
                    <?php
                    echo '<td>'.$sex['male'].' ('.$sexPercent['male'].'%) male</td>
                    <td>'.$sex['female'].' ('.$sexPercent['female'].'%) female</td>
                    <td>'.$sex['alien'].' ('.$sexPercent['alien'].'%) not specified</td>';
                    ?>
                </tr>
            </tbody>
        </table>
    </body>
</html>