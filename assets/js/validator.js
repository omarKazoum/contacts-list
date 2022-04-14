/**
 *
 * @param el HTMLInput element to make valid or invalid
 * @param enable
 */
const enableErrorOn=(el,enable,message)=>{
    el.closest('form.needs-validation').classList.add('was-validated');
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
        console.log('bound form '+form);
        console.log(form);
        form.addEventListener('submit', (e) => {
            const inputs = e.target.querySelectorAll("[data-validate='1']");
            let allValide = true;
            e.target.classList.add('was-validated');
            for (let input of inputs) {
                console.log("bound:"+input.name);
                let isInputValide = input.value.match(input.dataset.validatePattern);
                if(input.hasAttribute('data-validate-match')){
                    let elementToMatch= document.getElementById(input.dataset.validateMatch);
                    isInputValide=input.value==elementToMatch.value;
                }
                if (!isInputValide) allValide = false;
                enableErrorOn(input, !isInputValide,input.dataset.validateMessage);
                input.addEventListener('keyup',validateInput);
                input.addEventListener('change',validateInput);
            }

            e.preventDefault();
            if (allValide) {
                console.log('all valid');
            }else{
                e.stopImmediatePropagation();
                console.log('not all is valid');
            }
        })
    });
}
const validateInput=(e)=>{
    const input=e.target;
    let isInputValide ;
    if(input.hasAttribute('data-validate-match')){
        let elementToMatch= document.getElementById(input.dataset.validateMatch);
        isInputValide=input.value==elementToMatch.value && elementToMatch.value.match(elementToMatch.dataset.validatePattern);
    }else{
        isInputValide= null!=input.value.match(input.dataset.validatePattern);
    }
    enableErrorOn(input, !isInputValide,input.dataset.validateMessage);
}
bindFormValidator();