<?

$endPoint="https://api.flickr.com/services/feeds/photos_public.gne";
$_RAW_REQUEST=file_get_contents("php://input");
// echo $_RAW_REQUEST;

$request=json_decode($_RAW_REQUEST,false);

$requestString="$endPoint?format={$request->format}&lang={$request->lang}".($request->tagMode==1?"&tagmode=ANY":"&tagmode=ALL");
if(isset($request->tags) && !empty($request->tags)){
  $requestString.="&tags={$request->tags}";
}
if(isset($request->id) && !empty($request->id)){
  $idArr=explode(",",$request->id);
  if(count($idArr)>1){
    $requestString.="&ids={$request->id}";

  }else{

    $requestString.="&id={$request->id}";
  }
}

$cReq=curl_init($requestString);
curl_setopt($cReq,CURLOPT_RETURNTRANSFER,true);
$cResult=curl_exec($cReq);
curl_close($cReq);
if(stripos($cResult,"Flickr API: Page not found")!==false){
  die(json_encode(["r"=>400,"payload"=>null]));

}

$xml = new SimpleXMLElement($cResult);//($cResutl, "SimpleXMLElement", LIBXML_NOCDATA);

exit(json_encode(["r"=>200,"payload"=>$xml]));

?>
