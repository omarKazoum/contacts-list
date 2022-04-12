const signupForm=document.querySelector("#signupForm");
const signinForm=document.querySelector("#signinForm");
const ALERT_TYPE_SUCCESS='success';
const ALERT_TYPE_FAILED='question';

const alert=(message,type)=>{
    Swal.fire(
        message,
        '',
        type
    )
}
const signUpAndLoginFormHandler=(event)=>{
    console.log("form submit cllaback 2");
    try {
        let request = new XMLHttpRequest();
        request.open('post', '/api?action='+(event.target.dataset.action));
        request.onreadystatechange = () => {
            if (request.readyState === 4) {
                res=JSON.parse(request.response);
                switch(request.status){
                    case 200:
                       // alert(res.message,ALERT_TYPE_SUCCESS);
                        window.location.href='/';
                        break;
                    case 400:
                        //so we have errors let's display them to the user
                        const keys=Object.keys(res.errors)
                        keys.forEach((k)=>{
                            console.log(k+':'+res.errors[k]);
                            document.getElementsByName(k).forEach((el)=>{
                                enableErrorOn(el,true,res.errors[k]);
                            })
                        })
                        alert(res.message,ALERT_TYPE_FAILED);
                        break;
                    default: console.log('the server responded with code '+request.status);
                }
            }
        }
        request.send(new FormData(event.target));
    }catch (e){
        console.error(e);
    }
}
if(signupForm!=null)
    signupForm.addEventListener('submit',signUpAndLoginFormHandler)
if(signinForm!=null)
    signinForm.addEventListener('submit',signUpAndLoginFormHandler)