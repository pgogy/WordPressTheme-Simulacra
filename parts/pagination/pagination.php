<?PHP

	if(get_theme_mod("pagination")=="on"){

		$links = paginate_links( array( "prev_text" => _x("Previous", "Previous", "simulacra"), "next_text" => _x("Next", "Next", "simulacra") ));
		
		if($links!=""){ ?>
			<footer class="page-footer">
				<h1 class="pagination"><span class='more'><?PHP
					echo _x('More content', "More content", 'simulacra');
				?></span><?PHP
			
				echo $links;
				
				?></h1>
			</footer><?PHP
			
		}
		
	}
