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

if(!defined('SAFE')) exit('Nothing to do here');

### Config
# XML file
define('FILE', 'fql.xml');

# Time (in hours) before prompting for a refresh in data
define('CACHE', 48);

### Dates helper
define('ONE_MINUTE', 60);
define('ONE_HOUR', 60 * ONE_MINUTE);
define('NOW', time());
/** EOF /**/