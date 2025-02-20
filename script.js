console.log("hi");
l
let buttons=document.querySelectorAll(".commander-btn");



buttons.forEach(btn => {
    btn.addEventListener("click" , () => {
        alert("button clicked");
    })
});