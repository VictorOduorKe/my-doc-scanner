const contactForm=document.getElementById("contact-form");

contactForm.addEventListener("submit",(e)=>{
    e.preventDefault();
    
    const messageArea=document.querySelector(".message-area");
    const username=contactForm.elements["username"].value.trim();
    const message=contactForm.elements["message"].value.trim();
    const email=contactForm.elements["email"].value.trim();

    if(username===""||message===""||email===""){
         messageArea.innerHTML="Kindly fill all fields";
         messageArea.classList.add("message-error");
         contactForm.reset();

         setTimeout(() => {
            messageArea.innerHTML="";
            messageArea.classList.remove("message-error");
         }, 6000);
         return;
    }
    const regEmail=/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if(!regEmail.test(email)){
         messageArea.innerHTML="Invalid email";
         messageArea.classList.add("message-error");
          contactForm.reset();

         setTimeout(() => {
            messageArea.innerHTML="";
            messageArea.classList.remove("message-error");
         }, 6000);
         return;
    }

      if(message.length>50){
        messageArea.innerHTML="Message should not exceed 50 words";
        messageArea.classList.add("message-error");
         contactForm.reset();
        
         setTimeout(() => {
            messageArea.innerHTML="";
        messageArea.classList.remove("message-error");
         }, 6000);
         return;
      };

    messageArea.innerHTML="Message sent successfully";
    messageArea.classList.add("message-success");
     contactForm.reset();

    setTimeout(()=>{
        messageArea.innerHTML="";
        messageArea.classList.remove("message-success");
     contactForm.reset;

    },6000)
})