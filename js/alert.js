const Alert = document.querySelector("#alert");
const Msg = document.querySelector(".alert-msg");
Alert.style.cursor = "pointer";

Alert.addEventListener("click", function(e) {
	e.preventDefault();
	setTimeout(() => Alert.remove(), 0);
}),

Alert.addEventListener("hover", function(e) {
	e.preventDefault();
	Alert.style.boxShadow = "0 0 10px black";
})