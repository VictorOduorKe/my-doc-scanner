const togle_menu = document.querySelector(".toggle_menu");
const menu = document.querySelector(".menu");

togle_menu.addEventListener("click", () => {
  togle_menu.classList.toggle("fa-times");
  menu.classList.toggle("menu-active");
});

const deleteBtn = document.querySelectorAll(".delete");
const alertArea = document.querySelector(".alert");

for (let i = 0; i < deleteBtn.length; i++) {
  deleteBtn[i].addEventListener("click", (e) => {
    
      const deletArea = e.target.closest(".card");
    deletArea.remove();
    
    alertArea.innerHTML = "User details deleted";
    alertArea.style.backgroundColor = "green";
    alertArea.style.color = "white";
    alertArea.classList.add("add-alert");


    setTimeout(() => {
      alertArea.innerHTML = "";
      alertArea.classList.remove("add-alert");
    }, 1000);
  });

  
}

const statusBtn = document.querySelectorAll(".status");

/*for(let i=0; i<statusBtn.length; i++){
    statusBtn[i].addEventListener('click',(e)=>{
        e.preventDefault();
    statusBtn.innerTEXT="APPROVED";   
    })
}*/

statusBtn.forEach((element) => {
  element.addEventListener("click", () => {
    element.innerText = "APPROVED";
    element.style.backgroundColor = "green";
    element.style.color = "white";
  });
});

const downLoadBtns = document.querySelectorAll(".btn");

downLoadBtns.forEach((btn) => {
  btn.addEventListener("click", (e) => {
    e.preventDefault();
    const prevLink = btn.querySelector("a"); 
    if (!prevLink) return;
    const addSpinner = document.createElement("p");
    addSpinner.classList.add("spinner");


    prevLink.style.display = "none"; 
    btn.insertBefore(addSpinner, prevLink); 
    setTimeout(() => {
      addSpinner.remove(); 
      prevLink.style.display = "block"; 
      prevLinkUser.style.display = "block"; 
    }, 6000);
  });
});


const userbtn=document.querySelectorAll(".user-btn");

userbtn.forEach(btn=>{
    btn.addEventListener("click",(e)=>{
        const alert=document.querySelector(".alert")
        const td=e.target.closest(".details-area");
        alert.innerHTML="User details deleted"
        alert.classList.add("add-alert");
        td.remove();
        setTimeout(() => {
            alert.innerHTML="";
            alert.classList.remove("add-alert");
        }, 6000);
    })
})

const userDownloadPdf = document.querySelectorAll(".btn-download-user-pdf");

userDownloadPdf.forEach((btn=>{
    btn.addEventListener("click",(e)=>{
          e.preventDefault(); 

    const prevLinkUser = btn.querySelector("a"); 
    if (!prevLinkUser) return;

    const p = document.createElement("p");
    p.classList.add("spinner");

    prevLinkUser.style.display = "none"; 
    btn.insertBefore(p,prevLinkUser); 

    setTimeout(() => {
        p.remove(); 
        prevLinkUser.style.display = "inline-block";
    }, 6000);
    })
}))

