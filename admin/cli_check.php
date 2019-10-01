<?php

class cliCheck
{
	function check()
	{
		if (PHP_SAPI == "cli")
		{
			return true;
		}
		return false;
	}
}

?>
