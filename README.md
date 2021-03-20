# Freshchat Web Widget for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/tealorca/laravel-freshchat.svg?style=flat-square)](https://packagist.org/packages/tealorca/laravel-freshchat)
[![Total Downloads](https://img.shields.io/packagist/dt/tealorca/laravel-freshchat.svg?style=flat-square)](https://packagist.org/packages/tealorca/laravel-freshchat)



## Installation

You can install the package via composer:

```bash
composer require tealorca/laravel-freshchat
```

The package will automatically register a service provider.



Next, Include the chat widget into blade layout code by adding Blade directive ` @laravelFreshchat ` before the end of the body tag.

```html
<body>
    ...
    ...
    @laravelFreshchat
</body>
</html>
```

Next, you need to publish the freshchat configuration file:

```bash
php artisan vendor:publish --provider="TealOrca\LaravelFreshchat\LaravelFreshchatServiceProvider" --tag="config"

```

This is the default content of the config file that will be published as `config/laravel-freshchat.php`:


```php
/*
 * Freshchat Configurations
 */
return [

    /*
     * Freshchat's Web Messenger Token.
     *
     * You can see that on Web Messenger Settings page of Freshchat Portal.
     */
    'token'      => env('FRESHCHAT_TOKEN', null),

    /*
     * Freshchat's Web Messenger Host Value. ( it would be different based on your data region)
     *
     * Few examples:
     *
     *	https://wchat.freshchat.com
     *	https://wchat.in.freshchat.com
     *
     * You can see that on Web Messenger Settings page of Freshchat Portal.
     */
    'host'       => env('FRESHCHAT_HOST', 'https://wchat.freshchat.com'),
];

```



Once you added `FRESHCHAT_TOKEN` and `FRESHCHAT_HOST` values to your `.env` file you can see the widget on your webpage.



The displayed widget will be treated as a [Anonymous User](https://developers.freshchat.com/web-sdk/#anonymous-user) window.

You can see the [Freshchat's Web SDK Docs](https://developers.freshchat.com/web-sdk/) for more details.



## Configure Logged in User



#### Add the `ChatUser` Trait to your User Model

To treat the current authenticated user as a Freshchat user, simply add the `TealOrca\LaravelFreshchat\Traits\ChatUser` trait to the user authentication model.

``` php
use TealOrca\LaravelFreshchat\Traits\ChatUser;

class User extends Model {

    use ChatUser;

	/**
     * Specify the column name for Freshchat Restore Id
     */
    protected $freshchatRestoreId = '<<the column name you created for storing the Freshchat restoreId>>';

    /**
     * Specify the value for Freshchat External Id
     *
     * @return string
     */
    public function chatUserExternalId()
    {
        return $this->email; // using the user's email as the external id
    }

    /**
     * Specify the properties
     *
     * @return array
     */
    public function chatUserProperties() {

        return [
            'firstName' => 'first_name', ////// '<< Property Name for Freshchat >>' => '<< column name on the users table >>',
            'lastName' => 'last_name',
            'email' => 'email',
            'phone' => 'phone_no',
            'phoneCountryCode' => 'phone_country_code',
        ];
    }
}
```



#### Add the Restore Id column to your user table

```bash
php artisan make:migration add_freshchat_restore_id_to_users_table --table=users
```


``` php

class AddFreshchatRestoreIdToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {

            if (!Schema::hasColumn('users', 'freshchat_restore_id')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->string('freshchat_restore_id')->nullable();
                });
            }

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {

            if (Schema::hasColumn('users', 'freshchat_restore_id')) {
                $table->dropColumn('freshchat_restore_id');
            }
        });
    }
}
```



### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email danielfelix1995@gmail.com instead of using the issue tracker.

## Credits

- [Daniel Felix](https://github.com/itsdanielfelix)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.