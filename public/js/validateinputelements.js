$pwdI = document.getElementById('passwordInput');
$cfmPwdI = document.getElementById('confirmPasswordInput');
$pFP = document.getElementById('passwordFeedbackP');
$emFP = document.getElementById('emailFeedbackP');
$emFI = document.getElementById('emailFeedbackI');
$emI = document.getElementById('emailInput');

var $pwd;
var $cfmPwd;
var $em;

function validatePasswords() {
    setTimeout(function () {
        $pwd = $pwdI.value;
        $cfmPwd = $cfmPwdI.value;

        if ($pwd && $cfmPwd) {
            $pFP.style.display = 'block';
            if ($pwd === $cfmPwd) {
                $pFP.innerText = 'The passwords are identical';
                $pFP.style.color = 'limegreen';
            } else {
                $pFP.innerText = 'The passwords are not identical';
                $pFP.style.color = 'red';
            }
        } else {
            $pFP.style.display = 'none';
        }
    }, 10);
}

function validateEmail() {
    setTimeout(function () {
        $em = $emI.value;

        if ($em) {
            if (/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test($em)) {
                $emFP.style.display = 'none';
                $emFI.style.display = 'inline-block';
                $emFI.classList.remove('fa-warning');
                $emFI.classList.add('fa-check');
                $emFI.style.color = 'limegreen';
            } else {
                $emFP.style.display = 'block';
                $emFI.style.display = 'inline-block';
                $emFI.style.color = 'red';
                $emFI.classList.remove('fa-check');
                $emFI.classList.add('fa-warning');

            }
        } else {
            $emFP.style.display = 'none';
            $emFI.style.display = 'none';
        }
    }, 10);
}