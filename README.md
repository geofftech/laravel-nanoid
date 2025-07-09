# GeoffTech Laravel NanoID

Initial code from https://github.com/yondifon/laravel-nanoid

## Usage

```php
use GeoffTech\LaravelNanoId\HasNanoId;

class MyModel
{
    use HasNanoId;
}
```

## Database definition

```php
$table->char('id', 36)
    ->primary();
```
