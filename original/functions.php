<?php

$apikey = "AIzaSyDjpt36QVsNph_rkPLdrUgWria2IuIFaWU";

function shortNumber($number){
    if($number>999999){
        return round($number/1000000, 2)."M";
    }else if($number<1000){
        return $number;
    }else{
        return round($number/1000, 2)."K";
    }
}

function getCountryName($id){
	return "Category Name ".$id;
}

function getCategoryName($id){
	return "Category Name ".$id;
}

function getLanguageName($languageCode){
	return "Language Name ".$languageCode;
}

function getMostWatchedVideoDetails($channel){
    $apikey = $GLOBALS['apikey'];
    $video = array();
    if(!empty($channel)){
        $html = json_decode(gethtml("https://www.googleapis.com/youtube/v3/search?order=viewCount&maxResults=1&channelId=".$channel."&key=".$apikey), true);
        if(isset($html['items'][0]['id']['videoId'])){
            $videoId = $html['items'][0]['id']['videoId'];
            $video['videoId'] = $videoId;
            $html = json_decode(gethtml("https://youtube.googleapis.com/youtube/v3/videos?part=snippet,statistics&id=".$videoId."&key=".$apikey), true);
            //print_r($html);
            if(isset($html['error']['errors'][0]['reason']) && $html['error']['errors'][0]->reason=='quotaExceeded'){
                echo "Daily Limit Consumed";
                exit;
            }else if(isset($html['items'][0])){
                $video['snippet'] = $html['items'][0]['snippet'];
                $video['statistics'] = $html['items'][0]['statistics'];
            }
        }
    }
    return $video;
}

function getVideoDetails($videoId){
    $apikey = $GLOBALS['apikey'];
    $video = array('snippet'=>array(), 'statistics'=>array());
    if(!empty($videoId)){
        $html = json_decode(gethtml("https://youtube.googleapis.com/youtube/v3/videos?part=snippet,statistics&id=".$videoId."&key=".$apikey), true);
        //print_r($html);
        if(isset($html['error']['errors'][0]['reason']) && $html['error']['errors'][0]->reason=='quotaExceeded'){
            echo "Daily Limit Consumed";
            exit;
        }else if(isset($html['items'][0])){
            $video['snippet'] = $html['items'][0]['snippet'];
            $video['statistics'] = $html['items'][0]['statistics'];
        }
    }
    
    return $video;
}

function getVideoStats($videoIds){
	$apikey = $GLOBALS['apikey'];
	$stats=array('language'=>array(), 'avgviews'=>array(), 'avglikes'=>array(), 'avgcomments'=>array(), 'avgfavorites'=>array(), 'category'=>array());
	if(!empty($videoIds)){
		$videoIds = implode(",", $videoIds);
		$html = json_decode(gethtml("https://youtube.googleapis.com/youtube/v3/videos?part=snippet,statistics&id=".$videoIds."&key=".$apikey));
		if(isset($html->error->errors[0]->reason) && $html->error->errors[0]->reason=='quotaExceeded'){
			echo "Daily Limit Consumed";
			exit;
		}else if(isset($html->items[0])){
            $views = 0;
            $avgviews = 0;

            $likes = 0;
            $avglikes = 0;

            $comments = 0;
            $avgcomments = 0;

            $favorites = 0;
            $avgfavorites = 0;

            //$engagement = 0;
            $count = 0;
            foreach($html->items as $item){
              if(isset($item->snippet->liveBroadcastContent) && $item->snippet->liveBroadcastContent=='upcoming'){
                continue;
              }
              // if(isset($item->snippet->tags)){
              //   $channelstats[$item->id]['tags'] = array_values(preg_replace('/[^\00-\255]+/u', '', $item->snippet->tags));
              // }
              $count++;
              if(isset($item->snippet->defaultAudioLanguage)){
                $language[] = $item->snippet->defaultAudioLanguage;
              }else if(isset($item->snippet->defaultLanguage)){
                $language[] = $item->snippet->defaultLanguage;
              }

              if(isset($item->snippet->categoryId)){
                $category[] = $item->snippet->categoryId;
              }

              $stats[$item->id] = $item->statistics;

              //$stats[$item->id]=$item->statistics;
              $views = $views + $item->statistics->viewCount;
              $likes = $likes + $item->statistics->likeCount;
              $comments = $comments + $item->statistics->commentCount;
              $favorites = $favorites + $item->statistics->favoriteCount;
              // if(!isset($item->statistics->dislikeCount)){
              // 	$item->statistics->dislikeCount=0;
              // }
              //$engagement = $engagement + (($item->statistics->likeCount + $item->statistics->dislikeCount + $item->statistics->commentCount)/$item->statistics->viewCount);
            }
            $values = array_count_values($language);
            reset($values);
            $language = key($values);

            $valuesc = array_count_values($category);
            reset($valuesc);
            $category = key($valuesc);

            //$engagementrate = round(($engagement/$count)*100,2);
            $avgviews = ceil($views/$count);
            $avglikes = ceil($likes/$count);
            $avgcomments = ceil($comments/$count);
            $avgfavorites = ceil($favorites/$count);
            $stats['category']=$category;
            $stats['language']=$language;
            $stats['avgviews']=$avgviews;
            $stats['avglikes']=$avglikes;
            $stats['avgcomments']=$avgcomments;
            $stats['avgfavorites']=$avgfavorites;
            return $stats;
            // foreach ($html->items as $item){
            //   if($item->statistics->viewCount > $avgviews){
            //     $onehit++;
            //   }
            //   if($item->statistics->viewCount < ($avgviews/2)){
            //     $onehit2++;
            //   }
            // }
            // if($onehit=1 && $onehit2==4){
            //   $onehit=1;
            // }else{
            //   $onehit=0;
            // }
        }
    }
}

function gethtml($url){
  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36");
  curl_setopt($curl, CURLOPT_CONNECTTIMEOUT ,10);
  curl_setopt($curl, CURLOPT_TIMEOUT, 30);
  return $html = curl_exec($curl);
  curl_close($curl);
}

function timeAgo($time_ago){
    date_default_timezone_set("Asia/kolkata");
    $time_ago = strtotime($time_ago);
    $cur_time   = time();
    $time_elapsed   = $cur_time - $time_ago;
    $seconds    = $time_elapsed ;
    $minutes    = round($time_elapsed / 60 );
    $hours      = round($time_elapsed / 3600);
    $days       = round($time_elapsed / 86400 );
    $weeks      = round($time_elapsed / 604800);
    $months     = round($time_elapsed / 2600640 );
    $years      = round($time_elapsed / 31207680 );
    // Seconds
    if($seconds <= 60){
        return "just now";
    }
    //Minutes
    else if($minutes <=60){
        if($minutes==1){
            return "one minute ago";
        }
        else{
            return "$minutes minutes ago";
        }
    }
    //Hours
    else if($hours <=24){
        if($hours==1){
            return "an hour ago";
        }else{
            return "$hours hrs ago";
        }
    }
    //Days
    else if($days <= 7){
        if($days==1){
            return "yesterday";
        }else{
            return "$days days ago";
        }
    }
    //Weeks
    else if($weeks <= 4.3){
        if($weeks==1){
            return "a week ago";
        }else{
            return "$weeks weeks ago";
        }
    }
    //Months
    else if($months <=12){
        if($months==1){
            return "a month ago";
        }else{
            return "$months months ago";
        }
    }
    //Years
    else{
        if($years==1){
            return "one year ago";
        }else{
            return "";
        }
    }
}

?>