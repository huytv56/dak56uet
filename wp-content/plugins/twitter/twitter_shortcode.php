<?php
/**
 * Plugin Name: Twitter shortocde
 * Description: A widget that displays Latest Tweets status via user API.
 * Version: 0.1
 * Author: Ovatheme
 * Author URI: http://ovatheme.com
 */

require_once(dirname(__FILE__) . '/twitteroauth.php');


function getAgoshortcode($timestamp) {
        $difference = time() - $timestamp;

        if ($difference < 60) {
            return $difference." seconds ago";
        } else {
            $difference = round($difference / 60);
        }

        if ($difference < 60) {
            return $difference." minutes ago";
        } else {
            $difference = round($difference / 60);
        }

        if ($difference < 24) {
            return $difference." hours ago";
        }
        else {
            $difference = round($difference / 24);
        }

        if ($difference < 7) {
            return $difference." days ago";
        } else {
            $difference = round($difference / 7);
            return $difference." weeks ago";
        }
}

function getConnectionWithAccessTokenshortcode($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
  $connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
  return $connection;
}


function twitter_shotcode( $atts, $content ) {

        global $theme_option;
        $html ='';

        //Our variables from the widget settings.
        
        $twitteruser = $theme_option['twitteruser'];
        $notweets = $theme_option['twittercount'];
        $consumerkey = $theme_option['consumerkey'];
        $consumersecret = $theme_option['consumersecret'];
        $accesstoken = $theme_option['accesstoken'];
        $accesstokensecret = $theme_option['accesstokensecret'];
          
           $connection = getConnectionWithAccessTokenshortcode($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
           $tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$twitteruser."&count=".$notweets);
           $status = json_encode($tweets);
           $fp = fopen('results.json', 'w');
            fwrite($fp, json_encode($tweets));
            fclose($fp);
            $responseJson = file_get_contents(get_home_url().'/results.json');
            if ($responseJson) {
                $response = json_decode($responseJson);
            }
            $rand = rand();
            
            $html .= '<div class="last-tweet">
                <div class="owl-controls">
                    <a id="prev-tweet" class="prev" href="#">
                        <i class="fa fa-angle-left"></i>
                    </a>
                    <a id="next-tweet" class="next" href="#">
                        <i class="fa fa-angle-right"></i>
                    </a>
                </div>
                <div class="twitter-icon" data-animation="bounceIn" data-animation-delay="100">
                    <i class="fa fa-twitter"></i>
                </div>
                <div id="last-tweets'.$rand.'" data-animation="fadeInUp" data-animation-delay="500">';
                        
                        function processString($s) {
                            return preg_replace('/https?:\/\/[\w\-\.!~?&+\*\'"(),\/]+/','<a href="$0">$0</a>',$s);
                        }

                       foreach ((array)$response as $tweet) {
                        $html .='<div class="media">
                                    <div class="media-body">
                                        <p>'.processString($tweet->text).'</p>
                                        <p>'.getAgoshortcode(strtotime($tweet->created_at)).'<a target="_blank" href="https://twitter.com/twitterapi/status/'.$tweet->id_str.'"> @'.$twitteruser.'</a></p>
                                    </div>
                                </div>';
                        }
                $html .='</div>
            </div>';

         $html .='
         
         <script>
            jQuery(document).ready(function($){
                    $("#last-tweets'.$rand.'").owlCarousel({singleItem: true, autoPlay: '.$theme_option['twitter_autoplay'].', pagination: false });
                    $("#next-tweet").click(function () {
                        $("#last-tweets'.$rand.'").trigger("owl.next");
                        return false;
                    });
                    $("#prev-tweet").click(function () {
                        $("#last-tweets'.$rand.'").trigger("owl.prev");
                        return false;
                    });
            });
         </script>
         ';

        return $html;
    }
add_shortcode('twitter', 'twitter_shotcode');


?>
