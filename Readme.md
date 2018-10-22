[![License](https://poser.pugx.org/alshf/Instasave/license)](https://packagist.org/packages/alshf/Instasave)
[![Total Downloads](https://poser.pugx.org/alshf/Instasave/downloads)](https://packagist.org/packages/alshf/Instasave)
[![Build Status](https://travis-ci.org/alshf89/InstaSave.svg?branch=master)](https://travis-ci.org/alshf89/Instasave)
[![Latest Stable Version](https://poser.pugx.org/alshf/Instasave/version)](https://packagist.org/packages/alshf/Instasave)

# InstaSave :metal: :sparkles: :camera: :computer:

You can fetch all resources from instagram and download them with your program. At least PHP 7.0 is required.

InstaSave support public **feeds**, it also support **playlist**, **IGTV** and **HQ** users profile pictures as well.

## #Documentation

 - [Installation](#installation)
    - [Basic Setup](#basic-setup)
 - [How to use](#how-to-use)
    - [Example](#example)
 	- [Response](#response)
 	- [Exceptions](#exceptions)
 - [Contributing](#contributing)
 - [Credits](#credits)
 - [License](#license)

### #Installation

InstaSave uses [Composer](http://getcomposer.org/doc/00-intro.md#installation-nix) to make things easy.
Composer is a dependency management tool for PHP that allows you to declare the dependencies your project needs and installs them into your project.

#### #Basic Setup

Learn to use composer and run this command line:

    composer require alshf/instasave

### #How to use

Make sure you have composer's autoload file included

```PHP
require 'vendor/autoload.php';
```

#### #Example

```PHP
use InstaSave\URL\URL;
use Instasave\InstaSave;

try {
    // First we create URL object, This object do Validation check on URL.
    // You can also access URL with $absoluteUrl property.
    $url = new URL('https://www.instagram.com/p/BoaOrTsBIvm/');

    // Create an InstaSave object, InstaSave use injected URL and pass it to the Client and send GET request
    // to the instagram website and fetch a JSON as a response, then it will pass it to the EntityCollector to 
    // detect instagram feed type and suitable response to parse.
    $instaSave = new InstaSave($url);

    // Parse response to the suitable Entity in InstaSave\Response\Entity.
    $response = $instaSave->fetch();
} catch (Exception $e) {
    echo $e->getMessage();
}
```
___

#### #Response

After you get the Response by calling _fetch()_ method on InstaSave object, it will bring you the Response Entity which it is instance of Entity (**Playlist**, **Feed**, **Igtv**, **User**) in _Instasave\\Response\\Entity_ folder.

These response has a _type_ property that you can compare it with _InstaSave\\Enumeration\\Entity_.

```PHP
use InstaSave\Enumeration\Entity;

// Check Response type
$response->type === Entity::Feed;
$response->type === Entity::Playlist;
$response->type === Entity::User;
$response->type === Entity::Igtv;
```

Responses has lots of properties base on their entity for example **feed** entity has these properties:

```PHP
$response->id;
$response->type;
$response->shortcode;
$response->comments;
$response->postedAt;
$response->likes;

// Dimenstion of the Entity which contains with & height
$response->dimensions;

// Owner of the Entity
$response->owner;

// Array of Resources -> Image or Video
$response->resources;
```

You can also check response tree in [InstaSave\Response\Sample\Parsed](https://github.com/alshf89/InstaSave/tree/master/engine/Response/Sample/Parsed) folder.

##### #Owner Property

This node contains information about the owner of entity.

```PHP
$response->owner->id;
$response->owner->username;
$response->owner->fullname;
$response->owner->avator;
```

##### #Dimension Property

Contains entity dimensions, note that **resources** property also has dimensions property.

```PHP
$response->owner->id;
$response->owner->username;
$response->owner->fullname;
$response->owner->avator;
```

##### #Resources Property

Contains array of ressources (**Image**, **Video**) which blongs to the entity.
This property also has a _type_ property that you can compare it with _InstaSave\\Enumeration\\Resource_.

```PHP
use InstaSave\Enumeration\Resource;

// Check Resource type
$response->resources[0]->type === Resource::Video;
$response->resources[1]->type === Resource::Image;
```

Other __resources__ Property:

```PHP
$response->resources[0]->id;
$response->resources[0]->type
$response->resources[0]->shortcode;
$response->resources[0]->dimensions;
$response->resources[0]->thumbnail;

// If resource type is Video then it will have these additional property
$response->resources[0]->video;
$response->resources[0]->duration;
$response->resources[0]->views;
```
**NOTE:** duration Property will be _0_ on Playlist Entity.

___

#### #Exceptions

You can get URL validation Errors with **URLValidationException** but if you want to get request errors like connection error, Server errors like 5xx or 4xx errors you can catch them with **ClientException**, you can also catch Response errors with **ResponseException**.

- **URLValidationException**: When URL string pass into InstaSave\\URL\\URL class if it doesn't validate it will throw exception.
- **ResponseException**: When we dont have any response or error on parsing response this exception will throw.
- **ClientException**: Connection Errors, 4xx, 5xx will handle with this exception this exception has previous exception which it comes from _Alshf\\Exceptions\\FootmanRequestException_.

```PHP
use InstaSave\URL\URL;
use Instasave\InstaSave;
use Instasave\Exceptions\ClientException;

try {
    // Create invalid URL object
    $url = new URL('https://www.instagram.com/some404UrlThatDoesntExist/');

    // Create InstaSave object from URL
    $instaSave = new InstaSave($url);

    // Try to get Response
    $instaSave->fetch();
} catch (ClientException $e) {
    echo $e->getPrevious()->getStatusCode(); // 404
    echo $e->getPrevious()->getReasonPhrase() // Not Found
}
```
For more information check [UnitTest](https://github.com/alshf89/InstaSave/blob/master/tests/InstaSaveTest.php) file.

### #Contributing

Bugs and feature request are tracked on [GitHub](https://github.com/alshf89/Instasave/issues).

### #Credits

The code on which this package is principally developed and maintained by [Ali Shafiee](https://github.com/alshf89).

### #License

InstaSave package is released under [MIT](LICENSE.txt).