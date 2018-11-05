<?php
namespace App\Settings;

use Cake\Core\Configure\ConfigEngineInterface;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;

class DbConfig implements ConfigEngineInterface
{

    private $scope;
    private $context;

    /**
     * Set DbConfig to return user settings as default
     * @param string $scope   User, App, (Os, Env ...)
     * @param string $context depent on the scope, the context can be uuid, string, integer, etc.
     */
    public function __construct($scope = 'user', $context = '')
    {
        $this->scope = $scope;
        $this->context = $context;
    }

    /**
     * @param string $key Table name with the settings
     * @return array
     * @throws \Exception
     */
    public function read($key)
    {
        $query = TableRegistry::get($key);
        // App level costum settings
        $data = $query->find('list', ['keyField' => 'key', 'valueField' => 'value'])
                      ->where(['scope' => $this->scope, 'context' => $this->context])
                      ->toArray();

        $config = Hash::expand($data);

        return $config;
    }

    /**
     * @param string $key Table name
     * @param array $data Data to dump.
     * @return void
     * @throws \Exception
     */
    public function dump($key, array $data)
    {
        throw new Exception('Not implemented');
    }
}
