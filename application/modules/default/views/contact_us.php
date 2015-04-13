<script>
    function contactShow(){
        $("#contact-form").show(1000);
        $("#contact-span").hide();
        
    }
</script>
<div id='contact-us'>
    <!--<img src="<?php echo base_url();?>public/images/icon/address.png" />-->
    <div id="google-map">
        <iframe width="100%" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
            src="https://maps.google.com/maps/ms?msa=0&amp;msid=201931294760135328451.0005027b0cb2660ec9f1d&amp;ie=UTF8&amp;t=m&amp;start=0&amp;geocode=&amp;ll=21.036562,105.815903&amp;spn=0,0&amp;output=embed">
        </iframe>
        <br />
        <small>Xem <a href="https://maps.google.com/maps/ms?msa=0&amp;msid=201931294760135328451.0005027b0cb2660ec9f1d&amp;ie=UTF8&amp;t=m&amp;start=0&amp;geocode=&amp;ll=21.036562,105.815903&amp;spn=0,0&amp;source=embed"
            style="color:#0000FF;text-align:left">Địa điểm </a> ở bản đồ lớn hơn
        </small>
    </div>
    <div class="contact-title">Contact us</div>
	<p>
		&nbsp;&nbsp;&nbsp;&nbsp;The place where you have a last ditch attempt 
		at getting potential clients, customers and 
		fans to get in touch or, in my case, 
		convince them otherwise (I get a lot of emails).
		So we’ve had a look at the best About Us pages 
		and now I want to do the same for the Contact 
		Us page. What are the best practices? What works 
		and what doesn’t? Is there anything you can do 
		to increase your chances of success?
		Let’s take a look at what I think are 10 of 
		the best Contact Us pages on the internet.<br/><br/>	
		<b>NOTE:</b> Please give this post a Tweet if you 
		like it. It’ll only take you one click of 
		that button up in the top left. You guys are 
		amazing commentators but terrible social sharers!<br/><br/>
		
		&nbsp;&nbsp;&nbsp;&nbsp;An important note on responsive Contact Us pages		
		As you might know, the web has now gone mobile. 
		People browse websites on their iPhones and iPads 
		as much as they do on their laptops and PCs. This 
		means we have to change our design to responsive – 
		make the website change to the device.<br/><br/>
		
		<b>Contact us page</b><br/><br/>
		
		&nbsp;&nbsp;&nbsp;&nbsp;Click here to see some 
		beautiful themes that will present your Contact 
		Us page in a perfect way on every device and 
		make sure you come back to see the new Blog 
		Tyrant responsive theme soon! eople browse websites on their iPhones and iPads 
		as much as they do on their laptops and PCs. This 
		means we have to change our design to responsive – 
		make the website change to the device.<br/><br/>
		<b><i>What makes a good Contact Us page?</i></b><br/><br/>
		
		&nbsp;&nbsp;&nbsp;&nbsp;As you guys probably know 
		by now, I have a few other online companies that 
		keep me busy during the day. One of the things that 
		I have found with this non-blog based sites is that 
		the contact page can be quite important and can even 
		help to set the tone of future relations with your 
		clients. It is an important step in the relationship.<br/><br/>
		
		<b><i>So what makes a good Contact Us page?</i></b><br/><br/>
	
	    Here are some thoughts:<br/>
	    &nbsp;&nbsp;&nbsp;&nbsp;It needs to work
	    At a very basic level, the darn thing needs to work. 
	    I have been to so many webpages where the contact 
	    form is broken or doesn’t send properly. Bad look and lost business.
	    It needs to grab attention
	    Of course, this is the last point whereby a potential 
	    client can change their mind. If they get sent to a horrible looking contact page you are in trouble. It needs to be visually perfect.
	    The copy needs to be extremely seductive
	    Seductive copy. I do mean that literally. You need to seduce the person reading the page like you would a man/woman that you really want to take on a date. Hopefully most of the selling would already have been done if they are on the Contact Us page, so this is the tiny little flirt where you get their phone number.
	    It needs to set the client up for future relations
	    This is really important. You need to establish some ground rules. You need to set the client up for the way your relationship is going to work in the future. Statements like, “We check our emails every day and reply even if we’re at dinner,” can send very powerful messages.
	
	Sometimes, just by looking at a good Contact Us page, you can tweak your own so as to increase conversions and save a potential lost client. That is the point of this post.
	</p>
    <hr />
    <div id="contact-help">
        <div class="contact-title">
            How can we help you?
        </div>
        
        <span onclick="contactShow()" id="contact-span">Click here to contact us..</span>
        
        <form method="POST" action="" id="contact-form">
            <label>Your name</label>
            <input type="text" name="txtname" />
            <br />
            
            <label>Your email</label>
            <input type="text" name="txtemail" />
            <br />
            
            <label>Your phone</label>
            <input type="text" name="txtphone"/>
            <br />
            
            <label>How did you find us?</label>
            <select>
                <option>&nbsp;via google</option>
                <option>&nbsp;via facebook</option>
                <option>&nbsp;via twitter</option>
                <option>&nbsp;via linkedln</option>
            </select>
            <br />
            
            <label>Your opinion</label>
            <textarea name="txtopinion"></textarea>
            <br />
            
            <label>&nbsp;</label>
            <input type="submit" name="btok" value="Send" />
        </form>
    </div>
</div>