<?php
/**
 * This file is part of Curl Utility.
 * 
 * Curl Utility is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * Curl Utility is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see 
 * <http://www.gnu.org/licenses/>.
 *
 * @author Johnathan Pulos <johnathan@missionaldigerati.org>
 * @copyright Copyright 2012 Missional Digerati
 * 
 */
namespace tests\support;

/**
 * A class that holds the database settings, please rename to database_settings.php
 *
 * @package default
 * @author Johnathan Pulos
 */
class DatabaseSettings
{
    /**
     * The default database to use
     *
     * @var array
     * @access public
     */
    public $default = array(
        'host'      =>  'localhost',
        'name'      =>  'jp',
        'username'  =>  'jp',
        'password'  =>  'jp'
    );
}