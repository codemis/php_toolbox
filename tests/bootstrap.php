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
/**
 * preload source files
 *
 * @author Johnathan Pulos
 */
require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'src.php';
$databaseSettings = 
    dirname(__DIR__) .
    DIRECTORY_SEPARATOR .
    'tests' .
    DIRECTORY_SEPARATOR .
    'support' .
    DIRECTORY_SEPARATOR .
    'DatabaseSettings.php';
if (file_exists($databaseSettings)) {
    require_once $databaseSettings;
}
/**
 * autoload test files
 *
 * @package default
 * @author Johnathan Pulos
 */
spl_autoload_register(
    function ($class) {
        $file = dirname(__DIR__). DIRECTORY_SEPARATOR
              . 'tests' . DIRECTORY_SEPARATOR
              . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
        if (file_exists($file)) {
            require $file;
        }
    }
);
