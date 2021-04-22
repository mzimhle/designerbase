{if !isset($participantData)}
<div class="widget widget-newsletter">
	<h3 class="widget-title">Register</h3>
	<p>Enter your details to register to the website and be part of the family!</p>
	<form action="{$smarty.server.REQUEST_URI|default:'/'}" method="POST">
		<div class="form-group">
			<input type="text" id="participant_name" name="participant_name" class="form-control" placeholder="Your full name" required>
		</div>							
		<div class="form-group">
			<img src="/images/icon-newsletter-email.png" alt="Enter your email address here" title="Enter your email address here">
			<input type="email" name="participant_email" id="participant_email" class="form-control" placeholder="Email Address" required>
		</div>
		<!-- End .form-group -->
		<input type="submit" value="Register now" class="btn btn-block" />
		{if isset($success)}
		<div class="form-group">
			<p class="green">You have been successfully registered and will receive an email to confirm your email.</p>
		</div>
		{/if}
		{if isset($errorArray)}
		<div class="form-group">
			<br />
			<p class="red">{$errorArray}</p>
		</div>
		{/if}
		<input type="hidden" id="register_form" name="register_form" value="1" />
	</form>
</div>
<!-- End .widget -->
{/if}