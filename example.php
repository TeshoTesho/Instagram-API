
<?php

require "api.php";
$insta = new InstagramApi;
$user = $insta->instagram("neymarjr"); //Example @User
$photo_profile = $insta->user_image_profile($user);
echo "<img src='$photo_profile'>" ;

//
echo "<h1>Single Post</h1><hr>";


//Example Single Post
$post = $insta->get_single_post_profile($user,2); // Second Post
$image_url = $post["image"][0]["url"]; // Collect image in var
echo "<img src='$image_url'>"; // Publish in html img


echo "<h1>All Posts</h1><hr>";

//Example All Posts
$post = $insta->get_all_post_profile($user);
echo "<pre>";
print_r($post); // Pegando a primeira imagem
echo "</pre>";


?>