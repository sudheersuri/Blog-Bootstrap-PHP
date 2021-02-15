<div class="col-xl-4 sidebar ftco-animate bg-light pt-5">
	            <div class="sidebar-box pt-md-4">
	              <form action="#" class="search-form">
	                <div class="form-group">
	                  <span class="icon icon-search"></span>
	                  <input type="text" class="form-control" placeholder="Type a keyword and hit enter">
	                </div>
	              </form>
	            </div>
	            <div class="sidebar-box ftco-animate">
	            	<h3 class="sidebar-heading">Categories</h3>
	              <ul class="categories">
				  <?php
				 	$query = "select category,count(*) as count from blogs group by category";
					$result = $conn->query($query);
					if($result->num_rows>0)
					{
						while($row=$result->fetch_assoc())
						{
							echo '<li><a href="#">'.$row['category'].'<span>('.$row['count'].')</span></a></li>';	
						}
					} 
				  ?>
					<li><a href="#">Fashion <span>(6)</span></a></li>
	                <li><a href="#">Technology <span>(8)</span></a></li>
	                <li><a href="#">Travel <span>(2)</span></a></li>
	                <li><a href="#">Food <span>(2)</span></a></li>
	                <li><a href="#">Photography <span>(7)</span></a></li>
	              </ul>
	            </div>

	            <div class="sidebar-box ftco-animate">
	              <h3 class="sidebar-heading">Popular Articles</h3>
                  <?php
                  $query = "select * from blogs order by viewcounter desc limit 5";
                  $result = $conn->query($query);
                  if($result->num_rows>0)
                  { 
                    while($row=$result->fetch_assoc())
                    {
                        ?>
                        <div class="block-21 mb-4 d-flex">
	                <a class="blog-img mr-4" style="background-image: url(<?php echo $row['imglocation']?>);"></a>
	                <div class="text">
	                  <h3 class="heading"><a href="detail.php?id=<?php echo $row["id"];?>"><?php echo $row['title']?></a></h3>
	                  <div class="meta">
	                    <div><a href="#"><span class="icon-calendar"></span>&nbsp;&nbsp;<?php
                        $date=date_create($row["dateadded"]);
                        echo date_format($date,"F m,Y"); ?></a></div>
	                    <div><a href="#"><span><i class="icon-eye mr-2"></i><?php echo $row["viewcounter"];?></span>
                        </div>
	                  </div>
	                </div>
	              </div>
                        <?php
                    }
                  }
                  ?>
	              
	            </div>
	          </div><!-- END COL -->
	    		</div>
	    	</div>
	    				</section>
		</div><!-- END COLORLIB-MAIN -->