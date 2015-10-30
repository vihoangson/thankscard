<?php
/**
* 
*/
class Emotion
{

		public static $array_emotion = array(
			":)"          =>"https://www.chatwork.com/image/emoticon/emo_smile.gif",
			// ":("          =>"https://www.chatwork.com/image/emoticon/emo_sad.gif",
			// ":D"          =>"https://www.chatwork.com/image/emoticon/emo_more_smile.gif",
			// "8-)"         =>"https://www.chatwork.com/image/emoticon/emo_lucky.gif",
			// ":o"          =>"https://www.chatwork.com/image/emoticon/emo_surprise.gif",
			// ";)"          =>"https://www.chatwork.com/image/emoticon/emo_wink.gif",
			// ";("          =>"https://www.chatwork.com/image/emoticon/emo_tears.gif",
			// "(sweat)"     =>"https://www.chatwork.com/image/emoticon/emo_sweat.gif",
			// ":|"          =>"https://www.chatwork.com/image/emoticon/emo_mumu.gif",
			// ":*"          =>"https://www.chatwork.com/image/emoticon/emo_kiss.gif",
			// ":p"          =>"https://www.chatwork.com/image/emoticon/emo_tongueout.gif",
			// "(blush)"     =>"https://www.chatwork.com/image/emoticon/emo_blush.gif",
			// ":^)"         =>"https://www.chatwork.com/image/emoticon/emo_wonder.gif",
			// "|-)"         =>"https://www.chatwork.com/image/emoticon/emo_snooze.gif",
			// "(inlove)"    =>"https://www.chatwork.com/image/emoticon/emo_love.gif",
			// "]:)"         =>"https://www.chatwork.com/image/emoticon/emo_grin.gif",
			// "(talk)"      =>"https://www.chatwork.com/image/emoticon/emo_talk.gif",
			// "(yawn)"      =>"https://www.chatwork.com/image/emoticon/emo_yawn.gif",
			// "(puke)"      =>"https://www.chatwork.com/image/emoticon/emo_puke.gif",
			// "(emo)"       =>"https://www.chatwork.com/image/emoticon/emo_ikemen.gif",
			// "8-|"         =>"https://www.chatwork.com/image/emoticon/emo_otaku.gif",
			// ":#)"         =>"https://www.chatwork.com/image/emoticon/emo_ninmari.gif",
			"(nod)"       =>"https://www.chatwork.com/image/emoticon/emo_nod.gif",
			// "(shake)"     =>"https://www.chatwork.com/image/emoticon/emo_shake.gif",
			// "(^^)"       =>"https://www.chatwork.com/image/emoticon/emo_wry_smile.gif",
			// "(whew)"      =>"https://www.chatwork.com/image/emoticon/emo_whew.gif",
			// "(clap)"      =>"https://www.chatwork.com/image/emoticon/emo_clap.gif",
			"(bow)"       =>"https://www.chatwork.com/image/emoticon/emo_bow.gif",
			// "(roger)"     =>"https://www.chatwork.com/image/emoticon/emo_roger.gif",
			// "(flex)"      =>"https://www.chatwork.com/image/emoticon/emo_muscle.gif",
			// "(dance)"     =>"https://www.chatwork.com/image/emoticon/emo_dance.gif",
			// "(:/)"        =>"https://www.chatwork.com/image/emoticon/emo_komanechi.gif",
			// "(devil)"     =>"https://www.chatwork.com/image/emoticon/emo_devil.gif",
			// "(*)"         =>"https://www.chatwork.com/image/emoticon/emo_star.gif",
			// "(h)"         =>"https://www.chatwork.com/image/emoticon/emo_heart.gif",
			// "(F)"         =>"https://www.chatwork.com/image/emoticon/emo_flower.gif",
			// "(cracker)"   =>"https://www.chatwork.com/image/emoticon/emo_cracker.gif",
			// "(^)"         =>"https://www.chatwork.com/image/emoticon/emo_cake.gif",
			// "(coffee)"    =>"https://www.chatwork.com/image/emoticon/emo_coffee.gif",
			// "(beer)"      =>"https://www.chatwork.com/image/emoticon/emo_beer.gif",
			"(handshake)" =>"https://www.chatwork.com/image/emoticon/emo_handshake.gif",
			"(y)"         =>"https://www.chatwork.com/image/emoticon/emo_yes.gif",
		);

	public static function add_emotion(&$string){
		if(true)
		foreach (self::$array_emotion as $sign => $file) {
			$string=str_replace($sign, " <img src='$file'> ",$string);
		}
	}
}

 ?>