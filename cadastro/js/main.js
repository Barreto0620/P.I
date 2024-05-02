const signInBtn = document.getElementById("signIn");
const fistForm = document.getElementById("form1");
const container = document.querySelector(".container");

signInBtn.addEventListener("click", () => {
	container.classList.remove("#");
});

fistForm.addEventListener("submit", (e) => e.preventDefault());
secondForm.addEventListener("submit", (e) => e.preventDefault());
