# Gogoprint PHP Developer Test


## Requirements

* [Php](http://php.net/) 7.1.3 or higher
* [Composer](https://getcomposer.org)


## Installation

1. Clone project `git clone https://github.com/Seb33300/Gogoprint-PHP-Developer-Test.git`
2. Install PHP dependencies `composer install`
3. Launch web server `php bin/console server:start`

_A ready-to-use SQLite database is included in the project._
_(only the first product configuration options have been set => with id `1`)_


## How to use

Use the REST client of your choice to make requests.
_Using a web browser may not works!_

**Get Form Options**
```
GET http://127.0.0.1:8000/api/product/options
```

**Get Price Table**
```
GET http://127.0.0.1:8000/api/product/prices?paper_format_id=1&pages_id=1&paper_type_id=1
```

**Add To Cart**
```
POST http://127.0.0.1:8000/api/product/cart
```
``` json
{
    "paper_format_id": "1",
    "pages_id": "1",
    "paper_type_id": "1",
    "quantity": "100",
    "date": "2019-02-26"
}
```
