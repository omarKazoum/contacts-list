/**
 *
 * @param el HTMLInput element to make valid or invalid
 * @param enable
 */
const enableErrorOn=(el,enable,message)=>{
        if(enable)
            el.closest('form').classList.add('was-validated')
    el.setCustomValidity(enable?' ':'');
        let errorEl=el.parentNode.querySelector('.invalid-feedback')
        if(errorEl==null){
           errorEl=document.createElement('div');
           errorEl.classList.add('invalid-feedback');
           el.parentNode.appendChild(errorEl);
        }
        errorEl.textContent=message;
}

/**
 * enables form validation for all Form Html elements in the calling html page
 * use data-validate='1' to specify which you want to validate
 * use data-validate-pattern='regex' to specify a pattern to respect
 * use data-validate-message='1' to specify a message to display above the input the element if it does not respect data-validate-pattern
 */
const bindFormValidator=() =>{
    document.querySelectorAll('form.needs-validation').forEach((form) => {
        console.log('bound form ');
        console.log(form);
        form.addEventListener('submit', (e) => {
            const inputs = e.target.querySelectorAll("[data-validate='1']");
            let allValide = true;
            e.target.classList.add('was-validated');
            for (let input of inputs) {
                console.log("bound:"+input.name);
                if (!validateInput(input)) allValide = false;
                enableErrorOn(input, !isInputValide,input.dataset.validateMessage);
            }
            e.preventDefault();
            if (allValide) {
                console.log('all valid');
            }else{
                e.stopImmediatePropagation();
                console.log('not all is valid');
            }
        })
        form.querySelectorAll('input').forEach((input)=>{
            input.addEventListener('keyup',e=>validateInput(e.target));
            input.addEventListener('change',e=>validateInput(e.target));
        })
    });
}
const validateInput=(input)=>{
    let isInputValide ;
    if(input.hasAttribute('data-validate-match')){
        let elementToMatch= document.getElementById(input.dataset.validateMatch);
        isInputValide=input.value==elementToMatch.value && elementToMatch.value.match(elementToMatch.dataset.validatePattern);
    }else{
        isInputValide= input.value.match(input.dataset.validatePattern);
    }
    enableErrorOn(input, !isInputValide,input.dataset.validateMessage);
    return isInputValide;
}
const forceValidateAllInputs=(form)=>{
    form.querySelectorAll('input').forEach((input)=>{
        validateInput(input);
    })
}
bindFormValidator();