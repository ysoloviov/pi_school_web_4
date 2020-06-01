export default class MobileVerificationForm
{
	errors = {};

	constructor(phoneNumberLength)
	{
		this.phoneNumberLength = phoneNumberLength;
	}

	set phone_number(number)
	{
		if(number.match(/\D/) || number.length !== this.phoneNumberLength)
			this.errors.phone_number = "invalid_phone_number";
	}
}
