<?php
// PhpDoc Comments for code completion in views */
/* @var $this View */
/* @var $html HtmlHelper */
/* @var $javascript JavascriptHelper */
?>
<?php
    echo $javascript->link('jquery.tinycarousel', false);
?>


<div id="slider">
	<div class="viewport">
		<ul class="overview">
            <?php
                foreach($banners as $slide)
                {
                    if(!empty($slide['Banner']['url']))
                    {
                        print '<li>' . $html->link($image->resizeAndCrop($slide['Banner']['afbeelding'], 746, 246), $slide['Banner']['url'], array('escape' => false)) . '</li>';
                    }
                    else
                    {
                        print '<li>' . $image->resizeAndCrop($slide['Banner']['afbeelding'], 746, 246) . '</li>';
                    }
                }
            ?>
		</ul>
	</div>
</div>


<script type="text/javascript">
    $(document).ready(function(){
        $('#slider').tinycarousel({
            interval: true,
            intervaltime: 5000
        });
    });
</script>
