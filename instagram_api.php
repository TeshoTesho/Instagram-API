<?php

  /* ///// PORTUGUES
			Instagram API desenvolvida por Nicolas L. Araujo 
			Data: 06/03/2021
			Email: nicolasleitearaujo@gmail.com
			Site: nicolasleitearaujo.online


	///// ENGLISH
			Instagram API developed by Nicolas L. Araujo
			Date: 3/6/2021
			Email: nicolasleitearaujo@gmail.com
			Website: nicolasleitearaujo.online
*/
			class InstagramApi{

  /**
   * id base do instagram
   * @var string
   */
  private $user;

  /* ///// PORTUGUES
			Conexão, efetua a coleta de dados na pagina do instagram do usuário declarado

	///// ENGLISH
			Connection, performs data collection on the declared user's instagram page
*/
			function instagram($user){
				$arrContextOptions=array(
					"ssl"=>array(
						"verify_peer"=>false,
						"verify_peer_name"=>false,
					),
				);  
  	$url = "https://www.instagram.com/$user/channel/?__a=1&page=3  "; // Default page
  	$cnt = json_decode(file_get_contents($url, false, stream_context_create($arrContextOptions)));
  	return $cnt;
  }

  //Collect image profile
  function user_image_profile($cnt){
  	if($cnt->graphql->user->is_private!=1){}
  		$url_image_profile = $cnt->graphql->user->profile_pic_url_hd;
  	return $url_image_profile;
  }

  // Search for a single post
  function get_single_post_profile($cnt,$post_number){
  	($post_number>0? $post_number--: $post_number=0); //Filtro

    if($post_number<11){
     $url_image_post= $cnt->graphql->user->edge_owner_to_timeline_media->edges[$post_number]->node->display_url;
     $descricao_post= $cnt->graphql->user->edge_owner_to_timeline_media->edges[$post_number]->node->edge_media_to_caption->edges[0]->node->text;
     $likes_count= $cnt->graphql->user->edge_owner_to_timeline_media->edges[$post_number]->node->edge_liked_by->count;
     
     $post = array(
      "id"=>$post_number,
      "description" => $descricao_post,
      "likes" => $likes_count,
      "image" =>  array()

    );
     if (isset($cnt->graphql->user->edge_owner_to_timeline_media->edges[$post_number]->node->edge_sidecar_to_children->edges)){
      $count_post_images =count($cnt->graphql->user->edge_owner_to_timeline_media->edges[$post_number]->node->edge_sidecar_to_children->edges);
      for ($a=0; $a < $count_post_images; $a++) { 
       $url_image_post_more= $cnt->graphql->user->edge_owner_to_timeline_media->edges[$post_number]->node->edge_sidecar_to_children->edges[$a]->node->display_url;
       $number = array(
        'id' => $a,
        'url' => $url_image_post );
       array_push($post["image"],$number);
     }
   }else{
    $first = array(
     'id' => 0,
     'url' => $url_image_post );
    array_push($post["image"],$first);
  }
  return $post;
}else{

}
}


  // LIMIT 12 posts -- Limitation of access to instagram, sorry
function get_all_post_profile($cnt){
  $z = 0;
 $post = array();
 $qtd_images = count($cnt->graphql->user->edge_owner_to_timeline_media->edges);
 for ($i=0; $i < $qtd_images; $i++) { 
  $url_image_post= $cnt->graphql->user->edge_owner_to_timeline_media->edges[$i]->node->display_url;
  //$descricao_post= $cnt->graphql->user->edge_owner_to_timeline_media->edges[$i]->node->edge_media_to_caption->edges[$z]->node->text;
  $likes_post =  $cnt->graphql->user->edge_owner_to_timeline_media->edges[$i]->node->edge_liked_by->count;
  $post_mature = array(
   "id"=>$i,
   //"description" => $descricao_post,
   "image" =>  array(),
   "likes" => $likes_post
 );
  array_push($post, $post_mature);
  if (isset($cnt->graphql->user->edge_owner_to_timeline_media->edges[$i]->node->edge_sidecar_to_children->edges)){

   $count_post_images =count($cnt->graphql->user->edge_owner_to_timeline_media->edges[$i]->node->edge_sidecar_to_children->edges);
   if($count_post_images>1){
    for ($a=0; $a < $count_post_images; $a++) { 
     $url_image_post_more= $cnt->graphql->user->edge_owner_to_timeline_media->edges[$i]->node->edge_sidecar_to_children->edges[$a]->node->display_url;

     $number = array(
      'id' => $a,
      'url' => $url_image_post_more );
     array_push($post[$i]["image"],$number);
   }
 }
}else{
 $first = array(
  'id' => 0,
  'url' => $url_image_post );
 array_push($post[$i]["image"],$first);
}
}
return $post;
}

//Get follows account
function get_follows($cnt){
  if($cnt->graphql->user->is_private!=1){}
    $follows_profile = $cnt->graphql->user->edge_followed_by->count;
  return $follows_profile;
}


  // End Class
}
?>
