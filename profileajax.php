<?php
include('config.php');
include('functions.php');

if(isset($_POST['action']) && $_POST['action']=='getsocial'){
	$channel = $_POST['channel'];
	$html = '';
	$html = gethtml("https://www.youtube.com/channel/".$channel."/about");
    $tdk_doc = new DOMDocument;
    @$tdk_doc->loadHTML($html);
    $tdk_xpath = new DOMXPath($tdk_doc);
    $script = $tdk_xpath->query('//script');
    $socialdata = '';
    $htmldata = '';
    $primary = array();
    foreach($script as $data){
      	if(strpos($data->nodeValue, 'var ytInitialData =')!==false){
	      	$array = explode("};", $data->nodeValue);
	        $required = json_decode(str_replace('var ytInitialData =', "", $array[0]."}"), true);
	        if(isset($required['contents']['twoColumnBrowseResultsRenderer']['tabs'][7]['tabRenderer']['content']['sectionListRenderer']['contents'][0]['itemSectionRenderer']['contents'][0]['channelAboutFullMetadataRenderer']['links'])){
            $primary = $required['contents']['twoColumnBrowseResultsRenderer']['tabs'][7]['tabRenderer']['content']['sectionListRenderer']['contents'][0]['itemSectionRenderer']['contents'][0]['channelAboutFullMetadataRenderer']['links'];
          }else if(isset($required['contents']['twoColumnBrowseResultsRenderer']['tabs'][8]['tabRenderer']['content']['sectionListRenderer']['contents'][0]['itemSectionRenderer']['contents'][0]['channelAboutFullMetadataRenderer']['links'])){
            $primary = $required['contents']['twoColumnBrowseResultsRenderer']['tabs'][8]['tabRenderer']['content']['sectionListRenderer']['contents'][0]['itemSectionRenderer']['contents'][0]['channelAboutFullMetadataRenderer']['links'];
          }
          if(!empty($primary)){
            $count = 0;
            foreach ($primary as $prim){
              $count++;
              $link = $prim['channelExternalLinkViewModel']['link']['content'];
              $name = $prim['channelExternalLinkViewModel']['title']['content'];
              $htmldata .= '<li class="d-flex mb-4 pb-1">
                        <div class="avatar flex-shrink-0 me-3">

                        <div class="flex-shrink-0">';
              if(stripos($link, 'facebook')!==false){
                $htmldata .= '<img
                                src="assets/img/icons/brands/facebook.png"
                                alt="facebook"
                                class="me-3"
                                height="30"
                              />'; 
              }else if(stripos($link, 'instagram')!==false){
                $htmldata .= '<img
                                  src="assets/img/icons/brands/instagram.png"
                                  alt="instagram"
                                  class="me-3"
                                  height="30"
                                />';
              }else if(stripos($link, 'twitter')!==false){
                $htmldata .= '<img
                                  src="assets/img/icons/brands/twitter.png"
                                  alt="twitter"
                                  class="me-3"
                                  height="30"
                                />';
              }else{
                $htmldata .= '<img
                                  src="assets/img/icons/brands/dribbble.png"
                                  alt="web"
                                  class="me-3"
                                  height="30"
                                />';
              }
                                
              $htmldata .= '</div>
                          <!--<span class="avatar-initial rounded bg-label-primary"
                            ><i class="bx bx-right-top-arrow-circle"></i
                          ></span>-->

                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                        <a target="_blank" href="https://'.$link.'" title='.strip_tags($name).'>
                          <div class="me-2">
                            <h6 class="mb-0">'.strip_tags(strlen($name)>16? substr($name,0,14)."..":$name).'</h6>
                            <!--<small class="text-muted">'.$link.'</small>-->
                          </div>
                          <div class="user-progress">
                            <small class="fw-semibold">Link</small>
                          </div>
                          </a>
                        </div>
                      </li>';
              if($count>=5){
                break;
              }        
            }
          }
          echo $htmldata;
        }
    }
}

?>