document.addEventListener("DOMContentLoaded",function(){
 const search=document.getElementById("searchBox"), cat=document.getElementById("categoryFilter"), cards=document.querySelectorAll(".food-card");
 function filter(){if(!cards.length)return; const q=(search?.value||"").toLowerCase(), c=cat?.value||"";
 cards.forEach(card=>{const okName=card.dataset.name.includes(q), okCat=!c||card.dataset.category===c; card.style.display=(okName&&okCat)?"block":"none";});}
 search?.addEventListener("input",filter); cat?.addEventListener("change",filter);
});
function validateRegister(){const p=document.getElementById("password");if(p && p.value.length<6){alert("Password must contain at least 6 characters.");return false;}return true;}
function validateContact(){const m=document.getElementById("contactMessage");if(m && m.value.trim().length<5){alert("Message is too short.");return false;}return true;}