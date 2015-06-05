PDO Database
------------

This is a singleton class for connecting to a Mysql Database using PHP's PDO library.  Since it is a singleton class,  you need to call the __getInstance()__ class.  Here is how you can call the class:

* Get an instance of the class

`$db = PDODatabaseConnect::getInstance();`

* You will need a class for your database settings that looks like this:

`
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
`
* You can pass this class object to the __setDatabaseSettings()__ method like this.

`
$db->setDatabaseSettings($this->databaseSettings);
`

*  Now you can request the database instance to make your queries:

`
$connection = $db->getDatabaseInstance();
`

Testing
-------

All the code has been tested using [PHPUnit](www.phpunit.de).  You can run the tests by calling:

`phpunit tests/`

Usage
-----

The code here adheres to the [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md) coding style.  You should use a PHP autoloader like [Aura AutoLoader](https://github.com/auraphp/Aura.Autoload) to load these classes.

Development
-----------

Questions or problems? Please post them on the [issue tracker](https://github.com/codemis/php_toolbox/issues). You can contribute changes by forking the project and submitting a pull request.

This script is created by Johnathan Pulos and is under the [GNU General Public License v3](http://www.gnu.org/licenses/gpl-3.0-standalone.html).