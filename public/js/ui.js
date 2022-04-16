document.addEventListener("DOMContentLoaded", function (event) {
  const showNavbar = (toggleId, navId, bodyId, headerId) => {
    const toggle = document.getElementById(toggleId),
      nav = document.getElementById(navId),
      bodypd = document.getElementById(bodyId),
      headerpd = document.getElementById(headerId);
    if (toggle && nav && bodypd && headerpd) {
      toggle.addEventListener("click", () => {
        // document.cookie = 'nav=collapse'
        nav.classList.toggle("show");
        toggle.classList.toggle("bx-x");
        bodypd.classList.toggle("body-pd");
        headerpd.classList.toggle("body-pd");
      });
    }
  };

  showNavbar("header-toggle", "nav-bar", "body-pd", "header");

  const linkColor = document.querySelectorAll(".nav_link");

  function colorLink() {
    if (linkColor) {
      linkColor.forEach((l) => l.classList.remove("active"));
      this.classList.add("active");
    }
  }
  linkColor.forEach((l) => l.addEventListener("click", colorLink));


var view_mode = document.querySelectorAll('.view_mode'); 

view_mode.forEach((v) => v.addEventListener('click',view_mode_changer));

function view_mode_changer(){
    if(view_mode){
      view_mode.forEach((v) => {
         if(v.classList.contains("btn-primary")){
          v.classList.remove("btn-primary");

        }
        v.classList.add("btn-light")
      })
      
      this.classList.add("btn-primary")
      this.classList.remove("btn-light")
     

    }
}

});
