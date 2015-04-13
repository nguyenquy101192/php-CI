
			<!--Colleft-->
            <div id="colleft">
                <div id="category">
                    <div class="title-category">
                        <h4>category</h4>
                    </div>
                    <div id="menu-left">
                        <ul id="nav">
                            <?php echo $listCate; ?>                       
                        </ul>
                    </div>
                </div>
                
                <div id="pro-type">
                    <div class="title-category">
                        <h4>collection</h4>
                    </div>
                    <div id="filter">
                    <label id="bp_filter">Brands</label><br/><br/>
                        <?php
                        if($this->session->userdata("config_brands")){
                            $brands = $this->session->userdata("config_brands");
                        }
                            
                        count($listBrand);
                        $i = 0;
                        foreach ($listBrand as $key => $value){?>
                        <input id='filter<?php echo $i;?>' type="checkbox" name="brand_id[]" value="<?php echo $value['brand_id'];?>" 
                        <?php 
                        if(isset($brands) && $brands != null){
                       		foreach ($brands as $bkey => $bvalue){
								if($bvalue==$value['brand_id']){echo "checked";}
							}
                        }
                        ?>
                       />
                       <label id="filter"><?php echo $value['brand_name'];?></label>
                       <br />
                       <?php $i++;}?>
                       <div id='filter-price'>
	                       <label id="bp_filter">Price range</label><br />
						   <input type="text" id="price">
	      				   <div id="slider-3"></div>
						   <div id='amount'></div>
					   </div>
                    </div>
                </div>
            </div>
            <!--End colleft-->