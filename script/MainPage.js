const img = document.querySelector('#information-photo');
const logOutButton = document.querySelector('#buttonLogOut');
const openSettingMenu =document.querySelector('#buttonSetting');
const openLikeList = document.querySelector('#buttonLikes');
const closeSettingMenu=document.querySelector('#clossSettingMenu')
const settingMenu=document.querySelector('#settimgMenu');
const backgroundMenu = document.querySelector('#backgroundMenu');
const changeEmailButton = document.querySelector('#changeEmail');
const inputOldPassword = document.querySelector('#oldPassword');
const inputNewPasword = document.querySelector('#newPasword');
const confNewPassWord = document.querySelector('#ConfirmPasword');
const buttonChangePassWord = document.querySelector('#changePassword');
const buttonOpenHObbyMenu = document.querySelector('#add-hobby-button');
const addHobbyMenu = document.querySelector('#addHobby');
const buttonAddHobby= document.querySelector('#buttonAddHobby');
const buttonCloseHobbyMenu=document.querySelector('#clossHobbyMenu');
const inputHobby = document.querySelector('#inputHobby');
const resultItem =document.querySelector('#resalt-item');
const buttonNextPerson = document.querySelector('#next-person');
const buttonPreviosPreson = document.querySelector('#previos-person');
const likeUsermenu = document.querySelector('#likeUser');
const buttonCloseLikeMenu = document.querySelector('#clossLikeMenu');
const likeUserList = document.querySelector('#likeUserLIST');
let i = 0;
const likeUserArr=[]; 
// const buttonUearchUsers = document.querySelector('#filter-usres');
const sectionResalt = document.querySelector('#search-resalt');
let usersList=JSON.parse(document.querySelector('[data-userList]').getAttribute('data-userList'))

// console.log(usersList);
// console.log(usersList.length);
function setPhotoUser(){
    console.log(img.dataset.gender);
    if(img.dataset.gender == 'female'){
        img.classList.add('photo-female')
    } else(
        img.classList.add('photo-male')
    )
}
window.onload= ()=>{
    setPhotoUser();
}
function openMenu(event){
    settingMenu.classList.add('display-action');
    settingMenu.classList.remove('display-hidden');
    backgroundMenu.style.display = 'block';
    event.preventDefault();
}
function closeMenu(){
    settingMenu.classList.remove('display-action');
    settingMenu.classList.add('display-hidden');
    backgroundMenu.style.display = 'none';
}
function changeEmail(ev){
    let changeConfirm =confirm("Are you sure? Do you want to change your Email?");
    if(!changeConfirm){
        ev.preventDefault();
    }
}
function confirmLogOut(ev){
    let confirmLogout=confirm("Are you sure? Do you want LogOut?");
    if(!confirmLogout){
        ev.preventDefault();
    }
}
function checkNewPassWord(ev){
    console.log("password check") ;
    if(inputOldPassword.value == "" || inputNewPasword.value == "" || confNewPassWord.value == ""){
        alert("Fill in all INPUTS, Please");
        ev.preventDefault();
    }else{
        if(inputNewPasword.value !== confNewPassWord.value){
            alert("Check your password It does not match!");
            ev.preventDefault();
        }
    }
}

function openHobbyMenu(ev){
    addHobbyMenu.classList.add('display-action');
    addHobbyMenu.classList.remove('display-hidden');
    backgroundMenu.style.display = 'block';
    ev.preventDefault();
}

function closeMenuHobby(){
    addHobbyMenu.classList.add('display-hidden');
    addHobbyMenu.classList.remove('display-action');
    backgroundMenu.style.display = 'none';
}
function openLikeMenu(ev){
    likeUsermenu.classList.add('display-action');
    likeUsermenu.classList.remove('display-hidden');
    backgroundMenu.style.display = 'block';
    ev.preventDefault();
    likeUserArr.forEach((el)=>{
        likeUserList.insertAdjacentHTML('beforeend',`
            <li class = "likelist-item"><span>${el['firstname']} ${el['lastname']},${el['city']}</span></li>
            `)
    })

}
function closeLikeMenu(){    
    likeUsermenu.classList.add('display-hidden');
    likeUsermenu.classList.remove('display-action');
    backgroundMenu.style.display = 'none';
}
function addToLikeList(){
    
    let userLike = {
        'firstname' : usersList[i]['firstname'],
        'lastname' : usersList[i]['lastname'],
        'city' : usersList[i]['city']
    };

    likeUserArr.push(userLike); 
}
function checkNewHobby(ev){
    if(inputHobby.value == ""){
        alert("Add a hobby");
        ev.preventDefault();
    }
}

function showUsers(i){
    
    resultItem.innerHTML = "";
    resultItem.insertAdjacentHTML('beforeend', 
        `<ul class="resalt-info">
                <li class="resalt-info-item"><span class="resalt-info-title">First Name: </span><span class="resalt-info-text">${usersList[i]['firstname']}</span></li>
                <li class="resalt-info-item"><span class="resalt-info-title">Last Name: </span><span class="resalt-info-text">${usersList[i]['lastname']}</span></li>
                <li class="resalt-info-item"><span class="resalt-info-title">BirthDate: </span><span class="resalt-info-text">${usersList[i]['birthdate']}</span></li>                
                <li class="resalt-info-item"><span class="resalt-info-title">City: </span><span class="resalt-info-text">${usersList[i]['city']}</span></li>
                <li class="resalt-info-item"><span class="resalt-info-title">Hobbies: </span><span class="resalt-info-text">${usersList[i]['hobbies']}</span></li>                 
            </ul>
        `)
    console.log    
    if(usersList[i]['gender']=='male'){
        resultItem.classList.add('photo-male');
        resultItem.classList.remove('photo-female');
    }else if(usersList[i]['gender']=='female'){
        resultItem.classList.add('photo-female');
        resultItem.classList.remove('photo-male');
    }
    if(usersList[i]['status']=='1'){
        resultItem.classList.add('status-in');
        resultItem.classList.remove('status-off');
    } else {
        resultItem.classList.remove('status-in');
        resultItem.classList.add('status-off');
    }
}

if(usersList!= undefined){
    sectionResalt.classList.add('display-action');
    sectionResalt.classList.remove('display-hidden');
    showUsers(i);
    
}else{
    sectionResalt.classList.add('display-hidden');
    sectionResalt.classList.remove('display-action');
}

// logOut.addEventListener('click', (event)=>{
//     post('../Controller/MainPageController.php',{action:'logOut'},function(response){
//         console.log(response);
//     })
// })
// function getUsersList(){
//     console.log('click');
//     usersList = sectionResalt.dataset.userList;
//     console.log(usersList);
// }
openSettingMenu.addEventListener('click', (event)=>{    
    openMenu(event)});
closeSettingMenu.addEventListener('click', closeMenu);
openLikeList.addEventListener('click', (event)=>{
    openLikeMenu(event);
})
buttonCloseLikeMenu.addEventListener('click',closeLikeMenu);
changeEmailButton.addEventListener('click', (ev)=>{
    changeEmail(ev);   
});
logOutButton.addEventListener('click', (ev)=>{
    confirmLogOut(ev);
})
buttonChangePassWord.addEventListener('click', (ev)=>{
    console.log("click");
    checkNewPassWord(ev);
})
buttonOpenHObbyMenu.addEventListener('click',(ev)=>{
    openHobbyMenu(ev)});
buttonCloseHobbyMenu.addEventListener('click', closeMenuHobby);
buttonAddHobby.addEventListener('click', (ev)=>{
    checkNewHobby(ev);
});
buttonNextPerson.addEventListener('click',()=>{
    i++;
    console.log(usersList.length);
    if(i>usersList.length-1){

        i=0;
    }
    console.log("next", i);
    showUsers(i);
})
buttonPreviosPreson.addEventListener('click',()=>{
    i--;
    if(i<0){
        i=usersList.length-1;
    }
    console.log("previos", i);
    showUsers(i);
})
resultItem.addEventListener('click', addToLikeList);
// buttonUearchUsers.addEventListener('click', getUsersList);
console.log(changeEmailButton);
console.log(img);
console.log(likeUserArr);