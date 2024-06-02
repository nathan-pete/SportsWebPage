<?php
	define("ROOT_DOC", preg_replace("@\/NHL-Sports\/Code\/.*@", "", $_SERVER['REQUEST_URI']));
	
	// Because header() can not be used on a mac, JavaScript is used instead
	function redirectScript($location, $timer = 0)
	{
		echo "<script> setTimeout(function(){
                                    window.location.href = '" . $location . "';
                                  }, $timer);
              </script>";
	}
	
	function redirectError($location = ROOT_DOC . "/NHL-Sports/Code/Utils/404.php", $timer = 0)
	{
		echo "<script> setTimeout(function(){
                                    window.location.href = '" . $location . "';
                                  }, $timer);
              </script>";
		
	}

?>
