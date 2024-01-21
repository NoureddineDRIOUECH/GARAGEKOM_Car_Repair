let theme = document.querySelector(".themecheckbox");
theme.addEventListener("change", () => {
  let theme2 = document.documentElement.getAttribute("data-bs-theme");
  document.documentElement.setAttribute(
    "data-bs-theme",
    theme2 === "light" ? "dark" : "light"
  );
});
function setTheme() {
  let theme = document.querySelector(".themecheckbox");
  let theme2 =
    window.matchMedia &&
    window.matchMedia("(prefers-color-scheme: dark)").matches
      ? "dark"
      : "light";
  if (theme2 === "dark") {
    document.documentElement.setAttribute("data-bs-theme", "dark");
    theme.selectedIndex = 1;
  } else {
    document.documentElement.setAttribute("data-bs-theme", "light");
    theme.selectedIndex = 0;
  }
}
window.addEventListener("DOMContentLoaded", setTheme);
let dateNow = new Date();
let mycopyrightp = document.createElement("p");
mycopyrightp.innerHTML =
  "&copy; " + dateNow.getFullYear() + " DRCoffee. Tous droits réservés.";
document.querySelector("div.copyright").appendChild(mycopyrightp);

// function submitForm() {
//   // Perform your CAPTCHA verification here
//   var response = grecaptcha.getResponse();

//   if (response.length == 0) {
//     // Show the Bootstrap modal
//     $("#captchaModal").modal("show");
//     return false;
//   }

//   // If CAPTCHA is verified, proceed with form submission
//   document.forms[0].submit();
// }
//fucntion for recaptcha verification chekbox
