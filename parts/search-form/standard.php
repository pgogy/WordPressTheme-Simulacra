<?PHP

	if(get_theme_mod("search")=="on"){

	?><form action="<?PHP echo home_url(); ?>" method="GET">
		<input type="text" class='simulacra_search_box' name="s" value="Search...." />
		<input type="submit" />
	</form><?PHP
	
	}
	
?>