//validate user registration
const registerForm=document.getElementById("register_form");
 registerForm.addEventListener("submit",(e)=>{
  e.preventDefault();
  const messageArea=document.querySelector(".message-area");
  const username=registerForm.elements["username"].value.trim();
  const email=registerForm.elements["email"].value.trim();
  const password=registerForm.elements["password"].value.trim();
  const confirmPassword=registerForm.elements["confirm_password"].value.trim();

  if(username==""||email==""||password==""||confirmPassword==""){
    messageArea.innerHTML="Kindly fill all fields"; 
    messageArea.classList.add("message-error");
    setTimeout(() => {
      messageArea.innerHTML=""; 
    messageArea.classList.remove("message-error");
    registerForm.reset();
    }, 6000);
    return;
  };

  
  const regPass=/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
if(!regPass.test(password)){
    messageArea.innerHTML="Password must be 8 charactrs long, Have one uppercase, number and special characters";
    messageArea.classList.add("message-error");
    setTimeout(() => {
        messageArea.innerHTML=""; 
      messageArea.classList.remove("message-error");
    registerForm.reset();
      }, 6000);
    return;
}
if(password !== confirmPassword){
    messageArea.innerHTML="Password do not match";
    messageArea.classList.add("message-error");
    setTimeout(() => {
        messageArea.innerHTML=""; 
      messageArea.classList.remove("message-error");
    registerForm.reset();
      }, 6000);
    return;
}
  const regEmail=/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

if(!regEmail.test(email)){
    messageArea.innerHTML="Invalid Email";
    messageArea.classList.add("message-error");
    setTimeout(() => {
        messageArea.innerHTML=""; 
      messageArea.classList.remove("message-error");
    registerForm.reset();
      }, 6000);
    return;
}

  messageArea.innerHTML="Registration success";
  messageArea.classList.add("message-success");
  setTimeout(()=>{
    messageArea.innerHTML=""; 
    registerForm.reset();
    messageArea.classList.remove("message-success");
      window.location.href="login.html";
  },6000)
 })