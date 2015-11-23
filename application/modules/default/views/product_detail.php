<script>
    function clickFunc() {
        $("#feed-info").show(1500);
        $("#show_feed").hide();
    }

    //$(document).ready(function(){
    //          // simple jRating call
    //          $(".basic").jRating();
    //
    //          // more complex jRating call
    //          $(".basic").jRating({
    //             step:true,
    //             length : 20, // nb of stars
    //             onSuccess : function(){
    //               alert('Success : your rate has been saved :)');
    //             }
    //           });
    //
    //          // you can rate 3 times ! After, jRating will be disabled
    //          $(".basic").jRating({
    //             canRateAgain : true,
    //             nbRates : 3
    //           });
    //
    //          // get the clicked rate !
    //          $(".basic").jRating({
    //            onClick : function(element,rate) {
    //             alert(rate);
    //            }
    //          });
    //    });
</script>
<style>
    #feed-item {
        padding-bottom: 10px;
    }

    #feed-inside {
        padding-top: 3px;
    }

    #feed-tile-comment {
        font-size: 18px;
        color: rgba(225, 81, 25, 1);
    }

    #feed-title {
        font-size: 14px;
    }

    #feed-info {
    <?php if(!isset($display)){
    	echo "display: none;";
    }
    else{
		if($display==1){
			echo "";
		}else{
			echo "display: none;";
		}
		
    }?>
    }

    #feed-info label {
        font-size: 18px;
        font-weight: bold;
        width: 150px;
        float: left;
        line-height: 30px;
        margin-top: 10px;
    }

    #feed-info input[type=text] {
        width: 300px;
        height: 30px;
        margin: 10px 0;
    }

    #feed-info input[type=submit] {
        margin: 10px 0;
        height: 30px;
        width: 80px;
    }

    #feed-list {
        margin-top: 50px;
    }

    #feed-content {
    }

    #feed-name {
        color: blue;
    }

    .error {
        color: red;
    }

    .rate_widget {
        border: 1px solid #CCC;
        overflow: visible;
        padding: 10px;
        position: relative;
        width: 180px;
        height: 32px;
    }

    .ratings_stars {
        background: url('star_empty.png') no-repeat;
        float: left;
        height: 28px;
        padding: 2px;
        width: 32px;
    }

    .ratings_vote {
        background: url('star_full.png') no-repeat;
    }

    .ratings_over {
        background: url('star_highlight.png') no-repeat;
    }

    .total_votes {
        background: #eaeaea;
        top: 58px;
        left: 0;
        padding: 5px;
        position: absolute;
    }

    .movie_choice {
        font: 10px verdana, sans-serif;
        margin: 0 auto 40px auto;
        width: 180px;
    }

    ul.nostyle {
        list-style: none;
        padding-top: 15px;
    }
</style>
<div id='pro-feedback'>
    <div id="pro-detail">
        <div id="left">
            <?php
            $num_row = count($proInfo);
            $i = 2;
            if (isset($proInfo) && $proInfo != null) {
                echo "<div id='images'>
                <img src='" . base_url() . "public/images/products/" . $proInfo[0]['pro_images'] . "' />";
                foreach ($proInfo as $key => $value) {
                    if (isset($value['img_link'])) {
                        echo "<img src='" . base_url() . 'public/images/products/' . $value['img_link'] . "'/>";
                    }
                }
                echo "</div>";

                echo "<div id='list-thumbs'>
                <ul id='thumbs'>";
                echo "<li class='active' rel='1'><img src='" . base_url() . 'public/images/products/' . $value['pro_images'] . "'/></li>";
                foreach ($proInfo as $key1 => $value1) {
                    if (isset($value1['img_link'])) {
                        echo "<li rel='$i'>";
                        echo "<img src='" . base_url() . "public/images/products/" . $value1['img_link'] . "'/>";
                        echo "</li>";
                        $i++;
                    }
                }
                echo "</ul>
	        </div>
        </div>";
                //right
                echo "<div id='right'>
	        <div id='name-product'>
	            " . strtoupper($value['pro_name']) .
                    "</div>

                    <div id='price'>
                        " . number_format($value['pro_list_price'], "0", "", ".") . "&nbsp;$
	        </div>
	        
	        <div id='brand'>
	            <label>Made by:</label> " . strtoupper($value['brand_name']) . "<br />
	            <label>Made in:</label> " . strtoupper($value['pro_country']) . "
	        </div>
	        
	        <div>
	        	<label>Rating:</label>
        		
		        		<div class='rateit' data-rateit-value='" . $rating_avg[0]['feed_rate'] . "' data-rateit-ispreset='true' data-rateit-readonly='true'>
		            	</div>&nbsp&nbsp&nbsp&nbsp&nbsp" . strtoupper(number_format(($rating_avg[0]['feed_rate'] * 2), 2) . "/10.") . "
    				
        		<br />
	        	" . count($listComment) . " comment(s)<br />
	        </div>
	        
	        <div id='description'>
	            " . $value['pro_desc'] . "
	        </div>";

                echo "<div class='detail-cart'>
	            <a href='#' onclick='if(add_cart(" . $value['pro_id'] . ", " . $value['pro_sale_price'] . ")) return false;' class='fa fa-shopping-cart'>&nbsp;Add to cart</a>
	        </div>";
            }
            ?>
        </div>
        <!--end right-->
    </div>
    <!--end detail-->

    <hr/>
    <div id='feedback'>
        <div id="feed-message"><?php if (isset($msg)) {
                echo $msg;
            } ?></div>
        <span id="show_feed" onclick="clickFunc()">Leave a comment <font size="3" color="blue"><u>click here</u></font></span>

        <div class="notice">
            <!--comment-->
            <div id="feed-info">
                <div>
                    <form action="<?php echo base_url(); ?>default/home/detail/<?php echo $proInfo[0]['pro_id']; ?>"
                          method="POST">
                        <label>Name</label>
                        <input type="text" name="feed_name"/>
                        <span class="error"><i><?php echo form_error("feed_name"); ?></i></span>
                        <br/>

                        <label>Email</label>
                        <input type="text" name="feed_email"/>
                        <span class="error"><i><?php echo form_error("feed_email"); ?></i></span>
                        <br/>

                        <label>Title</label>
                        <input type="text" name="feed_title"/>
                        <span class="error"><i><?php echo form_error("feed_title"); ?></i></span>
                        <br/>

                        <label>Your comment</label>
                        <textarea name="feed_content"></textarea>
                        <span class="error"><i><?php echo form_error("feed_content"); ?></i></span>
                        <br/>

                        <label for="rating"><b>Rating</b></label>
                        <ul class="nostyle">
                            <li>
                                <input type="range" value="5" step="0.5" id="backing4" name="feed_rate">

                                <div class="rateit" data-rateit-backingfld="#backing4" data-rateit-resetable="false"
                                     data-rateit-ispreset="true"
                                     data-rateit-min="0" data-rateit-max="5">
                                </div>
                            </li>
                        </ul>
                        <br/>
                        <input type="hidden" name="pro_id" value="<?php echo $proInfo[0]['pro_id']; ?>">
                        <label>&nbsp;</label>
                        <input type="submit" name="feed_submit" value="Send" onclick="hideForm()"/>
                    </form>
                </div>
            </div>
            <!--end comment-->

            <!--list comment-->
            <div id="feed-list">
                <div id="feed-content">
                    <?php foreach ($listComment as $key => $value) { ?>
                        <div id="feed-item">
                            <div>
                                <div class='rateit' data-rateit-value='<?php echo $value['feed_rate'] ?>'
                                     data-rateit-ispreset='true' data-rateit-readonly='true'></div>
                                &nbsp<span id="feed-tile-comment"><?php echo $value['feed_title']; ?>
					</span></div>
                            <div id="feed-inside"><?php echo $value['feed_content']; ?></div>

                            <div id="feed-inside" style="color: rgba(111, 111, 43, 1)">
                                Date: <?php echo $value['feed_time']; ?></div>
                        </div>
                        <br/>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>