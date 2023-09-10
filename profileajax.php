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
    foreach($script as $data){
      	if(strpos($data->nodeValue, 'var ytInitialData =')!==false){
	      	$array = explode("};", $data->nodeValue);
	        $required = json_decode(str_replace('var ytInitialData =', "", $array[0]."}"), true);
	        if(isset($required['contents']['twoColumnBrowseResultsRenderer']['tabs'][7]['tabRenderer']['content']['sectionListRenderer']['contents'][0]['itemSectionRenderer']['contents'][0]['channelAboutFullMetadataRenderer']['links'])){
          		$primary = $required['contents']['twoColumnBrowseResultsRenderer']['tabs'][7]['tabRenderer']['content']['sectionListRenderer']['contents'][0]['itemSectionRenderer']['contents'][0]['channelAboutFullMetadataRenderer']['links'];
          		foreach ($primary as $prim){
		            $link = $prim['channelExternalLinkViewModel']['link']['content'];
		            $name = $prim['channelExternalLinkViewModel']['title']['content'];
		            $htmldata .= '<li class="d-flex mb-4 pb-1">
                          <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-primary"
                              ><i class="bx bx-right-top-arrow-circle"></i
                            ></span>
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                          <a target="_blank" href="'.$link.'">
                            <div class="me-2">
                              <h6 class="mb-0">'.$name.'</h6>
                              <small class="text-muted">'.$link.'</small>
                            </div>
                            <div class="user-progress">
                              <small class="fw-semibold">Here</small>
                            </div>
                            </a>
                          </div>
                        </li>';
          		}
        	}
        }
    }
    echo $htmldata;
}

?>