# Load and Use Configuration Files With Ease

Basic Usage

database.php

```php
return [
  'user' => 'hsntngr',
  'password' => 'secret'
  ...
];
```

```php
echo config("database.user");
// hsntngr
```

**Insallation**

`composer require hsntngr/config-loader`

**Create a Config File**

yaml example
```yaml
driver: mysql
host: 127.0.0.1
dbname: example
port: 3306
user:
  name: hsntngr
  password: secret
```
php example
```php
return [
    "driver" => "mysql",
    "host" => "127.0.0.1",
    "dbname" => "example",
    "port" => "3306",
    "user" => [
        "name" => "example",
        "password" => "secret",
    ]
];
```

**Register Config Loader**

```php
use Hsntngr\Config\Config;
use Hsntngr\Config\ArrayLoader;

$path = "/path/to/config/directory/";
$config = Config::create(new ArrayLoader($path));
// use YamlLoader for yaml files
$config->load();

// loading single file
$path = "/path/to/config.php";
$config->loadFromFile($path);
```

**Basic Usage**

get a config value with helper method

```php
config('auth.session.provider');
// database
```

get a config value with Config class
```php

$config = Config::getInstance();
$config->get('auth.session.provider');

```

store a config value at runtime
```php
config("auth.api.token", "sample-token")

print_r(config("auth.api"))

// [
//  "driver"  => "driver",
//  "endpoint" => "v1/users",
//  "token" => "sample-token" 
// ]
```
