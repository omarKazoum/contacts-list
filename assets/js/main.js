const signupForm=document.querySelector("#signupForm");
signupForm.addEventListener('submit',(e)=>{
    console.log("form submit cllaback 2");

    try {
        let request = new XMLHttpRequest();
        request.open('post', '/api');
        request.onreadystatechange = () => {
            if (request.readyState = 4) {
                res=request.response;
                switch(request.status){
                    case 200:
                        console.log('the request was successfull !');
                        console.log(request.response);
                        break;
                    default: console.log('the server responded with code '+request.status);
                }
            }
        }
        request.send(new FormData(e.target));
    }catch (e){
        console.error(e);
    }
})