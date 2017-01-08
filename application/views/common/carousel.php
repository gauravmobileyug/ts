 <style>
        /* jssor slider arrow navigator skin 05 css */
        /*
        .jssora05l                  (normal)
        .jssora05r                  (normal)
        .jssora05l:hover            (normal mouseover)
        .jssora05r:hover            (normal mouseover)
        .jssora05l.jssora05ldn      (mousedown)
        .jssora05r.jssora05rdn      (mousedown)
        .jssora05l.jssora05lds      (disabled)
        .jssora05r.jssora05rds      (disabled)
        */
		.jssor_1_class {
			display:block;			
		}
        .jssora05l, .jssora05r {
            display: block;
            position: absolute;
            /* size of arrow element */
            width: 40px;
            height: 40px;
            cursor: pointer;
            background: url('<?=base_url('assets/dist/slider/jssor/img/a17.png');?>') no-repeat;
            overflow: hidden;
        }
        .jssora05l { background-position: -10px -40px; }
        .jssora05r { background-position: -70px -40px; }
        .jssora05l:hover { background-position: -130px -40px; }
        .jssora05r:hover { background-position: -190px -40px; }
        .jssora05l.jssora05ldn { background-position: -250px -40px; }
        .jssora05r.jssora05rdn { background-position: -310px -40px; }
        .jssora05l.jssora05lds { background-position: -10px -40px; opacity: .3; pointer-events: none; }
        .jssora05r.jssora05rds { background-position: -70px -40px; opacity: .3; pointer-events: none; }
        /* jssor slider thumbnail navigator skin 01 css *//*.jssort01 .p            (normal).jssort01 .p:hover      (normal mouseover).jssort01 .p.pav        (active).jssort01 .p.pdn        (mousedown)*/.jssort01 .p {    position: absolute;    top: 0;    left: 0;    width: 72px;    height: 72px;}.jssort01 .t {    position: absolute;    top: 0;    left: 0;    width: 100%;    height: 100%;    border: none;}.jssort01 .w {    position: absolute;    top: 0px;    left: 0px;    width: 100%;    height: 100%;}.jssort01 .c {    position: absolute;    top: 0px;    left: 0px;    width: 68px;    height: 68px;    border: #000 2px solid;    box-sizing: content-box;    background: url('<?=base_url('assets/dist/slider/jssor/img/t01.png');?>') -800px -800px no-repeat;    _background: none;}.jssort01 .pav .c {    top: 2px;    _top: 0px;    left: 2px;    _left: 0px;    width: 68px;    height: 68px;    border: #000 0px solid;    _border: #fff 2px solid;    background-position: 50% 50%;}.jssort01 .p:hover .c {    top: 0px;    left: 0px;    width: 70px;    height: 70px;    border: #fff 1px solid;    background-position: 50% 50%;}.jssort01 .p.pdn .c {    background-position: 50% 50%;    width: 68px;    height: 68px;    border: #000 2px solid;}* html .jssort01 .c, * html .jssort01 .pdn .c, * html .jssort01 .pav .c {    /* ie quirks mode adjust */    width /**/: 72px;    height /**/: 72px;}
    </style>
	
	<script src="<?php echo base_url('assets/dist/slider/jssor/js/jssor.slider-21.1.6.mini.js');?>" type="text/javascript"></script>
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
			
			
		

            var jssor_1_SlideshowTransitions = [
              {$Duration:1200,x:0.3,$During:{$Left:[0.3,0.7]},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
              {$Duration:1200,x:-0.3,$SlideOut:true,$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
              {$Duration:1200,x:-0.3,$During:{$Left:[0.3,0.7]},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
              {$Duration:1200,x:0.3,$SlideOut:true,$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
              {$Duration:1200,y:0.3,$During:{$Top:[0.3,0.7]},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
              {$Duration:1200,y:-0.3,$SlideOut:true,$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
              {$Duration:1200,y:-0.3,$During:{$Top:[0.3,0.7]},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
              {$Duration:1200,y:0.3,$SlideOut:true,$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
              {$Duration:1200,x:0.3,$Cols:2,$During:{$Left:[0.3,0.7]},$ChessMode:{$Column:3},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
              {$Duration:1200,x:0.3,$Cols:2,$SlideOut:true,$ChessMode:{$Column:3},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
              {$Duration:1200,y:0.3,$Rows:2,$During:{$Top:[0.3,0.7]},$ChessMode:{$Row:12},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
              {$Duration:1200,y:0.3,$Rows:2,$SlideOut:true,$ChessMode:{$Row:12},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
              {$Duration:1200,y:0.3,$Cols:2,$During:{$Top:[0.3,0.7]},$ChessMode:{$Column:12},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
              {$Duration:1200,y:-0.3,$Cols:2,$SlideOut:true,$ChessMode:{$Column:12},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
              {$Duration:1200,x:0.3,$Rows:2,$During:{$Left:[0.3,0.7]},$ChessMode:{$Row:3},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
              {$Duration:1200,x:-0.3,$Rows:2,$SlideOut:true,$ChessMode:{$Row:3},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
              {$Duration:1200,x:0.3,y:0.3,$Cols:2,$Rows:2,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$ChessMode:{$Column:3,$Row:12},$Easing:{$Left:$Jease$.$InCubic,$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
              {$Duration:1200,x:0.3,y:0.3,$Cols:2,$Rows:2,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$SlideOut:true,$ChessMode:{$Column:3,$Row:12},$Easing:{$Left:$Jease$.$InCubic,$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
              {$Duration:1200,$Delay:20,$Clip:3,$Assembly:260,$Easing:{$Clip:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
              {$Duration:1200,$Delay:20,$Clip:3,$SlideOut:true,$Assembly:260,$Easing:{$Clip:$Jease$.$OutCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
              {$Duration:1200,$Delay:20,$Clip:12,$Assembly:260,$Easing:{$Clip:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
              {$Duration:1200,$Delay:20,$Clip:12,$SlideOut:true,$Assembly:260,$Easing:{$Clip:$Jease$.$OutCubic,$Opacity:$Jease$.$Linear},$Opacity:2}
            ];

            var jssor_1_options = {
              $AutoPlay: true,
              $SlideshowOptions: {
                $Class: $JssorSlideshowRunner$,
                $Transitions: jssor_1_SlideshowTransitions,
                $TransitionsOrder: 1
              },
              $ArrowNavigatorOptions: {
                $Class: $JssorArrowNavigator$
              },
              $ThumbnailNavigatorOptions: {
                $Class: $JssorThumbnailNavigator$,
                $Cols: 10,
                $SpacingX: 8,
                $SpacingY: 8,
                $Align: 360
              }
            };

            var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);

            /*responsive code begin*/
            /*you can remove responsive code if you don't want the slider scales while window resizing*/
            function ScaleSlider() {
                var refSize = jssor_1_slider.$Elmt.parentNode.clientWidth;
                if (refSize) {
                    refSize = Math.min(refSize, 800);
                    jssor_1_slider.$ScaleWidth(refSize);
                }
                else {
                    window.setTimeout(ScaleSlider, 30);
                }
            }
            ScaleSlider();
            $(window).bind("load", ScaleSlider);
            $(window).bind("resize", ScaleSlider);
            $(window).bind("orientationchange", ScaleSlider);
            /*responsive code end*/
        });
		
		function start_slide(){
			
			$('#jssor_1').show();
		}
    </script>
<div class="col-md-6">
				  <div class="box box-solid">
					<div class="box-header with-border" style="    padding: 5px 10px;">
					  <h3 class="box-title">Gallery</h3>
					  
					  
					  <?php /*<a class="pull-right label label-info fa fa-play-circle" style="cursor:pointer;" onclick="$('#ninja-slider').show();$('.fs-icon').trigger('click');$('.fs-icon').addClass('expanded');"><i></i></a>
					  */?>
					  <a class="pull-right label label-info fa fa-play-circle group1" style="cursor:pointer;" data-toggle="modal" data-target="#custom_slider" onclick="start_slide()"><i></i></a>
					</div>
					<!-- /.box-header --> 
					<div class="box-body" style="padding-top:0px;">
					  <div id="carousel-example-generic" class="carousel slide vis-gallery" data-ride="carousel">
						<ol class="carousel-indicators">
						<?php for($i = 0; $i < count($common_data['gallery_images']); $i++){?>
						  <li data-target="#carousel-example-generic"  data-slide-to="<?=$i;?>" <?php if($i == 0) {?>class="active"<?php }?>></li>
						<?php }?>
						</ol>
						<div class="carousel-inner">
						  
						  
						  <?php foreach($common_data['gallery_images'] as $key => $gallery):?>
						
						  <div class="item <?php if($key == 0):?>active<?php endif;?>">
							<a class="group1" href="javascript:void(0)">
							<img src="<?php echo base_url($gallery['file']);?>" alt="First slide">	
							</a>
						  </div>
						  
						  
						
							<?php endforeach;?>
						</div>
						<a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
						  <span class="fa fa-angle-left"></span>
						</a>
						<a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
						  <span class="fa fa-angle-right"></span>
						</a>
					  </div>
					</div>
					
					
				  </div>
				  <!-- /.box -->
				</div>
				<?php foreach($common_data['gallery_images'] as $key => $gallery):?>
					<p><a class="group1" href="<?php echo base_url($gallery['file']);?>" ></a></p>
				<?php endforeach;?>
				
				
`<div id="custom_slider" class="modal fade" role="dialog" style="background: rgb(0, 0, 0);">		
	<div class="modal-dialog" style="width:85%">	
		<div class="modal-content" style="background-color: rgba(0, 0, 0, 0.17);">		
		<div class="modal-header" style="border-bottom:0px;">
			<button type="button" class="close" data-dismiss="modal" style="    color: #fff;opacity:1;">x</button>
		</div>	
			<div class="modal-body" style="height: 100%;width:75%">
				<div id="jssor_1" class="jssor_1_class" style="position: relative; margin: 0 auto; top: 0px; left: 162px; width: 800px; height: 456px; overflow: hidden; visibility: hidden; background-color: #24262e;">
					<!-- Loading Screen -->
					<div data-u="loading" style="position: absolute; top: 0px; left: 0px;">
						<div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block; top: 0px; left: 0px; width: 100%; height: 100%;"></div>
						<div style="position:absolute;display:block;background:url('img/loading.gif') no-repeat center center;top:0px;left:0px;width:100%;height:100%;"></div>
					</div>
					<div data-u="slides" style="cursor: default; position: relative; top: 0px; left: 0px; width: 800px; height: 356px; overflow: hidden;">
					   <?php foreach($common_data['gallery_images'] as $key => $gallery):?>
						<div data-p="144.50" style="display: none;">
							<img data-u="image" src="<?php echo base_url($gallery['file']);?>" />
						</div>
					   <?php endforeach;?>
					</div>
					<!-- Thumbnail Navigator -->
					<div data-u="thumbnavigator" class="jssort01" style="position:absolute;left:0px;bottom:0px;width:800px;height:100px;" data-autocenter="1">
						<!-- Thumbnail Item Skin Begin -->
						<div data-u="slides" style="cursor: default;">
							<div data-u="prototype" class="p">
								<div class="w">
									<div data-u="thumbnailtemplate" class="t"></div>
								</div>
								<div class="c"></div>
							</div>
						</div>
						<!-- Thumbnail Item Skin End -->
					</div>
					<!-- Arrow Navigator -->
					<span data-u="arrowleft" class="jssora05l" style="top:158px;left:8px;width:40px;height:40px;"></span>
					<span data-u="arrowright" class="jssora05r" style="top:158px;right:8px;width:40px;height:40px;"></span>
				</div>
			</div>
		</div>
	</div>
 </div>
				
	<?php /*			
	<link href="<?php echo base_url('assets/css/thumbnail-slider.css');?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/css/ninja-slider.css');?>" rel="stylesheet" type="text/css" />
    <script src="<?php echo base_url('assets/dist/js/thumbnail-slider.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/dist/js/ninja-slider.js');?>" type="text/javascript"></script>
	
	<div id='ninja-slider' style="display:none;">
        <div>
            <div class="slider-inner">
                <ul>
                   
                    <?php foreach($common_data['gallery_images'] as $key => $gallery):?>
                        <li><a class="ns-img" href="<?php echo base_url($gallery['file']);?>"></a></li>
                      <?php endforeach;?>
                </ul>
                <div class="fs-icon" title="Expand/Close"></div>
            </div>
            <div id="thumbnail-slider">
                <div class="inner">
                    <ul>
					 <?php foreach($common_data['gallery_images'] as $key => $gallery):?>
                        <li>
                            <a class="thumb" href="<?php echo base_url($gallery['file']);?>"></a>
                            <span><?=$key;?></span>
                        </li>
                      <?php endforeach;?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
	
	<script>			
		$(document).ready(function(){
			$('.fs-icon').click(function(){
				if( $( ".fs-icon" ).hasClass( "expanded" )){
					$('#ninja-slider').hide();
					$( ".fs-icon" ).removeClass("expanded");
				}
				
			});
		});
	</script>
*/?>
