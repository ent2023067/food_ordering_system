document.addEventListener("DOMContentLoaded",function(){
 const dialogStyles=document.createElement("style");
 dialogStyles.textContent=".site-dialog-backdrop{position:fixed;inset:0;z-index:20;display:flex;align-items:center;justify-content:center;padding:20px;background:rgba(0,0,0,.55)}.site-dialog{width:min(100%,420px);padding:25px;background:#fff;border-radius:10px;box-shadow:0 8px 30px rgba(0,0,0,.3)}.site-dialog h3{margin-top:0}.site-dialog-actions{display:flex;justify-content:flex-end;gap:10px}.site-dialog-actions .btn{margin-top:8px}.dialog-cancel{background:#777}.dialog-confirm{background:#c1121f}";
 document.head.appendChild(dialogStyles);
 const search=document.getElementById("searchBox"), cat=document.getElementById("categoryFilter"), cards=document.querySelectorAll(".food-card");
 function filter(){if(!cards.length)return; const q=(search?.value||"").toLowerCase(), c=cat?.value||"";
 cards.forEach(card=>{const okName=card.dataset.name.includes(q), okCat=!c||card.dataset.category===c; card.style.display=(okName&&okCat)?"block":"none";});}
 search?.addEventListener("input",filter); cat?.addEventListener("change",filter);
 document.querySelectorAll("[data-confirm]").forEach(trigger=>trigger.addEventListener("click",function(event){
  event.preventDefault();
  showConfirmation(this.dataset.confirm,()=>{window.location.href=this.href;});
 }));
});
function showConfirmation(message,onConfirm){
 const backdrop=document.createElement("div");
 backdrop.className="site-dialog-backdrop";
 backdrop.innerHTML=`<div class="site-dialog" role="dialog" aria-modal="true" aria-labelledby="dialogTitle"><h3 id="dialogTitle">Please confirm</h3><p></p><div class="site-dialog-actions"><button type="button" class="btn dialog-cancel">Cancel</button><button type="button" class="btn dialog-confirm">Continue</button></div></div>`;
 backdrop.querySelector("p").textContent=message;
 backdrop.querySelector(".dialog-cancel").addEventListener("click",()=>backdrop.remove());
 backdrop.querySelector(".dialog-confirm").addEventListener("click",()=>{backdrop.remove();onConfirm();});
 backdrop.addEventListener("click",event=>{if(event.target===backdrop)backdrop.remove();});
 document.body.appendChild(backdrop);
}
function showFormMessage(form,message){
 form.querySelector(".js-form-message")?.remove();
 const messageCard=document.createElement("div");
 messageCard.className="alert js-form-message";
 messageCard.textContent=message;
 form.prepend(messageCard);
}
function validateRegister(){const p=document.getElementById("password"), form=p?.closest("form");if(p && p.value.length<6){showFormMessage(form,"Password must contain at least 6 characters.");return false;}return true;}
function validateContact(){const m=document.getElementById("contactMessage"), form=m?.closest("form");if(m && m.value.trim().length<5){showFormMessage(form,"Message is too short.");return false;}return true;}