<?php
// PhpDoc Comments for code completion in views */
/* @var $this View */
/* @var $html HtmlHelper */
/* @var $javascript JavascriptHelper */
?>

<div id="meganav" class="corner-all">
    <?php
        echo '<ul id="megamenu">';
        foreach($nav_categorien as $categorie)
        {
            echo '<li>';
            echo $html->link($categorie['Categorie']['naam'], '/' . $categorie['Categorie']['slug'] . '/', array('escape' => false));
            if(count($categorie['children']) > 0)
            {
                echo '<div class="sub">';
                
                foreach($categorie['children'] as $subcategorie)
                {
                    echo '<ul><li><h2>' . $html->link($subcategorie['Categorie']['naam'], '/' . $categorie['Categorie']['slug'] . '/' . $subcategorie['Categorie']['slug'] . '/', array('escape' => false)) . '</h2></li>';
                    foreach($subcategorie['children'] as $subsubcategorie)
                    {
                        echo '<li>';
                        echo $html->link($subsubcategorie['Categorie']['naam'], '/' . $categorie['Categorie']['slug'] . '/' . $subcategorie['Categorie']['slug'] . '/' . $subsubcategorie['Categorie']['slug'] . '/', array('escape' => false));
                        echo '</li>';
                    }
                    echo '</ul>';
                }
                echo '</div>';

                // optioneel : div class="row", of meerdere UL's
            }
            echo '</li>';
        }
        echo '</ul>';
    ?>
    <div class="clear"></div>
</div>

<script type="text/javascript">
$(document).ready(function() {


	function megaHoverOver(){
		$(this).find(".sub").stop().fadeTo('fast', 1).show();

		//Calculate width of all ul's
		(function($) {
			jQuery.fn.calcSubWidth = function() {
				rowWidth = 0;
				//Calculate row
				$(this).find("ul").each(function() {
					rowWidth += $(this).width();
				});
			};
		})(jQuery);

		if ( $(this).find(".row").length > 0 ) { //If row exists...
			var biggestRow = 0;
			//Calculate each row
			$(this).find(".row").each(function() {
				$(this).calcSubWidth();
				//Find biggest row
				if(rowWidth > biggestRow) {
					biggestRow = rowWidth;
				}
			});
			//Set width
			$(this).find(".sub").css({'width' :biggestRow});
			$(this).find(".row:last").css({'margin':'0'});

		} else { //If row does not exist...

			$(this).calcSubWidth();
			//Set Width
			$(this).find(".sub").css({'width' : rowWidth});

		}
	}

	function megaHoverOut(){
	  $(this).find(".sub").stop().fadeTo('fast', 0, function() {
		  $(this).hide();
	  });
	}


	var config = {
		 sensitivity: 2, // number = sensitivity threshold (must be 1 or higher)
		 interval: 100, // number = milliseconds for onMouseOver polling interval
		 over: megaHoverOver, // function = onMouseOver callback (REQUIRED)
		 timeout: 500, // number = milliseconds delay before onMouseOut
		 out: megaHoverOut // function = onMouseOut callback (REQUIRED)
	};

	$("ul#megamenu li .sub").css({'opacity':'0'});
	$("ul#megamenu li").hoverIntent(config);



});



</script>