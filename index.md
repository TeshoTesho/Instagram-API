# Instagram API

> English

API Developed By: [Nicolas L. Araujo](http://nicolasleitearaujo.online)

## Installation

Just add the api inside the file and declare the class

```php
require "instagram_api.php";
$insta = new InstagramApi;
```
## How to use

You need to define an instagram user

> As an example, using the @neymarjr account

```php
$user = $insta->instagram("neymarjr"); 
```

Then you can abuse the api while it works.

```php
$post = $insta->get_single_post_profile($user,2); // Second Post
$image_url = $post["image"][0]["url"]; // Collect image in var
echo "<img src='$image_url'>"; // Publish in html img
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)
