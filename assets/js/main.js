$(document).ready(function () {

    $('.paginationNum').click(posts);
    $('#filSub').click(filterPosts);
    $('#filRes').click(resetPosts);
})

function posts(e){
    e.preventDefault();
        let limit = ($(this).data('limit')-1)*10;
        $.ajax({
        url: "models/filter.php",
        method: "post",
        data:{
            limit: limit
        },
        dataType: "json",
        success: function(data){
            ispisiPost(data.posts);
            pagination(data.pg);
        },
        error:function(er){
            console.log(er);
        }
    })
}
function resetPosts(){
    let resetuj = 1;
    $.ajax({
        url: "models/filter.php",
        method: "post",
        data: {
            resetuj: resetuj
        },
        success: function(data){
            ispisiPost(data.posts);
            pagination(data.pg);
        },
        error:function(er){
            console.log(er);
        } 
    });
}
function filterPosts(){
    let sortiranje = $('#ddSort').val();
    let kategorija = $('#ddCategory').val();
    let tekst = $('#srchTxt').val();

    let limit = 0;
    console.log("sort: "+sortiranje+", kategorija: "+kategorija+", tekst: "+tekst)
    $.ajax({
        url: "models/filter.php",
        method: "post",
        data: {
            limit : limit,
            sort : sortiranje,
            cat : kategorija,
            txt : tekst
        },
        dataType: "json",
        success: function(data){
            ispisiPost(data.posts);
            pagination(data.pg);
        },
        error:function(er){
            console.log(er);
        } 
    });
}
function pagination(num){
    let html="";
    for(let i=1;i<=num;i++){
        html+=`<li class="paginacija m-2"><a href="#" class="paginationNum" data-limit="${i}">${i}</a></li>`
    }
    $('#pagination').html(html);
    $('.paginationNum').click(posts);
}
function ispisiPost(data){
    console.log("ispisalo")
    let html="";
    data.forEach(e =>{
        let dat = e.created.split(' ');
        html += `<div class="d-flex flex-column flex-md-row justify-content-center m-5 text-center col-11">
        <div class="d-flex flex-column align-items-center justify-content-center postAu col-2">
            <img src="${e.src}" alt="${e.alt}" class="img-fluid postIco">
            <p>${e.username}</p>
        </div>
        <div class="postBckgSmall d-flex flex-column p-3 col-9">
            <div class="a">
                    <img src="${e.pSrc}" alt="${e.pAlt}" class="img-fluid postSlika">
            </div>
            <div class="postTitle mt-2">
                <a href="index.php?page=post&id=${e.id}"><h2>${e.title}</h2></a>
            </div>
            <div class="d-flex justify-content-end align-items-center">
                <i class="far fa-clock pr-2 pl-2"></i> ${dat[0]}
            </div>
        </div>
    </div>`;
    })
    $('#sviPostovi').html(html);
}
function formCheck(){
    let user = document.getElementById("username").value;
    let email = document.getElementById("email").value;
    let pass = document.getElementById("password").value;
    let repPass = document.getElementById("rePassword").value;
    let reUser = /^[a-z0-9]{4,20}$/;
    let reEmail = /^[a-z][a-z\d\_\.\-]+\@[a-z\d]+(\.[a-z]{2,4})+$/;
    let rePass = /(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}/;

    let greske= 0;

    if (!reUser.test(user)) {
        $("#username").next().css("display", "block");
        greske++;
        }
    else {
        $("#username").next().css("display", "none");
    }

    if (!reEmail.test(email)) {
        $("#email").next().css("display", "block");
        greske++;
    }
    else {
        $("#email").next().css("display", "none");
    }

    if (!rePass.test(pass)) {
        $("#password").next().css("display", "block");
        greske++;
    }
    else {
        $("#password").next().css("display", "none");
    }
    if (pass != repPass) {
        $("#rePassword").next().css("display", "block");
        greske++;
    }
    else {
        $("#rePassword").next().css("display", "none");
    }
    console.log(greske)
    if(greske>0){
        return false;
    }
    else{
        return true;
    }
}
function editCheck(){
    let user = document.getElementById("username").value;
    let email = document.getElementById("email").value;
    let pass = document.getElementById("password").value;
    //
    let reUser = /^[a-z0-9]{4,20}$/;
    let reEmail = /^[a-z][a-z\d\_\.\-]+\@[a-z\d]+(\.[a-z]{2,4})+$/;
    let rePass = /(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}/;
    let greske= 0;
    if (!reUser.test(user)) {
        $("#username").css("border", "2px solid red");
        greske++;
    }
    else{
        $("#username").css("border", "none");
    }
    if (!reEmail.test(email)) {
        $("#email").css("border", "2px solid red");
        greske++;
    }
    else{
        $("#email").css("border", "none");
    }
    if (!rePass.test(pass)) {
        $("#password").css("border", "2px solid red");
        greske++;
    }
    else{
        $("#password").css("border", "none");
    }
    console.log(greske)
    if(greske>0){
        return false;
    }
    else{
        return true;
    }
}
function editContact(){
    let name = document.getElementById("name").value;
    let reName = /^[A-Z][a-z]{2,9}(\s[A-Z][a-z]{2,14})+$/;
    let email = document.getElementById("email").value;
    let reEmail = /^[a-z][a-z\d\_\.\-]+\@[a-z\d]+(\.[a-z]{2,4})+$/;
    let subject = document.getElementById("subject").value;
    let reSubj = /^[A-zšđžčćŠĐŽČĆ 1-9]{10,150}/;
    let msg = document.getElementById("text").value;
    let reMsg = /^[A-zšđžčćŠĐŽČĆ 1-9]{10,300}/;
    //
    let greske= 0;
    if (!reName.test(name)) {
        $("#name").css("border", "2px solid red");
        greske++;
    }
    else{
        $("#name").css("border", "none");
    }
    if (!reEmail.test(email)) {
        $("#email").css("border", "2px solid red");
        greske++;
    }
    else{
        $("#email").css("border", "none");
    }
    if (!reSubj.test(subject)) {
        $("#subject").css("border", "2px solid red");
        greske++;
    }
    else{
        $("#subject").css("border", "none");
    }
    if (!reMsg.test(msg)) {
        $("#text").css("border", "2px solid red");
        greske++;
    }
    else{
        $("#text").css("border", "none");
    }
    console.log(greske)
    if(greske>0){
        return false;
    }
    else{
        return true;
    }
}