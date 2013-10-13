<?php
/* Twitter Proxy for updated OAuth */
$config = array(
    //Twitter OAuth config
    'oauth_access_token' => '',
    'oauth_access_token_secret' => '',
    'consumer_key' => '',
    'consumer_secret' => '',
    'base_url' => 'http://api.twitter.com/1.1/',
    //Request specific user
    'screen_name' => '',
    'count' => 3
);

$twitter_request = 'statuses/user_timeline.json?screen_name='.$config['screen_name'].'&count='.$config['count'];

// Parse $twitter_request into URL parameters
$url_part = parse_url($twitter_request);

/* url_arguments=
* Array
* (
*    [screen_name] => lcherone
*    [count] => 3
* )
*/
parse_str($url_part['query'], $url_arguments);

$base_url = $config['base_url'].$url_part['path'];
$full_url = $config['base_url'].$twitter_request;

// Set up the OAuth authorization array
$oauth = array(
'oauth_consumer_key' => $config['consumer_key'],
'oauth_nonce' => time(),
'oauth_signature_method' => 'HMAC-SHA1',
'oauth_token' => $config['oauth_access_token'],
'oauth_timestamp' => time(),
'oauth_version' => '1.0'
);

// Build vectors for request
$composite_request = _BaseString($base_url, 'GET', array_merge($oauth, $url_arguments));
$composite_key     = rawurlencode($config['consumer_secret']).'&'.rawurlencode($config['oauth_access_token_secret']);
$oauth_signature   = base64_encode(hash_hmac('sha1', $composite_request, $composite_key, true));
$oauth['oauth_signature'] = $oauth_signature;

// Make cURL Request
$options = array(
CURLOPT_HTTPHEADER => array(_AuthorizationHeader($oauth),'Expect:'),
CURLOPT_HEADER => false,
CURLOPT_URL => $full_url,
CURLOPT_RETURNTRANSFER => true,
CURLOPT_SSL_VERIFYPEER => false
);

$feed = curl_init();
curl_setopt_array($feed, $options);
$result = curl_exec($feed);
$info = curl_getinfo($feed);
curl_close($feed);

// Send suitable headers to the end user.
if(isset($info['content_type']) && isset($info['size_download'])){
    header('Content-Type: '.$info['content_type']);
    header('Content-Length: '.$info['size_download']);
}
exit($result);

function _BaseString($base_url, $method, $values) {
    $ret = array();
    ksort($values);
    foreach($values as $key=>$value)
    $ret[] = $key."=".rawurlencode($value);
    return $method."&".rawurlencode($base_url).'&'.rawurlencode(implode('&', $ret));
}

function _AuthorizationHeader($oauth) {
    $ret = 'Authorization: OAuth ';
    $values = array();
    foreach($oauth as $key=>$value)
    $values[] = $key.'="'.rawurlencode($value).'"';
    $ret .= implode(', ', $values);
    return $ret;
}
?>