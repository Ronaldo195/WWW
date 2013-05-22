function emailCheck(emailStr) {
        var emailPat = /^(.+)@(.+)$/;
        var specialChars = "\\(\\)<>@,;:\\\\\\\"\\.\\[\\]";
        var validChars = "[^\\s" + specialChars + "]";
        var quotedUser = "(\"[^\"]*\")";
        var ipDomainPat = /^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/;
        var atom = validChars + "+";
        var word = "(" + atom + "|" + quotedUser + ")";
        var userPat = new RegExp("^" + word + "(\\." + word + ")*$");
        var domainPat = new RegExp("^" + atom + "(\\." + atom + ")*$");
        var matchArray = emailStr.match(emailPat);
        if (matchArray == null) {
            return false;
        }
        var user = matchArray[1];
        var domain = matchArray[2];
        if (user.match(userPat) == null) {
            return false;
        }
        var IPArray = domain.match(ipDomainPat);
        if (IPArray != null) {
            for (var i = 1; i <= 4; i++) {
                if (IPArray[i] > 255) {
                    return false;
                }
            }
            return true;
        }
        var domainArray = domain.match(domainPat);
        if (domainArray == null) {
            return false;
        }
        var atomPat = new RegExp(atom, "g");
        var domArr = domain.match(atomPat);
        var len = domArr.length;
        if (domArr[domArr.length - 1].length < 2 ||
            domArr[domArr.length - 1].length > 6) {
            return false;
        }
        if (len < 2) {
            alert(errStr);
            return false;
        }
        return true;
    }

function myLayer (x){
//individuo l’oggetto
	if(document.layers){ // browser="NN4"; 
		lay=document.layers[x];
	} 
	if(document.all){ // browser="IE"; 
		lay=eval("document.all." + x);
	} 
	if(!document.all && document.getElementById){ // browser="NN6+ or IE5+ if you’re willing to dump the !document.all stuff"; 
		lay=document.getElementById(x);
	}
	return lay;
}

function fnCaptcha(){
	var numero=Math.random()*9*9999;
	var numero=Math.floor(numero);
	form = document.forms['frmCaptcha'];

	myLayer("recaptcha_image").innerHTML = numero;
}
	
function Registrami(){
	form = document.forms['register-new-user'];
	month = form.elements['registrationBean.month'].value;
	day = form.elements['registrationBean.day'].value;
	year = form.elements['registrationBean.year'].value;
	email = form.elements['registrationBean.email'];
	username = form.elements['registrationBean.username'];
	password = form.elements['registrationBean.password'];
	conditions = form.elements['registrationBean.termsOfServiceSelection'];
	captcha = form.elements['recaptcha_response_field'];
	error1 = true;
	error2 = true;
	error3 = true;
	error4 = true;
	error5 = true;
	error6 = true;
	
	if(month == "" || day == "" || year == "" || year > 2001){
		document.getElementById('registrationBean.birth.error').style.display='block';
		document.getElementById('registration-birthday').className = 'error';
	}else{
		document.getElementById('registrationBean.birth.error').style.display='none';
		document.getElementById('registration-birthday').className = '';
		error1 = false;
	}
	
	if(email.value == "" || !emailCheck(email.value)){
		document.getElementById('registrationBean.email.error').style.display='block';
		email.className = 'error';
	}else{
		document.getElementById('registrationBean.email.error').style.display='none';
		email.className = 'ok';
		error2 = false;
	}
	
	if(username.value == '' || username.className != 'ok'){
		document.getElementById('registrationBean.username.error').style.display='block';
		username.className = 'error';
	}else{
		error3 = false;
	}
	
	if(password.value == '' || password.className != 'ok'){
		document.getElementById('registrationBean.password.error').style.display='block';
		password.className = 'error';
	}else{
		error4 = false;
	}
	
	if(!conditions.checked){
		document.getElementById('registrationBean.conditions.error').style.display='block';
	}else{
		document.getElementById('registrationBean.conditions.error').style.display='none';
		error5 = false;
	}
	
	if (captcha.value != myLayer("recaptcha_image").innerHTML){
		document.getElementById('registrationBean.captcha.error').style.display='block';
		captcha.className = 'error';
	}else{
		document.getElementById('registrationBean.captcha.error').style.display='none';
		captcha.className = 'ok';
		error6 = false;
	}
	
	if(!error1 && !error2 && !error3 && !error4 && !error5 && !error6){
		$(".register-submit").addClass("dimmed");
		Overlay.showDialogOnOverlay($("#change-password-form2"));
		
		window.location = "capt.php?adduser=1&month=" + month + "&day=" + day + "&year=" + year + "&email=" + email.value + 
		"&username=" + username.value + "&password=" + password.value;
	}
}

function MailTaken(mail) {
    mail.className = 'loading';
    $.get("nametaken.php?habbo_name=&password=&mail=" + mail.value, function (data) {
        if ($.trim(data) != "1") {
            document.getElementById('registrationBean.email.error').style.display = 'block';
            mail.className = 'error';
        } else {
            document.getElementById('registrationBean.email.error').style.display = 'none';
            mail.className = 'ok';
            error4 = false;
        }
    });
}
function PassTaken (password){
	password.className = 'loading';
	$.get("nametaken.php?habbo_name=&mail=&password=" + password.value, function(data)
	{
		if($.trim(data) != "1"){
			document.getElementById('registrationBean.password.error').style.display='block';
			password.className = 'error';
		}else{
			document.getElementById('registrationBean.password.error').style.display='none';
			password.className = 'ok';
			error4 = false;
		}
	});
}
function NameTaken (username){
	username.className = 'loading';
	$.get("nametaken.php?password=&mail=&habbo_name=" + username.value, function(data)
	{
		if($.trim(data) != "1")
		{
			document.getElementById('registrationBean.username.error').style.display='block';
			username.className = 'error';
		}else{
			document.getElementById('registrationBean.username.error').style.display='none';
			username.className = 'ok';
		}
	});
}
window.onload=function(){fnCaptcha();}
