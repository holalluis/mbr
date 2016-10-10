<?php
	function timeAgo($time_ago)
	/* Returns a string indicating how much time passed from now*/
	{
		$time_ago 		= strtotime($time_ago);
		$cur_time 		= time();
		$time_elapsed 	= $cur_time - $time_ago;
		$seconds    	= $time_elapsed ;
		$minutes    	= round($time_elapsed/60 );
		$hours      	= round($time_elapsed/3600);
		$days       	= round($time_elapsed/86400 );
		$weeks      	= round($time_elapsed/604800);
		$months     	= round($time_elapsed/2600640 );
		$years      	= round($time_elapsed/31207680 );
		if($seconds<0)return "In the future? Check it!";
		else if($seconds<=60)return "Just now";
		else if($minutes<=60)
		{
			if($minutes==1)return "Last minute";
			else return "$minutes minutes ago";
		}
		else if($hours<=24)
		{
			if($hours==1)return "Last hour";
			else return "$hours hours ago";
		}
		else if($days<=7)
		{
			if($days==1)return "Yesterday";
			else return "$days days ago";
		}
		else if($weeks<=4)
		{
			if($weeks==1)return "Last week";
			else return "$weeks weeks ago";
		}
		else if($months<=12)
		{
			if($months==1)return "Last month";
			else return "$months months ago";
		}
		else
		{
			if($years==1)return "Last year";
			else return "$years years ago";
		}
	}
?>
