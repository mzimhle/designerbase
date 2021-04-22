<footer class="footer">
	<div class="container">
		<div class="info-bar">
			<div class="info-bar-col">
				<a href="#">
					<h5 class="info-bar-title">CUSTOM DESIGNER CATALOG</h5>
					<p>Only fashion items that have been created by up coming designers.</p>
				</a>
			</div>
			<!-- End .info-bar-col -->
			<div class="info-bar-col">
				<a href="#">
					<h5 class="info-bar-title">SUPPORT LOCAL DESIGNERS</h5>
					<p>No big company products, we source only custom made products from local designers.</p>
				</a>
			</div>
			<!-- End .info-bar-col -->
			<div class="info-bar-col">
				<a href="#">
					<h5 class="info-bar-title">WE PROVIDE DIRECT SERVICE</h5>
					<p>We make sure you get your items straight from the designers.</p>
				</a>
			</div>
			<!-- End .info-bar-col -->
		</div>
		<!-- End .info-bar -->
	</div>
	<!-- End .container -->
	<div class="footer-inner">
		<div class="container">
			<div class="row">
				<div class="col-sm-6 col-md-3">
					<div class="widget widget-about">
						<h4 class="widget-title">Contact Information</h4>
						<address>
							<span>Phoenix View Estate, Midrand, Gauteng</span>
							<a href="mailto:info@designerbase.co.za">info@designerbase.co.za</a>
						</address>
						<br /><img src="/images/icons/favicon_bg.png" width="70" />
					</div>
					<!-- End .widget -->
				</div>
				<!-- End .col-md-3 -->

				<div class="col-sm-6 col-md-3">
					<div class="widget">
						<h4 class="widget-title">Categories</h4>
						<ul class="links">
						{foreach from=$categoryData item=category}
						<li><a href="/catalog/?filter_category={$category.item_code}">{$category.item_name}</a></li>
						{/foreach}
						</ul>
					</div>
					<!-- End .widget -->
				</div>
				<!-- End .col-md-3 -->

				<div class="clearfix visible-sm"></div>
				<!-- clearfix -->

				<div class="col-sm-6 col-md-3">
					<div class="widget">
						<h4 class="widget-title">Links</h4>
						<ul class="links">
							{if !isset($participantData)}
							<li><a href="/register">Sign Up</a></li>
							<li><a href="/login">Login</a></li>
							{else}
							<li><a href="/account">{$participantData.participant_name}</a></li>
							{/if}
							<li><a href="/basket">My Basket</a></li>
							<li><a href="/contact">Contact</a></li>
							<li><a href="/terms-and-conditions">Terms and Conditions</a></li>
							<li><a href="/privacy-policy">Privacy Policy</a></li>		
						</ul>
					</div>
					<!-- End .widget -->
				</div>
				<!-- End .col-md-3 -->
				<div class="col-sm-6 col-md-3">
					<div class="widget widget-newsletter">
						<h4 class="widget-title">Social Media</h4>
						<p>Follow us on one of our social media accounts.</p>
						<div class="social-icons">
							<a href="https://www.facebook.com/designedbase/" class="social-icon" alt="Designer Base Facebook" title="Designer Base Facebook" target="_blank"><i class="fa fa-facebook"></i></a>
							<a href="https://twitter.com/designedbase" class="social-icon" title="Designer Base Twitter" alt="Designer Base Twitter" target="_blank"><i class="fa fa-twitter"></i></a>
							<a href="https://instagram.com/designerbasesa" class="social-icon" title="Designer Base Instagram" alt="Designer Base Instagram" target="_blank"><i class="fa fa-instagram"></i></a>
							<!-- <a href="#" class="social-icon" title="pinterest"><i class="fa fa-pinterest"></i></a> -->
						</div>
					</div>
					<!-- End .widget -->
				</div>
				<!-- End .col-md-3 -->
			</div>
			<!-- End .row -->
		</div>
		<!-- End .container -->
	</div>
	<!-- End .footer-inner -->
	<div class="footer-bottom">
		<div class="container">
			<p class="copyright">Designer Base &copy; <script>document.write(new Date().getFullYear())</script>. All Rights Reserved</p>
			<img src="/images/cards.png" alt="Payment Methods" class="img-cards">
		</div>
		<!-- End .container -->
	</div>
	<!-- End .footer-bottom -->
</footer>
<!-- End .footer -->
<!-- Modal -->
<div class="modal fade" id="addBasketItemModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Add to basket</h4>
			</div>
			<div class="modal-body">
				<b>
                    <span id="modal_basket_name" name="modal_basket_name" style="font-size: 23px;color: #e41f3b;"></span>
                    <!-- Current selected price is R <span id="modal_basket_price" name="modal_basket_price" style="color: #e41f3b;"></span> -->
				</b>
				<table class="table table-bordered">
					<tr>
						<th width="20%">Image</th>
						<th width="80%">Choose Price & Quantity</th>
					</tr>
					<tr>
                        <td><img src="" id="modal_basket_image" name="modal_basket_image" width="80px" /></td>
						<td>
						    Price is based on the size of the item, please make sure you selected the right price for the right size below:<br /><br />
						    <select id="modal_price_code" name="modal_price_code" class="form-control"></select><br />
						    Number of items for the selected price:<br /><br />
						    <input type="number" name="modal_basket_quantity" id="modal_basket_quantity" size="2" min="1" value="1" class="form-control" />
						</td>
					</tr>
				</table>
				<b>Extra information on the item.</b>
				<textarea id="modal_basket_text" name="modal_basket_text" rows="5" class="form-control"></textarea>
				<p id="modal_basket_result" class="red"></p>
			</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
				<button class="btn btn-warning" type="button" onclick="javascript:addBasketItem();">Add</button>
				<input type="hidden" id="modal_basket_code" name="modal_basket_code" value="" />
			</div>
		</div>
	</div>
</div>
{literal}
<!-- modal -->
<script type="text/javascript">
	function addBasketItemModal(id, name, pricecode, priceamount, image) {
		$.ajax({
			type: "GET",
			url: "/includes/footer.php?modal_basket_price_select=1",
			data: "catalog_code="+id+"&pricecode="+pricecode,
			dataType: "html",
			success: function(data){
			    $('#modal_price_code').html(data);
        		$('#modal_basket_code').val(id);
        		$('#modal_basket_name').html(name);
        		$("#modal_basket_image").attr("src", image);	
        		$('#modal_basket_quantity').val(1);
        		$('#modal_basket_text').val('');
        		$('#addBasketItemModal').modal('show');
			}
		});

		return false;
	}

	function addBasketItem() {
		
		$('#modal_basket_result').html('');
		
		var id			= $('#modal_basket_code').val();
		var quantity	= $('#modal_basket_quantity').val();
		var text		= $('#modal_basket_text').val();
		var price		= $('#modal_price_code').val();

		$.ajax({
			type: "GET",
			url: "/includes/footer.php?modal_basket_ajax=1",
			data: "basket_code="+id+"&price_code="+price+"&basket_quantity="+quantity+"&basket_text="+text,
			dataType: "json",
			success: function(data){
				if(data.result == 1) {
					window.location.href = window.location.href;
				} else {
					$('#modal_basket_result').html(data.message);
				}
			}
		});
		return false;
	}
</script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-71510823-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'UA-71510823-1');
</script>
{/literal}