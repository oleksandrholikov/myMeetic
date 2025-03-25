
    const buttonCreateUser = document.querySelector('#createUser');
    const Inputs = document.querySelectorAll('input');
    const formCreate = document.querySelector('#formCreate');
    const passwordInput = document.querySelector('#password');
    const confirmPassword = document.querySelector('#CheckPassword');
    console.log(formCreate);
    console.log("passWord: ", passwordInput.value);
    console.log("passWordConfirm : ", confirmPassword.value);
    function confitmPassWord(ev){
        if(passwordInput.value!=confirmPassword.value){
            alert("The passWord doesn't the same");
            ev.preventDefault();
        }
    }
    buttonCreateUser.addEventListener('click', (ev)=>{
        confitmPassWord(ev)
    });

    document.getElementById('formCreate').addEventListener('submit', function(event){
            let valid = true;    
            Inputs.forEach(el=>{
                if(!el.value.trim()){
                    el.classList.add('invalid');
                    valid = false;
                }else {
                    el.classList.remove('invalid');
                }
            });
            
            if(!valid){
                event.preventDefault();
            }
    });
        // console.log(buttonCreateUser);
        // console.log(Inputs);
        // 
        // function checkFields(){
        //     console.log("in");
            
        //     Inputs.forEach((el)=>{
        //         // console.log(el.value);
        //         if(el.value == ""){
        //             console.log("empty");
        //             el.classList.add('borderColorRed');
        //         }
                
        //     })
        // }
    
        // buttonCreateUser.addEventListener('click', checkFields);
        // buttonCreateUser.addEventListener('click',(event)=>{
        //     // console.log("submit");
        //     checkFields();
        // })
        //  Inputs.forEach((el)=>{
        //      el.addEventListener('onsubmit',(event)=>{
        //         console.log(event.target)
        //      });
        // })
    
    // console.log('Hello');