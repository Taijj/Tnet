jQuery(document).ready(function ($)
{
	var invalidText = $('.invalid-password-input');

	var password = "Nudelsuppe";
	$('.password-form').submit(function(e)
	{
		e.preventDefault();

		var input = $('.password-field').val();
		if(input.match(password))
		{
			$('.protected').removeClass('hidden');
			$('.password-widget').addClass('hidden');
			invalidText.addClass('hidden');
		}
		else
		{
			invalidText.removeClass('hidden');
		}
	});
});