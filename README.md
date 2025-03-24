# Журнал аутентификации Laravel


## Установка

> Для ведения журнала аутентификации Laravel требуется Laravel 5.5 или выше и PHP 7.0+.

Вы можете использовать Composer для установки Laravel Authentication Log в свой проект Laravel:

    composer require gsmanager/laravel-authentication-log

### Конфигурация

После установки журнала проверки подлинности Laravel опубликуйте его конфигурацию, выполните перенос и просмотр, используя `vendor:publish` Artisan команду:

    php artisan vendor:publish --provider="GSManager\AuthenticationLog\AuthenticationLogServiceProvider"

Затем вам нужно перенести вашу базу данных. При переносе журнала проверки подлинности Laravel будет создана таблица, необходимая вашему приложению для хранения журналов проверки подлинности:

    php artisan migrate

Наконец, добавьте `AuthenticationLogable` и `Notifiable` характеристики вашей аутентифицируемой модели (по умолчанию, `App\User` модель). Эти функции предоставляют различные методы, позволяющие вам получать общие данные журнала аутентификации, такие как время последнего входа в систему, IP-адрес последнего входа в систему, а также настраивать каналы для уведомления пользователя при входе с нового устройства:

```php
use Illuminate\Notifications\Notifiable;
use GSManager\AuthenticationLog\AuthenticationLogable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, AuthenticationLogable;
}
```

### Basic Usage

Получить все журналы аутентификации пользователя:

```php
User::find(1)->authentications;
```

Получите последнюю регистрационную информацию пользователя:

```php
User::find(1)->lastLoginAt();

User::find(1)->lastLoginIp();
```

Получить предыдущее время входа пользователя в систему и ip-адрес (игнорируя текущий логин):

```php
auth()->user()->previousLoginAt();

auth()->user()->previousLoginIp();
```

### Уведомлять о входе в систему с нового устройства

Уведомления могут быть отправлены на `mail`, `nexmo`, и `slack` каналы. По умолчанию вы отправляете уведомление по электронной почте.

Вы можете определить `notifyAuthenticationLogVia` метод определения того, по каким каналам должно быть доставлено уведомление:

```php
/**
 * The Authentication Log notifications delivery channels.
 *
 * @return array
 */
public function notifyAuthenticationLogVia()
{
    return ['nexmo', 'mail', 'slack'];
}
```

Конечно, вы можете отключить уведомление, установив `notify` вариант в вашем `config/authentication-log.php` конфигурационный файл для `false`:

```php
'notify' => env('AUTHENTICATION_LOG_NOTIFY', false),
```

### Очистите старые журналы

Вы можете очистить старые записи журнала проверки подлинности, используя `authentication-log:clear` Artisan команда:

    php artisan authentication-log:clear

Записи, которые старше количества дней, указанного в `older` вариант в вашем `config/authentication-log.php` будут удалены:

```php
'older' => 365,
```

## Способствующий

Благодарим вас за то, что вы решили внести свой вклад в журнал аутентификации Laravel.

## Лицензия

Журнал аутентификации Laravel - это программное обеспечение с открытым исходным кодом, лицензируемое в соответствии с [MIT license](http://opensource.org/licenses/MIT).
