<?php 
	
	//figure out how many pages to make links for
	$json = json_decode(file_get_contents('pages.json'));
	$numberOfPages = count((array)$json);

	if(isset($_GET)) {
		$currentPage = explode(".",$_GET['page']);
		$currentPage = $currentPage[0];
		echo $currentPage;
		
		$currentPageData = $json->$currentPage;
		
		$title = $currentPageData->title;
		$content = $currentPageData->content;
	}


?>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script>
	$(document).ready(function(){


		$("#pages>li").each(function(index, item){
			$item = $(item);
			var id = $item.attr("id");
			
			$item.click(function(item){
			history.pushState("", "id", id + ".html");
				$.ajax({
				  url: "pages.json",
				  dataType: 'json',
				  success: function(data){
					$("#title").html(data[id].title);
					$("#content").html(data[id].content);
				  }
				});	
			});
		});
		
	});
</script>
<ul id="pages">
	<?php foreach($json as $pageID => $page) { ?>
	<li id="<?php echo $pageID;?>"><?php echo $page->title;?></li>
	<?php } ?>
</ul>
<?php if($title); {?>
<h1 id="title"><?php echo $title;?></h1>
<p id="content"><?php echo $content;?></p>
<?php } ?>