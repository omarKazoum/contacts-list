const signupForm=document.querySelector("#signupForm");
const signinForm=document.querySelector("#signinForm");
const contactsForm=document.querySelector('#contacts-form');
const noContactsMsg=document.querySelector('.no-contacts-msg');
const pageHeading=document.querySelector('.page-header');
const btnSave=document.querySelector('.btn-save');
const addContactBtn=document.querySelector('.add-contact-btn');

const CONTACT_MODE_UPDATE=1;
const CONTACT_MODE_ADD=0;
let contactsMode=CONTACT_MODE_ADD;
const ALERT_TYPE_SUCCESS='success';
const ALERT_TYPE_FAILED='question';
const ADD_FORM_HEADING="Add a contact";
const EDIT_FORM_HEADING="Edit a contact";
const EDIT_BTN_TEXT="Update";
const ADD_BTN_TEXT='Add';
const ACTION_TYPE_ADD_CONTACT="ADD_CONTACT";
const ACTION_TYPE_UPDATE_CONTACT="UPDATE_CONTACT";
const ACTION_TYPE_LIST_CONTACTS="LIST_CONTACTS";
const ACTION_TYPE_DELETE_CONTACT="DELETE_CONTACTS";
let contactIdToBeHighlighted=-1;
let data;

const addContactToList = (contactData) => {
    const parent = document.createElement('div');
    parent.classList.add('card','no-gutters','p-0','contact-item');
    parent.setAttribute('data-contact-id', contactData.id);
    let contactHtml = `
              <div class="p-1 card-body d-flex flex-row align-items-center">
                <div class="fw-bold contact-name col-6">${contactData.nom}</div>
                <div class="contact-actions d-flex flex-row-reverse col-6">
                    <a href="#form-con" class="btn fa-solid fa-pen-to-square edit-btn"></a>
                    <button href="" class="delete-btn btn fa-solid fa-trash-can"></button>
                </div>
              <div class="card-body">
    `;
    parent.innerHTML = contactHtml;
    const editBtnListenner=(e) => {
        if(e.target.classList.contains('delete-btn'))
            return false;
        let id='';
        if(e.target.classList.contains('contact-item'))
            id=e.target.dataset.contactId;
        else
            id= e.target.closest('.contact-item').dataset.contactId;
        console.log('editing contact with id ' + id);
        updateUi(CONTACT_MODE_UPDATE);
        let contact = data.find(c => c.id == id)
        console.log('found :');
        console.log(contact);
        Object.keys(contact).forEach((k) => {
            if (k != 'user_id')
                document.getElementsByName(k)[0].value = contact[k];
        })

        contactsForm.querySelectorAll('input').forEach(input=>{
            input.style.animation='';
            setTimeout(()=>{
                input.style.animation='highlightForm 2s 1';
            },100)
        })
    };
    parent.querySelector('.edit-btn').addEventListener('click', editBtnListenner,false);
    parent.addEventListener('click', editBtnListenner,true);


    parent.querySelectorAll('.delete-btn').forEach((btn) => {
        btn.addEventListener('click', (e) => {
            e.stopPropagation()
            let sellectedContactId = e.target.parentNode.parentNode.parentNode.dataset.contactId;
            console.log("to delete " + sellectedContactId);
            prompt((res) => {

                    sendHttpPostRequest(ACTION_TYPE_DELETE_CONTACT,(res)=>{
                        //success
                        alert(res.message, ALERT_TYPE_SUCCESS);
                        removeContact(sellectedContactId);
                            contactsForm.reset();
                    },
                        (res)=>{
                        //faillure
                        alert(res.message, ALERT_TYPE_FAILED);
                    },
                        "id=" + sellectedContactId,
                        true)

            }, () => {
                console.log("delete cancled")
            }, "you want to delete <b>" + data.find(c => c.id == sellectedContactId).nom + "</b>");

        })
    })
    document.querySelector('.contacts-table').appendChild(parent);
}
const highlightSuccess = (id) => {
    if (id != -1) {
        console.log("highlighting contact with id " + id);
        const el = document.querySelector("[data-contact-id='" + id + "']");
        let h = document.getElementById('highlighted')
        if (h != null)
            h.removeAttribute('id');
        el.setAttribute('id', 'highlighted');
        let href = window.location.href;
        href = href.replace(/(\#[\w\-]+)/g, '');
        window.location.href = href + "#highlighted";
        el.style.animation = '';
        setTimeout(() => {
            el.style.animation = 'highlightSuccess 2s 1';
        }, 100)
        contactIdToBeHighlighted = -1;
    }
}
const removeContact = (id) => {
    let selectedContactElement = document.querySelector("[data-contact-id='" + id + "']");
    data = data.filter((contact, index, arr) => contact.id != id);
    selectedContactElement.style.animation = "";
    setTimeout(() => {
        selectedContactElement.style.animation = "remove 2s 1";
        selectedContactElement.style.fillAfterMode = 'forwards';
    }, 100);
    setTimeout(() => {
        selectedContactElement.parentNode.removeChild(selectedContactElement);
    }, 2000);
}
const prompt=(yesCallback, noCallback = () => {
}, message)=> {
    Swal.fire({
        title: 'Are you sure?',
        text: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            yesCallback()
        } else
            noCallback()
    })
}
//fixing boostrap navbar toggle not expanding
document.querySelectorAll('.navbar-toggler').forEach((btn)=>{
    btn.addEventListener('click',(e)=>{
        $(e.target.closest('.navbar-toggler').dataset.target).toggle()
    })
})
const sendHttpPostRequest=(endpintAction,sucess,faillier,data=null,urlencodedDataForm=false)=>{
    try {
        let request = new XMLHttpRequest();
        request.open('post', '/api?action=' + endpintAction);
        if(urlencodedDataForm)
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        async function onreadystatechange() {
            if (request.readyState === 4) {
                res = JSON.parse(request.response);
                if (request.status === 200) {
                    sucess(res);
                } else if (request.status === 400) {//so we have errors let's display them to the user
                    faillier(res);
                } else {
                    console.log('the server responded with code ' + request.status);
                }
            }
        }

        request.onreadystatechange = onreadystatechange;
        if(data==null)
            request.send();
        else
        request.send(data);
    } catch (e) {
        console.error(e);
    }
}
const updateUi=(mode)=>{
    contactsMode=mode;
    if(contactsMode==CONTACT_MODE_ADD){
        contactsForm.dataset.action=ACTION_TYPE_ADD_CONTACT;
        addContactBtn.style.display="none";
        pageHeading.textContent=ADD_FORM_HEADING;
        btnSave.textContent=ADD_BTN_TEXT;
    }else{
        contactsForm.dataset.action=ACTION_TYPE_UPDATE_CONTACT;
        addContactBtn.style.display="block";
        pageHeading.textContent=EDIT_FORM_HEADING;
        btnSave.textContent=EDIT_BTN_TEXT;
    }
}
function reloadContactsList(){
    sendHttpPostRequest(ACTION_TYPE_LIST_CONTACTS,()=>{
        //success
        if(res.data.length>0){
            document.querySelector('.contacts-table').innerHTML='';
            res.data.forEach((contact)=>{
                addContactToList(contact);
            })
            noContactsMsg.style.display='none';
        }else{
            noContactsMsg.style.display='block';
        }
        data=res.data;
        highlightSuccess(contactIdToBeHighlighted)
    },()=>{
        //faillier
        alert(res.message,ALERT_TYPE_FAILED);
    })
}
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
 //for signup page
    signupForm.addEventListener('submit',signUpAndLoginFormHandler)
if(signinForm!=null)
    //for signin page
    signinForm.addEventListener('submit',signUpAndLoginFormHandler)
if(contactsForm!=null) {
    addContactBtn.addEventListener('click', () => {
        updateUi(CONTACT_MODE_ADD);
        contactsForm.reset();
        contactsForm.classList.remove('was-validated');
    })
    reloadContactsList()
    // for contact page
    contactsForm.addEventListener('submit',  (event) => {
        console.log("sending form data");
        sendHttpPostRequest(event.target.dataset.action,()=>{
            //success
            alert(res.message, ALERT_TYPE_SUCCESS);
            if(CONTACT_MODE_ADD==contactsMode){
                restContactsForm();
            }
            contactIdToBeHighlighted = res.affected.id;
            reloadContactsList()
        },
            (res)=>{
            //faillier
            const keys = Object.keys(res.errors)
            keys.forEach((k) => {
                console.log(k + ':' + res.errors[k]);
                document.getElementsByName(k).forEach((el) => {
                    enableErrorOn(el, true, res.errors[k]);
                })
            })
            alert(res.message, ALERT_TYPE_FAILED);

        },
            new FormData(contactsForm));
    });
    updateUi(CONTACT_MODE_ADD);
}
