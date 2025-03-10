const loginForm=document.querySelector("#login-form");

loginForm.addEventListener("submit",(e)=>{
    e.preventDefault();
    const username=loginForm.elements["username"].value.trim();
    const password=loginForm.elements["password"].value.trim();
    const messageArea=document.querySelector(".message-area");

    if(username===""||password===""){
       messageArea.innerHTML="Kindly fill all fields";
       messageArea.classList.add("message-error");

       setTimeout(() => {
        messageArea.innerHTML="";
        messageArea.classList.remove("message-error");
       }, 6000);
       return;
    };
      
       messageArea.innerHTML="login Success";
       messageArea.classList.add("message-success");
        setTimeout(()=>{
         window.location.href="../uploadProject/upload.html"
        },6000)
})